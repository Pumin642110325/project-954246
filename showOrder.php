<?php
session_start();
include_once "config.php"; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการส่งค่า orderID มาหรือไม่
if (!isset($_GET['orderID'])) {
    die("Order ID is missing.");
}

$orderID = intval($_GET['orderID']);

// ดึงข้อมูลออเดอร์หลัก
$orderQuery = "SELECT o.*, u.firstname, u.lastname, u.phone 
               FROM orders o 
               JOIN users u ON o.userID = u.userID 
               WHERE o.orderID = ?";
$stmt = $connect->prepare($orderQuery);
$stmt->bind_param("i", $orderID);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();

if (!$order) {
    die("Order not found.");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= htmlspecialchars($orderID) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">📜 รายละเอียดออเดอร์ #<?= htmlspecialchars($orderID) ?></h2>
        <hr>
        
        <div class="row">
            <div class="col-md-6">
                <h5>📌 ข้อมูลลูกค้า</h5>
                <p><strong>ชื่อ:</strong> <?= htmlspecialchars($order['firstname'] . " " . $order['lastname']) ?></p>
                <p><strong>เบอร์โทร:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                <p><strong>ที่อยู่จัดส่ง:</strong> <?= nl2br(htmlspecialchars($order['shippingAddress'])) ?></p>
            </div>
            <div class="col-md-6">
                <h5>📆 ข้อมูลออเดอร์</h5>
                <p><strong>วันที่สั่งซื้อ:</strong> <?= htmlspecialchars($order['orderDate']) ?></p>
                <p><strong>สถานะ:</strong> <?= htmlspecialchars($order['status']) ?></p>
                <p><strong>วิธีชำระเงิน:</strong> <?= htmlspecialchars($order['paymentMethod']) ?></p>
                <p><strong>ยอดรวม:</strong> <?= number_format($order['totalPrice'], 2) ?> บาท</p>
                <?php if ($order['trackingNumber']): ?>
                    <p><strong>เลขพัสดุ:</strong> <?= htmlspecialchars($order['trackingNumber']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">🔙 กลับหน้าหลัก</a>
        </div>
    </div>
</body>
</html>