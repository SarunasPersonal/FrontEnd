<?php 
include "partials/menu.php"; 

// Check if the connection is properly initialized
if (!isset($conn)) {
    die("Connection failed: Please check the database connection settings.");
}

if (isset($_GET['id'])) {
    //get the id of selected admin
    $id = $_GET['id'];

    //create sql query to get the details
    $sql = "SELECT * FROM tbl_admin WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        //check whether the query is executed or not
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            //echo "Admin Available";
            $row = mysqli_fetch_assoc($res);

            $full_name = $row['full_name'];
            $username = $row['username'];
        } else {
            //redirect to manage admin page
            header('location:' . SITEURL . 'admin/manage-admin.php');
            exit;
        }
    }
}

if (isset($_POST['submit'])) {
    //create sql query to update admin
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    $sql = "UPDATE tbl_admin SET
    full_name = ?,
    username = ?
    WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssi', $full_name, $username, $id);
    $res = mysqli_stmt_execute($stmt);

    session_start(); 
    if ($res) {
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Admin.</div>";
    }
    header('location:' . SITEURL . 'admin/manage-admin.php');
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1 class="text-center">Update Admin</h1>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" value="<?php echo htmlspecialchars($full_name); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>" class="form-control">
                </div>
                <div class="form-group text-center">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <button type="submit" name="submit" class="btn btn-primary">Update Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "partials/footer.php"; ?>
