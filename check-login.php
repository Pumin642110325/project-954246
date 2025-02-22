<html>
<link rel="stylesheet" href="main.css">
<div class="error">
    <?php
    session_start();
    include_once "config.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $password = mysqli_real_escape_string($connect, $_POST['password']);

        // Prepare query to prevent SQL injection
        $userQuery = "SELECT u.*, e.firstname, e.lastname FROM systemuser AS u 
                      INNER JOIN user_detail AS e ON u.detail_id = e.detail_id 
                      WHERE u.username = ?";

        if ($stmt = mysqli_prepare($connect, $userQuery)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 0) {
                $_SESSION['errors_msg'] = "Username or Password is incorrect.";
                header("Location: login.php");
                exit();
            } else {
                $row = mysqli_fetch_assoc($result);

                // Compare passwords (assuming plaintext, replace with password_verify if hashed)
                if ($password == $row['password']) {

                    // Set session variables
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['firstname'] = $row['firstname'];
                    $_SESSION['lastname'] = $row['lastname'];
                    $_SESSION['level'] = $row['level'];

                    // Clear cart after login
                    unset($_SESSION['cart']);

                    // Redirect based on user level
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

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    }
    ?>
</div>

</html>