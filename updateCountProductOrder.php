<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index = $_POST['index'];
    $quantity = intval($_POST['quantity']);

    // ตรวจสอบว่าจำนวนถูกต้องและมากกว่า 0
    if ($quantity > 0 && isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
        $_SESSION['success_message'] = "อัพเดตจำนวนสินค้าเรียบร้อยแล้ว";
    } else {
        $_SESSION['error_message'] = "จำนวนสินค้าไม่ถูกต้อง";
    }
}

header("Location: showCart.php");
exit();
?>