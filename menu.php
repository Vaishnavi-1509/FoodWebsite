<?php
include('partials.front/menu.php');
?>

<?php
$category_id = isset($_GET['category_id']) ? (int) $_GET['category_id'] : 0;
$category_title = '';

if ($category_id > 0) {
    $sql_cat = "SELECT title FROM tbl_category WHERE id=$category_id AND active='Yes'";
    $res_cat = mysqli_query($conn, $sql_cat);
    if ($res_cat && mysqli_num_rows($res_cat) === 1) {
        $row_cat = mysqli_fetch_assoc($res_cat);
        $category_title = $row_cat['title'];
    } else {
        $category_id = 0;
    }
}
?>

<section class="food-menu">
    <div class="container">
        <?php if ($category_id > 0 && $category_title !== '') { ?>
            <h2 class="text-center">Category: <?php echo $category_title; ?></h2>
        <?php } else { ?>
            <h2 class="text-center">Food Menu</h2>
        <?php } ?>

        <?php
        // SQL Query to get active food items (optionally by category)
        if ($category_id > 0) {
            $sql = "SELECT * FROM tbl_food WHERE active='Yes' AND category_id=$category_id";
        } else {
            $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
        }
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='error'>Image not available</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <button
                            type="button"
                            class="btn btn-primary add-to-cart"
                            data-id="<?php echo $id; ?>"
                            data-title="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>"
                            data-price="<?php echo $price; ?>"
                        >
                            Add to Cart
                        </button>
                        <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-secondary">Order Now</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='error'>Food not found</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>

<?php include('partials.front/footer.php'); ?>
