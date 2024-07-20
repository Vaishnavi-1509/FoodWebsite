<?php include('partials.front/menu.php'); ?>

<?php 
// Check whether food id is set or not
if (isset($_GET['food_id'])) {
    // Get the food id and details of the selected food
    $food_id = $_GET['food_id'];

    // Get the details of the selected food
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        // Food available
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        // Food not available
        header('location:'.SITEURL);
        exit();
    }
} else {
    // Redirect to homepage
    header('location:'.SITEURL);
    exit();
}
?>

<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <?php
        if (isset($_POST['submit'])) {
            // Get all the details from the form
            $food = $title;
            $qty = $_POST['qty'];
            $total = $price * $qty; // Total calculation
            $order_date = date("Y-m-d H:i:s"); // Order date
            $status = "Ordered"; // Order status
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            // Save the order in the database
            $sql2 = "INSERT INTO tbl_order SET 
                food = '$food',
                price = $price,
                qty = $qty,
                total = $total,
                order_date = '$order_date',
                status = '$status',
                customer_name = '$customer_name',
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_address = '$customer_address'
            ";

            // Execute the query and check for errors
            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == TRUE) {
                // Order saved
                $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                ?>
                <div class="order-confirmation">
                    <h3 class="text-center">Thank you for your order!</h3>
                    <p class="text-center">Here are the details of your order:</p>
                    <div class="order-details">
                        <p><strong>Food:</strong> <?php echo $food; ?></p>
                        <p><strong>Price:</strong> $<?php echo $price; ?></p>
                        <p><strong>Quantity:</strong> <?php echo $qty; ?></p>
                        <p><strong>Total:</strong> $<?php echo $total; ?></p>
                        <p><strong>Order Date:</strong> <?php echo $order_date; ?></p>
                        <p><strong>Status:</strong> <?php echo $status; ?></p>
                        <p><strong>Customer Name:</strong> <?php echo $customer_name; ?></p>
                        <p><strong>Contact:</strong> <?php echo $customer_contact; ?></p>
                        <p><strong>Email:</strong> <?php echo $customer_email; ?></p>
                        <p><strong>Address:</strong> <?php echo $customer_address; ?></p>
                    </div>
                    <a href="<?php echo SITEURL; ?>" class="btn btn-primary">Back to Home</a>
                </div>
                <?php
            } else {
                // Failed to save order
                echo "<div class='error text-center'>Failed to Order Food. Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
        ?>
            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                        if ($image_name == "") {
                            echo "<div class='error'>Image not available.</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <p class="food-price">$<?php echo $price; ?></p>

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="customer_name" placeholder="E.g. John Doe" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="customer_contact" placeholder="E.g. 1234567890" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="customer_email" placeholder="E.g. example@example.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="customer_address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>
            </form>
        <?php
        }
        ?>

    </div>
</section>

<?php include('partials.front/footer.php'); ?>
