<?php
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>

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
                    <li class="nav-item"><a class="nav-link" href="showOrder.php">Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="showSystemuser.php">System-user</a></li>
                </ul>

                <ul class="navbar-nav">
                    <!-- ตะกร้าสินค้า -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="Showcart.php">
                            <i class="bi bi-cart3 text-warning" style="font-size: 1.5rem;"></i>
                            <?php if ($cart_count > 0): ?>
                                <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $cart_count ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
