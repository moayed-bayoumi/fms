<div class="container">
    <h1>New Order</h1>
    <form action="" method="post">
        <div class="form-group row">
            <label for="client" class="col-sm-2 col-form-label">الموقع</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="client" name="client" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="product_id" class="col-sm-2 col-form-label">المنتج</label>
            <div class="col-sm-10">
                <select class="form-control" id="product_id" name="product_id" required>
                    <?php foreach (getAllProducts() as $product) : ?>
                        <option value="<?= $product['id'] ?>">
                            <img src="<?= $product['image'] ?>" style="width: 50px; height: 50px; display: inline-block; margin-right: 10px;">
                            <?= $product['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="quantity" class="col-sm-2 col-form-label">الكمية</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="delivery_date" class="col-sm-2 col-form-label">Delivery Date</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="shipping_status" class="col-sm-2 col-form-label">Shipping Status</label>
            <div class="col-sm-10">
                <div class="progress">
                    <div id="shipping_status" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                        Pending
                    </div>
                </div>
                <small class="form-text text-muted">Update the status by selecting one of the options below:</small>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="shipping_status_id" id="pending" value="pending" checked>
                    <label class="form-check-label" for="pending">Pending</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="shipping_status_id" id="shipped" value="shipped">
                    <label class="form-check-label" for="shipped">Shipped</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="shipping_status_id" id="delivered" value="delivered">
                    <label class="form-check-label" for="delivered">Delivered</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary" name="submit">Add Order</button>
                <a href="order-list.php" class="btn btn-secondary">Back to Order List</a>
            </div>
        </div>
    </form>

</div>
<script>
    $(document).ready(function() {
        $('input[type="radio"]').change(function() {
            let status = $(this).val();
            $('#shipping_status').text(status);
            $('#shipping_status').removeClass().addClass(`progress-bar progress-bar-striped progress-bar-animated bg-${status}`);
        });
    });
</script>
<?php
include 'include/footer.php';
?>