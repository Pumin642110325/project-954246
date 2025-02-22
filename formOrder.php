<?php
session_start();
include_once "./partials/layout.php";
include_once "./partials/navbar.php";

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">💳 ชำระเงิน</h2>

        <h4>สรุปรายการสินค้า</h4>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวม</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($cart as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['productName']) ?></td>
                    <td><?= number_format($item['price'], 2) ?> บาท</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($subtotal, 2) ?> บาท</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">ราคารวมทั้งหมด:</td>
                    <td class="fw-bold"><?= number_format($total, 2) ?> บาท</td>
                </tr>
            </tfoot>
        </table>

        <h4 class="mt-4">ข้อมูลการจัดส่ง</h4>
        <form action="processOrder.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อผู้รับ</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">ที่อยู่จัดส่ง</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>

            <input type="hidden" name="total" value="<?= $total ?>">
            <a href="showCart.php" class="btn btn-secondary">🔙 กลับไปตะกร้าสินค้า</a>
            <button type="submit" class="btn btn-primary">✅ ยืนยันการสั่งซื้อ</button>
        </form>
    </div>
</body>

</html>