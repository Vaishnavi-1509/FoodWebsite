<?php include('partials/menu.php'); ?>

<div class="main-content">
    <h1>Add Food</h1>

    <br><br>

    <?php
    if(isset($_SESSION['upload'])) {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    } 
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Title of the food">
                </td>
            </tr>
            
            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the food."></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>

            <tr>
                <td>Select image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">
                        <?php
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);  

                        if($count > 0){
                            while($row = mysqli_fetch_assoc($res)){
                                $id = $row['id'];
                                $title = $row['title'];
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                            }
                        }
                        else{
                            ?>
                            <option value="0">No category found</option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Feature: </td>
                <td>
                    <input type="radio" name="feature" value="Yes"> Yes
                    <input type="radio" name="feature" value="No"> No
                </td>
            </tr>
            <tr>
                <td>Active: </td>
                <td>
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="active" value="No"> No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>

    <?php
    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];    
        $category = $_POST['category'];

        $featured = isset($_POST['featured']) ? $_POST['featured'] : 'No';
        $active = isset($_POST['active']) ? $_POST['active'] : 'No';

        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
            // File name and extension
            $image_name = $_FILES['image']['name'];
            $ext_arr = explode('.', $image_name);
            $ext = end($ext_arr);
            $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;

            // Source and destination paths
            $src = $_FILES['image']['tmp_name'];
            $dst = "../images/food/" . $image_name;

            // Upload the image
            $upload = move_uploaded_file($src, $dst);

            if($upload == false){
                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                header('location:'.SITEURL.'admin/add-food.php');
                die();
            }
        } else {
            $image_name = "";
        }

        // Insert into database
        $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active'
        ";

        $res2 = mysqli_query($conn, $sql2);

        if($res2 == true){
            $_SESSION['add'] = "<div class='success'>Food added successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        } else {
            $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    ?>

</div>
<?php include('partials/footer.php'); ?>
