<?php
    include('../config/constants.php');
    session_destroy(); //destroy the session and logout from admin page

    header('location:'.SITEURL.'admin/login.php');  


