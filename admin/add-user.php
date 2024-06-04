<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="container">
        <h2>Add New Admin</h2>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Register</button>
        </form>

        <?php
        // Handle form submission
        if (isset($_POST['submit'])) {
            // Check if POST data is set and not empty
            $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
            $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
            $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';
            $confirm_password = isset($_POST['confirm_password']) ? mysqli_real_escape_string($conn, $_POST['confirm_password']) : '';

            // Check if all required fields are filled
            if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
                // Check if password matches confirm password
                if ($password === $confirm_password) {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert user data into the database
                    $sql = "INSERT INTO tbl_users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
                    $res = mysqli_query($conn, $sql);

                    if ($res) {
                        echo '<div class="alert alert-success" role="alert">User added successfully.</div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Failed to add user.</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Password and confirm password do not match.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">All fields are required.</div>';
            }
        }
        ?>
    </div>
</div>

<?php include ('partials/footer.php'); ?>
