<?php

session_start(); // Start a session to store user information if needed
include('./connect.php');

$username = "";
$password = "";

$username_error = "";
$password_error = "";
$login_success = false; // Variable to check if login is successful

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password input
    if (empty($username)) {
        $username_error = "*Please enter your email.";
    }

    if (empty($password)) {
        $password_error = "*Please enter your password.";
    }

    // Check if there are no errors before processing
    if (empty($username_error) && empty($password_error)) {
        // Connect to the database
        $dbConnection = getDatabaseConnection();

        // Prepare the SQL statement to prevent SQL injection
        $statement = $dbConnection->prepare("SELECT password FROM user WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $statement->store_result();

        if ($statement->num_rows > 0) {
            // User exists, now check the password
            $statement->bind_result($hashed_password);
            $statement->fetch();

            // Verify the password (if hashed, use password_verify)
            if ($password === $hashed_password) { // Change this if you're hashing passwords
                $login_success = true;
                // Start a session or perform login actions here
            } else {
                $password_error = "*Incorrect password.";
            }
        } else {
            $username_error = "*Username not found.";
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
                <form method="post" action="login">
                    <h2 class="login-header">Login</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" id="username" name="username">
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="password" name="password">
                        <label for="">Password</label>
                    </div>
                    <div class="forget">
                        <label for=""><input type="checkbox">Remember Me</label>
                        <a href="#">Forget Password</a>
                    </div>
                    <div class="row" style="justify-content: center; padding-top: 15px;">
                        <input type="submit" value="Login" class="primary-btn login-btn">
                    </div>
                    <div class="register">
                        <p>Don't have a account <a href="register.html">Register</a></p>
                    </div>
                </form>

                <?php if ($login_success): ?>
                    <div class="notification" id="notification">
                        Login successful! Redirecting...
                    </div>
                    <script>
                        setTimeout(() => {
                            window.location.href = 'dashboard.php'; // Redirect to the desired page after successful login
                        }, 3000);
                    </script>
                <?php endif; ?>

                
            </div>
        </div>
    </section>
</body>
</html>
        <!--div class="container">
            <div class="row" style="justify-content: center;">
                <div class="col-4" style=" display: flex; justify-content: center;">
                    <div class="form-box" style="justify-content: center; padding: 20px;">
                    <form method="post" action="login">
                        <h2 class="login-header">Login</h2>
                        <div class="inputbox">
                            <ion-icon name="mail-outline"></ion-icon>
                            <input type="email" id="username" name="username" required >
                            <label for="">Email</label>
                        </div>
                        <div class="inputbox">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            <input type="password" id="password" name="password" required>
                            <label for="">Password</label>
                        </div>
                        <div class="forget">
                            <label for=""><input type="checkbox">Remember Me</label>
                            <a href="#">Forget Password</a>
                        </div>
                        <div class="row" style="justify-content: center; padding-top: 15px;">
                            <input type="submit" value="Login" class="primary-btn login-btn">
                        </div>
                        <div class="register">
                            <p>Don't have a account <a href="register.html">Register</a></p>
                        </div>
                    </form>
                    </form>
                </div>
                </div>
            </div>
        </div-->

