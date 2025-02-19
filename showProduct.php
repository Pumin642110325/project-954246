<?php
include_once "./partials/layout.php";
include_once "./partials/navbar.php";

// ดึงข้อมูลจากฐานข้อมูล
$userQuery = "SELECT * FROM product";
$result = mysqli_query($connect, $userQuery);

if (!$result) {
  die("Query failed: " . mysqli_error($connect));
}

// นับจำนวนสินค้า
$productCount = mysqli_num_rows($result);
?>

<body>
    <img src="./picture/background-violin-small.png" alt="background-header-violin" class="img-header-show-product" />
    <div class="container mt-4">
        <!-- Display product count -->
        <p class="fs-3 fw-bold">รายการสินค้า (<?= $productCount ?> รายการ)</p>

        <!-- Responsive grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($row['picture']) ?>" class="card-img-top"
                        alt="<?= htmlspecialchars($row['productName']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold"><?= htmlspecialchars($row['productName']) ?></h5>
                        <p class="card-text my-1"><?= htmlspecialchars($row['detail']) ?></p>
                        <p class="card-text my-1"><strong>Price:</strong> <?= htmlspecialchars($row['price']) ?> บาท</p>
                        <p class="card-text my-1"><strong>Stock:</strong> <?= htmlspecialchars($row['qty']) ?></p>
                    </div>
                    <div class="d-flex justify-content-between gap-2 p-2">
                        <a href='detail.php?id=<?= $row['productID'] ?>'
                            class="btn btn-light btn-sm w-100">รายละเอียด</a>
                        <a href='showCart.php?id=<?= $row['productID'] ?>' class="btn btn-warning btn-sm w-100">
                            <i class="bi bi-bag-plus" style="font-size: 1rem;"></i>
                            ใส่ตะกร้า</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>