<?php
// Check if the user is logged in
session_start();
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    // Redirect to a different page or display an error message
    header('Location: unauthorized.php');
    exit();
}

?>

<!-- HTML content for the manage-category page -->

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
    } else {
        // Create session variable to display error message
        $_SESSION["delete"] = "<div class='error'>Failed to Delete Category.</div>";
    }
    // Redirect to manage category page
    header("location:" . SITEURL . "/admin/manage-category.php");

    // Close the prepared statement
    mysqli_stmt_close($stmt);

    // Close database connection
    mysqli_close($conn);
} else {
    // If id is not set in the URL
    $_SESSION["delete"] = "<div class='error'>Invalid request. Category ID is missing.</div>";
}

// Redirect to manage category page
header("location:" . SITEURL . "/admin/manage-category.php");

