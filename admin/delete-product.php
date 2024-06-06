<?php
if (!isset($_SESSION)) {
    session_start();
}

include('../config/constants.php');

// Check if id is set in the URL
if (isset($_GET['id'])) {
    // Get the id to delete
    $product_id = $_GET['id'];

    // Prepare SQL statement to delete product
    $sql = "DELETE FROM tbl_product WHERE product_id=?";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind the product_id parameter to the statement
        mysqli_stmt_bind_param($stmt, 'i', $product_id);

        // Execute the statement
        $res = mysqli_stmt_execute($stmt);

        // Check if deletion was successful
        if ($res) {
            // Create session variable to display success message
            $_SESSION['delete'] = "<div class='success'>Product Deleted Successfully.</div>";
        } else {
            // Create session variable to display error message
            $_SESSION["delete"] = "<div class='error'>Failed to Delete Product: " . mysqli_error($conn) . "</div>";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Error in preparing the SQL statement
        $_SESSION["delete"] = "<div class='error'>Error in preparing SQL statement: " . mysqli_error($conn) . "</div>";
    }

    // Close database connection
    mysqli_close($conn);

    // Redirect to manage products page
    header("location:" . SITEURL . "/admin/manage-product.php");
} else {
    $_SESSION["delete"] = "<div class='error'>Invalid request. Product ID is missing.</div>";
    // Redirect to manage products page
    header("location:" . SITEURL . "/admin/manage-product.php");
}
?>
