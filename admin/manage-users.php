<?php 
include ('partials/menu.php'); 
?>


<!-- HTML header and navigation menu -->

<div class="container mt-5">
    <h2>Manage Users</h2>
    <a href="add-user.php" class="btn btn-primary mb-3">Add New User</a>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Address</th>
                    <th scope="col">Registration Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve user data from the database
                $sql = "SELECT * FROM tbl_users";
                $res = mysqli_query($conn, $sql);
                $sn = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    // Display user details in table rows
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['surname']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['shipping_address']; ?></td>
                        <td><?php echo $row['registration_date']; ?></td>
                        <td>
                            <!-- Add action buttons for managing users -->
                            <!-- Example: Edit and Delete buttons -->
                            <a href="update-user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete-user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
// Include the footer file
include ('partials/footer.php');
?>
<!-- HTML footer -->
