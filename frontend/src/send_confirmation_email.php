<?php
// Start the session (if necessary)
session_start(); 

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


// Ensure we have an order ID to work with
if (!isset($_GET['order_id'])) {
    die("Order ID not provided.");
}
$order_id = $_GET['order_id'];

// Define the shipping fee
$shipping_fee = 10.00;

// Retrieve order details from the orders table
$order_query = $conn->prepare("SELECT first_name, last_name, email, address, country, city, postal_code, total_price, order_date FROM orders WHERE order_id = ?");
$order_query->bind_param("i", $order_id);
$order_query->execute();
$order_query->bind_result($first_name, $last_name, $email, $address, $country, $city, $postal_code, $total_price, $order_date);
$order_query->fetch();
$order_query->close();

// Retrieve order items from the order_items table
$items_query = $conn->prepare("SELECT oi.product_id, oi.quantity, oi.total_price, p.product_name, p.product_image FROM order_items oi JOIN perfumes p ON oi.product_id = p.product_id WHERE oi.order_id = ?");
$items_query->bind_param("i", $order_id);
$items_query->execute();
$items_result = $items_query->get_result();

// Prepare the email content
$subject = "Order Confirmation - Order #$order_id";
$headers = "From: atelier@noreply\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Start building the HTML email message
$message = "<h2>Thank you for your order, $first_name!</h2>";
$message .= "<p>Your order has been placed successfully. Here are the details:</p>";
$message .= "<h3>Order Summary:</h3>";
$message .= "<p><strong>Order ID:</strong> #$order_id</p>";
$message .= "<p><strong>Order Date:</strong> $order_date</p>";
$message .= "<p><strong>Shipping Address:</strong><br>$address<br>$city, $postal_code<br>$country</p>";

// Order items table
$message .= "<table border='1' cellpadding='10' cellspacing='0' style='width: 100%; border-collapse: collapse;'>";
$message .= "<tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
$subtotal = 0;

while ($item = $items_result->fetch_assoc()) {
    $product_name = $item['product_name'];
    // Use the image path from your database. This assumes that product_image contains the filename.
    $product_image = "https://raw.githubusercontent.com/Lay-jr/Atelier-Perfume/refs/heads/main/" . $item['product_image']; 
    $quantity = $item['quantity'];
    $item_price = $item['total_price'] / $quantity; // Calculate individual price
    $item_total = $item['total_price'];
    $subtotal += $item_total;

    $message .= "<tr>";
    $message .= "<td><img src='" . $product_image . "' alt='" . $product_name . "' style='width:50px; height:50px; vertical-align:middle; margin-right:10px;'> " . $product_name . "</td>";
    $message .= "<td style='text-align:center;'>$quantity</td>";
    $message .= "<td style='text-align:center;'>$" . number_format($item_price, 2) . "</td>";
    $message .= "<td style='text-align:center;'>$" . number_format($item_total, 2) . "</td>";
    $message .= "</tr>";
}

$message .= "</table>";

// Add subtotal, shipping, and total
$message .= "<p><strong>Subtotal:</strong> $" . number_format($subtotal, 2) . "</p>";
$message .= "<p><strong>Shipping:</strong> $" . number_format($shipping_fee, 2) . "</p>";
$message .= "<p><strong>Total:</strong> $" . number_format($total_price, 2) . "</p>";
$message .= "<p>If you have any questions, please feel free to contact us.</p>";
$message .= "<p>Thank you for shopping with us!</p>";

// Add Track Order button
$message .= "<p style='text-align: left;'>";
$message .= "<a href='orders.html' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;'>Track Your Order</a>";
$message .= "</p>";

// Send the email
if (mail($email, $subject, $message, $headers)) {
    //echo "Order confirmation email sent successfully.";
} else {
    echo "Failed to send confirmation email.";
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "index.css">
    <link rel="stylesheet" href="product_page.css">
    <link rel="icon" href="assets/logos/logo-light.png" type="image/png">
    
    <!--====== BootStrap Icons (NOTE: THIS IS NOT BOOTSTRAP FRAMEWORK, JUST ITS ICONS)======-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--====== Lineicons CSS ======-->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <title>Confirmation</title>
</head>
<body>
    <section class="confirmation">
        <div class="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row">
               <div class="col-12">
                    <div class="content" style="text-align: center;">
                        <i class="bi bi-check-circle-fill"></i>
                        <h1 style="padding-bottom: 20px; padding-top: 20px;">Thank You!<br>Your Order Has Been Confirmed</h1>
                        <p>
                           A confirmation email has been sent.
                        </p>
                        <p>Your order number is <span><?php echo htmlspecialchars($order_id); ?></span></p>
                        <div class="options" style="padding-top: 20px;">
                            <a href="home.php"><button class="btn primary-btn">Back to Home</button></a>
                            <a href="orders.php"><button class="btn primary-btn">View Orders</button></a>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- row -->
         </div>
    </section>
</body>
</html>