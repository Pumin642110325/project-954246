<?php
include_once "./partials/layout.php";
include_once "./partials/navbar.php";

// ดึงข้อมูลจากฐานข้อมูล
$userQuery = "SELECT * FROM product";
$result = mysqli_query($connect, $userQuery);

if (!$result) {
  die("Query failed: " . mysqli_error($connect));
}
?>

<body>
  <div class="container mt-4">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col">
          <div class="card h-100">
            <img src="<?= htmlspecialchars($row['picture']) ?>" class="card-img-top"
              alt="<?= htmlspecialchars($row['productName']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['productName']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($row['detail']) ?></p>
              <p class="card-text"><strong>Price:</strong> <?= htmlspecialchars($row['price']) ?> บาท</p>
              <p class="card-text"><strong>Stock:</strong> <?= htmlspecialchars($row['qty']) ?></p>
            </div>
            <a href='showCart.php?id=<?= $row['productID'] ?>' class="btn btn-warning btn-sm">Add Product</a>
            <a href='detail.php?id=<?= $row['productID'] ?>' class="btn btn-danger btn-sm">Detail</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>