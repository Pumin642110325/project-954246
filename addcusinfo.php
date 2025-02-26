ใช้พื้นที่เก็บข้อมูลไป 80% … หากพื้นที่เต็ม คุณจะสร้าง แก้ไข และอัปโหลดไฟล์ไม่ได้ รับพื้นที่เก็บข้อมูลขนาด 100 GB ในราคา ฿70.00 ฿17.00/เดือน เป็นเวลา 2 เดือน
<?php 
$title = "Register"; 
include_once "config.php";
include_once "./partials/layout.php";
$bgImage = "background-violin-notext.jpg"
?>

<div class='d-flex flex-column flex-grow-1 container-fluid justify-content-center align-items-center' style="background-image: url('<?php echo $bgImage; ?>'); background-size: cover; background-position: center; height: 100vh;">
    <div class="login-wrap">
        <h2 class="text-center mt-5 fw-bold text-primary text-warning">Register</h2>

        <form action="addcusinfo_db.php" method="POST" class="border p-4 rounded shadow mt-1 bg-light">
            <div class="mb-3">
                <label class="form-label">Account Type :</label><br>
                <input type="radio" id="normal" name="account_type" value="1" checked>
                <label for="normal">Normal User</label>
                <input type="radio" id="member" name="account_type" value="2">
                <label for="member">Member (10% Discount)</label>
            </div>
            <div class="mb-3">
                <label for="fname" class="form-label">First name :</label>
                <input type="text" id="fname" name="fname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name :</label>
                <input type="text" id="lname" name="lname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone NO. :</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address :</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-warning w-100">Register</button>
        </form>
    </div>
</div>

<?php include_once  "./partials/footer.php";