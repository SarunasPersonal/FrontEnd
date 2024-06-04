<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Broadhleigh Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>
            <?php
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            ?>
            <br><br>
            <form action="login.php" method="post" class="text-center">
                Username:<br>
                <input type="text" name="username" placeholder="Enter Username">
                <br><br>
                Password:<br>
                <input type="password" name="password" placeholder="Enter Password">
                <br><br>
                <button type="submit" name="submit" class="btn btn-primary btn-large">Login</button>
            </form>
            <p class="text-center">Created By <a href="#">Sarunas Slekys </a></p>
        </div>
    </body>
</html>

<?php

//CHECK IF BUTTON IS CLICKED
//Check whether the Submit Button is Clicked or Not
if(isset($_POST['submit']))
{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    //Encrypt the password - you should use more secure methods such as password_hash and password_verify
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);

    // SQL to check whether the user with username and password exists or not
    $sql = "SELECT * FROM tbl_user WHERE username='$username' AND password='$password'";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);

    if($count==1)
    {
        // User available and login successful
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username; // To check whether the user is logged in or not and logout will unset it

        header('location:'.SITEURL.'admin/');
    }
    else
    {
        // User not available or login failed
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
        // Redirect to Login Page
        header('location:'.SITEURL.'admin/login.php');
    }
}
?>
