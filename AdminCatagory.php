<?php
include("./DatabaseConnectivity/DbConfig.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

$errorMessage = "";
$uploadedImage = "";  // Variable to hold the uploaded image path
$sql = "CREATE TABLE IF NOT EXISTS category (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL
)";

$result = $con->query($sql);
if (!$result) {
    die("<h6>Error to create table<h6>");
}


// Handle form submission logic
if (isset($_POST['submit'])) {
    $Name = isset($_POST['nameOfproduct']) ? $_POST['nameOfproduct'] : '';
    $Image = isset($_FILES['productFile']) ? $_FILES['productFile'] : null;

    if ($Image && $Image['error'] == 0) {
        $targetDir = "CatagoeryUplods/";
        $targetFilePath = $targetDir . basename($Image["name"]);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpeg', 'jpg', 'png', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            if (move_uploaded_file($Image["tmp_name"], $targetFilePath)) {
                $sql = "INSERT INTO category (image, name) VALUES ('$targetFilePath', '$Name')";

                if ($con->query($sql) === TRUE) {
                    $errorMessage = "Product uploaded successfully.";
                    // Redirect to the target page with the user parameter
                    $temp = $_GET['user'];
                    header("Location: HomeCatagoryPage.php?user=" . urlencode($temp));
                    exit();
                } else {
                    $errorMessage = "Error: " . $sql . "<br>" . $con->error;
                }
            } else {
                $errorMessage = "Sorry, there was an error uploading your file.";
            }
        } else {
            $errorMessage = "Sorry, only JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        $errorMessage = "Please upload a valid image file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product File</title>
    <link rel="stylesheet" href="./styleSheetGroup/addProductStyle.css">
    <script>
        function PreviewImage() {
            var file = document.getElementById("productFile").files[0];
            var preview = document.getElementById("blah");
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = "block";
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
            }
        }
    </script>
</head>

<body>
    <?php include "./SmallScript/NavBar.php"; ?>
    <div class="main">
        <div class="container">
            <h2>Upload Catagory File</h2>
            <form action="AdminCatagory.php" method="post" enctype="multipart/form-data">
                <label for="productFile">Product File:</label>
                <input type="file" id="productFile" name="productFile" accept="image/jpeg,image/png,image/gif" onchange="PreviewImage();" required>
                <div class="uploaded-image">
                    <img id="blah" src="#" alt="Preview" style="display: none;" />
                </div>
                <input type="text" placeholder="Enter Product name" name="nameOfproduct" required>
                <button type="submit" name="submit">Upload</button>
                <h6><?php echo $errorMessage; ?></h6>
            </form>
        </div>
    </div>
    <?php include "./SmallScript/footer.php"; ?>
</body>

</html>