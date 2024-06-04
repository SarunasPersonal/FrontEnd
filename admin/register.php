<?php include('../config/constants.php'); ?>

<?php
// Handle form submission
if(isset($_POST['submit'])) {
    // Retrieve form data
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($conn, $_POST['confirm_password']) : '';

    // Check if password and confirm password match
    if($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header('location:'.SITEURL.'admin/add-user.php');
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $sql = "SELECT * FROM tbl_users WHERE email='$email'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) > 0) {
        $_SESSION['error'] = "Email already exists.";
        header('location:'.SITEURL.'admin/add-user.php');
        exit;
    }

    // Insert user data into the database
    $sql = "INSERT INTO tbl_users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['success'] = "User added successfully.";
        header('location:'.SITEURL.'admin/manage-users.php');
        exit;
    } else {
        $_SESSION['error'] = "Failed to add user.";
        header('location:'.SITEURL.'admin/add-user.php');
        exit;
    }
}
?>
