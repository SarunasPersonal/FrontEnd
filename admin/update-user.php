<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="container">
        <h2>Edit User</h2>
        <?php
        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];

            $sql = "SELECT * FROM tbl_users WHERE user_id = $user_id";
            $res = mysqli_query($conn, $sql);

            if ($res) {
                // Check if user exists
                $count = mysqli_num_rows($res);
                if ($count == 1) {
                    // User found, fetch user data
                    $row = mysqli_fetch_assoc($res);
                    $username = $row['username'];
                    $name = $row['name'];
                    $surname = $row['surname'];
                    $email = $row['email'];
                    $shipping_address = $row['shipping_address'];
        ?>
                    <form action="update-user.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $user_id; ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="surname" class="form-label">Surname:</label>
                            <input type="text" id="surname" name="surname" class="form-control" value="<?php echo $surname; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address:</label>
                            <input type="text" id="shipping_address" name="shipping_address" class="form-control" value="<?php echo $shipping_address; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password (leave blank to keep current password):</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    </form>
        <?php
                } else {
                    echo '<div class="alert alert-danger" role="alert">User not found.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Failed to fetch user data.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">User ID not provided.</div>';
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
if (isset($_POST['submit'])) {
    // Connect to the database
   

    $user_id = $_POST['id'];
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $surname = isset($_POST['surname']) ? mysqli_real_escape_string($conn, $_POST['surname']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $shipping_address = isset($_POST['shipping_address']) ? mysqli_real_escape_string($conn, $_POST['shipping_address']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($conn, $_POST['confirm_password']) : '';

    // Check if all required fields are filled
    if (!empty($username) && !empty($name) && !empty($surname) && !empty($email) && !empty($shipping_address)) {
        // Initialize the SQL query
        $sql = "UPDATE tbl_users SET 
                username='$username', 
                name='$name', 
                surname='$surname', 
                email='$email', 
                shipping_address='$shipping_address'";

        // Check if the password is provided and matches the confirm password
        if (!empty($password) && $password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password='$hashed_password'";
        }

        // Complete the SQL query
        $sql .= " WHERE user_id='$user_id'";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        if ($res) {
            $_SESSION['update'] = "User Updated Successfully";
            header("location:" . SITEURL . 'admin/manage-users.php');
        } else {
            $_SESSION['update'] = "Failed to Update User";
            header("location:" . SITEURL . 'admin/update-user.php?id=' . $id);
        }
    } else {
        $_SESSION['update'] = "All fields are required.";
        header("location:" . SITEURL . 'admin/update-user.php?id=' . $id);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>