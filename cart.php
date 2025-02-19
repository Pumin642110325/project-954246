<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    // รับค่าจากฟอร์ม
    $productID = $_POST['productID'] ?? '';
    $productName = $_POST['productName'] ?? '';
    $price = $_POST['price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;
    $picture = $_POST['picture'] ?? '';

    // ตรวจสอบข้อมูลที่รับมา
    if (empty($productID) || empty($productName) || $price <= 0 || $quantity <= 0) {
        die("Error: ข้อมูลสินค้าไม่ถูกต้อง");
    }

    // ตรวจสอบว่ามี session ตะกร้าสินค้าอยู่หรือยัง
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ค้นหาว่าสินค้าอยู่ในตะกร้าแล้วหรือไม่
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productID'] == $productID) {
            $item['quantity'] += $quantity; // ถ้ามีอยู่แล้วให้เพิ่มจำนวน
            $found = true;
            break;
        }
    }
    unset($item); // รีเซ็ต reference เพื่อป้องกันปัญหา

    // ถ้ายังไม่มีสินค้า ให้เพิ่มเข้าไป
    if (!$found) {
        $_SESSION['cart'][] = [
            'productID' => $productID,
            'productName' => $productName,
            'price' => $price,
            'quantity' => $quantity,
            'picture' => $picture
        ];
    }

    // กลับไปที่หน้าตะกร้าสินค้า
    header("Location: showcart.php");
    exit();
}
?>
