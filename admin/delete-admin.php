<?php
//include constants.php
include('../config/constants.php');
//id to delete
echo $id = $_GET['id'];
$sql = "DELETE FROM tbl_admin WHERE id=$id";
//execute the query
$res = mysqli_query($conn, $sql);

if ($res == true) {
    //Create session variable to display message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
    //Redirect to manage admin page
    header("location:" . SITEURL . "/admin/manage-admin.php");
} else {
    ///Create session variable to display message
    $_SESSION["delete"] = "<div class='error'>Failed to Delete Admin.</div>";
    header("location:" . SITEURL . "/admin/manage-admin.php");
}
