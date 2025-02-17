<?php
$sever = "localhost";
$user = "root";
$password = "";
$dbname = "642110325";

$connect = mysqli_connect($sever, $user, $password, $dbname);
if(!$connect){
    die ("ERROR:cannot connect to the database $dbname on sever $sever
    using username $user (".mysqli_connect_errno().",".mysqli_connect_error().")");
}
?>