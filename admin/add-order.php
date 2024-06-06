<?php include('partials/menu.php'); ?>
<!-- Main Content Section Starts -->
<div class="container text-center mx-auto" style="width: 500px;">
    <h1>Add Order</h1>
    <?php

    // Fetch all users for the user selection dropdown
    $users_sql = "SELECT user_id, username FROM tbl_users";
    $users_result = $conn->query($users_sql);

    // Fetch all products for the product selection dropdown
    $products_sql = "SELECT product_id, title, price FROM tbl_product";
    $products_result = $conn->query($products_sql);
    ?>

    <form action="process-add-order.php" method="post">
        <div class="form-group">
            <label for="user_id">Select User:</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <?php
                if ($users_result->num_rows > 0) {
                    while($user = $users_result->fetch_assoc()) {
                        echo "<option value='" . $user["user_id"] . "'>" . $user["username"] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="products">Select Products:</label>
            <div id="products">
                <?php
                if ($products_result->num_rows > 0) {
                    while($product = $products_result->fetch_assoc()) {
                        echo "<div class='product-item'>";
                        echo "<input type='checkbox' name='product_ids[]' value='" . $product["product_id"] . "'>";
                        echo "<label>" . $product["title"] . " (Price: $" . $product["price"] . ")</label>";
                        echo "<input type='number' name='quantities[" . $product["product_id"] . "]' min='1' value='1' class='form-control' style='width: 60px; display: inline-block;'>";
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Order</button>
    </form>
</div>
<!-- Main Content Section Ends -->
<?php include('partials/footer.php'); ?>
