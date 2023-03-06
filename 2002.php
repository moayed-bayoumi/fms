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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" integrity="sha512-NxidTm7lTlE1iRmFhWt2c7f1nm4tq3oVJ4xOhTz7pTJdS1hZhRum0W61O8+Dz0XaCClOyysEogZG8RRvz+23Kg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Awesome 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-kzv1fELr3+7gI42y8Kl6P+o6YJ9D1piU98Oxanb+rkzOfJcHw47+ESt+RP0oKj/cvY1c9J/XRop0kyz+M1Iv3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <div class="container-fluid py-4">

        <div class="row gy-4">

            <div class="col-lg-4 col-md-6">
                <div class="card bg-primary text-white shadow-lg">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Products</h5>
                            <h2 class="card-subtitle mb-0"><?php echo $total_products; ?></h2>
                        </div>
                        <i class="fas fa-box-open fa-3x"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card bg-success text-white shadow-lg">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Orders</h5>
                            <h2 class="card-subtitle mb-0"><?php echo $total_orders; ?></h2>
                        </div>
                        <i class="fas fa-shopping-cart fa-3x"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card bg-info text-white shadow-lg">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Categories</h5>
                            <h2 class="card-subtitle mb-0"><?php echo $total_categories; ?></h2>
                        </div>
                        <i class="fas fa-list-alt fa-3x"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Orders Due in 20 Days</< /h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // query orders due in 20 days
                                        $query = "SELECT orders.order_id, customers.customer_name, orders.due_date, orders.amount, orders.status 
                                    FROM orders JOIN customers ON orders.customer_id=customers.customer_id 
                                    WHERE DATEDIFF(orders.due_date, CURDATE()) <= 20";
                                        $result = mysqli_query($conn, $query);
                                        // loop through each order and display in table
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['order_id'] . "</td>";
                                            echo "<td>" . $row['customer_name'] . "</td>";
                                            echo "<td>" . $row['due_date'] . "</td>";
                                            echo "<td>" . $row['amount'] . "</td>";
                                            echo "<td>" . $row['status'] . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>