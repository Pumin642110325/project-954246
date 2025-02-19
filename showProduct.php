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
              
              <!-- Form สำหรับเพิ่มสินค้าเข้าตะกร้า -->
              <form action="cart.php" method="POST">
                <input type="hidden" name="productID" value="<?= $row['productID'] ?>">
                <input type="hidden" name="productName" value="<?= htmlspecialchars($row['productName']) ?>">
                <input type="hidden" name="price" value="<?= $row['price'] ?>">
                <input type="hidden" name="picture" value="<?= htmlspecialchars($row['picture']) ?>">
                
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" value="1" min="1" max="<?= $row['qty'] ?>" class="form-control mb-2">
                
                <button type="submit" name="add_to_cart" class="btn btn-warning">Add to Cart</button>
              </form>

              <a href='detail.php?id=<?= $row['productID'] ?>' class="btn btn-danger btn-sm">Detail</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
