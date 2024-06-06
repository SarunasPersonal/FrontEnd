

<?php
// Include constants.php
include('../config/constants.php');
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}



// Check if id is set in the URL
if (isset($_GET['id'])) {
    // Get the id to delete
    $id = $_GET['id'];

    $sql = "DELETE FROM tbl_category WHERE id=?";

    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Execute the statement
    $res = mysqli_stmt_execute($stmt);

    // Check if deletion was successful
    if ($res) {
        // Create session variable to display success message
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
        header("location:" . SITEURL . "/admin/manage-category.php");
    } else {
        // Create session variable to display error message
        $_SESSION["delete"] = "<div class='error'>Failed to Delete Category.</div>";
        header("location:" . SITEURL . "/admin/manage-category.php");
    }
    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Close database connection
    mysqli_close($conn);
} else {
    // If id is not set in the URL
    $_SESSION["delete"] = "<div class='error'>Invalid request. Category ID is missing.</div>";
    header("location:" . SITEURL . "/admin/manage-category.php");
}

// Redirect to manage category page
header("location:" . SITEURL . "/admin/manage-category.php");
