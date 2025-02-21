<?php
require_once "config.php";

$street_address = $_POST['street_address'];
$city = $_POST['city'];
$state_province = $_POST['state_province'];
$postal_code = $_POST['postal_code'];


$userQuery = "INSERT INTO product VALUES ('', '$street_address', '$city', '$state_province', '$postal_code',)";
$result = mysqli_query($connect,$userQuery);

if(!$result){
    die("Error Try Again $userQuery".mysqli_error($connect));
}
else{
    header("location: showOrder.php");
}
?>