<?php include('partials/menu.php'); ?>

<?php
// Check if ID is set
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_food WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $current_category = $row['category_id'];
        $featured = $row['featured'];
        $active = $row['active'];
    } else {
        $_SESSION['no-food-found'] = "<div class='error'>Food not found.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
} else {
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>

<div class="main-content">
    <h2>Update Food</h2>
    <br/><br/>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>
            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>
            <tr>
                <td>Current Image:</td>
                <td>
                    <?php
                    if($current_image != ""){
                        ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                        <?php
                    } else {
                        echo "<div class='error'>Image not available.</div>";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Select New Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">
                        <?php
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);

                        if($count > 0) {
                            while($row = mysqli_fetch_assoc($res)) {
                                $category_id = $row['id'];
                                $category_title = $row['title'];
                                ?>
                                <option <?php if($current_category == $category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                            }
                        } else {
                            echo "<option value='0'>Category Not Available</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                    <input <?php if($featured == "No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                </td>
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                    <input <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>

    <?php
    if(isset($_POST['submit'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];
        $current_image = $_POST['current_image'];

        if(isset($_FILES['image']['name'])) {
            $image_name = $_FILES['image']['name'];

            if($image_name != "") {
                $ext_arr = explode('.', $image_name);
                $ext = end($ext_arr);
                $image_name = "Food-Name-".rand(0000, 9999).".".$ext;
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/food/".$image_name;
                $upload = move_uploaded_file($source_path, $destination_path);

                if($upload == false) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    die();
                }

                if($current_image != "") {
                    $remove_path = "../images/food/".$current_image;
                    $remove = unlink($remove_path);

                    if($remove == false) {
                        $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                    }
                }
            } else {
                $image_name = $current_image;
            }
        } else {
            $image_name = $current_image;
        }

        $sql2 = "UPDATE tbl_food SET 
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
            WHERE id = $id
        ";

        $res2 = mysqli_query($conn, $sql2);

        if($res2 == true) {
            $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        } else {
            $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    ?>
</div>
<?php include('partials/footer.php'); ?>
         
