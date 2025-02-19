<?php
include_once "./partials/layout.php";
include_once "./partials/navbar.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Product ID is missing.");
}

$productID = intval($_GET['id']); // ป้องกัน SQL Injection

// ดึงข้อมูลสินค้า
$query = "SELECT * FROM product WHERE productID = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $productID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Error: Product not found.");
}
?>

<body>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6">
        <img src="<?= htmlspecialchars($product['picture']) ?>" class="img-fluid"
          alt="<?= htmlspecialchars($product['productName']) ?>">
      </div>
      <div class="col-md-6">
        <h2><?= htmlspecialchars($product['productName']) ?></h2>
        <p class="text-muted"><?= htmlspecialchars($product['detail']) ?></p>
        <p><strong>Price:</strong> <?= htmlspecialchars($product['price']) ?> บาท</p>
        <p><strong>Stock:</strong> <?= htmlspecialchars($product['qty']) ?></p>

        <!-- Form สำหรับเพิ่มสินค้าเข้าตะกร้า -->
        <form action="cart.php" method="POST">
          <input type="hidden" name="productID" value="<?= $product['productID'] ?>">
          <input type="hidden" name="productName" value="<?= htmlspecialchars($product['productName']) ?>">
          <input type="hidden" name="price" value="<?= $product['price'] ?>">
          <input type="hidden" name="picture" value="<?= htmlspecialchars($product['picture']) ?>">
          <label for="quantity">Quantity:</label>
          <input type="number" name="quantity" value="1" min="1" max="<?= $product['qty'] ?>" class="form-control mb-2">
          <button type="submit" name="add_to_cart" class="btn btn-warning">Add to Cart</button>
        </form>

        <a href="showProduct.php" class="btn btn-secondary mt-2">Back to Shop</a>
      </div>
    </div>
  </div>
</body>
