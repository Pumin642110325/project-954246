<?php
session_start();

if (isset($_GET['index'])) {
    $index = $_GET['index'];

    // ตรวจสอบว่ามีสินค้าในตะกร้า
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // รีเซ็ต key index
    }
}

header("Location: view_cart.php");
exit();
