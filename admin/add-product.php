<?php
ob_start();
// Include the menu file to maintain consistency across pages
include ('partials/menu.php');

// Check if a session message is set for product addition or update
if (isset($_SESSION['add'])) {
    // Display success or error message based on session data
    if ($_SESSION['add'] === "Product Added Successfully") {
        echo '<div class="alert alert-success">' . $_SESSION['add'] . '</div>';
    } else {
        echo '<div class="alert alert-danger">' . $_SESSION['add'] . '</div>';
    }
    // Unset the session variable to prevent displaying the message again
    unset($_SESSION['add']);

    if (isset($_SESSION['update'])) {
        echo '<div class="alert alert-success">' . $_SESSION['update'] . '</div>';
        unset($_SESSION['update']);
    }
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center">Add Product</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" name="price" id="price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" name="image" id="image" class="form-control-file">
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
                                $id = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$id'>$title</option>";
                            }
                        } else {
                            echo "<option value='0'>No category found</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
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

    // Handle file upload
    $image_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    // Check if all required fields are filled
    if ($title != '' && $price != '' && $category_id != '') {
        // Check if an image is uploaded
        if (!empty($image_name)) {
            // Move the uploaded file to the desired location
            $upload_path = "../images/product/";
            $target_file = $upload_path . basename($image_name);
            move_uploaded_file($tmp_name, $target_file);
        } else {
            // Set a default image if no image is uploaded
            $image_name = 'default_product_image.jpg';
        }

        // Insert product details into the database
        $sql = "INSERT INTO tbl_product (title, description, price, quantity, image_name, category_id) VALUES ('$title', '$description', '$price', '$quantity', '$image_name', '$category_id')";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            // Set success message in session variable
            $_SESSION['add'] = "Product Added Successfully";
            // Redirect to manage product page
            header('location:' . SITEURL . 'admin/manage-product.php');
            exit;
        } else {
            // Set error message in session variable
            $_SESSION['add'] = "Failed to Add Product";
            // Redirect back to add product page
            header('location:' . SITEURL . 'admin/add-product.php');
            exit;
        }
    } else {
        // Set error message in session variable
        $_SESSION['add'] = "Please fill all the fields";
        // Redirect back to add product page
        header('location:' . SITEURL . 'admin/add-product.php');
        exit;
    }
}
?>

<?php
// Include the footer file
include ('partials/footer.php');
ob_end_flush();
?>
