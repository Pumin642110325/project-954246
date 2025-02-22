<?php
session_start();
require_once "config.php";

// ตรวจสอบว่าเข้าสู่ระบบแล้วและมีสิทธิ์เป็น admin (level 3)
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 3) {
    header("Location: login.php");
    exit();
}

// ตรวจสอบว่าได้ส่ง Order ID มาหรือไม่
if (!isset($_GET['id'])) {
    echo "Order ID not provided.";
    exit();
}

$order_id = intval($_GET['id']);

// ลบรายการสินค้าใน order_items ที่เกี่ยวข้องกับคำสั่งซื้อนี้
$itemDeleteQuery = "DELETE FROM order_items WHERE order_id = ?";
if ($itemStmt = mysqli_prepare($connect, $itemDeleteQuery)) {
    mysqli_stmt_bind_param($itemStmt, "i", $order_id);
    mysqli_stmt_execute($itemStmt);
    mysqli_stmt_close($itemStmt);
} else {
    echo "Error preparing deletion of order items.";
    exit();
}

// ลบคำสั่งซื้อจากตาราง orders
$orderDeleteQuery = "DELETE FROM orders WHERE id = ?";
if ($orderStmt = mysqli_prepare($connect, $orderDeleteQuery)) {
    mysqli_stmt_bind_param($orderStmt, "i", $order_id);
    if (mysqli_stmt_execute($orderStmt)) {
        // เปลี่ยนเส้นทางกลับไปที่ showOrder.php หลังจากลบคำสั่งซื้อเสร็จสิ้น
        header("Location: showOrder.php?msg=Order deleted successfully");
        exit();
    } else {
        echo "Error deleting order.";
    }
    mysqli_stmt_close($orderStmt);
} else {
    echo "Error preparing deletion of order.";
    exit();
}
?>
