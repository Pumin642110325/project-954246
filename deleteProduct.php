<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['level']) || $_SESSION['level'] < 3) {
    echo '<h3 style="color:red; text-align:center;">You are unable to access the data, please try again.</h3>';
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h3>Product ID is missing or invalid.</h3>";
    exit();
}

$productID = (int)$_GET['id']; 

$stmt = $connect->prepare("DELETE FROM product WHERE productID = ?");
$stmt->bind_param("i", $productID);

if ($stmt->execute()) {
    echo "<h3>Product deleted successfully.</h3>";
    echo "<a href='displayProduct.php'>Back To Product List</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$connect->close();
?>