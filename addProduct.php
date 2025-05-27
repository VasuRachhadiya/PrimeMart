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
$categoryId = $_GET["id"];
// MARK: Table Creation If not exist
$tablename = "products";
$tableQuery  =  "CREATE TABLE IF NOT EXISTS products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    productimage VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT(11),
    
    -- Define the foreign key constraint and give it a name 'fk_category'
    CONSTRAINT fk_category FOREIGN KEY (category_id) 
    REFERENCES category(id) ON DELETE CASCADE
)"; 

$result = $con->query($tableQuery);
if (!$result) {
    die("<h6>Error to create table<h6>");
}

// Handle form submission logic
if (isset($_POST['submit'])) {
    $productName = isset($_POST['nameOfproduct']) ? $_POST['nameOfproduct'] : '';
    $productPrice = isset($_POST['price']) ? $_POST['price'] : '';
    $productImage = isset($_FILES['productFile']) ? $_FILES['productFile'] : null;

    if ($productImage && $productImage['error'] == 0) {
        $targetDir = "uploads/";
        $targetFilePath = $targetDir . basename($productImage["name"]);
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpeg', 'jpg', 'png', 'gif');
        if (in_array(strtolower($fileType), $allowTypes)) {
            if (move_uploaded_file($productImage["tmp_name"], $targetFilePath)) {
                $sql = "INSERT INTO $tablename (productimage, name, price, category_id) 
          VALUES ('$targetFilePath', '$productName', '$productPrice', '$categoryId')";

                if ($con->query($sql) === TRUE) {
                    $errorMessage = "Product uploaded successfully.";
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $tempuser = $_GET["user"];
                        $tempname = $_GET["nameofcat"];
                        $tempid = $_GET["id"];
                        header('Location: ' . "homePage.php?user=$tempuser&nameofcat=$tempname&id=$tempid");
                        exit();
                    } 
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
            <h2>Upload Product File</h2>
            <form action="addProduct.php?nameofcat=<?php echo $_GET['nameofcat']; ?>&id=<?php echo $_GET['id'];?>" method="post" enctype="multipart/form-data">
                <label for="productFile">Product File:</label>
                <input type="file" id="productFile" name="productFile" accept="image/jpeg,image/png,image/gif" onchange="PreviewImage();" required>
                <div class="uploaded-image">
                    <img id="blah" src="#" alt="Preview" style="display: none;" />
                </div>
                <input type="text" placeholder="Enter Product name" name="nameOfproduct" required>
                <input type="text" placeholder="Enter Price of product" name="price" required>
                <button type="submit" name="submit">Upload</button>
                <h6><?php echo $errorMessage; ?></h6>
            </form>
        </div>
    </div>
    <?php include "./SmallScript/footer.php"; ?>
</body>

</html>