<?php
session_start();
require_once "config.php"; 
include_once "./partials/layout.php";
include_once "./partials/navbar.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '
    <div class="container mt-5 text-center">
        <h3>กรุณาเข้าสู่ระบบเพื่อดูรายการสั่งซื้อ</h3>
        <a href="login.php" class="btn btn-primary mt-3">🔑 กลับไปหน้าเข้าสู่ระบบ</a>
    </div>';
    exit();
}

$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['level']; 
$columnsQuery = "SHOW COLUMNS FROM orders LIKE 'user_id'";
$columnsResult = mysqli_query($connect, $columnsQuery);

if (mysqli_num_rows($columnsResult) == 0) {
    echo '
    <div class="container mt-5 text-center">
        <h3>ตาราง orders ไม่มีคอลัมน์ user_id กรุณาอัปเดตโครงสร้างฐานข้อมูล</h3>
        <a href="login.php" class="btn btn-primary mt-3">🔑 กลับไปหน้าเข้าสู่ระบบ</a>
    </div>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งซื้อของฉัน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">📋 รายการสั่งซื้อของฉัน</h2>

        <?php
        // Admin (level 3) can see all orders
        if ($user_level == 3) {
            $orderQuery = "SELECT o.*, u.username FROM orders o JOIN systemuser u ON o.user_id = u.user_id ORDER BY o.created_at DESC";
        } else {
            // Regular user can see only their orders
            $orderQuery = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        }

        // Prepare and execute the query
        if ($stmt = mysqli_prepare($connect, $orderQuery)) {
            if ($user_level != 3) {
                mysqli_stmt_bind_param($stmt, "i", $user_id);
            }
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) :
                while ($order = mysqli_fetch_assoc($result)) :
        ?>
        <div class="card mb-4">
            <div class="card-header">
                <strong>รหัสคำสั่งซื้อ:</strong> <?= $order['id']; ?> |
                <strong>ชื่อลูกค้า:</strong>
                <?= $user_level == 3 ? htmlspecialchars($order['username']) : htmlspecialchars($_SESSION['username']); ?>
                |
                <strong>ชื่อผู้รับสินค้า:</strong> <?= htmlspecialchars($order['customer_name']); ?> |
                <strong>รวม:</strong> <?= number_format($order['total'], 2); ?> บาท |
                <strong>วันที่สั่งซื้อ:</strong> <?= $order['created_at']; ?>
            </div>

            <div class="card-body">
                <h5 class="card-title">รายการสินค้า</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวน</th>
                            <th>รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Fetch order items for this order
                            $order_id = $order['id'];
                            $itemQuery = "SELECT * FROM order_items WHERE order_id = ?";
                            $itemStmt = mysqli_prepare($connect, $itemQuery);
                            mysqli_stmt_bind_param($itemStmt, "i", $order_id);
                            mysqli_stmt_execute($itemStmt);
                            $itemResult = mysqli_stmt_get_result($itemStmt);

                            while ($item = mysqli_fetch_assoc($itemResult)) :
                            ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']); ?></td>
                            <td><?= number_format($item['price'], 2); ?> บาท</td>
                            <td><?= $item['quantity']; ?></td>
                            <td><?= number_format($item['subtotal'], 2); ?> บาท</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <p><strong>ที่อยู่จัดส่ง:</strong> <?= nl2br(htmlspecialchars($order['address'])); ?></p>
                <p><strong>เบอร์โทรศัพท์:</strong> <?= htmlspecialchars($order['phone']); ?></p>
            </div>
        </div>
        <?php
                endwhile;
            else :
                echo "<div class='alert alert-info'>ไม่มีคำสั่งซื้อที่บันทึกไว้</div>";
            endif;

            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการดึงข้อมูลคำสั่งซื้อ</div>";
        }
        ?>

        <div class="mt-4">
            <a href="showProduct.php" class="btn btn-primary">🛍️ กลับไปหน้ารายการสินค้า</a>
        </div>
    </div>

    <?php include_once "./partials/footer.php"; ?>
</body>

</html>