<?php
include ('partials/menu.php');?>

<?php

// Check if a session message is set for product deletion or update
if (isset($_SESSION['delete'])) {
    if ($_SESSION['delete'] === "Product Deleted Successfully") {
        echo '<div class="alert alert-success">' . $_SESSION['delete'] . '</div>';
    } else {
        echo '<div class="alert alert-danger">' . $_SESSION['delete'] . '</div>';
    }
    unset($_SESSION['delete']);

    if (isset($_SESSION['update'])) {
        echo '<div class="alert alert-success">' . $_SESSION['update'] . '</div>';
        unset($_SESSION['update']);
    }
}

?>

<div class="container mt-5">
    <div class="mb-3">
        <a href="<?php echo SITEURL; ?>admin/add-product.php" class="btn btn-primary">Add New Product</a>
    </div>
    <h1 class="text-center">Manage Products</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Category</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch products from the database and display them in the table
            $sql = "SELECT p.*, c.title AS category_title FROM tbl_product p JOIN tbl_category c ON p.category_id = c.id";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                $sn = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $product_id = $row['product_id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $quantity = $row['quantity'];
                    $category = $row['category_title'];
            ?>
                    <tr>
                        <th scope="row"><?php echo $sn++; ?></th>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $description; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $category; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-product.php?id=<?php echo $product_id; ?>" class="btn btn-secondary">Update</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-product.php?id=<?php echo $product_id; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                // If no products found
                echo '<tr><td colspan="7" class="text-center">No products found</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php
// Include the footer file
include ('partials/footer.php');
?>
