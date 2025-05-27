<?php
include("./DatabaseConnectivity/DbConfig.php");
session_start();
$error_Message = "";
if (isset($_POST["submit"])) {
  if (empty($_POST["username"]) || empty($_POST["password"])) {
    $error_Message = "Details are empty";
  } else {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $usertype = "user";
    $validationQuery = "SELECT username FROM users WHERE username = '$username'";
    
    $result = $con->query($validationQuery);

    if ($result->num_rows == 0) {
      $queryIns = "INSERT INTO users (username, password, userType) VALUES ('$username', '$password', '$usertype')";

      if ($con->query($queryIns) === TRUE) {
        $_SESSION['username'] = $_POST["username"];
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = 'user';
        header("Location: " ."HomeCatagoryPage.php");
        exit(); 
      } else {
        $error_Message = "Error: " . $con->error;
      }
    } else {
      $error_Message = "Username already taken";
    }
  }
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="./styleSheetGroup/stylesheet.css">
</head>

<body>
  <div class="container">
  <div class="head-view">
      <img src="./uploads/assets/Prime Mart.png"/>
      <h1>Sign Up</h1>
    </div>
    <form action="signup.php" method="POST">
      <input type="text" placeholder="Username" name="username" required>
      <input type="password" placeholder="Password" name="password" required>
      <button type="submit" name="submit">Signup</button><br>
    </form>
    <p class="Error"><?php echo $error_Message;?></p>
  </div>
</body>

</html>

