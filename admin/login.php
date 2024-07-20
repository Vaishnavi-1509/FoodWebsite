<?php include('../config/constants.php'); ?>


<html>
    <head>
        <title>Login - Food order system</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1>Login</h1>
            <br><br>

            <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-msg'])){
                echo $_SESSION['no-login-msg'];
                unset($_SESSION['no-login-msg']);
            }
            ?>

            <br><br>

            <form action="" method="POST">
            Username: <br>
            <input type="text" name="username" placeholder="Enter username"><br><br>
            Password: <br>
            <input type="text" name="password" placeholder="Enter password"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
            </form>

            <p>Created By - Vaishnavi G</p>
        </div>
    </body>
</html>

<?php

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql= "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1){
        $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
        $_SESSION['user'] = $username; //to check if user is logged in or not and logout will unset it

        header('location:'.SITEURL.'admin/');
    }
    else{
        $_SESSION['login'] = "<div class='error'>Username or Password didn't match.</div>";

        header('location:'.SITEURL.'admin/login.php');
    }
}

?>