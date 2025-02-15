<?php 
session_start(); // Start the session at the top
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lab9</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <?php include_once('partials/header.php'); ?>
    
    <div class="login-container">
        <h2>Login</h2>
        
        <?php
        if (isset($_SESSION['errors_msg'])) {
            echo "<p class='error'>" . $_SESSION['errors_msg'] . "</p>";
            unset($_SESSION['errors_msg']); // Clear message after displaying
        }
        ?>
        
        <form action="auth/login_process.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>

    <?php include_once('partials/footer.php'); ?>
</body>
</html>
