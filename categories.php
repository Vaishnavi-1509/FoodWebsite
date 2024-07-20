<?php
include('config/constants.php'); // Ensure this file is included to get the DB connection
include('partials.front/menu.php');
?>

<section id="categories" class="food_items section">
    <div class="container">
        <h2>Explore Categories</h2>

        <div class="items">
            <?php
            // SQL Query to get all active categories
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>
                    <a href="<?php echo SITEURL; ?>menu.php?category_id=<?php echo $id; ?>">
                        <div class="item">
                            <?php
                            if ($image_name == "") {
                                echo "<div class='error'>Image not available</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>"/>
                                <?php
                            }
                            ?>
                            <h3><?php echo $title; ?></h3>
                        </div>
                    </a>
                    <?php
                }
            } else {
                echo "<div class='error'>No categories found</div>";
            }
            ?>
        </div>
    </div>
</section>

<?php include('partials.front/footer.php'); ?>
