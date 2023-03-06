<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';

if (isset($_POST['submit'])) {
    $client = $_POST['client'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $date = date('Y-m-d');
    $delivery_date = $_POST['delivery_date'];
    $shipping_status_id = $_POST['shipping_status_id'];

    $result = addOrder($client, $product_id, $quantity, $date, $delivery_date, $shipping_status_id);

    if ($result) {
        $_SESSION['message'] = "Order added successfully";
        header('location: order-list.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to add order";
    }
}
?>
<div class="container">
    <h1>New Order</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="client">الموقع</label>
            <input type="text" class="form-control" id="client" name="client" required>
        </div>
        <div class="form-group">
            <label for="product">Product</label>
            <div class="row">
                <?php foreach (getAllProducts() as $product) : ?>
                    <div class="col-sm-3">
                        <div class="card">
                            <img src="images/<?= $product['image'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product['name'] ?></h5>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="product_<?= $product['id'] ?>" name="product_id" value="<?= $product['id'] ?>" required>
                                    <label class="form-check-label" for="product_<?= $product['id'] ?>">Select</label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="quantity">الكمية</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="delivery_date">Delivery Date</label>
            <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
        </div>
        <div class="form-group">
            <label for="shipping_status_id">Shipping Status</label>
            <select class="form-control" id="shipping_status_id" name="shipping_status_id" required>
                <option value="pending">Pending</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" value="Add Order" name="submit" class="btn btn-primary">
            <a href="order-list.php" class="btn btn-secondary">Back to Order List</a>
        </div>
    </form>

</div>
<script>
    document.querySelector('#product_id').addEventListener('change', function(e) {
        const selectedProduct = getAllProducts().find(product => product.id === this.value);
        const productImage = document.querySelector('#product-image');
        productImage.innerHTML = `<img src="${selectedProduct.image}" alt="${selectedProduct.name}" width="100" height="100">`;
    });
</script>
<?php
include 'include/footer.php';
?>