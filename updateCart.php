<?php
session_start();

if (isset($_POST['index']) && isset($_POST['quantity'])) {
    $index = $_POST['index'];
    $quantity = $_POST['quantity'];

    if ($quantity > 0 && isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
    }
}

// กลับไปที่ตะกร้าสินค้า
header("Location: view_cart.php");
exit();
?>