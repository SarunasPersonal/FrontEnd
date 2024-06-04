<?php include('../config/constants.php'); ?>

<html>
<head>
    <title>Login - Broadhleigh order system</title>
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
        <!-- Login Form -->
        <form action="login.php" method="post" class="text-center">
            Username:<br>
            <input type="text" name="username" placeholder="Enter Username">
            <br><br>
            Password:<br>
            <input type="password" name="password" placeholder="Enter Password">
            <br><br>
            <button type="submit" name="submit" class="btn btn-primary btn-large">Login</button>
        </form>

        <br><br>

        <!-- Sign-up Form -->
        <h2 class="text-center">Sign Up</h2>
        <form action="signup.php" method="post" class="text-center">
            Username:<br>
            <input type="text" name="username" placeholder="Enter Username">
            <br><br>
            Password:<br>
            <input type="password" name="password" placeholder="Enter Password">
            <br><br>
            <button type="submit" name="submit" class="btn btn-success btn-large">Sign Up</button>
        </form>
    </div>
</body>
</html>
