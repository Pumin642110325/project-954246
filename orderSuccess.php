<!DOCTYPE html>
<html lang="th">

<?php
include_once "./partials/layout.php";
include_once "./partials/navbar.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สั่งซื้อสำเร็จ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5 text-center">
        <h2 class="mb-4">🎉 การสั่งซื้อสำเร็จ!</h2>
        <p class="lead">ขอบคุณสำหรับการสั่งซื้อของคุณ</p>
        <p>เราจะทำการจัดส่งสินค้าของคุณโดยเร็วที่สุด</p>

        <div class="mt-4">
            <a href="showProduct.php" class="btn btn-primary">🛍️ กลับไปหน้ารายการสินค้า</a>
            <a href="showOrder.php" class="btn btn-success">📋 ดูรายการสั่งซื้อของฉัน</a><br><br>
        </div>

        <div class="mt-5">
            <h4>สแกน QR Code เพื่อชำระเงิน</h4>
            <img src="./picture/qrcode.png" alt="purchase" class="img-fluid mt-3" style="max-width: 300px;">
        </div>
    </div>
</body>

</html>


<?php
include_once "./partials/footer.php";
?>