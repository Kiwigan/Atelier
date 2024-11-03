<?php
session_start(); // Start the session

// Initiate Subtotal
$subtotal = 0;
$shipping = 10.00; // Flat rate shipping, or you could calculate based on cart content

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])):
    foreach ($_SESSION['cart'] as $cart_id => $item):
        $subtotal += $item['total_price'];
    endforeach;
endif; 
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
</head>
<body>
    <section>
        <div class="container" style="padding-top: 50px;">
            <div class="row" style="justify-content: center">
                <div class="col-5">
                    <h2 class="title_heading-2">Checkout &nbsp;&boxh;&boxh;&boxh;&boxh;&boxh;&boxh;</h2>
                    <h3 style="padding-bottom: 10px;">Delivery Information</h3>

                    <form action="checkout.php" method="POST">
                        <div class="row delivery-input">
                            <div class="col-6 input-wrapper">
                                <div class="input-items default">
                                    <input type="text" name="first_name" placeholder="First Name" required/>
                                </div>
                            </div>
                            <div class="col-6 input-wrapper">
                                <div class="input-items default">
                                    <input type="text" name="last_name" placeholder="Last Name" required/>
                                </div>
                            </div>
                            <div class="col-12 input-wrapper">
                                <div class="input-items default">
                                    <input type="text" name="email" placeholder="Email" required/>
                                </div>
                            </div>
                            <div class="col-12 input-wrapper">
                                <div class="input-items default">
                                    <input type="text" name="address" placeholder="Address" required/>
                                </div>
                            </div>
                            <div class="col-4 input-wrapper">
                                <div class="input-items default">
                                    <input type="text" name="country" placeholder="Country" required/>
                                </div>
                            </div>
                            <div class="col-4 input-wrapper">
                                <div class="input-items default">
                                    <input type="text" name="city" placeholder="City" required/>
                                </div>
                            </div>
                            <div class="col-4 input-wrapper">
                                <div class="input-items default">
                                    <input type="text" name="postal_code" placeholder="Postal Code" required/>
                                </div>
                            </div>
                        </div>
                    
                        <h3 style="padding-bottom: 10px;">Payment Method</h3>
                        <div class=" row payment-input" style="justify-content: start; margin-left:-5px; margin-right: -5px;">
                            <div class="col-4 input-wrapper">
                                <button class="paypal-btn">
                                    <img src="./assets/logos/paypal1.png" alt="Paypal">
                                </button>
                            </div>
                            <div class="col-4 input-wrapper">
                                <button class="credit-btn">
                                    <span>Credit Card</span>
                                </button>
                            </div>

                            <div class="col-12" style="margin-left:-10px; margin-right: -10px;">
                                <button class="primary-btn addtocart-btn" name="place_order" value="Place Order" style="margin-top: 15px;">Place Order</button>
                            </div>
                        </div>
                    </form>
                    

                
                    


                </div>
                <div class="col-4" style="padding-left: 100px;">
                    <h2 style="padding-bottom: 15px;">Order Summary</h2>
                    <input type="text" placeholder="Enter coupon code here" style="width: 100%; padding: 5px; margin-bottom: 15px;">
                    <div class="row" style="justify-content: space-between; padding-top: 5px;">
                        <h5>Subtotal</h5>
                        <h5><?php echo number_format($subtotal, 2); ?></h5>
                    </div>
                    <div class="row" style="justify-content: space-between; padding-top: 8px; padding-bottom: 8px;">
                        <h5>Shipping</h5>
                        <h5>$<?php echo number_format($shipping, 2); ?></h5>
                    </div>
                    <hr>
                    <div class="row" style="justify-content: space-between; padding-top: 8px;">
                        <h5>Total</h5>
                        <h5>$<?php echo number_format($subtotal + $shipping, 2); ?></h5>
                    </div>
                    <button type="submit" class="primary-btn addtocart-btn" value="Edit Order" style="margin-top: 15px;" onclick="window.location.href='cart.php'">Edit Order</button>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
