<?php
require_once "config.php";

$productID = $_GET['id'];
$userQuery = "SELECT * FROM product WHERE productID = $productID";
    $result = mysqli_query($connect, $userQuery);

    if(!$result){
        die("Could not successfully run the query $userQuery".mysqli_error($connect));
    }
    else{
        echo "Update data<br><br>";
        while ($row = mysqli_fetch_assoc($result)){
?>
<html>
    <body>
        <form action="checkUpdateProduct.php?id=<?php echo $productID; ?>" method="post">
            <table width="416" border=0>
                <tr>
                    <td>Product Name</td>
                    <td><input type="text" name="productName" value="<?=$row['productName'] ?>"></td>
                </tr>
                <tr>
                    <td>detail</td>
                    <td><input type="text" name="detail" value="<?php echo $row['detail'] ?>"></td>
                </tr>
                <tr>
                    <td>pricel</td>
                    <td><input type="text" name="price" value="<?php echo $row['price'] ?>"></td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td><input type="text" name="qty" value="<?php echo $row['qty'] ?>"></td>
                </tr>
                <tr>
                    <td>picture</td>
                    <td><input type="text" name="picture" value="<?php echo $row['picture'] ?>"></td>
                </tr>
                <tr>
                    <td align="right"><input type="submit" name="button" values="Submit"></td>
                    <td><input type="reset" name="button2" values="Cancel"></td>
                </tr>
            </table>
        </form>
    </body>
</html>
<?php
        }
    }
?>