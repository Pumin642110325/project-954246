<?php
require_once "config.php";

$productName = $_POST['productName'];
$detail = $_POST['detail'];
$price = $_POST['price'];
$qty = $_POST['qty'];
$picture = $_POST['picture'];

$userQuery = "INSERT INTO product VALUES ('','$productName','$detail','$price','$qty','$picture')";
$result = mysqli_query($connect,$userQuery);

if(!$result){
    die("Error Try Again $userQuery".mysqli_error($connect));
}
else{
    header("location: displayProduct.php");
}
?>