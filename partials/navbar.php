<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-black p-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-warning" href="index.php">MUSIC SHOP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="displayProduct.php">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="displayOrder.php">Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="showSystemuser.php">System-user</a></li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Logout</a>
                        </li>
                        <li class="nav-item">
                            <span class="text-white nav-link">[ <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] . " - Level: " . $_SESSION['level']; ?> ]</span>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Employee Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>