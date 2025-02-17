<?php
require_once "config.php";

$productID = $_GET['id'];
$productName = $_POST['productName'];
$detail = $_POST['detail'];
$price = $_POST['price'];
$qty = $_POST['qty'];
$picture = $_POST['picture'];

$userQuery = "UPDATE product
              SET productName = '$productName', 
                  detail = '$detail',
                  price = '$price',
                  qty = '$qty',
                  picture = '$picture'
              WHERE productID = '$productID'";

$result = mysqli_query($connect,$userQuery);

if(!$result)
{
    die("FAILED: " . mysqli_error($connect));
}
else{
    header('location: displayProduct.php');
}