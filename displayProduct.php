<html>
    <body>
        <div class="main-content">
            <?php 
            require_once "./partials/header.php";

                $userQuery = "SELECT count(*) AS total FROM product";
                $result = mysqli_query($connect, $userQuery);
                $row = mysqli_fetch_assoc($result);
                $count = $row['total'];
                $userQuery = "SELECT * FROM product";
                $result = mysqli_query($connect, $userQuery);
                if(!$result){
                    die("could not successfully run the query $userQuery".mysqli_error($connect));
                }
                if($_SESSION['level']>3){
                    if($_SESSION['level']>3){
                        echo '<a href="formAddProduct.php">Create New Product</a>';
                    }
            ?>
            <table border="1">
                <tr>
                    <th>Name</th>
                    <th>Detail</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Picture</th>
                    <?php
                    if($_SESSION['level']>2){
                        echo "<th>Action</th>";
                    } ?>
                </tr>
                    <?php
                    if(mysqli_num_rows($result)==0){
                        echo "<td colspan='3'>No records were found</td>";
                    }
                    else{
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "  <td>".$row['productName']."</td>";
                            echo "  <td>".$row['detail']."</td>";
                            echo "  <td>".$row['price']."</td>";
                            echo "  <td>".$row['qty']."</td>";
                            echo "  <td>".$row['picture']."</td>";

                            if($_SESSION['level']>2){
                                echo "<td><a href='updateProduct.php?id=" .$row['productID']."'>Edit</a>&nbsp;&nbsp;
                                <a href='deleteProduct.php?id=".$row['productID']."'>Delete</a></td>";
                            }
                            echo "</tr>";
                        }
                    } ?>
                <tr>
                    <td colspan="5"><?= $count ?> Records </td>
                </tr>
            </table>
            <?php  }else {
                echo "<h3 class='error'>You are unable to access the data, please try again</h3>";
            }
            ?>
        </div>
    </body>
</html>