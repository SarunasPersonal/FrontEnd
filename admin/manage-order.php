<?php include('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="container text-center mx-auto" style="width: 500px;">
    <h1>Manage Orders</h1>
    <?php
 

    $sql = "SELECT o.order_id, o.order_date, o.total_amount, u.username, u.email
            FROM tbl_order o
            JOIN tbl_users u ON o.user_id = u.user_id
            ORDER BY o.order_date DESC";
    $result = $conn->query($sql);
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Username</th>
                <th>Email</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["order_id"] . "</td>";
                    echo "<td>" . $row["order_date"] . "</td>";
                    echo "<td>" . $row["total_amount"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td><a href='order-details.php?order_id=" . $row["order_id"] . "'>View Details</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No orders found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<!-- Main Content Section Ends -->
<?php include('partials/footer.php'); ?>
