<?php 
include ('partials/menu.php'); 
?>

<?php
if (isset($_SESSION['add'])) {
    if ($_SESSION['add'] === "Order Added Successfully") {
        echo '<div class="alert alert-success">' . $_SESSION['add'] . '</div>';
    } else {
        echo '<div class="alert alert-danger">' . $_SESSION['add'] . '</div>';
    }
    unset($_SESSION['add']);

    if (isset($_SESSION['update'])) {
        echo '<div class="alert alert-success">' . $_SESSION['update'] . '</div>';
        unset($_SESSION['update']);
    }
}
?>

<div class="container text-center mx-auto">
    <div class="wrapper">
        <h1>Manage Orders</h1>
        <br><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Order Date</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch orders from the database and display them in the table
                $sql = "SELECT * FROM tbl_orders";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $order_id = $row['order_id'];
                        $user_id = $row['user_id'];
                        $order_date = $row['order_date'];
                        $total_amount = $row['total_amount'];

                        // Retrieve customer name based on user_id from tbl_users
                        $sql_user = "SELECT username FROM tbl_users WHERE id = $user_id";
                        $res_user = mysqli_query($conn, $sql_user);
                        $row_user = mysqli_fetch_assoc($res_user);
                        $customer_name = $row_user['username'];
                ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $order_date; ?></td>
                    <td><?php echo $total_amount; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $order_id; ?>" class="btn btn-secondary">Update Order</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-order.php?id=<?php echo $order_id; ?>" class="btn btn-danger">Delete Order</a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    // If no orders found
                    echo '<tr><td colspan="5" class="text-center">No orders found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php include ('partials/footer.php'); ?>
