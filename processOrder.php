<?php
session_start();
require_once "config.php"; // ใช้ $connect จากไฟล์นี้

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือยัง
if (!isset($_SESSION['user_id'])) {
    die("กรุณาเข้าสู่ระบบก่อนทำการสั่งซื้อ");
}

$user_id = $_SESSION['user_id']; // ดึง user_id จาก session
$user_level = $_SESSION['level'] ?? 1; // ดึง user level จาก session (ถ้าไม่มีให้เป็นเลเวล 1)

// รับข้อมูลจากฟอร์ม และป้องกัน XSS
$name = htmlspecialchars($_POST['name'] ?? '');
$address = htmlspecialchars($_POST['address'] ?? '');
$phone = htmlspecialchars($_POST['phone'] ?? '');
$total = floatval($_POST['total'] ?? 0);

// ตรวจสอบข้อมูลที่ผู้ใช้กรอก
if (empty($name) || empty($address) || empty($phone) || $total <= 0) {
    die("กรุณากรอกข้อมูลให้ครบถ้วน");
}

// รับข้อมูลตะกร้าสินค้า
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die("ตะกร้าสินค้าว่าง");
}

// คำนวณส่วนลดตามเลเวลของผู้ใช้
$discount_percentage = 0;

if ($user_level == 2) {
    $discount_percentage = 10; // ส่วนลด 10% สำหรับเลเวล 2
} elseif ($user_level == 3) {
    $discount_percentage = 20; // ส่วนลด 20% สำหรับเลเวล 3
}

$discount_amount = ($total * $discount_percentage) / 100; // จำนวนเงินส่วนลด
$final_total = $total - $discount_amount; // ยอดรวมหลังหักส่วนลด

try {
    // เริ่มธุรกรรม
    mysqli_begin_transaction($connect);

    // บันทึกข้อมูลลงในตาราง orders พร้อม user_id และยอดรวมหลังหักส่วนลด
    $orderQuery = "INSERT INTO orders (user_id, customer_name, address, phone, total) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $orderQuery);
    mysqli_stmt_bind_param($stmt, "isssd", $user_id, $name, $address, $phone, $final_total);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) <= 0) {
        throw new Exception("ไม่สามารถบันทึกข้อมูลการสั่งซื้อได้");
    }

    // ดึง ID คำสั่งซื้อที่เพิ่มล่าสุด
    $order_id = mysqli_insert_id($connect);

    // บันทึกรายการสินค้าลงในตาราง order_items
    $itemQuery = "INSERT INTO order_items (order_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?)";
    $stmtItem = mysqli_prepare($connect, $itemQuery);

    foreach ($cart as $item) {
        $productName = htmlspecialchars($item['productName']);
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $subtotal = $price * $quantity;

        mysqli_stmt_bind_param($stmtItem, "isdid", $order_id, $productName, $price, $quantity, $subtotal);
        mysqli_stmt_execute($stmtItem);

        if (mysqli_stmt_affected_rows($stmtItem) <= 0) {
            throw new Exception("ไม่สามารถบันทึกรายการสินค้าได้: $productName");
        }
    }

    // ยืนยันธุรกรรม
    mysqli_commit($connect);

    // ล้างตะกร้าสินค้าหลังสั่งซื้อสำเร็จ
    unset($_SESSION['cart']);

    // ไปที่หน้าคำสั่งซื้อสำเร็จ
    header("Location: orderSuccess.php");
    exit();

} catch (Exception $e) {
    // ยกเลิกธุรกรรมหากเกิดข้อผิดพลาด
    mysqli_rollback($connect);
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>
