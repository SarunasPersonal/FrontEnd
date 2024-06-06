<?php include('partials/menu.php'); ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $product_ids = $_POST['product_ids'];
    $quantities = $_POST['quantities'];
    $total_amount = 0;

    // Calculate the total amount
    foreach ($product_ids as $product_id) {
        $product_sql = "SELECT price FROM tbl_product WHERE product_id = $product_id";
        $product_result = $conn->query($product_sql);
        if ($product_result->num_rows > 0) {
            $product = $product_result->fetch_assoc();
            $total_amount += $product['price'] * $quantities[$product_id];
        }
    }

    // Insert the order into tbl_order
    $insert_order_sql = "INSERT INTO tbl_order (user_id, total_amount) VALUES ($user_id, $total_amount)";
    if ($conn->query($insert_order_sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert each product into tbl_orders_details
        foreach ($product_ids as $product_id) {
            $quantity = $quantities[$product_id];
            $product_sql = "SELECT price FROM tbl_product WHERE product_id = $product_id";
            $product_result = $conn->query($product_sql);
            if ($product_result->num_rows > 0) {
                $product = $product_result->fetch_assoc();
                $order_price = $product['price'];

                $insert_order_detail_sql = "INSERT INTO tbl_orders_details (order_id, product_id, qty, order_price) VALUES ($order_id, $product_id, $quantity, $order_price)";
                $conn->query($insert_order_detail_sql);
            }
        }

        echo "Order added successfully!";
    } else {
        echo "Error: " . $insert_order_sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
