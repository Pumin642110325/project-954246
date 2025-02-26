<?php
include_once "./partials/layout.php";
include_once "./partials/navbar.php";
$userQuery = "SELECT * FROM product";
$result = mysqli_query($connect, $userQuery);

if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}

// นับจำนวนสินค้า
$productCount = mysqli_num_rows($result);
?>


<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="picture\Screenshot (137).png" class="d-block w-100" alt="Recommended Product">
        </div>
        <div class="carousel-item">
            <img src="picture\Screenshot (139).png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Second slide label</h5>
                <p>Some representative placeholder content for the second slide.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="picture\Screenshot (138).png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Third slide label</h5>
                <p>Some representative placeholder content for the third slide.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

</div>

<div class="container mt-4">
    <!-- Display product count -->
    <p class="fs-3 fw-bold">รายการสินค้า (<?= $productCount ?> รายการ)</p>

    <!-- Responsive grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($row['picture']) ?>" class="card-img-top"
                        alt="<?= htmlspecialchars($row['productName']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold"><?= htmlspecialchars($row['productName']) ?></h5>
                        <p class="card-text my-1"><?= htmlspecialchars($row['detail']) ?></p>
                        <p class="card-text my-1"><strong>Price:</strong> <?= htmlspecialchars($row['price']) ?> บาท</p>
                        <p class="card-text my-1"><strong>Stock:</strong> <?= htmlspecialchars($row['qty']) ?></p>
                    </div>
                    <div class="d-flex flex-column gap-2 p-2">
                        <a href='detail.php?id=<?= $row['productID'] ?>' class="btn btn-light btn-sm w-100">รายละเอียด</a>

                        <!-- Form สำหรับเพิ่มสินค้าเข้าตะกร้า -->
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="productID" value="<?= $row['productID'] ?>">
                            <input type="hidden" name="productName" value="<?= htmlspecialchars($row['productName']) ?>">
                            <input type="hidden" name="price" value="<?= $row['price'] ?>">
                            <input type="hidden" name="picture" value="<?= htmlspecialchars($row['picture']) ?>">

                            <div class="d-flex">
                                <input type="number" name="quantity" value="1" min="1" max="<?= $row['qty'] ?>"
                                    class="form-control form-control-sm me-2" style="width: 60px;">
                                <button type="submit" name="add_to_cart" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-bag-plus" style="font-size: 1rem;"></i>
                                    ใส่ตะกร้า
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<!DOCTYPE html>
<html lang="th">

<body>
    <div class="container mt-4">
      