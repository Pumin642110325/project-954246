<?php
session_start();
require_once "config.php";

$username = $_POST['username'];
$password = $_POST['password'];
$detail_id = $_SESSION['detail_id'];
$account_type = $_SESSION['account_type'];

$userQuery = "INSERT INTO systemuser VALUES ('', '$username', '$password', '$account_type', '$detail_id')";
$result = mysqli_query($connect,$userQuery);

if(!$result){
    die("Error Try Again $userQuery".mysqli_error($connect));
}
else{
    header("location: login.php");
}
    var_dump($_SESSION['account_type']); 
    exit;
?>