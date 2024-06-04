<?php include("partials/menu.php"); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br><br>
        <?php
            
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        
        ?>
        <br><br>

        <div class="col-4 text-center">

            <?php

            ?>

            <h1></h1>
            <br />
            Categories
        </div>

        <div class="col-4 text-center">

            <?php

            ?>

            <h1></h1>
            <br />
            Foods
        </div>

        <div class="col-4 text-center">

            <?php
            //Sql Query 

            ?>

            <h1></h1>
            <br />
            Total Orders
        </div>

        <div class="col-4 text-center">

            <?php


            ?>

            <h1></h1>
            <br />
            Revenue Generated
        </div>

        <div class="clearfix"></div>

    </div>
</div>

<!-- Main Content Setion Ends -->

</div>



<!-- Menu Ends -->



</body>

</html>
<?php include("partials/footer.php"); ?>



<link rel="stylesheet" href="../css/admin.css">