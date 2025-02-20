<html>
<link rel="stylesheet" href="main.css">
<div class=error>
    <?php
    session_start();
    include_once "config.php";

    $userQuery = "SELECT * FROM systemuser as u 
       INNER JOIN user_detail as e ON u.detail_id = e.detail_id 
       WHERE username = '" . mysqli_real_escape_string($connect, $_POST['username']) . "'";

    $result = mysqli_query($connect, $userQuery);

    if (!$result) {
        die("Could not successfully run the query $userQuery" . mysqli_error($connect));
    }

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['errors_msg'] = "Username or Password is incorrect.";
        header("Location: login.php");
        exit();
    } else {
        $row = mysqli_fetch_assoc($result);

        if ($_POST['username'] == $row['username'] && $_POST['password'] == $row['password']) {
            // เซ็ต session ของ user
            $_SESSION['username'] = $row['username'];
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];
            $_SESSION['level'] = $row['level'];

            // ✅ ล้างตะกร้าสินค้า
            unset($_SESSION['cart']);

            // ✅ Redirect ตามระดับของผู้ใช้
            if ($_SESSION['level'] == 1 || $_SESSION['level'] == 2) {
                header("Location: showProduct.php");
            } elseif ($_SESSION['level'] == 3) {
                header("Location: displayProduct.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $_SESSION['errors_msg'] = "Username or Password is incorrect.";
            header("Location: login.php");
            exit();
        }
    }


    ?>
</div>

</html>