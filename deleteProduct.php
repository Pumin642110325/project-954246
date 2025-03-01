<?php
// เริ่มต้นเซสชันเพื่อให้สามารถเข้าถึงตัวแปร $_SESSION
session_start();

// เชื่อมต่อฐานข้อมูล
require_once "config.php";

// ตรวจสอบสิทธิ์ของผู้ใช้
// ถ้าผู้ใช้ไม่มีตัวแปร $_SESSION['level'] หรือมีค่า < 3 (ไม่ได้รับสิทธิ์เพียงพอ)
// ให้แสดงข้อความแจ้งเตือนและหยุดการทำงานของสคริปต์
if (!isset($_SESSION['level']) || $_SESSION['level'] < 3) {
    echo '<h3 style="color:red; text-align:center;">You are unable to access the data, please try again.</h3>';
    exit(); // หยุดการทำงานของสคริปต์
}

// ตรวจสอบว่ามีค่าพารามิเตอร์ `id` ถูกส่งมาหรือไม่ และต้องเป็นตัวเลขเท่านั้น
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h3>Product ID is missing or invalid.</h3>";
    exit(); // หยุดการทำงานของสคริปต์
}

// แปลงค่า `id` จากพารามิเตอร์ GET ให้เป็นจำนวนเต็มเพื่อความปลอดภัย
$productID = (int)$_GET['id'];

// ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
$stmt = $connect->prepare("DELETE FROM product WHERE productID = ?");

// ผูกค่าตัวแปร `$productID` กับ Statement โดยกำหนดให้เป็นชนิดตัวเลข (integer - "i")
$stmt->bind_param("i", $productID);

// ทำการลบข้อมูล ถ้าสำเร็จให้เปลี่ยนเส้นทางไปที่ `displayProduct.php`
if ($stmt->execute()) {
    header("Location: displayProduct.php"); // เปลี่ยนเส้นทางไปยังหน้าที่แสดงสินค้าหลังจากลบ
} else {
    echo "Error: " . $stmt->error; // แสดงข้อผิดพลาดถ้าลบไม่สำเร็จ
}

// ปิด Statement และการเชื่อมต่อฐานข้อมูลเพื่อคืนทรัพยากร
$stmt->close();
$connect->close();
?>
