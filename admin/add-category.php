<?php
// Start output buffering
ob_start();
include("partials/menu.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="wrapper">
            <h1 class="text-center">Add Category</h1>
            <br><br>
            <div class="text-center">
                <?php
                if (isset($_SESSION['add'])) {
                    if ($_SESSION['add'] === "Category Added Successfully") {
                        echo '<div class="text-success">' . $_SESSION['add'] . '</div>';
                    } else {
                        echo '<div class="text-danger">' . $_SESSION['add'] . '</div>';
                    }
                    unset($_SESSION['add']);
                }
                ?>
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="title">Category Title:</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Category Title">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
            </form>
        </div>
    </div>
    <?php include('partials/footer.php'); ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
    $title = $_POST['title'];

    // Insert into database
    $sql = "INSERT INTO tbl_category (title) VALUES ('$title')";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['add'] = "Category Added Successfully";
        header("location:" . SITEURL . 'admin/manage-category.php');
        exit(); // Added to prevent further execution
    } else {
        $_SESSION['add'] = "Failed to Add Category";
        header("location:" . SITEURL . 'admin/add-category.php');
        exit(); // Added to prevent further execution
    }
}

// Flush the output buffer and end output buffering
ob_end_flush();
?>
