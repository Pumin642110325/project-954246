<html>
<link rel="stylesheet" href="main.css">
<div class="error">
    <?php
    session_start();
    include_once "config.php"; // เชื่อมต่อฐานข้อมูล

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST หรือไม่
        $username = mysqli_real_escape_string($connect, $_POST['username']); // รับค่า username และป้องกัน SQL Injection
        $password = mysqli_real_escape_string($connect, $_POST['password']); // รับค่า password และป้องกัน SQL Injection

        // คำสั่ง SQL เพื่อดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $userQuery = "SELECT u.*, e.firstname, e.lastname FROM systemuser AS u 
                      INNER JOIN user_detail AS e ON u.detail_id = e.detail_id 
                      WHERE u.username = ?";

        if ($stmt = mysqli_prepare($connect, $userQuery)) { // เตรียมคำสั่ง SQL
            mysqli_stmt_bind_param($stmt, "s", $username); // ใส่ค่า username ลงไปใน SQL
            mysqli_stmt_execute($stmt); // รันคำสั่ง SQL
            $result = mysqli_stmt_get_result($stmt); // ดึงผลลัพธ์จากคำสั่ง SQL

            if (mysqli_num_rows($result) == 0) { // ถ้าไม่มีข้อมูลผู้ใช้ในฐานข้อมูล
                $_SESSION['errors_msg'] = "Username or Password is incorrect."; // บันทึกข้อความผิดพลาดลง Session
                header("Location: login.php"); // กลับไปที่หน้า login
                exit();
            } else {
                $row = mysqli_fetch_assoc($result); // ดึงข้อมูลของผู้ใช้

                // ตรวจสอบรหัสผ่าน (ใช้การเปรียบเทียบแบบปกติ)
                if ($password == $row['password']) {

                    // เก็บข้อมูลผู้ใช้ลงในตัวแปรเซสชัน
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['firstname'] = $row['firstname'];
                    $_SESSION['lastname'] = $row['lastname'];
                    $_SESSION['level'] = $row['level'];
                    $_SESSION['detail_id'] = $row['detail_id'];

                    // เคลียร์ตะกร้าสินค้าใน Session (ถ้ามี)
                    unset($_SESSION['cart']);

                    // ตรวจสอบระดับผู้ใช้และเปลี่ยนเส้นทางไปยังหน้าที่เหมาะสม
                    if ($_SESSION['level'] == 1 || $_SESSION['level'] == 2) {
                        header("Location: index.php");
                    } elseif ($_SESSION['level'] == 3) {
                        header("Location: displayProduct.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit();
                } else {
                    $_SESSION['errors_msg'] = "Username or Password is incorrect."; // แจ้งเตือนว่ารหัสผ่านไม่ถูกต้อง
                    header("Location: login.php"); // กลับไปที่หน้า login
                    exit();
                }
            }

            mysqli_stmt_close($stmt); // ปิด Statement เพื่อคืนทรัพยากร
        } else {
            echo "Error: " . mysqli_error($connect); // แสดงข้อผิดพลาดของ MySQL ถ้ามีปัญหาในการรัน SQL
        }
    }
    ?>
</div>
</html>
