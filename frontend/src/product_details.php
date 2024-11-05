<?php
function displayrating($rating){
    echo "<div class='ratings'>";
    for($i = $rating; $i >= 1; $i--){
        echo "<i class='bi bi-star-fill'></i>&nbsp";
    }
    if(($rating*10)%10 != 0){
        echo "<i class='bi bi-star-half'></i>&nbsp";
    }
    $remainder = 5 - floor($rating);
    if($remainder > 0){
        for($i = $remainder; $i>0; $i--){
            echo "<i class='bi bi-star'></i>&nbsp";
        }
    }
    echo "</div>";

}
?>

<?php
session_start(); // Start the session
// Check if the user is logged in by checking if a session variable is set
$is_logged_in = isset($_SESSION['user_id']);

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

// Check if product_id is in the URL
if (isset($_GET['product_id'])) {
    $url_product_id = intval($_GET['product_id']);
    
    // Fetch product details
    $sql = "SELECT * FROM perfumes WHERE product_id = $url_product_id";
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

//Process form add to cart submission
if (isset($_POST['add_to_cart'])) {
    // Retrieve product details from form
    $form_product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $product_price = $_POST['product_price'];
    $total_price = $quantity * $product_price;

    // Initialize cart in session if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$form_product_id])) {
        // If product exists, update quantity and total price
        $_SESSION['cart'][$form_product_id]['quantity'] += $quantity;
        $_SESSION['cart'][$form_product_id]['total_price'] += $total_price;
    } else {
    
        // Add item to cart session
        $_SESSION['cart'][$form_product_id] = [
            'product_id' => $form_product_id,
            'quantity' => $quantity,
            'total_price' => $total_price,
            'product_price' => $product['product_price'],
            'product_name' => $product['product_name'], // Add product name if needed
            'product_image' => $product['product_image'],
        ];
    }

    // Success message with JavaScript alert, Returns to same page after a 0.2 second delay
    echo "<script>
        alert('Item successfully added to cart!');
        window.location.href = 'product_page.php?product_id=" . $form_product_id . "';
      </script>";

    exit(); // End script to prevent further execution
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
    <link rel="icon" href="assets/logos/logo-light.png" type="image/png">

    <!--====== BootStrap Icons (NOTE: THIS IS NOT BOOTSTRAP FRAMEWORK, JUST ITS ICONS)======-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--====== Lineicons CSS ======-->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <title>Product Details</title>


    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
          const header = document.querySelector("header");
          let lastScrollTop = 0;
    
          window.addEventListener("scroll", function() {
            let scrollTop = window.scrollY;
    
            if (scrollTop > 0) {
              header.classList.add("sticky");
              if (scrollTop >= lastScrollTop) {
                header.classList.add("hidden"); // Scroll down - hide
              } else {
                header.classList.remove("hidden"); // Scroll up - show
              }
            } else {
              header.classList.remove("sticky", "hidden"); // Reset at top
            }
            
            lastScrollTop = scrollTop;
          });
        });
    </script>
</head>

<body>
    <!--HEADER SECTION-->
    <section>
        <header class="header">
            <div class="container">
                <nav class="navbar">
                    <div class="logo">
                    <a href="#">
                        <img src="./assets/logos/logo.png" alt="companylogo" height="70" width="100">
                    </a>
                    </div>
                    <div class="nav-items">
                        <a href="home.php">Home</a>
                        <a href="product_page.php" class="active">Products</a>
                        <a href="orders.php">Orders</a>
                        <a href="contactus.html">Contact Us</a>
                    </div>
                    <div class="icon-items">
                        <a href="#"><i class="bi bi-search"></i></a>
                        <div class="profile-dropdown">
                            <a href="#"><i class="bi bi-person-circle"></i></a>
                            <div class="dropdown-content">
                                <a href="profile.html">Profile</a>
                                <a href="settings.html">Settings</a>
                                <?php if ($is_logged_in): ?>
                                    <a href="logout.php">Logout</a>
                                <?php else: ?>
                                    <a href="login.php">Login</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="cart.php"><i class="bi bi-bag" ></i></a>

                    </div>
                </nav>

            </div>
        </header>
    </section>

    <section>
        <div class="container" style="padding-bottom:50px; padding-top:50px;">
            <div class="row">
                <div class="col-7" style="padding-right: 80px; padding-bottom:30px; padding-top:30px; display: flex; justify-content: center;">
                    <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="product-detail-image">
                </div>
                <div class="col-5">
                    <h1><?php echo $product['product_name']; ?></h1> 
                    <h4 style="padding-bottom:5px;">$<?php echo number_format($product['product_price'], 2); ?></h4>
                    <?php displayrating($product['product_rating']); ?>
                    <br>
                    <hr>
                    <p style="padding-top: 30px; padding-bottom: 30px;"><?php echo $product['product_details']; ?></p>
                    

                    <b>
                        <span id="sold-no">17</span>
                        sold in last
                        <span id="hour-no">24</span>
                        Hour
                    </b>

                    <form action="" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $url_product_id; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['product_price']; ?>">

                        <div class="row" style="padding-top: 30px;">
                            <div class="col-2" style="display: flex; flex-wrap: wrap;">
                                <input type="number" name="quantity" value="1" min="1" class="quantityfield" style="width: 100%; height: 45px; min-width:60px;">
                            </div>
                            <div class="col-10" style="display: flex; flex-wrap: wrap;">
                                <button type="submit" name="add_to_cart" class="primary-btn addtocart-btn" value="Add to Cart">
                                    Add to Cart
                                </div>
                            </div>
                        </div>
                    </form>
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
                            The Atelier, a place for creative dialogues — <br>
                            Where heritage meets modernity
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
                                <i class="lni lni-map-marker"></i> 107 Corporation Walk, 618482
                            </li>
                            <li><i class="lni lni-phone-set"></i> +65 9866 1950</li>
                            <li><i class="lni lni-envelope"></i> Atelier@Noire.com</li>
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
            <div class="footer-copyright">
            <div class="container">
                <div class="row" style="justify-content: space-between; align-items: center;">
                    <div class="col-8">
                        <p class="text text-white">Copyright © 2024 <i>Keegan.</i> All Rights Reserved</p>
                    </div>
                    <div class="col-4" style="text-align: right;">
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
</body>
</html>

