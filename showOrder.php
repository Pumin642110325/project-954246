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

// Check if 'user_id' column exists in 'orders' table
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
        <h2 class="mb-4">📋 รายการสั่งซื้อ</h2>

        <?php
        // Admin (level 3) can see all orders
        if ($user_level == 3) {
            $orderQuery = "SELECT o.*, u.username, u.level AS order_user_level 
                           FROM orders o 
                           JOIN systemuser u ON o.user_id = u.user_id 
                           ORDER BY o.created_at DESC";
        } else {
            // Regular user can see only their orders
            $orderQuery = "SELECT o.*, u.level AS order_user_level 
                           FROM orders o 
                           JOIN systemuser u ON o.user_id = u.user_id 
                           WHERE o.user_id = ? 
                           ORDER BY o.created_at DESC";
        }

        // Prepare and execute the query
        if ($stmt = mysqli_prepare($connect, $orderQuery)) {
            if ($user_level != 3) {
                mysqli_stmt_bind_param($stmt, "i", $user_id);
            }
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0):
                while ($order = mysqli_fetch_assoc($result)):
                    $order_user_level = $order['order_user_level']; // Level ของคนที่สั่งซื้อ
                    ?>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <strong>รหัสคำสั่งซื้อ:</strong> <?= $order['id']; ?> |
                                <strong>ชื่อลูกค้า:</strong>
                                <?= $user_level == 3 ? htmlspecialchars($order['username']) : htmlspecialchars($_SESSION['username']); ?>
                                |
                                <strong>ชื่อผู้รับสินค้า:</strong> <?= htmlspecialchars($order['customer_name']); ?> |
                                <strong>วันที่สั่งซื้อ:</strong> <?= $order['created_at']; ?> |
                                <?php
                        $status_badge = '';
                        switch ($order['status']) {
                            case 'กำลังดำเนินการ':
                                $status_badge = '<span class="badge bg-warning text-dark">กำลังดำเนินการ</span>';
                                break;
                            case 'จัดส่งแล้ว':
                                $status_badge = '<span class="badge bg-primary">จัดส่งแล้ว</span>';
                                break;
                            case 'เสร็จสิ้น':
                                $status_badge = '<span class="badge bg-success">เสร็จสิ้น</span>';
                                break;
                            case 'ยกเลิก':
                                $status_badge = '<span class="badge bg-danger">ยกเลิก</span>';
                                break;
                            default:
                                $status_badge = '<span class="badge bg-secondary">ไม่ทราบสถานะ</span>';
                        }
                        echo $status_badge;
                    ?>
                            </div>
                            <?php if ($user_level == 3): ?>
                                <div>
                                    <!-- ปุ่มแก้ไขออเดอร์ -->
                                    <a href="updateOrder.php?id=<?= $order['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <!-- ปุ่มลบออเดอร์ พร้อมยืนยันการลบ -->
                                    <a href="deleteOrder.php?id=<?= $order['id']; ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบออเดอร์นี้?');">ลบ</a>
                                </div>
                            <?php endif; ?>
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

                                    $order_total = 0; // ตัวแปรสำหรับเก็บผลรวมจากรายการสินค้า
                                    while ($item = mysqli_fetch_assoc($itemResult)):
                                        $order_total += $item['subtotal'];
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($item['product_name']); ?></td>
                                            <td><?= number_format($item['price'], 2); ?> บาท</td>
                                            <td><?= $item['quantity']; ?></td>
                                            <td><?= number_format($item['subtotal'], 2); ?> บาท</td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>ราคารวมจากรายการสินค้า:</strong></td>
                                        <td><?= number_format($order_total, 2); ?> บาท</td>
                                    </tr>
                                    <?php
                                    // คำนวณส่วนลดตามเลเวลของ User ที่สั่งซื้อ
                                    $discount_percentage = ($order_user_level == 2) ? 10 : 0;
                                    $discount_amount = ($order_total * $discount_percentage) / 100;
                                    $final_total = $order_total - $discount_amount;
                                    ?>
                                    <?php if ($discount_percentage > 0): ?>
                                        <tr>
                                            <td colspan="3" class="text-end text-danger"><strong>ส่วนลด (<?= $discount_percentage; ?>%):</strong></td>
                                            <td class="text-danger">-<?= number_format($discount_amount, 2); ?> บาท</td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>ยอดรวมสุทธิ:</strong></td>
                                        <td><strong><?= number_format($final_total, 2); ?> บาท</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <?php
                endwhile;
            else:
                echo "<div class='alert alert-info'>ไม่มีคำสั่งซื้อที่บันทึกไว้</div>";
            endif;
        }
        ?>
    </div>
</body>
</html>
