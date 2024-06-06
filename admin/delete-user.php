<?php include('../config/constants.php'); ?>

<?php
if (isset($_GET['id'])) {
    // Get the user ID from the URL
    $user_id = $_GET['id'];

    // SQL query to delete the user from the database
    $sql = "DELETE FROM tbl_users WHERE user_id = $user_id";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // User deleted successfully
        $_SESSION['delete'] = "User removed successfully.";
        header('location:' . SITEURL . 'admin/manage-users.php');
    } else {
        // Failed to delete user
        $_SESSION['delete'] = "Failed to remove user.";
        header('location:' . SITEURL . 'admin/manage-users.php');
    }
} else {
    // If ID is not set in the URL, redirect to manage-users page
    header('location:' . SITEURL . 'admin/manage-users.php');
}
?>
