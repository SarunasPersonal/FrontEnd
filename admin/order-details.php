<?php include('partials/menu.php'); ?>
<!-- Main Content Section Starts -->
<div class="container text-center mx-auto" style="width: 500px;">
    <h1>Order Details</h1>
    <?php
    

    $order_id = intval($_GET['order_id']);

    $sql = "SELECT o.order_id, o.order_date, o.total_amount, u.username, u.email, u.shipping_address
            FROM tbl_order o
            JOIN tbl_users u ON o.user_id = u.user_id
            WHERE o.order_id = $order_id";
    $order_result = $conn->query($sql);

    $order_details_sql = "SELECT od.product_id, p.title, od.qty, od.order_price
                          FROM tbl_orders_details od
                          JOIN tbl_product p ON od.product_id = p.product_id
                          WHERE od.order_id = $order_id";
    $order_details_result = $conn->query($order_details_sql);
    ?>
    <?php
    if ($order_result->num_rows > 0
    ) {
        $order = $order_result->fetch_assoc();
        echo "<p><strong>Order ID:</strong> " . $order["order_id"] . "</p>";
        echo "<p><strong>Order Date:</strong> " . $order["order_date"] . "</p>";
        echo "<p><strong>Total Amount:</strong> " . $order["total_amount"] . "</p>";
        echo "<p><strong>Username:</strong> " . $order["username"] . "</p>";
        echo "<p><strong>Email:</strong> " . $order["email"] . "</p>";
        echo "<p><strong>Shipping Address:</strong> " . $order["shipping_address"] . "</p>";
    } else {
        echo "<p>Order not found</p>";
    }
    ?>
    <h2>Products in Order</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($order_details_result->num_rows > 0) {
                while ($detail = $order_details_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $detail["product_id"] . "</td>";
                    echo "<td>" . $detail["title"] . "</td>";
                    echo "<td>" . $detail["qty"] . "</td>";
                    echo "<td>" . $detail["order_price"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No products found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<!-- Main Content Section Ends -->
<?php include('partials/footer.php'); ?>
<?php $conn->close(); ?>