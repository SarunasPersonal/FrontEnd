<?php include('partials/menu.php'); 
if(isset($_POST['submit'])) {
    // Retrieve and sanitize input data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // Hash the password
    $hashed_password = md5($password);

    // SQL to check user credentials
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$hashed_password'";
    $res = mysqli_query($conn, $sql);

    // Check if a user with the given credentials exists
    if(mysqli_num_rows($res) == 1) {
        // User exists, set session variables and redirect to admin dashboard
        $user = mysqli_fetch_assoc($res);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role']; // Assuming 'role' is a column in your tbl_admin table
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        // Check if the user is an admin
        if ($_SESSION['user_role'] === 'admin') {
            header('location:'.SITEURL.'admin/dashboard.php');
        } else {
            // Redirect regular users to their dashboard
            header('location:'.SITEURL.'user/dashboard.php');
        }
        exit();
    } else {
        // User doesn't exist or credentials are incorrect, set error message and redirect back to login page
        $_SESSION['login'] = "<div class='error text-center'>Username or Password is incorrect.</div>";
        header('location:'.SITEURL.'admin/login.php');
        exit();
    }
}
?>

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
        // Display login messages
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br><br>
        <!-- Login Form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="text-center">
            Username:<br>
            <input type="text" name="username" placeholder="Enter Username" required>
            <br><br>
            Password:<br>
            <input type="password" name="password" placeholder="Enter Password" required>
            <br><br>
            <button type="submit" name="submit" class="btn btn-primary btn-large">Login</button>
            <p class="text-center">Created By <a href="#">Sarunas Slekys </a></p>
        </form>
    </div>
</body>
</html>