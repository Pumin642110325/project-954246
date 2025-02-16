<?php
  include_once __DIR__ . '/partials/header.php'; 
?>
 
<html>
<head>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <input type="email" placeholder="Email">
        <input type="password" placeholder="Password">
        <div class="remember">
            <input type="checkbox" name="remember"> Remember me
        </div>
        <button class="login2">Login</button>
        <p class="signup">Don't have an account? <a href="#">Sign up</a></p>
        <p class="forgot"><a href="#">Forgot password?</a></p>
    </div>
</body>
</html>