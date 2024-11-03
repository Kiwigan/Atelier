<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "atelier";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if product_id is in the URL
if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    
    // Fetch product details
    $sql = "SELECT * FROM perfumes WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<p>Product not found.</p>";
        exit;
    }
} else {
    echo "<p>No product specified.</p>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> - Details</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <section>
            <div class="container">
                <div class="row">
                    <div class="col-7" style="padding-right: 80px; display: flex; justify-content: center;">
                        <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="product-detail-image">
                    </div>
                    <div class="col-5">
                        <h1><?php echo $product['product_name']; ?></h1> 
                        <h4>$<?php echo number_format($product['product_price'], 2); ?></h4>
                        <br><br>
                        <hr>
                        <p style="padding-top: 30px; padding-bottom: 30px;"><?php echo $product['product_details']; ?></p>
                        <p>Rating: <?php echo $product['product_rating']; ?> / 5</p>

                        <b>
                            <span id="sold-no">17</span>
                            sold in last
                            <span id="hour-no">24</span>
                            Hour
                        </b>

                        <div class="row" style="padding-top: 30px;">
                            <div class="col-2" style="display: flex; flex-wrap: wrap;">
                                <input type="number" name="quantity" value="1" class="quantityfield">
                            </div>
                            <div class="col-10" style="display: flex; flex-wrap: wrap;">
                                <button type="submit" class="primary-btn addtocart-btn" value="Add to Cart">
                                    Add to Cart
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</body>
</html>
