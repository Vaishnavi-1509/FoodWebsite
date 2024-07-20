<?php
//authorisation - access control
//check whether user is logged in or not
if(!isset($_SESSION['user'])){ //if user session is not set
    //user not logged in
    //redirect to login page with msg
    $_SESSION['no-login-msg'] = "<div class='error'>Please login to access Admin Panel</div>";
    //redirect to login page
    header('location:'.SITEURL.'admin/login.php'); 
}

?>