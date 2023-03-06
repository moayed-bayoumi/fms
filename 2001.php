<?php
include 'include/header.php';
include 'include/functions.php';

$conn = connectDB();

// Get the total number of products
$query = "SELECT COUNT(id) as total_products FROM products";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_bind_result($stmt, $total_products);
    mysqli_stmt_fetch($stmt);
} else {
    die("Error executing statement: " . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);

// Get the total number of orders
$query = "SELECT COUNT(id) as total_orders FROM orders";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_bind_result($stmt, $total_orders);
    mysqli_stmt_fetch($stmt);
} else {
    die("Error executing statement: " . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);

// Get the total number of categories
$query = "SELECT COUNT(id) as total_categories FROM categories";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_bind_result($stmt, $total_categories);
    mysqli_stmt_fetch($stmt);
} else {
    die("Error executing statement: " . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);

// Get the number of orders due in the next 20 days
$query = "SELECT COUNT(id) as due_orders FROM orders WHERE DATEDIFF(delivery_date, CURDATE()) <= 20";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_bind_result($stmt, $due_orders);
    mysqli_stmt_fetch($stmt);
} else {
    die("Error executing statement: " . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);
?>

<link rel="stylesheet" href="include/assets/css/main.css">

<div class="container">
    <h2>Success!</h2>
    <p>The data has been successfully added to the database.</p>
    <a href="index.php" class="btn btn-primary">Back to Home</a>
</div>
<?php
include "include/footer.php";
?>