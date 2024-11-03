<?php
session_start(); // Start the session

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atelier";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, '3306');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the place order button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['place_order'])) {
    // Retrieve user input from payment form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];

    // Calculate total price from the cart session
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['total_price'];
    }

    // Add shipping fee
    $shipping_fee = 10; // Define the shipping fee
    $total_price += $shipping_fee;

    // Insert order details into orders table
    $stmt = $conn->prepare("INSERT INTO orders (first_name, last_name, email, address, country, city, postal_code, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssd", $first_name, $last_name, $email, $address, $country, $city, $postal_code, $total_price);
    $stmt->execute();
    
    // Get the last inserted order ID
    $order_id = $stmt->insert_id;

    // Insert each item from the cart into the order_items table
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $item_total_price = $item['total_price'];

        // Prepare the statement for order items
        $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
        $item_stmt->bind_param("iiid", $order_id, $product_id, $quantity, $item_total_price);
        $item_stmt->execute();
    }

    // Close statements
    $stmt->close();
    $item_stmt->close();
    
    // Clear the cart session
    unset($_SESSION['cart']);

    // Redirect to a thank you page or display a confirmation
    header("Location: send_confirmation_email.php?order_id=" . $order_id);
    exit();
}

// Close the database connection
$conn->close();
?>
