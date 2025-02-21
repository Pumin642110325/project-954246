<?php
include_once "./partials/layout.php";
include_once "./partials/navbar.php";
?>

<body>
    <img src="./picture/background-violin.png" alt="background-header-violin" class="img-header-display-product" />
    <div class="container mt-4">
        <div class="main-content">
            <?php
            include_once "./partials/layout.php";

            $userQuery = "SELECT count(*) AS total FROM class_order";
            $result = mysqli_query($connect, $userQuery);
            $row = mysqli_fetch_assoc($result);
            $count = $row['total'];
            $userQuery = "SELECT * FROM class_order";
            $result = mysqli_query($connect, $userQuery);
            if (!$result) {
                die("Could not successfully run the query $userQuery" . mysqli_error($connect));
            }
            if ($_SESSION['level'] >= 3) {
                echo '
                    <div class="d-flex justify-content-between">
                        <p class="fs-3 fw-bold">รายการเครื่องดนตรี</p>
                    </div>';
                ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr class="fs-4">
                                <th scope="col">Order ID</th>
                                <th scope="col">Product ID</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Address</th>
                                <th scope="col">Actions</th>
                                <?php if ($_SESSION['level'] >= 3): ?>
                                    <th scope="col">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) == 0): ?>
                                <tr>
                                    <tdcolspan="6" class="text-danger">No records were found</tdcolspan=>
                                </tr>
                            <?php else: ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr class="fs-5">
                                        <td><?= $row['order_id'] ?></td>
                                        <td><?= $row['productID'] ?></td>
                                        <td><?= htmlspecialchars($row['firstname']) ?></td>
                                        <td><?= htmlspecialchars($row['lastname']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['pnumber']) ?></td>
                                        <td><?= htmlspecialchars($row['address']) ?></td>
                                        <td>
                                            <a href='order_detail.php?id=<?= $row['order_id'] ?>'
                                                class="btn btn-primary btn-sm">ดูรายละเอียด</a>
                                        </td>
                                        <?php if ($_SESSION['level'] >= 3): ?>
                                            <td>
                                                <a href='updateOrder.php?id=<?= $row['order_id'] ?>'
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <a href='deleteOrder.php?id=<?= $row['order_id'] ?>' class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="fw-bold">Total Records: <?= $count ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php } else {
                echo "<div class='alert alert-danger'>You are unable to access the data, please try again</div>";
            }
            ?>
        </div>
    </div>
</body>