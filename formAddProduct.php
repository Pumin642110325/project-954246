<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add employee</title>
</head>

<body>
<?php 
include_once  './partials/header.php'; 
?>


<?php if($_SESSION['level']==4) { ?>
    <form action="addProduct.php" method="post">
        <div class="head">
            <h2>Add New Product</h2>
        </div>
        <table>
            <tr>
                <th><label for="text">Department_id</label></th>
                <td>Auto_increment</td>
            </tr>
            <tr>
                <th><label for="text">Product Name</label></th>
                <td><input type="text" name="productName"></td>
            </tr>
            <tr>
                <th><label for="text">Detail</label></th>
                <td><input type="text" name="detail"></td>
            </tr>
            <tr>
                <th><label for="text">Price</label></th>
                <td><input type="text" name="price"></td>
            </tr>
            <tr>
                <th><label for="text">Qty</label></th>
                <td><input type="text" name="qty"></td>
            </tr>
            <tr>
                <th><label for="text">Picture</label></th>
                <td><input type="text" name="picture"></td>
            </tr>
        </table><br>
        <input type="submit" value="Submit">
    </form>
    <?php } 
    else {
        echo "<h3 class='error'>You are unable to access the data, please try again</h3>"; 
    } ?>
</body>
<?php 
include_once  './partials/footer.php'; 
?>
</html>