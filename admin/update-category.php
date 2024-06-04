<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="container text-center">
        <h1>Update Category Title</h1>

        <br><br>

        <?php 
            // Check if the ID is set
            if(isset($_GET['id'])) {
                $id = $_GET['id'];
                // Fetch category details from the database
                $sql = "SELECT * FROM tbl_category WHERE id=$id";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count == 1) {
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                } else {
                    // Redirect with error message if category not found
                    $_SESSION['no-category-found'] = "<div class='error'>Category not found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    exit;
                }
            } else {
                // Redirect if ID is not set
                header('location:'.SITEURL.'admin/manage-category.php');
                exit;
            }
        ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="title">Category Title:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
                    </div>
                    <div class="text-center">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                        <button type="submit" name="submit" class="btn btn-primary">Update Title</button>
                    </div>
                </form>
            </div>
        </div>

        <?php 
            if(isset($_POST['submit'])) {
                // Process form submission
                $newTitle = $_POST['title'];
                // Update the title in the database
                $sql = "UPDATE tbl_category SET title='$newTitle' WHERE id=$id";
                $res = mysqli_query($conn, $sql);
                if($res) {
                    $_SESSION['update'] = "<div class='success'>Category title updated successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    exit;
                } else {
                    $_SESSION['update'] = "<div class='error'>Failed to update category title.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                    exit;
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
