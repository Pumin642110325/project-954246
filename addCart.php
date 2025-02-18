<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $picture = $_POST['picture'];

    // ตรวจสอบว่ามี session ตะกร้าสินค้าอยู่แล้วหรือยัง
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ตรวจสอบว่าสินค้านี้มีอยู่ในตะกร้าแล้วหรือยัง
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productID'] == $productID) {
            $item['quantity'] += $quantity; // ถ้ามีแล้วให้เพิ่มจำนวน
            $found = true;
            break;
        }
    }
    unset($item); // ป้องกันปัญหา reference

    // ถ้าไม่มีสินค้าในตะกร้า ให้เพิ่มเป็นรายการใหม่
    if (!$found) {
        $_SESSION['cart'][] = [
            'productID' => $productID,
            'productName' => $productName,
            'price' => $price,
            'quantity' => $quantity,
            'picture' => $picture
        ];
    }

    // กลับไปที่หน้าหลัก หรือไปที่หน้าตะกร้า
    header("Location: view_cart.php");
    exit();
}