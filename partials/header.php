<header class="bg-primary text-white text-center p-3">
    <h1>Welcome to My Website</h1>
    <nav>
        <ul class="nav justify-content-center">
            <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li class="nav-item"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="auth/logout.php">Logout</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link text-white" href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
