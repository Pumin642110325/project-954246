<?php
require_once "config.php";
include_once "./partials/layout.php";
include_once "./partials/navbar.php";

$productID = $_GET['id'];
$userQuery = "SELECT * FROM product WHERE productID = $productID";
$result = mysqli_query($connect, $userQuery);

if (!$result) {
    die("Could not successfully run the query $userQuery. " . mysqli_error($connect));
} else {
    echo '<div class="container mt-5">';
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

        </head>

        <body>
            <div class="card">
                <div class="card-header bg-dark text-warning">
                    <h2 class="mb-0">Edit Product</h2>
                </div>
                <div class="card-body">
                    <form action="checkUpdateProduct.php?id=<?php echo $productID; ?>" method="post" class="needs-validation"
                        novalidate>
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName"
                                value="<?= htmlspecialchars($row['productName']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail</label>
                            <input type="text" class="form-control" id="detail" name="detail"
                                value="<?= htmlspecialchars($row['detail']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price"
                                value="<?= htmlspecialchars($row['price']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="qty" name="qty"
                                value="<?= htmlspecialchars($row['qty']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="picture" class="form-label">Picture URL</label>
                            <input type="text" class="form-control" id="picture" name="picture"
                                value="<?= htmlspecialchars($row['picture']) ?>">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                           
                            <a href="displayProduct.php"  class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </body>

        </html>
        <?php
    }
    echo '</div>'; // Close container
}
?>
<?php include_once './partials/footer.php'; ?>