<?php
include 'include/header.php';
include 'include/functions.php';

$conn = connectDB();

$query = "SELECT orders.*, products.name as product_name, products.image as product_image, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 7 ORDER BY remaining_days ASC";
$result = mysqli_query($conn, $query);
?>
<style>
    .loading-bar {
        height: 20px;
        width: 100%;
        border-radius: 10px;
        animation: loading 2s linear infinite;
    }

    .loading-bar-red {
        background-color: #ff0000;
    }

    .loading-bar-yellow {
        background-color: #ffff00;
    }

    .loading-bar-green {
        background-color: #00ff00;
    }

    @keyframes loading {
        0% {
            transform: scale(0);
        }

        100% {
            transform: scale(1);
        }
    }

    .img-container {
        width: 50px;
        height: 50px;
        overflow: hidden;
        border-radius: 50%;
        margin: 0 auto;
    }

    .img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Nearby Orders</h4>
            </div>
            <div class="card-body">
                <table id="order-table" class="table table-striped">
                    <thead>
                        <th>Product Image</th>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Remaining Days</th>
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
                            $color = "";
                            if ($remaining_days <= 3) {
                                $color = "red";
                            } else if ($remaining_days <= 7) {
                                $color = "yellow";
                            } else {
                                $color = "green";
                            }
                            echo '<tr>';
                            echo '<td><img src="' . $product['image'] . '" height="50" width="50" /></td>';
                            echo '<td>' . $order['customer_name'] . '</td>';
                            echo '<td>' . $product['name'] . '</td>';
                            echo '<td>' . $order['quantity'] . '</td>';
                            echo '<td>' . $order['order_date'] . '</td>';
                            echo '<td>' . $order['delivery_date'] . '</td>';
                            echo '<td><div class="loading-bar loading-bar-' . $color . '"></div></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<style>
    #order-table td {
        text-align: center;
    }

    #order-table td img {
        border-radius: 50%;
        object-fit: cover;
    }
</style>
<script>
    $(document).ready(function() {
        $('#order-table').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [6]
            }]
        });
    });
</script>
</body>

</html>