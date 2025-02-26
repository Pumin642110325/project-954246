<?php
$title = "Register";
include_once "config.php";
include_once "./partials/layout.php";
$bgImage = "./picture/background-violin-notext.jpg";
?>

<div class='d-flex flex-column flex-grow-1 container-fluid justify-content-center align-items-center'
    style="background-image: url('<?php echo $bgImage; ?>'); background-size: cover; background-position: center; height: 100vh;">
    <div class="login-wrap">
        <h2 class="text-center mt-5 fw-bold text-primary text-warning">Register</h2>

        <form id="registerForm" action="adduser_db.php" method="POST" class="border p-4 rounded shadow mt-1 bg-light">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="button" class="btn btn-warning w-100" id="registerBtn">Register</button>
        </form>
    </div>
</div>

<?php include_once "footer.php"; ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById("registerBtn").addEventListener("click", function () {
        Swal.fire({
            title: "ยืนยันการสมัครสมาชิก?",
            text: "กรุณาตรวจสอบข้อมูลของคุณให้ถูกต้อง",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่, ลงทะเบียน!",
            cancelButtonText: "ยกเลิก"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("registerForm").submit();
            }
        });
    });
</script>
