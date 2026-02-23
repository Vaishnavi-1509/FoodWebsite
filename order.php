<?php include('partials.front/menu.php'); ?>

<?php
$prefill_item = null;
$order_success = false;
$order_error = '';
$order_summary = [];

if (isset($_GET['food_id'])) {
    $food_id = (int) $_GET['food_id'];
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_num_rows($res) === 1) {
        $row = mysqli_fetch_assoc($res);
        $prefill_item = [
            'id' => (int) $row['id'],
            'title' => $row['title'],
            'price' => (float) $row['price']
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name'] ?? '');
    $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact'] ?? '');
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email'] ?? '');
    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address'] ?? '');
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method'] ?? 'Pay on Delivery (Cash)');

    $cart_json = $_POST['cart_json'] ?? '';
    $cart = json_decode($cart_json, true);

    if (!is_array($cart) || count($cart) === 0) {
        $order_error = 'Your cart is empty. Please add items from the menu.';
    } else {
        $items = [];
        $ids = [];
        foreach ($cart as $item) {
            $id = isset($item['id']) ? (int) $item['id'] : 0;
            $qty = isset($item['qty']) ? (int) $item['qty'] : 0;
            if ($id > 0 && $qty > 0) {
                $items[$id] = $qty;
                $ids[] = $id;
            }
        }

        if (count($ids) === 0) {
            $order_error = 'Your cart is empty. Please add items from the menu.';
        } else {
            $id_list = implode(',', array_unique($ids));
            $food_map = [];
            $sql_food = "SELECT id, title, price FROM tbl_food WHERE id IN ($id_list) AND active='Yes'";
            $res_food = mysqli_query($conn, $sql_food);
            if ($res_food) {
                while ($row = mysqli_fetch_assoc($res_food)) {
                    $food_map[(int) $row['id']] = [
                        'title' => $row['title'],
                        'price' => (float) $row['price']
                    ];
                }
            }

            if (count($food_map) === 0) {
                $order_error = 'Selected items are not available right now.';
            } else {
                $order_items = [];
                $total_qty = 0;
                $grand_total = 0.0;
                $summary_parts = [];

                foreach ($items as $id => $qty) {
                    if (!isset($food_map[$id])) {
                        continue;
                    }
                    $title = $food_map[$id]['title'];
                    $price = $food_map[$id]['price'];
                    $line_total = $price * $qty;
                    $order_items[] = [
                        'id' => $id,
                        'title' => $title,
                        'price' => $price,
                        'qty' => $qty,
                        'total' => $line_total
                    ];
                    $total_qty += $qty;
                    $grand_total += $line_total;
                    $summary_parts[] = $title . ' x ' . $qty;
                }

                if (count($order_items) === 0) {
                    $order_error = 'Selected items are not available right now.';
                } else {
                    $food_summary = mysqli_real_escape_string($conn, implode(', ', $summary_parts));
                    $order_date = date("Y-m-d H:i:s");
                    $status = "Ordered";

                    $sql_order = "INSERT INTO tbl_order SET 
                        food = '$food_summary',
                        price = $grand_total,
                        qty = $total_qty,
                        total = $grand_total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    $res_order = mysqli_query($conn, $sql_order);
                    if ($res_order) {
                        $order_id = mysqli_insert_id($conn);

                        $sql_create_items = "CREATE TABLE IF NOT EXISTS tbl_order_item (
                            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            order_id INT NOT NULL,
                            food_id INT NOT NULL,
                            food VARCHAR(150) NOT NULL,
                            price DECIMAL(10,2) NOT NULL,
                            qty INT NOT NULL,
                            total DECIMAL(10,2) NOT NULL,
                            INDEX (order_id)
                        )";
                        mysqli_query($conn, $sql_create_items);

                        foreach ($order_items as $item) {
                            $food_title = mysqli_real_escape_string($conn, $item['title']);
                            $sql_item = "INSERT INTO tbl_order_item SET
                                order_id = $order_id,
                                food_id = {$item['id']},
                                food = '$food_title',
                                price = {$item['price']},
                                qty = {$item['qty']},
                                total = {$item['total']}
                            ";
                            mysqli_query($conn, $sql_item);
                        }

                        $order_success = true;
                        $order_summary = [
                            'customer_name' => $customer_name,
                            'customer_contact' => $customer_contact,
                            'customer_email' => $customer_email,
                            'customer_address' => $customer_address,
                            'payment_method' => $payment_method,
                            'items' => $order_items,
                            'total' => $grand_total,
                            'order_date' => $order_date,
                            'status' => $status
                        ];
                    } else {
                        $order_error = "Failed to place order. Error: " . mysqli_error($conn);
                    }
                }
            }
        }
    }
}
?>

<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Review your cart and confirm your order.</h2>

        <div class="order-layout">
            <div class="cart-panel">
                <h3 class="text-white">Your Cart</h3>
                <div id="cartEmpty" class="cart-empty">Your cart is empty. Add items from the menu.</div>
                <div id="cartItems" class="cart-items"></div>
                <div class="cart-footer">
                    <div class="cart-total">Total: <span id="cartTotal">$0.00</span></div>
                    <button type="button" id="clearCart" class="btn btn-secondary">Clear Cart</button>
                </div>
            </div>

            <div class="order-panel">
                <?php if ($order_error !== '') { ?>
                    <div class="error text-center"><?php echo $order_error; ?></div>
                <?php } ?>

                <?php if ($order_success) { ?>
                    <div id="orderConfirmation" class="order-confirmation">
                        <h3 class="text-center">Thank you for your order!</h3>
                        <p class="text-center">Here are the details of your order:</p>
                        <div class="order-details">
                            <p><strong>Name:</strong> <?php echo $order_summary['customer_name']; ?></p>
                            <p><strong>Contact:</strong> <?php echo $order_summary['customer_contact']; ?></p>
                            <p><strong>Email:</strong> <?php echo $order_summary['customer_email']; ?></p>
                            <p><strong>Address:</strong> <?php echo $order_summary['customer_address']; ?></p>
                            <p><strong>Payment:</strong> <?php echo $order_summary['payment_method']; ?></p>
                            <div class="order-items">
                                <?php foreach ($order_summary['items'] as $item) { ?>
                                    <p><strong><?php echo $item['title']; ?></strong> x <?php echo $item['qty']; ?> — $<?php echo number_format($item['total'], 2); ?></p>
                                <?php } ?>
                            </div>
                            <p><strong>Total:</strong> $<?php echo number_format($order_summary['total'], 2); ?></p>
                        </div>
                        <a href="index.php" class="btn btn-secondary">Back to Home</a>
                    </div>
                <?php } else { ?>
                <form id="orderForm" class="order" method="POST" action="">
                    <fieldset>
                        <legend>Delivery Details</legend>
                        <div class="order-label">Full Name</div>
                        <input type="text" name="customer_name" placeholder="E.g. John Doe" class="input-responsive" required>

                        <div class="order-label">Phone Number</div>
                        <input type="tel" name="customer_contact" placeholder="E.g. 1234567890" class="input-responsive" required>

                        <div class="order-label">Email</div>
                        <input type="email" name="customer_email" placeholder="E.g. example@example.com" class="input-responsive" required>

                        <div class="order-label">Address</div>
                        <textarea name="customer_address" rows="6" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>
                    </fieldset>

                    <fieldset>
                        <legend>Payment Method</legend>
                        <label class="radio-option">
                            <input type="radio" name="payment_method" value="Pay on Delivery (Cash)" checked>
                            Pay on Delivery (Cash)
                        </label>
                        <label class="radio-option disabled">
                            <input type="radio" name="payment_method" value="Online Payment (Coming Soon)" disabled>
                            Online Payment (Coming Soon)
                        </label>
                    </fieldset>

                    <input type="hidden" name="cart_json" id="cartJson">
                    <input type="submit" value="Confirm Order" class="btn btn-primary">
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php if ($prefill_item) { ?>
<script>
    window.prefillItem = {
        id: <?php echo (int) $prefill_item['id']; ?>,
        title: <?php echo json_encode($prefill_item['title']); ?>,
        price: <?php echo json_encode($prefill_item['price']); ?>
    };
</script>
<?php } ?>

<?php if ($order_success) { ?>
<script>
    localStorage.removeItem('fw_cart');
    const badge = document.getElementById('cartCount');
    const mobileBadge = document.getElementById('mobileCartCount');
    if (badge) badge.textContent = '0';
    if (mobileBadge) mobileBadge.textContent = '0';
</script>
<?php } ?>

<?php include('partials.front/footer.php'); ?>
