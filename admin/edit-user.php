<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="container">
        <h2>Edit User</h2>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "SELECT * FROM tbl_users WHERE id = $id";
            $res = mysqli_query($conn, $sql);

            if ($res) {
                // Check if user exists
                $count = mysqli_num_rows($res);
                if ($count == 1) {
                    // User found, fetch user data
                    $row = mysqli_fetch_assoc($res);
                    $username = $row['username'];
                    $email = $row['email'];
                    $role = $row['role']; // Add role field
        ?>
        <form action="edit-user.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="admin" <?php if ($role == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="user" <?php if ($role == 'user') echo 'selected'; ?>>User</option>
                </select>
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

<?php include ('partials/footer.php'); ?>
