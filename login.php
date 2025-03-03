<?php
session_start();
$title = "Login Page";
include_once "config.php";
include_once "./partials/layout.php";
$bgImage = "./picture/background-violin-notext.jpg"
    ?>

<div class='d-flex flex-column flex-grow-1 container-fluid justify-content-center align-items-center' style="background-image: url('<?php echo $bgImage; ?>'); background-size: cover; background-position: center; height: 100vh;">
    <div class="login-wrap">
        <h2 class="text-center mt-5 fw-bold text-primary text-warning">Login</h2>
        <?php if (isset($_SESSION['errors_msg'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['errors_msg']; unset($_SESSION['errors_msg']); ?>
            </div>
        <?php endif; ?>

        <form action="check-login.php" method="POST" class="border p-4 rounded shadow mt-1 bg-light">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-warning w-100">Login</button>
            <br><br>
            <p>Don't have an account? <a href="addcusinfo.php">Register here</a></p>
        </form>
    </div>
</div>

<?php include_once './partials/footer.php'; ?>