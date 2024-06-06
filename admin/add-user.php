<?php
// Start output buffering
ob_start();
include("partials/menu.php");


?>





<div class="container mt-5">
    <div class="wrapper">
        <h1 class="text-center">Add New User</h1>
        <br><br>
        <div class="text-center">
            <?php
            if (isset($_SESSION['add'])) {
                if ($_SESSION['add'] === "User Added Successfully") {
                    echo '<div class="text-success">' . $_SESSION['add'] . '</div>';
                } else {
                    echo '<div class="text-danger">' . $_SESSION['add'] . '</div>';
                }
                unset($_SESSION['add']);
            }
            ?>
        </div>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Username" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname:</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter Your Surname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
            </div>
            <div class="form-group">
                <label for="shipping_address">Address:</label>
                <input type="text" class="form-control" id="shipping_address" name="shipping_address" placeholder="Enter Your Address" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Your Password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php
if (isset($_POST['submit'])) {
    // Connect to the database
    include('config/db_connect.php'); // Include your database connection file

    // Check if POST data is set and not empty
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $surname = isset($_POST['surname']) ? mysqli_real_escape_string($conn, $_POST['surname']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $shipping_address = isset($_POST['shipping_address']) ? mysqli_real_escape_string($conn, $_POST['shipping_address']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($conn, $_POST['confirm_password']) : '';

    // Check if all required fields are filled
    if (!empty($username) && !empty($name) && !empty($surname) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        // Check if password matches confirm password
        if ($password === $confirm_password) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            $sql = "INSERT INTO tbl_users (username, name, surname, email, password, shipping_address) VALUES ('$username', '$name', '$surname', '$email', '$hashed_password', '$shipping_address')";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $_SESSION['add'] = "User Added Successfully";
                header("location:" . SITEURL . 'admin/manage-admin.php');
            } else {
                $_SESSION['add'] = "Failed to Add User";
                header("location:" . SITEURL . 'admin/add-admin.php');
            }
        } else {
            $_SESSION['add'] = "Password and confirm password do not match.";
        }
    } else {
        $_SESSION['add'] = "All fields are required.";
    }

    // Close the database connection
    mysqli_close($conn);
}

// Flush the output buffer and end output buffering
ob_end_flush();
?>
