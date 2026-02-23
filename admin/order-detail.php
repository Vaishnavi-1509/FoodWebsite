<?php include('partials/menu.php'); ?>

<div class="main-content">
    <h1>Order Details</h1>

    <br/><br/>

    <?php
    if (!isset($_GET['id'])) {
        echo "<div class='error'>Order ID missing.</div>";
        echo "<br/><a href='manage-order.php' class='btn-secondary'>Back to Orders</a>";
    } else {
        $id = (int) $_GET['id'];
        $sql = "SELECT * FROM tbl_order WHERE id=$id";
        $res = mysqli_query($conn, $sql);
        if ($res && mysqli_num_rows($res) === 1) {
            $row = mysqli_fetch_assoc($res);
            ?>
            <table class="tbl-full">
                <tr>
                    <th>Food Summary</th>
                    <td><?php echo $row['food']; ?></td>
                </tr>
                <tr>
                    <th>Grand Total</th>
                    <td>$<?php echo $row['total']; ?></td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td><?php echo $row['order_date']; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                <tr>
                    <th>Customer Name</th>
                    <td><?php echo $row['customer_name']; ?></td>
                </tr>
                <tr>
                    <th>Contact</th>
                    <td><?php echo $row['customer_contact']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $row['customer_email']; ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo $row['customer_address']; ?></td>
                </tr>
            </table>

            <br/><br/>

            <h2>Items</h2>

            <?php
            $res_table = mysqli_query($conn, "SHOW TABLES LIKE 'tbl_order_item'");
            if ($res_table && mysqli_num_rows($res_table) > 0) {
                $sql_items = "SELECT food, price, qty, total FROM tbl_order_item WHERE order_id=$id";
                $res_items = mysqli_query($conn, $sql_items);
                if ($res_items && mysqli_num_rows($res_items) > 0) {
                    echo "<table class='tbl-full'>";
                    echo "<tr><th>Food</th><th>Price</th><th>Qty</th><th>Total</th></tr>";
                    while ($item = mysqli_fetch_assoc($res_items)) {
                        echo "<tr>";
                        echo "<td>{$item['food']}</td>";
                        echo "<td>\${$item['price']}</td>";
                        echo "<td>{$item['qty']}</td>";
                        echo "<td>\${$item['total']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<div class='error'>No item records found for this order.</div>";
                }
            } else {
                echo "<div class='error'>Item details are not available.</div>";
            }
            ?>

            <br/>
            <a href="manage-order.php" class="btn-secondary">Back to Orders</a>
            <?php
        } else {
            echo "<div class='error'>Order not found.</div>";
            echo "<br/><a href='manage-order.php' class='btn-secondary'>Back to Orders</a>";
        }
    }
    ?>
</div>

<?php include('partials/footer.php'); ?>
