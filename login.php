<?php 
session_start();
$title = "Login Page"; 
include_once __DIR__ . '/partials/header.php'; 
?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <h2 class="text-center">Login</h2>

        <?php if (isset($_SESSION['errors_msg'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['errors_msg']; unset($_SESSION['errors_msg']); ?>
            </div>
        <?php endif; ?>

        <form action="auth/login_process.php" method="POST" class="border p-4 rounded shadow">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
