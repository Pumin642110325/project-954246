<?php
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand fw-bold text-warning" href="index.php">MUSIC SHOP</a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left-aligned menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

                    <!-- Product Menu with Level Check -->
                    <li class="nav-item">
                        <?php
                        if (isset($_SESSION['level']) && ($_SESSION['level'] == 1 || $_SESSION['level'] == 2)) {
                            echo '<a class="nav-link" href="showProduct.php">Product</a>';
                        } else {
                            echo '<a class="nav-link" href="displayProduct.php">Product</a>';
                        }
                        ?>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="showOrder.php">Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="showAboutus.php">About us</a></li>
                </ul>

                <!-- Right-aligned menu -->
                <ul class="navbar-nav mb-2 mb-lg-0 d-flex align-items-center">
                    <!-- Cart Icon with Badge -->
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="Showcart.php">
                            <i class="bi bi-cart3 text-warning" style="font-size: 1.5rem;"></i>
                            <?php if ($cart_count > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $cart_count ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <!-- Login/Logout and User Info -->
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item me-3">
                            <a class="nav-link" href="login.php">Logout</a>
                        </li>
                        <li class="nav-item">
                            <span class="text-white nav-link">[ <?= $_SESSION['firstname'] . " " . $_SESSION['lastname'] . " - Level: " . $_SESSION['level']; ?> ]</span>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Employee Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
