<?php

include("./DatabaseConnectivity/DbConfig.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

$sql = "CREATE TABLE IF NOT EXISTS category (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL
)";

$result = $con->query($sql);
if (!$result) {
    die("<h6>Error to create table<h6>");
}

$tablename = "category";
if (isset($_POST["delete"])) {
    $id = $_POST["delete"];

    // Fetch the image path from the database
    $query = "SELECT image FROM category WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image'];

        // Delete the image file from the server
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $queryDel = "DELETE FROM $tablename WHERE id='$id'";
    $result = $con->query($queryDel);
}


if(isset($_POST['logout'])){
$_SESSION = array();

// Destroy the session
session_destroy();
header("Location: index.php");
echo '
<script type="text/javascript">
    // Clear cart data from sessionStorage
    sessionStorage.removeItem("cart");
</script>
';
exit();
}

$query = "SELECT * FROM $tablename";

$result = $con->query($query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styleSheetGroup/homeStylesheet.css">
    <script type="text/javascript">
    // JavaScript function to clear cart from sessionStorage
    function clearCart() {
        // Clear cart data from sessionStorage
        sessionStorage.removeItem("cart");
        console.log("Cart cleared from sessionStorage");
        // You can also add any other actions here

        // The form will still be submitted since the return value is not false
    }
</script>
</head>
<body>
    <nav>
        <div class="main-nav">
            <div class="logoDiv">
                <img src="./uploads/assets/Prime Mart.png" class="logo" alt="logo">
                <h1 class="catlog_title">Prime Mart</h1>
            </div>
            <div class="nav-logout">
                <?php if ($_SESSION['user'] == "admin") { ?>
                    <a class="AddProduct" href="AdminCatagory.php"><img class="cart-logo" src="./uploads/assets/plus-solid.svg" alt="cart"></a>
                    <a class="AddProduct" href="orders.php"><img class="cart-logo" src="./uploads/assets/bag-shopping-solid (1).svg" alt="orders"></a>
                <?php } else { ?>
                    <a class="AddProduct" href="cart.php"><img class="cart-logo" src="./uploads/assets/cart-shopping-solid.svg" alt="cart"></a>
                <?php } ?>
                <form action="HomeCatagoryPage.php" method="POST">
                    <button class="delete" type="submit" name="logout" onclick="clearCart();"><img class="cart-logo" src="./uploads/assets/right-from-bracket-solid.svg" alt="logout"></button>
                </form>
            </div>
        </div>
    </nav>
    <div class="product-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <a href="homePage.php?nameofcat=<?php echo $row['name']; ?>&id=<?php echo $row['id']; ?>">
                    <div class="product">
                        <img src="<?php echo $row['image']; ?>" alt="product">
                        <div class="productname"><?php echo $row['name']; ?></div>
                        <div class="price">
                            <?php if ($_SESSION['user'] == "admin") { ?>
                                <form action="HomeCatagoryPage.php" method="POST">
                                    <button class="delete" type="submit" name="delete" value="<?php echo $row['id']; ?>"><img class="trashbutton" src="./uploads/assets/trash-solid.svg" alt="trash"></button>
                                </form>
                            <?php } ?>
                            <a class="delete" href="homePage.php?nameofcat=<?php echo $row['name']; ?>&id=<?php echo $row['id']; ?>"><img class="trashbutton" src="./uploads/assets/eye-solid.svg" alt="trash"></a>
                        </div>
                    </div>
                </a>
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