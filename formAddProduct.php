<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php 
    include_once './partials/layout.php'; 
    include_once './partials/navbar.php'; 
    ?>

    <div class="container mt-5">
        <?php if($_SESSION['level'] >= 3) { ?>
        <div class="card">
            <div class="card-header bg-dark text-warning">
                <h2 class="mb-0">Add New Product</h2>
            </div>
            <div class="card-body">
                <form action="addProduct.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Department ID</label>
                        <input type="text" class="form-control" value="Auto_increment" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" required>
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail</label>
                        <input type="text" class="form-control" id="detail" name="detail" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="qty" name="qty" required>
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="form-label">Picture URL</label>
                        <input type="text" class="form-control" id="picture" name="picture">
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="displayProduct.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php } else { ?>
        <div class="alert alert-danger mt-4" role="alert">
            <h4 class="alert-heading">Access Denied</h4>
            <p>You are unable to access the data, please try again.</p>
        </div>
        <?php } ?>
    </div>

</body>

</html>
<?php include_once  './partials/footer.php'; ?>