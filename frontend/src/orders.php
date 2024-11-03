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

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Prepare SQL statement
$sql = "SELECT 
            o.order_id,
            o.order_date,
            o.total_price AS order_total_price,
            o.status,
            oi.quantity,
            oi.total_price AS item_total_price,
            p.product_name,
            p.product_price,
            p.product_image
        FROM 
            orders o
        JOIN 
            order_items oi ON o.order_id = oi.order_id
        JOIN 
            perfumes p ON oi.product_id = p.product_id
        WHERE 
            o.user_id = ?
        ORDER BY 
            o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Create an array to hold orders grouped by order_id
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[$row['order_id']][] = $row; // Grouping items by order_id
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
    <title>Orders</title>

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
                        <a href="home.html">Home</a>
                        <a href="product_page.php">Products</a>
                        <a href="orders.php" class="active">Orders</a>
                        <a href="#">Contact Us</a>
                    </div>
                    <div class="icon-items">
                        <a href="#"><i class="bi bi-search"></i></a>
                        <div class="profile-dropdown">
                            <a href="#"><i class="bi bi-person-circle"></i></a>
                            <div class="dropdown-content">
                                <a href="profile.html">Profile</a>
                                <a href="settings.html">Settings</a>
                                <a href="login.php">Login</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </div>
                        <a href="cart.php"><i class="bi bi-bag" ></i></a>

                    </div>
                </nav>

            </div>
        </header>
    </section>

    <section>
        <div class="container" style="padding-top: 50px; padding-bottom: 50px;">
            <h2 class="title_heading-2" style="padding:bottom: 20px;">Your Orders &nbsp;&boxh;&boxh;&boxh;&boxh;&boxh;&boxh;</h2>
            <?php if (empty($orders)): ?>
                <p>You have not made any orders yet.</p>
            <?php else: ?>
                <?php foreach ($orders as $order_id => $items): ?>
                    <h3 style="padding-top: 35px;">Order ID: <?php echo htmlspecialchars($order_id); ?></h3>
                    <table style="width: 100%; margin-top: 5px; margin-bottom: 30px;">
                        <tr>
                            <th style="width: 10%;">Product</th>
                            <th style="width: 25%;"></th>
                            <th style="width: 15%;">Total</th>
                            <th style="width: 20%;">Status</th>
                            <th style="width: 15%;">Order Date</th>
                            <th style="width: 15%;"></th>
                        </tr>
                        <!--Cart Item-->

                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="Product Image">
                                </td>
                                <td>
                                    <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                                    <div class="row">
                                    <h4><span class="price">$<?php echo number_format($item['product_price'], 2); ?></span>&nbsp;&nbsp;Quantity: <span class="quantity"><?php echo htmlspecialchars($item['quantity']); ?></span></h4>
                                    </div>
                                </td>
                                <td>
                                    <h4><span class="total-price">$<?php echo number_format($item['item_total_price'], 2); ?></span></h4>
                                </td>
                                <td>
                                    <div class="row" style="justify-content: start;">
                                        <i class="bi bi-dot"></i>
                                        <span><?php echo htmlspecialchars($item['status']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <p><span class="order-time"><?php echo date("d-M-Y", strtotime($item['order_date'])); ?></span></p>
                                </td>
                                
                                <td style="text-align: end;">
                                    <button class="btn primary-btn">Track Order</button>
                                </td>
                            </tr>
                            <!--Cart Item End-->
                        <?php endforeach; ?>                         
                    </table>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</body>

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
</html>

<?php
// Close connection
$stmt->close();
$conn->close();
?>
