<?php
session_start();
include_once "./partials/layout.php";
include_once "./partials/navbar.php";
// ตรวจสอบว่ามีสินค้าในตะกร้าหรือไม่
$cart = $_SESSION['cart'] ?? [];

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">🛒 ตะกร้าสินค้าของคุณ</h2>

        <?php if (empty($cart)): ?>
        <div class="alert alert-warning">ไม่มีสินค้าในตะกร้า</div>
        <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>รูปภาพ</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวม</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $total = 0;
                    foreach ($cart as $index => $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                <tr>
                    <td>
                        <img src="<?= htmlspecialchars($item['picture']) ?>" alt="Product Image" width="80"
                            class="img-thumbnail">
                    </td>
                    <td><?= htmlspecialchars($item['productName']) ?></td>
                    <td><?= number_format($item['price'], 2) ?> บาท</td>
                    <td>
                        <form method="post" action="updateCountProductOrder.php" class="d-inline">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1"
                                class="form-control w-50 d-inline" onchange="this.form.submit()">
                        </form>

                    </td>
                    <td><?= number_format($subtotal, 2) ?> บาท</td>
                    <td>
                        <a href="deleteCart.php?index=<?= $index ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('คุณต้องการลบสินค้านี้ออกจากตะกร้าใช่หรือไม่?');">
                            ลบ
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end fw-bold">ราคารวมทั้งหมด:</td>
                    <td class="fw-bold"><?= number_format($total, 2) ?> บาท</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-4">
            <a href="showProduct.php" class="btn btn-outline-secondary">🔙 กลับไปซื้อสินค้า</a>
            <a href="formOrder.php" class="btn btn-success">✅ สั่งซื้อสินค้า</a>
        </div>
        <?php endif; ?>
    </div>
</body>

</html>