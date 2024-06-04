<?php include ('partials/menu.php'); ?>
<div class="container text-center mx-auto">
    <div class="wrapper">
        <h1>Manage Categories</h1>
        <br><br>
        <div class="row">
            <div class="col-sm">
                <!-- Button to Add Category -->
                <a type="button" class="btn btn-primary btn-lg" href="add-category.php" class="btn-primary">Add Category</a>
            </div>
        </div>
        <br/><br/>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">S.N</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch categories from the database and display them in the table
                $sql = "SELECT * FROM tbl_category";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $title; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn btn-secondary">Update Category</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete Category</a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    // If no categories found
                    echo '<tr><td colspan="3" class="text-center">No categories found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php include ('partials/footer.php'); ?>
