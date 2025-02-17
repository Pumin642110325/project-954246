<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "config.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($title) ? $title : "My Website"; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="main.css">
</head>
<body>
<div class="header">
        <h1>Web Database System</h1>
        <div class="nav">
            <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="displayProduct.php">Product</a></li>
            <li><a href="displayOrder.php">Order</a></li>
            <li><a href="showSystemuser.php">System-user</a></li>
            <?php
                if (isset($_SESSION['username'])) {
                echo '<li><a href="logout.php">Logout - </a>';
                echo "<span class='user-desc'>&nbsp;[";
                echo $_SESSION['firstname']
                ." ".$_SESSION['lastname']
                ." - Level: ".$_SESSION['level'];
                echo "]</span></li>";
                }
                else {
                echo '<li><a href="login.php">Employee Login</a></li>';
                }
            ?>
            </ul>
        </div>
    </div>
    
    

<div class="d-flex flex-column min-vh-100 container-fluid p-0">
    <div class="d-flex flex-column flex-grow-1">
