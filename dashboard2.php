<?php
include 'include/header.php';
include 'include/functions.php';

$conn = connectDB();

$query = "SELECT orders.*, products.name as product_name, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 7 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nearby Orders</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Remaining Days</th>
                            <th>Progress</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        $all_orders = getAllOrders();
                        while ($order = mysqli_fetch_assoc($all_orders)) {
                            $product_id = $order['product_id'];
                            $product = getProductById($product_id);
                            $order_date = new DateTime($order['order_date']);
                            $delivery_date = new DateTime($order['delivery_date']);
                            $remaining_days = $order_date->diff($delivery_date)->format("%a");
                            echo '<tr>';
                            echo '<td>' . $order['customer_name'] . '</td>';
                            echo '<td>' . $product['name'] . '</td>';
                            echo '<td>' . $order['quantity'] . '</td>';
                            echo '<td>' . $order['order_date'] . '</td>';
                            echo '<td>' . $order['delivery_date'] . '</td>';
                            echo '<td>' . $remaining_days . '</td>';
                            echo '<td><div class="progress">
                                  <div class="progress-bar" role="progressbar" style="width: ' . (100 - ($remaining_days * 100) / 7) . '%" aria-valuenow="' . (100 - ($remaining_days * 100) / 7) . '" aria-valuemin="0" aria-valuemax="100"></div>
                                </div></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
