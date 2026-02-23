<?php include('partials/menu.php'); ?>

<div class="main-content">
        <h1>Manage Order</h1>

        <br/><br/>
        
        <br/><br/>

        <a href="#" class="btn-primary">Add Order</a>
        <br/><br/><br/>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php
            // Fetch all orders from the database
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            $sn = 1; // Serial Number
            $has_items_table = false;
            $res_table = mysqli_query($conn, "SHOW TABLES LIKE 'tbl_order_item'");
            if ($res_table && mysqli_num_rows($res_table) > 0) {
                $has_items_table = true;
            }

            if ($res == TRUE) {
                $count = mysqli_num_rows($res); // Get the number of rows

                if ($count > 0) {
                    // Orders available
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $customer_contact; ?></td>
                            <td><?php echo $customer_email; ?></td>
                            <td><?php echo $customer_address; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/order-detail.php?id=<?php echo $id; ?>" class="btn-secondary">View Details</a>
                            </td>
                        </tr>

                        <?php
                        if ($has_items_table) {
                            $sql_items = "SELECT food, price, qty, total FROM tbl_order_item WHERE order_id=$id";
                            $res_items = mysqli_query($conn, $sql_items);
                            if ($res_items && mysqli_num_rows($res_items) > 0) {
                                echo "<tr><td colspan='12'><strong>Items:</strong> ";
                                $parts = [];
                                while ($item = mysqli_fetch_assoc($res_items)) {
                                    $parts[] = $item['food'] . " x " . $item['qty'] . " ($" . $item['total'] . ")";
                                }
                                echo implode(" | ", $parts);
                                echo "</td></tr>";
                            }
                        }
                    }
                } else {
                    // No orders available
                    echo "<tr><td colspan='12' class='error'>Orders not available.</td></tr>";
                }
            }
            ?>
        </table>
</div>

<?php include('partials/footer.php'); ?>
