<?php
include 'include/db.php';
include 'include/functions.php';
include 'include/header.php';

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

?>

<div class="container">
    <h1>Product List</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Code</th>
                <th>Type</th>
                <th>Wood Type</th>
                <th>Paint Type</th>
                <th>Wood Color</th>
                <th>Accessories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($product = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['description'] ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" height="50"></td>
                        <td><?= $product['code'] ?></td>
                        <td><?= $product['type'] ?></td>
                        <td><?= $product['wood_type'] ?></td>
                        <td><?= $product['paint_type'] ?></td>
                        <td><?= $product['wood_color'] ?></td>
                        <td><?= $product['accessories'] ?></td>
                        <td>
                            <a href="product-edit.php?id=<?= $product['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="product-delete.php?id=<?= $product['id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="product-add.php" class="btn btn-primary">Add Product</a>
    <a href="add-order.php" class="btn btn-primary">Add Order</a>
</div>
<?php
include 'include/footer.php';
?>