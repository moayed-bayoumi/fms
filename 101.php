<?php
include 'include/header.php';
include 'include/functions.php';

$conn = connectDB();

$query = "SELECT orders.*, products.name as product_name, products.image_path, products.category, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 7 ORDER BY remaining_days ASC";

$result = mysqli_query($conn, $query);
?>
<style>
.nearby-orders {
    margin-top: 30px;
    padding: 20px;
    background: #e9ecef;
}

.nearby-orders .order {
    background: #fff;
    box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.05);
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    position: relative;
}

.nearby-orders .order .title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 20px;
}

.nearby-orders .order .customer {
    font-size: 14px;
    margin-bottom: 20px;
}

.nearby-orders .order .product {
    font-size: 14px;
    margin-bottom: 20px;
}

.nearby-orders .order .order-date {
    font-size: 14px;
    margin-bottom: 20px;
}

.nearby-orders .order .delivery-date {
    font-size: 14px;
    margin-bottom: 20px;
}

.nearby-orders .order .remaining-days {
    font-size: 14px;
    margin-bottom: 20px;
    position: absolute;
    right: 20px;
    top: 20px;
}

.nearby-orders .order .remaining-days .days {
    background: #0f9d58;
    color: #fff;
    padding: 10px 20px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 14px;
}

</style>

<div class="order">
  <div class="title">Order Information</div>
  <div class="customer">Customer Name: <?php echo $order['customer_name']; ?></div>
  <div class="product">Product Name: <?php echo $order['product_name']; ?></div>
  <div class="image">
    <img src="<?php echo $order['image_path']; ?>" alt="Product Image">
  </div>
  <div class="category">Category: <?php echo $order['category']; ?></div>
  <div class="order-date">Order Date: <?php echo $order['order_date']; ?></div>
  <div class="delivery-date">Delivery Date: <?php echo $order['delivery_date']; ?></div>
  <div class="remaining-days">
    <div class="days">Remaining Days: <?php echo $order['remaining_days']; ?></div>
  </div>
</div>


<script>
    $(document).ready(function() {
        $('#order-table').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [5]
            }]
        });
    });
</script>
</body>

</html>