<?php
if (!isset($_SESSION["user"])) //if user session not set
{
    //user is not logged in
    //login
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please as an Admin to access Dashboard.</div>";
    header("location:" . SITEURL . "admin/login.php");
}
?>