<?php
session_start();
require_once "config.php"; // Using $connect from this file

// Get form data
$user_id = $_SESSION['user_id'];
$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$total = $_POST['total'] ?? 0;

// Validate form data
if (empty($name) || empty($address) || empty($phone) || $total <= 0) {
    die("กรุณากรอกข้อมูลให้ครบถ้วน");
}

// Get cart data
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die("ตะกร้าสินค้าว่าง");
}

try {
    // Start transaction
    mysqli_begin_transaction($connect);

    // Insert into orders table
    $orderQuery = "INSERT INTO orders (user_id, customer_name, address, phone, total) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $orderQuery);
    mysqli_stmt_bind_param($stmt, "isssd", $user_id, $customer_name, $address, $phone, $total);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) <= 0) {
        throw new Exception("ไม่สามารถบันทึกข้อมูลการสั่งซื้อได้");
    }

    // Get the last inserted order ID
    $order_id = mysqli_insert_id($connect);

    // Insert each item into order_items table
    $itemQuery = "INSERT INTO order_items (order_id, product_name, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?)";
    $stmtItem = mysqli_prepare($connect, $itemQuery);

    foreach ($cart as $item) {
        $productName = $item['productName'];
        $price = $item['price'];
        $quantity = $item['quantity'];
        $subtotal = $price * $quantity;

        mysqli_stmt_bind_param($stmtItem, "isdid", $order_id, $productName, $price, $quantity, $subtotal);
        mysqli_stmt_execute($stmtItem);

        if (mysqli_stmt_affected_rows($stmtItem) <= 0) {
            throw new Exception("ไม่สามารถบันทึกรายการสินค้าได้: $productName");
        }
    }

    // Commit transaction
    mysqli_commit($connect);

    // Clear cart after successful order
    unset($_SESSION['cart']);

    // Redirect to success page
    header("Location: orderSuccess.php");
    exit();
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($connect);
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}