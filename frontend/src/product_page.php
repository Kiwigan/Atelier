<?php
session_start(); // Start the session
// Check if the user is logged in by checking if a session variable is set
$is_logged_in = isset($_SESSION['user_id']);


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
    <link rel="icon" href="assets/logos/logo-light.png" type="image/png">
    
    <!--====== BootStrap Icons (NOTE: THIS IS NOT BOOTSTRAP FRAMEWORK, JUST ITS ICONS)======-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--====== Lineicons CSS ======-->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <title>Products</title>

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

        document.addEventListener("DOMContentLoaded", function() {
            // Restore the scroll position if it exists
            if (sessionStorage.getItem("scrollPosition")) {
                window.scrollTo(0, sessionStorage.getItem("scrollPosition"));
            }

            // Save scroll position before the page unloads
            window.addEventListener("beforeunload", function() {
                sessionStorage.setItem("scrollPosition", window.scrollY);
            });
        });
        window.addEventListener("load", function() {
            // Remove the scroll position after loading to avoid unexpected behavior
            sessionStorage.removeItem("scrollPosition");
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
        <div class="container" style="padding-top: 70px; padding-bottom: 70px;">
            <div class="row" style="align-items: flex-start; justify-content: space-between;">
                <div class="col-2" style="padding-top: 70px;">
                <form method="GET" action="">
                        <b>Gender</b>
                        <div class="filters" style="border-style: groove; padding-left: 15px; padding-right: 15px;">
                            <ul>
                                <li>
                                    <input type="radio" id="Men" name="gender" value="Men" 
                                        <?php if (isset($_GET['gender']) && $_GET['gender'] == 'Men') echo 'checked'; ?>
                                        onclick="this.form.submit()">
                                    <label for="Men">Men</label>
                                </li>
                                <li>
                                    <input type="radio" id="Women" name="gender" value="Women" 
                                        <?php if (isset($_GET['gender']) && $_GET['gender'] == 'Women') echo 'checked'; ?>
                                        onclick="this.form.submit()">
                                    <label for="Women">Women</label>
                                </li>
                                <li>
                                    <input type="radio" id="Unisex" name="gender" value="Unisex" 
                                        <?php if (isset($_GET['gender']) && $_GET['gender'] == 'Unisex') echo 'checked'; ?>
                                        onclick="this.form.submit()">
                                    <label for="Unisex">Unisex</label>
                                </li>
                            </ul>
                        </div>

                        <br>

                        <b>Price</b>
                        <div class="filters" style="border-style: groove; padding: 15px;">
                            <select name="sort_by" onchange="this.form.submit()">
                                <option value="">Select</option>
                                <option value="price_asc" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_asc') echo 'selected'; ?>>Price: Low to High</option>
                                <option value="price_desc" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_desc') echo 'selected'; ?>>Price: High to Low</option>
                                <option value="rating_desc" <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'rating_desc') echo 'selected'; ?>>Rating: High to Low</option>
                            </select>
                        </div>
                    </form>
            </div>
                <div class="col-10" style="padding-left: 100px;">

                    <div class="row" style="justify-content; space-between;">
                        <div>
                            <h1>Perfume Collection</h1>
                            <div class="line" style="margin-bottom:50px; width:80px;"></div>
                        </div>

                        <div>
                            <div class="row">
                                <a href="product_page.php"><button class="clear-filter-btn">Clear Filters</button></a>

                                <form action="search_results.php" method="POST">
                                    <input type="text" name="search_term" placeholder="Search products..." class="product-search">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="justify-content: start; margin-left:-15px; margin-right:-15px;">
                        

                        <?php
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

                        // Set the number of products per page
                        $products_per_page = 6;

                        // Get the current page number from the URL, default to 1 if not set
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                        // Calculate the offset for the SQL query
                        $offset = ($page - 1) * $products_per_page;


                        // Check if a gender filter has been set
                        $gender_filter = isset($_GET['gender']) ? $_GET['gender'] : '';
                        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';

                        // Start building the base SQL query
                        $sql = "SELECT product_id, product_name, product_price, product_image, product_details, product_rating, gender FROM perfumes";

                        // Add the gender filter to the SQL query
                        if ($gender_filter) {
                            $sql .= " WHERE gender = '$gender_filter'";
                        }

                        // Apply sorting if set
                        switch ($sort_by) {
                            case 'price_asc':
                                $sql .= " ORDER BY product_price ASC";
                                break;
                            case 'price_desc':
                                $sql .= " ORDER BY product_price DESC";
                                break;
                            case 'rating_desc':
                                $sql .= " ORDER BY product_rating DESC";
                                break;
                            default:
                                $sql .= " ORDER BY product_name ASC"; // Default ordering
                                break;
                        }
                        
                        // Add LIMIT and OFFSET for pagination
                        $sql .= " LIMIT $products_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                // Wrap each product card in an <a> tag
                                
                                echo "<div class='col-4'>";
                                echo "<form method='POST' action=''>";
                                echo "<input type='hidden' name='product_name' value='". $row['product_name'] . "'>";
                                echo "<input type='hidden' name='product_image' value='". $row['product_image'] . "'>";
                                echo "<input type='hidden' name='product_id' value='". $row['product_id'] . "'>";
                                echo "<input type='hidden' name='quantity' value='1'>";
                                echo "<input type='hidden' name='product_price' value='" . $row['product_price'] ."'>";

                                echo "<a href='product_details.php?product_id=" . $row['product_id'] . "' style='text-decoration: none; color: inherit;'>";

                                echo "<div class='card'>";
                                echo "<div class='product-image-container'>";
                                echo "<img src='" . $row['product_image'] . "' alt='" . $row['product_name'] . "' class='product-image'>";
                                echo "<div class='add-to-cart-overlay'>";
                                echo  "<button type='submit' name='add_to_cart' class='add-to-cart-btn' value='Add to Cart'>Add to Cart</button>";
                                echo  "</div></div>";
                                echo "<div class='card-body'>";
                                echo "<h2 class='card-title'>" . $row['product_name'] . "</h2>";
                                displayrating(number_format($row['product_rating'], 1));
                                echo "<p class='card-price'>$" . number_format($row['product_price'], 2) . "</p>";
                                echo "</div>";
                                
                                echo "</div>";
                                echo "</form>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No products found.</p>";
                        }
                        echo "</div>";

                        // Get the total number of products for pagination calculation
                        $total_products_result = $conn->query("SELECT COUNT(*) AS total FROM perfumes" . ($gender_filter ? " WHERE gender = '$gender_filter'" : ""));
                        $total_products_row = $total_products_result->fetch_assoc();
                        $total_products = $total_products_row['total'];

                        // Calculate total pages
                        $total_pages = ceil($total_products / $products_per_page);

                        // Display pagination links
                        if ($total_pages > 1) {
                            echo "<div class='row' style='justify-content:end; padding-top:15px;'><div class='pagination'>";
                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo "<a href='product_page.php?page=$i'><button" . ($i == $page ? " class='active'" : "") . ">$i</button></a> ";
                            }
                            echo "</div></div>";
                        }

                        // Handle Add to Cart submission
                        if (isset($_POST['add_to_cart'])) {
                            $product_id = $_POST['product_id'];
                            $quantity = $_POST['quantity'];
                            $product_price = $_POST['product_price'];
                            $total_price = $quantity * $product_price;

                            // Initialize the cart in the session if it doesn't exist
                            if (!isset($_SESSION['cart'])) {
                                $_SESSION['cart'] = [];
                            }

                            // Check if the product already exists in the cart
                            if (isset($_SESSION['cart'][$product_id])) {
                                // Update the existing item
                                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                                $_SESSION['cart'][$product_id]['total_price'] += $total_price;
                            } else {
                                // Add a new item to the cart
                                $_SESSION['cart'][$product_id] = [
                                    'product_id' => $product_id,
                                    'quantity' => $quantity,
                                    'total_price' => $total_price,
                                    'product_price' => $product_price, // Store the individual price for future reference
                                    'product_name' => $_POST['product_name'], // Assuming you have this input
                                    'product_image' => $_POST['product_image'], // Assuming you have this input
                                ];
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
