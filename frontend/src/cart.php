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

// Retrieve cart items from the database
$sql = "SELECT c.cart_id, c.product_id, c.quantity, c.total_price, p.product_name, p.product_price, p.product_image 
        FROM cart c
        JOIN perfumes p ON c.product_id = p.product_id";
$result = $conn->query($sql);

// Calculate subtotal
$subtotal = 0;
$shipping = 10.00; // Flat rate shipping, or you could calculate based on cart content

// Update cart quantity if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $new_quantity = $_POST['quantity'];

    // Get the product price from the perfumes table
    $product_id_query = "SELECT product_price FROM perfumes WHERE product_id = (SELECT product_id FROM cart WHERE cart_id = ?)";
    $product_stmt = $conn->prepare($product_id_query);
    $product_stmt->bind_param("i", $cart_id);
    $product_stmt->execute();
    $product_stmt->bind_result($product_price);
    $product_stmt->fetch();
    $product_stmt->close();

    // Calculate the new total price
    $new_total_price = $product_price * $new_quantity;

    // Update the cart with the new quantity and total price
    $update_sql = "UPDATE cart SET quantity = ?, total_price = ? WHERE cart_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("idi", $new_quantity, $new_total_price, $cart_id);
    $stmt->execute();
    $stmt->close();

    // Refresh the page to show updated cart
    header("Location: cart.php");
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "index.css">
    <link rel="icon" href="assets/logos/logo-light.png" type="image/png">
    
    <!--====== BootStrap Icons (NOTE: THIS IS NOT BOOTSTRAP FRAMEWORK, JUST ITS ICONS)======-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--====== Lineicons CSS ======-->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <title>Cart</title>

    <Style>
        .remove-btn {
            color: red;
            cursor: pointer;
        }
    </Style>
</head>
<body>
    <!--HEADER SECTION-->
    <section>
        <header>
            <div class="container">
                <nav class="navbar">
                    <div class="logo">
                    <a href="#">
                        <img src="./assets/logos/logo.png" alt="companylogo" height="70" width="100">
                    </a>
                    </div>
                    <div class="nav-items">
                        <a href="home.html">Home</a>
                        <a href="#">About</a>
                        <a href="product_page.php">Products</a>
                        <a href="#">Contact Us</a>
                    </div>
                    <div class="icon-items">
                        <a href="#"><img src="./assets/icons/search.png" height="27"></a>
                        <a href="#"><img src="./assets/icons/profile.png" height="30"></a>
                        <a href="cart.php"><img src="./assets/icons/cart.png" height="30"></a>

                    </div>
                </nav>
            </div>
        </header>
    </section>

    <section>
        <div class="container" style="padding-top: 50px;">
            <div class="row">
                <div class="col-7">
                    <h2>Your Cart</h2>
                    <h5>Not ready to checkout? <a href="home.html">Continue Shopping</a></h5>

                    <table style="width: 100%; margin-top: 30px; margin-bottom: 30px;">
                        <tr>
                            <th style="width: 15%;">Product</th>
                            <th style="width: 35%;"></th>
                            <th style="width: 20%;">Quantity</th>
                            <th style="width: 20%;">Subtotal</th>
                            <th style="width: 10%;">Remove</th>
                        </tr>
                        
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <?php $subtotal += $row['total_price']; ?>
                            <tr>
                                <td style="width: 20px;">
                                    <img src="<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" class="product-image">
                                </td>
                                <td>
                                    <h5 class="cart-title"><?php echo $row['product_name']; ?></h5>
                                    <h5 class="cart-price">$<?php echo number_format($row['product_price'], 2); ?></h5>
                                </td>
                                <td>
                                    <div class="row">
                                        <form method="POST" action="cart.php">
                                            <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                                            <input type="number" name="quantity" class="quantityfield" style="width: 50px; height: 30px; padding-right: 0px;" 
                                                   value="<?php echo $row['quantity']; ?>" min="1" step="1"
                                                   onchange="this.value = Math.max(1, this.value); this.form.submit()">
                                        </form>
                                    </div>
                                </td>
                                <td style="width: 20%;">
                                    <h5 class="cart-subtotal">$<?php echo number_format($row['total_price'], 2); ?></h5>
                                </td>
                                <td>
                                    <span class="remove-btn" onclick="removeFromCart(<?php echo $row['cart_id']; ?>)">×</span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
                <div class="col-5" style="padding-left: 100px;">
                    <h2 style="padding-bottom: 10px;">Order Summary</h2>
                    <input type="text" placeholder="Enter coupon code here" style="width: 100%; padding: 5px; margin-bottom: 10px;">
                    <div class="row" style="justify-content: space-between; padding-top: 5px;">
                        <h5>Subtotal</h5>
                        <h5>$<?php echo number_format($subtotal, 2); ?></h5>
                    </div>
                    <div class="row" style="justify-content: space-between; padding-top: 5px; padding-bottom: 5px;">
                        <h5>Shipping</h5>
                        <h5>$<?php echo number_format($shipping, 2); ?></h5>
                    </div>
                    <hr>
                    <div class="row" style="justify-content: space-between; padding-top: 5px;">
                        <h5>Total</h5>
                        <h5>$<?php echo number_format($subtotal + $shipping, 2); ?></h5>
                    </div>
                    <button class="primary-btn addtocart-btn" style="margin-top: 10px;" onclick="window.location.href='checkout.php'">Continue to checkout</button>
                </div>
            </div>
        </div>
    </section>

    <!--FOOTER SECTION-->
    <section>
        <footer class="footer-area footer-one">
            <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="f-download">
                        <div class="f-about">
                        <div class="footer-logo">
                            <a href="#">
                            <img src="./assets/logos/logo.png" alt="Logo" width="20%"/>
                            </a>
                        </div>
                        <p class="text">
                                Maximizing Profits, Ensuring Compliance — <br>
                                Your Trusted Partner in Accounting and Advisory
                        </p>
                        </div>
                        <div class="footer-app-store">
                        <h5 class="download-title">Download Our App Now!</h5>
                        <ul>
                            <li>
                                <img src="https://cdn.ayroui.com/1.0/images/footer/app-store.svg" alt="app"/>
                            </li>
                            <li>
                                <img src="https://cdn.ayroui.com/1.0/images/footer/play-store.svg" alt="play"/>
                            </li>
                        </ul>
                        </div>
                    </div>
                    <div class="f-company">
                        <div class="footer-link">
                        <h6 class="footer-title">Company</h6>
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Marketing</a></li>
                            <li><a href="#">Awards</a></li>
                        </ul>
                        </div>
                        <!-- footer link -->
                    </div>
                    <div class="f-link">
                        <div class="footer-link">
                        <h6 class="footer-title">Services</h6>
                        <ul>
                            <li><a href="#">Products</a></li>
                            <li><a href="#">Business</a></li>
                            <li><a href="#">Developer</a></li>
                            <li><a href="#">Insights</a></li>
                        </ul>
                        </div>
                        <!-- footer link -->
                    </div>
                    <div class="col-xl-2 col-lg-3 col-sm-4">
                        <!-- Start Footer Contact -->
                        <div class="footer-contact">
                        <h6 class=" footer-title">Help & Support</h6>
                        <ul>
                            <li>
                                <i class="lni lni-map-marker"></i> Madison Street, NewYork,
                                USA
                            </li>
                            <li><i class="lni lni-phone-set"></i> +88 556 88545</li>
                            <li><i class="lni lni-envelope"></i> support@ayroui.com</li>
                        </ul>
                        </div>
                        <!-- End Footer Contact -->
                    </div>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
            </div>
            <!-- footer widget -->
            <div class="footer-copyright bg-dark">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div
                        class="
                        copyright
                        text-center
                        d-md-flex
                        justify-content-between
                        align-items-center
                        "
                        >
                        <p class="text text-white">Copyright © 2024 <i>Keegan.</i> All Rights Reserved</p>
                        <ul class="social">
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="lni lni-facebook-square"></i>    
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                <i class="lni lni-twitter-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)"
                                    ><i class="lni lni-linkedin-original"></i
                                    ></a>
                            </li>
                        </ul>
                        </div>
                        <!-- copyright -->
                    </div>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
            </div>
            <!-- footer copyright -->
        </footer>
        <!--====== FOOTER ONE PART ENDS ======-->
    </section>

    <!-- JS to remove item from cart -->
    <script>
        function removeFromCart(cartId) {
            if (confirm("Are you sure you want to remove this item from your cart?")) {
                window.location.href = "remove_from_cart.php?cart_id=" + cartId;
            }
        }
    </script>
</body>
</html>


<?php $conn->close(); ?>
