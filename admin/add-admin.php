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
    <title>Add Admin</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="wrapper">
            <h1 class="text-center">Add Admin</h1>
            <br><br>
            <div class="text-center">
                <?php
                if (isset($_SESSION['add'])) {
                    if ($_SESSION['add'] === "Admin Added Successfully") {
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
                    <label for="full_name">Full Name:</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Your Name">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Username">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Add Admin</button>
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
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password = '$password'";

    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    if ($res == TRUE) {
        $_SESSION['add'] = "Admin Added Successfully";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        $_SESSION['add'] = "Failed to Add Admin";
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}

// Flush the output buffer and end output buffering
ob_end_flush();
?>