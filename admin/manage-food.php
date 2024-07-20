<?php include('partials/menu.php'); ?>
<div class="main-content">
    <h2> Manage Food</h2>
    <br/><br/>

    <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
    <br/><br/>

    <?php
    if(isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    ?>
    
    <table class="tbl-full">
        <tr>
            <th>S.N.</th>
            <th>Title</th>
            <th>Price</th>
            <th>Image</th>
            <th>Featured</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>

        <?php
        $sql = "SELECT * FROM tbl_food";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        $sn = 1;

        if($count > 0) {
            while($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
                ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $title; ?></td>
                    <td><?php echo $price; ?></td>
                    <td>
                        <?php
                        if($image_name != ""){
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                            <?php
                        } else {
                            echo "<div class='error'>Image not added</div>";
                        }
                        ?>
                    </td>
                    <td><?php echo $featured; ?></td>
                    <td><?php echo $active; ?></td>
                    <td>
                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-del">Delete Food</a>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="7"><div class="error">No Food Added</div></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<?php include('partials/footer.php'); ?>
