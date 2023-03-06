<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Orders Due in 20 Days</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <style>
        .card {
            transition: all 0.2s ease-in-out;
        }

        .card:hover {
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        #loading-bar {
            width: 100%;
            height: 10px;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #d9edf7;
            z-index: 10;
            opacity: 0.7;
        }

        #loading-bar-progress {
            width: 0;
            height: 100%;
            background-color: #337ab7;
            animation: loading-bar-animation 2s linear forwards;
        }

        @keyframes loading-bar-animation {
            0% {
                width: 0;
            }

            100% {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php
    include 'include/header.php';
    include 'include/functions.php';
    $conn = connectDB();

    $query = "SELECT orders.*, products.name as product_name, DATEDIFF(delivery_date, CURDATE()) as remaining_days FROM orders LEFT JOIN products ON orders.product_id = products.id WHERE DATEDIFF(delivery_date, CURDATE()) <= 20 ORDER BY remaining_days ASC";
    $result = mysqli_query($conn, $query);

    $due_orders = mysqli_num_rows($result);
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center">
        
                <div id="loading-bar">
                    <div id="loading-bar-progress"></div>
                </div>
                <p id="loading-text">0%</p>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <h4 class="card-title">Orders Due in 20 Days</h4>
            <hr>
            <table id="orders-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Remaining Days</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['remaining_days']; ?></td>
                            <td><img src="images/<?php echo $row['product_image']; ?>" alt="Product Image" width="50"></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
            <!-- Progress bar for delivery date -->
            <div class="progress mt-5">
                <div class="progress-bar" role="progressbar" style="width: <?php echo ($due_orders / $total_orders) * 100; ?>%" aria-valuenow="<?php echo $due_orders; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total_orders; ?>"></div>
            </div>
            <!-- Display customer's name above the bar in bold font -->
            <h3 class="text-center mt-2 font-weight-bold"><?php echo $_SESSION['username']; ?></h3>
            <!-- DataTables JavaScript -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
            <!-- Dynamic Animation for the loading bar -->
            <script>
                $(document).ready(function() {
                    // Initialize DataTables
                    $('#orders-table').DataTable({
                        "ordering": false
                    });

                    // Dynamic Animation for the progress bar
                    var progressBar = $('.progress-bar');
                    var remainingDays = parseInt(progressBar.attr('aria-valuenow'));
                    var totalOrders = parseInt(progressBar.attr('aria-valuemax'));

                    var interval = setInterval(function() {
                        if (remainingDays == 0) {
                            clearInterval(interval);
                        } else {
                            progressBar.css('width', ((totalOrders - remainingDays) / totalOrders * 100) + '%');
                            remainingDays--;
                        }
                    }, 1000);
                });
            </script>
            <!-- Footer -->
            <?php include 'include/footer.php'; ?>