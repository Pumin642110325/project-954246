<?php
require_once "config.php";

$userQuey="Select * from product";
$result = mysqli_query($connect, $userQuey);

echo"<a href=\"form_add_product.html\">Add a new product</a><br><br>";
if(!$result){
    die("Could not successfully run the query $userQuey ".mysqli_error($connect));
}

if(mysqli_num_rows($result)==0){
    echo"No record were found with query $userQuery";
}
else{
    echo "<table border =\"1\">";
 while ($row = mysqli_fetch_assoc($result))
 {
 echo 
 "<tr><td>".$row['productID']."</td><td>"
    .$row['productName']."</td><td>"
    .$row['detail']."</td><td>"
    .$row['price']."</td><td>"
    .$row['qty']."</td><td>"
    .$row['pictre']."</td><td>";
 }
    echo "</table>";
 }

 mysqli_close($connect);


 ?>