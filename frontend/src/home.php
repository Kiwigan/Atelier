<?php
session_start(); // Start the session
// Check if the user is logged in by checking if a session variable is set
$is_logged_in = isset($_SESSION['user_id']);
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
                        <a href="home.php" class="active">Home</a>
                        <a href="product_page.php">Products</a>
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
        <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <img src="assets/images/hero2.png" style="padding-top: 80px;">
                </div>
                <div class="col-6">
                    <h1 class="hero-tag">Welcome, Keegan</h1>
                    <p style="padding-top: 10px;">
                        Atelier Noire affixes to each of its creations a luminous Cologne signature, 
                        crafted from the noblest raw materials. By artfully combining the clarity and elegance 
                        of Cologne with the concentration and creativity of perfume, our collections reveal themselves 
                        as evoking artpieces that unveil emotions.</p>
                    <a href="product_page.php" class="btn-case">
                        <button class="primary-btn" style="margin-top: 30px;">Explore Now &#8594;</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </section>

    <section class="about-us">
        <div class="container">
            <h2 class="title_heading">About Us</h2>
            <div class=" about-row row">
                <!-- Left Column: Image stacked on top of a diagonally aligned rectangle -->
                <div class="col-6" style="display: flex; justify-content: center; align-items: center;">
                    <div class="image-container">
                        <div class="rectangle"></div>
                        <img src="./assets/images/men.jpg" alt="Image" class="image-on-rectangle">
                    </div>
                </div>
                
                <!-- Right Column: Text -->
                <div class="col-6" style="justify-content: top;">
                    <h2 class="tagline"> 
                        The Atelier, a place for creative dialogues — <br>
                        Where heritage meets modernity
                    </h2>
                    <p class="about-desc">
                        Atelier Noire, surrounded by perfumers and artists, celebrates and passes on the historical craftsmanship behind our exceptional fragrances. 
                        In the atelier, the gestures of our experts driven by a creative emulation, transform nature into art and reinvent the traditional Cologne. 
                        Our perfumed creations, sublimations of vibrant nature, revealing emotions, bear the imprint of authentic, innovative, and elegant French 
                        perfumery.
                    </p>
                </div>
            </div>
        </div>
    </section>



    <!--====== STATS SECTION PART START ======-->
    <section class="statsbar">
        <div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
            <div class="row" style="justify-content: space-around;">
                <div class="col-3">
                    <div class="row" style="justify-content: center;">
                        <div class="col-3">
                            <div class="icon">
                                <img src="assets/icons/Future.png" alt="futurepng">
                            </div>
                        </div>
                        <div class="col-9">
                            <h2>2004</h2>
                            <p class="lead">
                                Brand Beginnings
                            </p>
                        </div>
                    </div>
                    
                </div>
                <div class="col-3">
                    <div class="row" style="justify-content: center;">
                        <div class="col-3">
                            <div class="icon">
                                <img src="assets/icons/Group 44.png" alt="docpng">
                            </div>
                        </div>
                        <div class="col-9">
                            <h2>78</h2>
                            <p class="lead">
                                Patented Formulas
                            </p>
                        </div>
                    </div>  
                </div>
                <div class="col-3">
                    <div class="row" style="justify-content: center;">
                        <div class="col-3">
                            <div class="icon">
                                <img src="assets/icons/Handshake.png" alt="handpng">
                            </div>
                        </div>
                        <div class="col-9">
                            <h2>20+</h2>
                            <p>
                                Collaborations
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row" style="justify-content: center;">
                        <div class="col-3">
                            <div class="icon icon-primary mb-4">
                                <img src="assets/icons/Happy.png" alt="happypng">
                            </div>
                        </div>
                        <div class="col-9">
                            <h2>30 Days</h2>
                            <p class="lead">
                                Return policy
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <!--====== BEST SELLERS START ======-->
    <section>
        <div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
            <div class="row" style="justify-content: center;">
                <div class="col-12" style="text-align: center;"> 
                    <h2 class="title_heading">Our Best Sellers</h2>
                </div>
                <div class="col-12" style="display:flex; align-items: center; justify-content: center; padding-top: 20px; gap: 5px;">
                    <a href="productpage.html">
                        <button class="secondary-btn">New Arrivals</button>
                    </a>
                    <a href="productpage.html">
                        <button class="secondary-btn">Best Sellers</button>
                    </a>
                    <a href="productpage.html">
                        <button class="secondary-btn">Top Rated</button>
                    </a>
                </div>
            </div>
            
            <div class="row" style="padding-top: 50px;">
                <!--Card Start-->
                <div class="col-3">
                    <div class="card">
                        <img src="assets/images/product1.jpg" alt="image1">
                        <div class="card-body">
                            <h3 class="card-title">Floral Essence</h3>
                            <div class="ratings">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>   
                            </div>
                            <p class="card-price">$49.99</p>
                        </div>
                    </div>
                </div>
                <!--Card End-->
                <!--Card Start-->
                <div class="col-3">
                    <div class="card">
                        <img src="assets/images/product2.jpg" alt="image2">
                        <div class="card-body">
                            <h3 class="card-title">Ocean Breeze</h3>
                            <div class="ratings">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>   
                            </div>
                            <p class="card-price">$59.50</p>
                        </div>
                    </div>
                </div>
                <!--Card End-->
                <!--Card Start-->
                <div class="col-3">
                    <div class="card">
                        <img src="assets/images/product3.jpg" alt="image3">
                        <div class="card-body">
                            <h3 class="card-title">Amber Nights</h3>
                            <div class="ratings">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>   
                            </div>
                            <p class="card-price">$75.00</p>
                        </div>
                    </div>
                </div>
                <!--Card End-->
                <!--Card Start-->
                <div class="col-3">
                    <div class="card">
                        <img src="assets/images/product4.jpg" alt="image4">
                        <div class="card-body">
                            <h3 class="card-title">Citrus Burst</h3>
                            <div class="ratings">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>   
                            </div>
                            <p class="card-price">$39.99</p>
                        </div>
                    </div>
                </div>
                <!--Card End-->
                <!--Card Start-->
                <div class="col-3">
                    <div class="card">
                        <img src="assets/images/product5.jpg" alt="image1">
                        <div class="card-body">
                            <h3 class="card-title">Mystic Oud</h3>
                            <div class="ratings">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>   
                            </div>
                            <p class="card-price">$89.99</p>
                        </div>
                    </div>
                </div>
                <!--Card End-->            
            </div>

        </div>
    </section>



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
