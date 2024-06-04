<?php include('partials/menu.php'); ?>
<!-- Main Content Section Starts -->
<div class="container text-center mx-auto" style="width: 500px;">
    <h1>Manage Admin</h1>
    <?php
    // Check whether the session is set or not
    if (isset($_SESSION['add'])) {
        echo '<div class="alert alert-success">' . $_SESSION['add'] . '</div>';
        unset($_SESSION['add']);
    }
    if (isset($_SESSION['delete'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['delete'] . '</div>';
        unset($_SESSION['delete']);
    }
    if (isset($_SESSION['update'])) {
        echo '<div class="alert alert-success">' . $_SESSION['update'] . '</div>';
        unset($_SESSION['update']);
    }
    if (isset($_SESSION['user-not-found'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['user-not-found'] . '</div>';
        unset($_SESSION['user-not-found']);
    }
    if (isset($_SESSION['pwd-not-match'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['pwd-not-match'] . '</div>';
        unset($_SESSION['pwd-not-match']);
    }
    if (isset($_SESSION['change-pwd'])) {
        echo '<div class="alert alert-success">' . $_SESSION['change-pwd'] . '</div>';
        unset($_SESSION['change-pwd']);
    }
    ?>
</div>

<div class="container text-center mx-auto" style="width: 500px;">
    <div class="row">
        <div class="col-sm">
            <br /><br />
            <!-- Button to Add Admin -->
            <a type="button" class="btn btn-primary btn-lg" href="add-admin.php" class="btn-primary">Add Admin</a>
            <br /><br />
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to get all admin
                    $sql = "SELECT * FROM tbl_admin";
                    $res = mysqli_query($conn, $sql);

                    if ($res == TRUE) {
                        // Count rows to check whether we have data in database or not
                        $count = mysqli_num_rows($res);
                        $sn = 1; // Create a serial number variable
                        if ($count > 0) {
                            // We have data in database
                            while ($rows = mysqli_fetch_assoc($res)) {
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];
                    ?>
                    <tr>
                        <th scope="row"><?php echo $sn++; ?></th>
                        <td><?php echo $full_name; ?></td>
                        <td><?php echo $username; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn btn-secondary">Update Admin</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete Admin</a>
                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn btn-success">Change Password</a>
                        </td>
                    </tr>
                    <?php
                            }
                        } else {
                            // We do not have data in database
                            echo "<tr><td colspan='4' class='text-center'>No Admin Found</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Main Content Section Ends -->
<?php include('partials/footer.php'); ?>
