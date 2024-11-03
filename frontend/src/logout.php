<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Save the cart session data
    if (isset($_SESSION['cart'])) {
        // Convert cart array to JSON to store it as a cookie
        $cart_json = json_encode($_SESSION['cart']);
        // Set cookie to expire in 30 days
        setcookie("user_cart_" . $_SESSION['user_id'], $cart_json, time() + (30 * 86400), "/"); // 30 days
    }

    // Clear all session variables except for the saved cart
    session_unset(); // Remove all session variables
    session_destroy();

    // Destroy the session (optional, depending on your needs)
    session_destroy(); // This will log out the user completely, but we'll keep saved_cart

    // Redirect to the login page or another page
    header("Location: login.php"); // Change to your login page
    exit(); // Terminate the script after redirection
} else {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php"); // Change to your login page
    exit();
}
?>
