<?php

function addProduct($name, $description, $price, $image, $code, $type, $wood_type, $paint_type, $wood_color, $accessories) {
    global $conn;

    $sql = "INSERT INTO products (name, description, price, image, code, type, wood_type, paint_type, wood_color, accessories)
            VALUES ('$name', '$description', '$price', '$image', '$code', '$type', '$wood_type', '$paint_type', '$wood_color', '$accessories')";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

function getAllProducts()
{
    global $conn;
    $query = "SELECT id, name, description, price, image, code, type, wood_type, paint_type, wood_color, accessories, category FROM products";
    $result = mysqli_query($conn, $query);
    return $result;
}


function getAllCategories() {
    global $conn;
    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);
    return $result;
}


function getProductById($id) {
    global $conn;

    $sql = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    return mysqli_fetch_assoc($result);
}

function addOrder($customer_name, $product_id, $quantity, $order_date) {
    global $conn;
    $query = "INSERT INTO orders (customer_name, product_id, quantity, order_date) VALUES ('$customer_name', '$product_id', '$quantity', '$order_date')";
    $result = mysqli_query($conn, $query);
    if($result) {
        displayMessage('Order added successfully!');
    } else {
        displayMessage('Failed to add order!');
    }
}


function displayMessage() {
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}


function getAllOrders(){
    global $conn;
    $query = "SELECT * FROM orders";
    $result = mysqli_query($conn, $query);
    return $result;
}




function connectDB() {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mffus2";
    $conn = mysqli_connect($host, $username, $password, $dbname);
    return $conn;
}




function getOrdersByDeliveryDate($date, $limit) {
    $conn = mysqli_connect("localhost", "root", "", "mffus2");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM orders WHERE delivery_date = ? LIMIT ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $date, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getCount($date) {
    $conn = mysqli_connect("localhost", "root", "", "mffus2");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT COUNT(*) as total FROM orders WHERE delivery_date = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result)['total'];
}


function getShippingStatusName($shipping_status_id) {
    global $conn;
    $query = "SELECT name FROM shipping_status WHERE id = '$shipping_status_id'";
    $result = mysqli_query($conn, $query);
    $shipping_status = mysqli_fetch_assoc($result);
    return $shipping_status['name'];
}


function getRemainingDays($delivery_date) {
    $current_date = time();
    $delivery_date = strtotime($delivery_date);
    $difference = $delivery_date - $current_date;
    return floor($difference / (60 * 60 * 24));
}



// order
function getOrders() {
    // Connect to database and retrieve order data
    $conn = mysqli_connect("localhost", "root", "", "mffus2");
    $sql = "SELECT * FROM orders";
    $result = mysqli_query($conn, $sql);
  
    // Loop through the results and create a table row for each order
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['id'] . "</td>";
      echo "<td>" . $row['customer_name'] . "</td>";
      echo "<td>" . $row['order_date'] . "</td>";
      echo "<td>" . $row['price'] . "</td>";
      echo "</tr>";
    }
  
    // Close the database connection
    mysqli_close($conn);
  }
  
?>
