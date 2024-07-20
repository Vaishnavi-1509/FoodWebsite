<?php include('partials/menu.php'); ?>

        <div class="main-content">
            <h1>Manage Admin</h1> 
            <br/> <br/>
            <?php
               if(isset($_SESSION['add'])){
                echo $_SESSION['add'];   //adding session msg
                unset($_SESSION['add']); //removing session msg
               }

               if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
               }
               if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
               }
               if(isset($_SESSION['user-not-found'])){
                echo $_SESSION['update-password'];
                unset($_SESSION['update-password']);
               }
            ?>
            <br/> <br/>

            <a href="add-admin.php" class="btn-primary">Add Admin</a>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Full name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php
                    $sql = "SELECT * FROM tbl_admin";
                    $res = mysqli_query($conn, $sql);

                    $sn=1;
                    
                    if($res==TRUE){
                        $count = mysqli_num_rows($res); //fn to get all rows in db
                        
                        if($count > 0){
                            //there is data in db
                            while($rows = mysqli_fetch_assoc($res)){
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];

                                ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td> <?php echo $full_name; ?></td>
                                    <td> <?php echo $username; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change password</a>
                                        <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update admin</a>
                                        <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-del">Delete admin</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        else{

                        }
                    }
                ?>
            </table>
        </div>
<?php include('partials/footer.php'); ?>