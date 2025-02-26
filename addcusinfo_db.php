<?php
session_start(); // Start the session at the beginning
require_once "config.php";

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$account_type = $_POST['account_type'];

$userQuery = "INSERT INTO user_detail VALUES ('', '$fname', '$lname', '$phone', '$address', '$account_type')";
$result = mysqli_query($connect, $userQuery);

if(!$result){
    die("Error Try Again $userQuery".mysqli_error($connect));
}
else{
    $detail_id = mysqli_insert_id($connect);
    
    $_SESSION['detail_id'] = $detail_id;
    $_SESSION['account_type'] = $account_type;
    
    header("location: adduser.php");
    var_dump($_POST['account_type']); 
        exit;
}
?>