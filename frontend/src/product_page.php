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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="product_page.css">
    <link rel="icon" href="assets/logos/logo-light.png" type="image/png">
    
    <!--====== BootStrap Icons (NOTE: THIS IS NOT BOOTSTRAP FRAMEWORK, JUST ITS ICONS)======-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--====== Lineicons CSS ======-->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <title>My Home Page</title>

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
                        <a href="product_page.php" class="active">Products</a>
                        <a href="orders.html">Orders</a>
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
        <div class="container" style="padding-top: 100px;">
            <div class="row" style="align-items: flex-start;">
                <div class="col-2">
                    <b>Filters:</b>
                    <div class="filters" style="border-style: groove; padding-left: 15px; padding-right: 15px;">
                        <form method="POST" action="">
                            <ul>
                                <li>
                                    <input type="radio" id="Men" name="gender" value="Men" 
                                        <?php if (isset($_POST['gender']) && $_POST['gender'] == 'Men') echo 'checked'; ?>
                                        onclick="this.form.submit()">
                                    <label for="Men">Men</label>
                                </li>
                                <li>
                                    <input type="radio" id="Women" name="gender" value="Women" 
                                        <?php if (isset($_POST['gender']) && $_POST['gender'] == 'Women') echo 'checked'; ?>
                                        onclick="this.form.submit()">
                                    <label for="Women">Women</label>
                                </li>
                                <li>
                                    <input type="radio" id="Unisex" name="gender" value="Unisex" 
                                        <?php if (isset($_POST['gender']) && $_POST['gender'] == 'Unisex') echo 'checked'; ?>
                                        onclick="this.form.submit()">
                                    <label for="Unisex">Unisex</label>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="col-10">
                    <h1>Perfume Collection</h1>
                    <div class="row" style="justify-content: start;">

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


                        // Check if a gender filter has been set
                        $gender_filter = isset($_POST['gender']) ? $_POST['gender'] : '';
                        $sql = "SELECT product_id, product_name, product_price, product_image, product_details, product_rating, gender FROM perfumes";

                        // Add the gender filter to the SQL query
                        if ($gender_filter) {
                            $sql .= " WHERE gender = '$gender_filter'";
                        }

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                // Wrap each product card in an <a> tag
                                echo "<div class='col-4'>";
                                echo "<a href='product_details.php?product_id=" . $row['product_id'] . "' style='text-decoration: none; color: inherit;'>";

                                echo "<div class='card'>";
                                echo "<img src='" . $row['product_image'] . "' alt='" . $row['product_name'] . "' class='product-image'>";
                                echo "<form method='POST' action=''>";
                                echo "<div class='card-body'>";
                                echo "<h2 class='card-title'>" . $row['product_name'] . "</h2>";
                                displayrating(number_format($row['product_rating'], 1));
                                echo "<p class='card-price'>$" . number_format($row['product_price'], 2) . "</p>";
                                /*echo "<button type='submit' name='add_to_cart' class='add-to-cart-btn'>Add to Cart</button>";*/
                                echo "</div>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No products found.</p>";
                        }

                        // Handle Add to Cart submission
                        if (isset($_POST['add_to_cart'])) {
                            $product_id = $_POST['product_id'];
                            $quantity = $_POST['quantity'];
                            $product_price = $_POST['product_price'];
                            $total_price = $quantity * $product_price;

                            // Initialize the cart in the session if it doesn't exist
                            if (!isset($_SESSION['cart'])) {
                                $_SESSION['cart'] = array();
                            }

                            // Check if the product already exists in the cart
                            if (isset($_SESSION['cart'][$product_id])) {
                                // Update the existing item
                                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                                $_SESSION['cart'][$product_id]['total_price'] += $total_price;
                            } else {
                                // Add a new item to the cart
                                $_SESSION['cart'][$product_id] = array(
                                    'product_id' => $product_id,
                                    'quantity' => $quantity,
                                    'total_price' => $total_price,
                                    'product_price' => $product_price, // Store the individual price for future reference
                                    'product_name' => $_POST['product_name'], // Assuming you have this input
                                    'product_image' => $_POST['product_image'], // Assuming you have this input
                                );
                            }

                            echo "<script>
                                    alert('Item successfully added to cart!');
                                    window.location.href = 'product_page.php?product_id=" . $product_id . "';
                                </script>";
                        }

                        $conn->close();
                        ?>
                    </div>
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
</body>

</html>
