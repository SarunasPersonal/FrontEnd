<?php
ob_start();
// Include the menu file to maintain consistency across pages
include('partials/menu.php');

// Check if a session message is set for product update
if (isset($_SESSION['update'])) {
    // Display success or error message based on session data
    if ($_SESSION['update'] === "Product Updated Successfully") {
        echo '<div class="alert alert-success">' . $_SESSION['update'] . '</div>';
    } else {
        echo '<div class="alert alert-danger">' . $_SESSION['update'] . '</div>';
    }
    // Unset the session variable to prevent displaying the message again
    unset($_SESSION['update']);
}

// Check if the id is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database
    $sql = "SELECT * FROM tbl_product WHERE product_id = $product_id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            // Product found, fetch product data
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $description = $row['description'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $category_id = $row['category_id'];
            $current_image = $row['image_name'];
        } else {
            // Product not found
            $_SESSION['update'] = "<div class='error'>Product not found.</div>";
            header('location:' . SITEURL . 'admin/manage-product.php');
            exit;
        }
    } else {
        // Failed to fetch product data
        $_SESSION['update'] = "<div class='error'>Failed to fetch product details.</div>";
        header('location:' . SITEURL . 'admin/manage-product.php');
        exit;
    }
} else {
    // Redirect to manage product page if id is not provided
    header('location:' . SITEURL . 'admin/manage-product.php');
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">Update Product</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?php echo $title; ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" class="form-control" rows="5"><?php echo $description; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" name="price" id="price" class="form-control" value="<?php echo $price; ?>">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="<?php echo $quantity; ?>" min="1">
                </div>
                <div class="form-group">
                    <label for="image">Current Image:</label><br>
                    <?php
                    if ($current_image != "") {
                        // Display current image
                    ?>
                        <img src="<?php echo SITEURL; ?>images/product/<?php echo $current_image; ?>" width="150px">
                    <?php
                    } else {
                        // Display placeholder image if no current image
                        echo "<div class='error'>Image not available.</div>";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="new_image">New Image:</label>
                    <input type="file" name="new_image" id="new_image" class="form-control-file">
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" class="form-control">
                        <?php
                        // Fetch categories from the database and display them in the dropdown
                        $sql = "SELECT * FROM tbl_category";
                        $res = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($res) > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $cat_id = $row['id'];
                                $cat_title = $row['title'];
                        ?>
                                <option value="<?php echo $cat_id; ?>" <?php if ($category_id == $cat_id) {
                                                                            echo "selected";
                                                                        } ?>><?php echo $cat_title; ?></option>
                        <?php
                            }
                        } else {
                            echo "<option value='0'>No category found</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <div class="form-group text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Process form submission

    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category_id = $_POST['category'];
    $current_image = $_POST['current_image'];
    $product_id = $_POST['product_id'];

    // Handle file upload
    $new_image_name = $_FILES['new_image']['name'];
    $tmp_name = $_FILES['new_image']['tmp_name'];

    // Check if all required fields are filled
    if ($title != '' && $price != '' && $category_id != '') {
        // Check if a new image is uploaded
        if (!empty($new_image_name)) {
            // Move the uploaded file to the desired location
            $upload_path = "../images/product/";
            $target_file = $upload_path . basename($new_image_name);
            move_uploaded_file($tmp_name, $target_file);
        } else {
            // If no new image uploaded, set the current image name
            $new_image_name = $current_image;
        }

        // Update product details in the database
        $sql = "UPDATE tbl_product SET 
                title = '$title', 
                description = '$description', 
                price = '$price', 
                quantity = '$quantity', 
                image_name = '$new_image_name', 
                category_id = '$category_id' 
                WHERE product_id = '$product_id'";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            // Set success message
            // Set success message in session variable
            $_SESSION['update'] = "Product Updated Successfully";
            // Redirect to manage product page
            header('location:' . SITEURL . 'admin/manage-product.php');
            exit;
        } else {
            // Set error message in session variable
            $_SESSION['update'] = "Failed to Update Product";
            // Redirect back to update product page
            header('location:' . SITEURL . 'admin/update-product.php?id=' . $product_id);
            exit;
        }
    } else {
        // Set error message in session variable
        $_SESSION['update'] = "Please fill all the fields";
        // Redirect back to update product page
        header('location:' . SITEURL . 'admin/update-product.php?id=' . $product_id);
        exit;
    }
}
?>

<?php
// Include the footer file
include('partials/footer.php');
ob_end_flush();
?>