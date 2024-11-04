<?php

session_start(); // Start a session to store user information if needed
include('./connect.php');

$username = "";
$password = "";

$username_error = "";
$password_error = "";
$login_success = false; // Variable to check if login is successful
$notification = ""; // Variable for notification message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password input
    if (empty($username)) {
        $username_error = "*Please enter your email.<br>";
    }

    if (empty($password)) {
        $password_error = "*Please enter your password.<br>";
    }

    // Check if there are no errors before processing
    if (empty($username_error) && empty($password_error)) {
        // Connect to the database
        $dbConnection = getDatabaseConnection();

        // Prepare the SQL statement to prevent SQL injection
        $statement = $dbConnection->prepare("SELECT user_id, password FROM user WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            // User exists, now check the password
            $statement->bind_result($user_id, $hashed_password);
            $statement->fetch();

            // Verify the password (if hashed, use password_verify)
            if ($password === $hashed_password) { // Change this if you're hashing passwords
                $login_success = true;
                // Store user information in session
                $_SESSION['user_id'] = $user_id; // Store user ID in session

                // Check for the cookie corresponding to this user
                if (isset($_COOKIE["user_cart_" . $user_id])) {
                    // Load the cart from the cookie
                    $_SESSION['cart'] = json_decode($_COOKIE["user_cart_" . $user_id], true);
                    // Optionally unset the cookie after loading it
                    setcookie("user_cart_" . $user_id, "", time() - 3600, "/"); // Delete the cookie
                } else {
                    $_SESSION['cart'] = isset($_SESSION['cart']) ? $_SESSION['cart'] : []; // Initialize cart if not already set
                }


            } else {
                $password_error = "*Incorrect password.<br>";
            }
        } else {
            $username_error = "*Username not found.<br>";
        }

        $statement->close();
        $dbConnection->close();
    }
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

    <title>Login</title>

</head>
<body>
    <section class="login">
         <div class="form-box">
            <div class="form-value">
                <form method="post">
                    <h2 class="login-header">Login</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" id="username" name="username" placeholder=" ">
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="password" name="password" placeholder=" ">
                        <label for="">Password</label>
                    </div>
                    <div class="forget">
                        <label for=""><input type="checkbox">Remember Me</label>
                        <a href="#">Forget Password</a>
                    </div>

                    <span class="text-danger"><?= $username_error ?></span>
                    <span class="text-danger"><?= $password_error ?></span>

                    <div class="row" style="justify-content: center; padding-top: 15px;">
                        <button type="submit" class="primary-btn login-btn">Login</button>
                    </div>
                    <div class="register">
                        <p>Don't have a account <a href="register.php">Register</a></p>
                    </div>
                </form>


                <?php if ($login_success): ?>
                    <div class="notification" id="notification">
                        Login successful! You will be redirected to the main page shortly.
                    </div>
                    <script>
                        setTimeout(() => {
                            window.location.href = 'home.php'; // Redirect to the desired page after successful login
                        }, 3000);
                    </script>

                <?php endif; ?>


            </div>
        </div>
    </section>

    <script>
        // Show the notification if registration is successful
        <?php if ($login_success): ?>
            const notification = document.getElementById('notification');
            notification.style.display = 'block'; // Show notification
            setTimeout(() => {
                notification.style.opacity = 0; // Fade out effect
                setTimeout(() => {
                    window.location.href = 'home.php'; // Redirect to login page after fade out
                }, 500); // Wait for fade out to finish
            }, 1500); // Show for 3 seconds
        <?php endif; ?>
    </script>
</body>
</html>
