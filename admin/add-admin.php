<?php include('partials/menu.php'); ?>

<div class="main-content">
    <h1>Add Admin</h1>
    <br></br>
    <form action="" method="POST">
        <table class="tbl-30">
            <tr>
                <td>Full name: </td>
                <td><input type="text" name="full_name" placeholder="Enter your name"></td>
            </tr>
            <tr>
                <td>Username: </td>
                <td><input type="text" name="username" placeholder=" Your username"></td>
            </tr>
            <tr>
                <td>Password: </td>
                <td><input type="password" name="password" placeholder=" Your password"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add admin" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>
</div>

<?php include('partials/footer.php'); ?>

<?php
    //process value from form ans save it in database
    if(isset($_POST['submit'])){
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //pwd encryption with md5

        $sql = "INSERT INTO tbl_admin SET
                full_name = '$full_name',
                username = '$username',
                password = '$password'
        ";
        
        $conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error());
        $db_select = mysqli_select_db($conn, 'food-order') or die(mysqli_error());

        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        include('../css/admin.css');
        if($res==true){

            //creating session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully.✔️</div>";
            //redirect page to manage admin page
            header("location:" .SITEURL. 'admin/manage-admin.php');
        }
        else{
            
            //creating session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin. ❌Try again later.</div>";
            //redirect page to manage admin page
            header("location:" .SITEURL. 'admin/add-admin.php');
        }
    }

?>