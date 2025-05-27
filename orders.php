<?php
include("./DatabaseConnectivity/DbConfig.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Fetch orders from the database
$sql = "SELECT id, user_name, total_price, order_date,status FROM orders ORDER BY order_date DESC";
$result = $con->query($sql);

// Check if any orders are found
$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
} else {
    $error = "No orders found!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link rel="stylesheet" href="./styleSheetGroup/orders.css">
</head>
<body>
    <nav>
        <div class="logoDiv">
            <img src="./uploads/assets/Prime Mart.png" class="logo" alt="logo">
            <h1 class="catlog_title">Orders</h1>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php else: ?>
            <ul class="orders-list">
                <?php foreach ($orders as $order): ?>
                    <li class="order-item">
                        <div class="order-details">
                            <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
                            <p><strong>User:</strong> <?php echo $order['user_name']; ?></p>
                            <p><strong>Total Price:</strong> ₹ <?php echo $order['total_price']; ?></p>
                            <p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
                            <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
