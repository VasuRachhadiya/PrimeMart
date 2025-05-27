<?php

include("./DatabaseConnectivity/DbConfig.php");

session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}


$tableQuery  = "CREATE TABLE IF NOT EXISTS products (
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

$tablename = "products";
$catagoryname = $_GET['nameofcat'];
$catid = $_GET['id'];

if (isset($_POST["delete"])) {
    $id = $_POST["delete"];

    // Fetch the image path from the database
    $query = "SELECT productimage FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $catid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['productimage'];

        // Delete the image file from the server
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $queryDel = "DELETE FROM $tablename WHERE id='$id'";
    $result = $con->query($queryDel);
}

$query = "SELECT * FROM $tablename WHERE category_id = '$catid'";

$result = $con->query($query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styleSheetGroup/homeStylesheet.css?v=1">
</head>

<body>
    <nav>
        <div class="main-nav">
            <div class="logoDiv">
                <img src="./uploads/assets/Prime Mart.png" class="logo" alt="logo">
                <h1 class="catlog_title"><?php echo $catagoryname;?></h1>
            </div>
            <div class="">
                <?php if ($_SESSION["user"] == "admin") { ?>
                    <a class="AddProduct" href="addProduct.php?nameofcat=<?php echo $_GET['nameofcat']; ?>&id=<?php echo $_GET['id']; ?>"><img class="cart-logo" src="./uploads/assets/plus-solid.svg" alt="cart"></a>
                <?php } else { ?>
                    <a class="AddProduct" href="cart.php"><img class="cart-logo" src="./uploads/assets/cart-shopping-solid.svg" alt="cart"></a>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="product-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="product">
                    <img src="<?php echo $row['productimage']; ?>" alt="product">
                    <div class="productname"><?php echo $row['name']; ?></div>
                    <div class="price">
                        <div class="priceSyle"><?php echo "₹ " . $row['price']; ?></div>
                        <?php if ($_SESSION["user"] == "admin") { ?>
                            <form action="homePage.php?nameofcat=<?php echo $_GET['nameofcat']; ?>&id=<?php echo $_GET['id']; ?>" method="POST">
                                <button class="delete" type="submit" name="delete" value="<?php echo $row['id']; ?>"><img class="trashbutton" src="./uploads/assets/trash-solid.svg" alt="trash"></button>
                            </form>
                        <?php } else { ?>
                            <button  class="delete add-to-cart" data-name="<?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" data-price="<?php echo $row['price']; ?>"><img class="trashbutton" src="./uploads/assets/cart-plus-solid.svg" alt="addtocart"></button>
                        <?php } ?>
                    </div>
                </div>
            <?php
            } // End while
        } else {
            ?>
            <h1>No Product Found!</h1>
        <?php
        } // End if
        ?>
    </div>
     <?php include "./SmallScript/footer.php"; ?>
    <script src="./Scripts/app.js"></script>
</body>
</html>