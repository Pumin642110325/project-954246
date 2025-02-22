<?php
session_start();
require_once "config.php";

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบและเป็นแอดมิน (level 3)
if (!isset($_SESSION['user_id']) || $_SESSION['level'] != 3) {
    die("คุณไม่มีสิทธิ์ในการเข้าถึงหน้านี้");
}

// รับค่า order_id จาก URL
if (!isset($_GET['id'])) {
    die("ไม่พบคำสั่งซื้อที่ต้องการแก้ไข");
}

$order_id = intval($_GET['id']);
$errors = [];
$success_message = "";

// เมื่อมีการส่งฟอร์มเพื่ออัปเดตคำสั่งซื้อ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'];
    $customer_name = trim($_POST['customer_name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    // ตรวจสอบสถานะที่เลือก
    $valid_statuses = ['กำลังดำเนินการ', 'จัดส่งแล้ว', 'เสร็จสิ้น', 'ยกเลิก'];
    if (!in_array($new_status, $valid_statuses)) {
        $errors[] = "สถานะไม่ถูกต้อง";
    }

    // ตรวจสอบข้อมูลผู้รับ
    if (empty($customer_name)) {
        $errors[] = "กรุณากรอกชื่อผู้รับสินค้า";
    }
    if (empty($address)) {
        $errors[] = "กรุณากรอกที่อยู่จัดส่ง";
    }
    if (empty($phone)) {
        $errors[] = "กรุณากรอกเบอร์โทรศัพท์";
    }

    if (empty($errors)) {
        // อัปเดตสถานะและข้อมูลผู้รับในฐานข้อมูล
        $updateQuery = "UPDATE orders SET status = ?, customer_name = ?, address = ?, phone = ? WHERE id = ?";
        $stmt = mysqli_prepare($connect, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ssssi", $new_status, $customer_name, $address, $phone, $order_id);

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "✅ อัปเดตคำสั่งซื้อสำเร็จ!";
        } else {
            $errors[] = "❌ เกิดข้อผิดพลาดในการอัปเดตคำสั่งซื้อ: " . mysqli_error($connect);
        }

        mysqli_stmt_close($stmt);
    }
}

// ดึงข้อมูลคำสั่งซื้อเพื่อแสดงในฟอร์ม
$orderQuery = "SELECT * FROM orders WHERE id = ?";
$stmt = mysqli_prepare($connect, $orderQuery);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($order = mysqli_fetch_assoc($result)) {
    ?>
    <!DOCTYPE html>
    <html lang="th">

    <head>
        <meta charset="UTF-8">
        <title>แก้ไขคำสั่งซื้อ</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container mt-5">
            <h2 class="mb-4">📝 แก้ไขคำสั่งซื้อ: #<?= $order['id']; ?></h2>

            <!-- แสดงข้อความสำเร็จ -->
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <!-- แสดงข้อผิดพลาด -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- ฟอร์มแก้ไขคำสั่งซื้อ -->
            <form method="POST">
                <div class="mb-3">
                    <label for="status" class="form-label">สถานะคำสั่งซื้อ:</label>
                    <select name="status" id="status" class="form-select" required>
                        <?php
                        $statuses = ['กำลังดำเนินการ', 'จัดส่งแล้ว', 'เสร็จสิ้น', 'ยกเลิก'];
                        foreach ($statuses as $status) {
                            $selected = $order['status'] === $status ? 'selected' : '';
                            echo "<option value=\"$status\" $selected>$status</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="customer_name" class="form-label">ชื่อผู้รับสินค้า</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                        value="<?= htmlspecialchars($order['customer_name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">ที่อยู่จัดส่ง</label>
                    <textarea class="form-control" id="address" name="address" rows="3"
                        required><?= htmlspecialchars($order['address']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="<?= htmlspecialchars($order['phone']); ?>" required>
                </div>

                <button type="submit" class="btn btn-success">💾 บันทึกการเปลี่ยนแปลง</button>
                <a href="showOrder.php?msg=Order%20deleted%20successfully" class="btn btn-secondary">🔙 กลับไปหน้ารายการสั่งซื้อ</a>
            </form>
        </div>
    </body>

    </html>
    <?php
} else {
    echo "<div class='alert alert-danger'>ไม่พบคำสั่งซื้อที่ระบุ</div>";
}

mysqli_stmt_close($stmt);
?>
