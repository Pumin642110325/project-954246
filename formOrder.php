<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    include_once './partials/layout.php';
    include_once './partials/navbar.php';

    // สมมติว่าคุณได้ข้อมูลจาก session หรือแหล่งอื่น ๆ
    $productID = 123; // ตัวอย่าง Product ID ที่เลือก
    $firstname = "John"; // ชื่อผู้ใช้
    $lastname = "Doe"; // นามสกุลผู้ใช้
    $email = "john.doe@example.com"; // อีเมล
    $pnumber = "1234567890"; // เบอร์โทรศัพท์
    ?>

    <div class="container mt-5">
        <?php if ($_SESSION['level'] >= 1) { ?>
            <div class="card">
                <div class="card-header bg-dark text-warning">
                    <h2 class="mb-0">Your Order</h2>
                </div>
                <div class="card-body">
                    <form action="addOrder.php" method="post">
                        <div class="mb-3">
                            <label for="productID" class="form-label">Product ID</label>
                            <input type="text" class="form-control" id="productID" name="productID" value="<?php echo $productID; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="pnumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="pnumber" name="pnumber" value="<?php echo $pnumber; ?>" readonly>
                        </div>
                        <!-- ข้อมูลที่อยู่ -->
                        <div class="mb-3">
                            <label for="street_address" class="form-label">Street Address</label>
                            <input type="text" class="form-control" id="street_address" name="street_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="mb-3">
                            <label for="state_province" class="form-label">State/Province</label>
                            <input type="text" class="form-control" id="state_province" name="state_province" required>
                        </div>
                        <div class="mb-3">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
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
                <p>You are unable to access this page, please try again.</p>
            </div>
        <?php } ?>
    </div>

</body>

</html>

<?php include_once './partials/footer.php'; ?>
