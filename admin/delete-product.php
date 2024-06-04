<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Include constants.php
include('../config/constants.php');

// Check if id is set in the URL
if (isset($_GET['id'])) {
    // Get the id to delete
    $id = $_GET['id'];

    // Prepare SQL statement to delete product
    $sql = "DELETE FROM tbl_product WHERE id=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Execute the statement
    $res = mysqli_stmt_execute($stmt);

    // Check if deletion was successful
    if ($res) {
        // Create session variable to display success message
        $_SESSION['delete'] = "<div class='success'>Product Deleted Successfully.</div>";
    } else {
        // Create session variable to display error message
        $_SESSION["delete"] = "<div class='error'>Failed to Delete Product.</div>";
    }
    // Redirect to manage products page
    header("location:" . SITEURL . "/admin/manage-product.php");

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Close database connection
    mysqli_close($conn);
} else {
    // If id is not set in the URL
    $_SESSION["delete"] = "<div class='error'>Invalid request. Product ID is missing.</div>";
    // Redirect to manage products page
    header("location:" . SITEURL . "/admin/manage-product.php");
}
?>
