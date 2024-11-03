<?php


$username = "";
$password = "";
$confirm_password = "";

$username_error = "";
$password_error = "";
$confirm_password_error = "";

$error = false;
$registration_success = false; // Variable to check if registration is successful

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate email format
    if (empty($username)) {
        $username_error = "*Please enter your email.";
    } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $username_error = "*Please enter a valid email address.<br>";
    }

    include('./connect.php');
    $dbConnection = getDatabaseConnection();

    $statement = $dbConnection -> prepare("SELECT user_id FROM user WHERE username = ?");

    $statement->bind_param("s", $username);

    $statement->execute();

    $statement->store_result();
    if($statement->num_rows>0) {
        $username_error = "Email is already used";
        $error = true;
    }

    $statement->close();


    // Validate password length
    if (strlen($password) < 6) {
        $password_error = "*Password must be at least 6 characters.<br>";
    }

    // Confirm password match
    if ($confirm_password != $password) {
        $confirm_password_error = "*Passwords do not match.<br>";
    }

    // Check if there are no errors before processing
    if (empty($username_error) && empty($password_error) && empty($confirm_password_error)) {
        $statement = $dbConnection->prepare(
            "INSERT INTO user (username, password)" . "VALUES (?, ?)"
        );

        $statement->bind_param('ss', $username, $password);

        if ($statement->execute()){
            $registration_success = true;
        }


        $insert_id = $statement->insert_id;
        $statement->close();
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

    <title>Register</title>

    <style>
        .notification {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            top: -100px; /* Place it at the bottom */
            right: 0px; /* Place it at the right */
            background-color: #4CAF50; /* Green */
            color: white; /* White text */
            padding: 15px; /* Some padding */
            border-radius: 5px; /* Rounded corners */
            z-index: 1000; /* Sit on top */
            transition: opacity 0.5s; /* Fade effect */
        }
    </style>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const emailInput = document.getElementById('username');
            const email = emailInput.value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email pattern
    
            if (!emailPattern.test(email)) {
                event.preventDefault(); // Prevent form submission
                alert('Please enter a valid email address.');
                emailInput.focus();
            }
        });
    </script>

</head>
<body>
    <section class="login">
        <div class="form-box-register">
            <div class="form-value" style="justify-content: center;">
                <form method="post"><!--action="register"-->
                    <h2 class="login-header">Register</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" id="username" name="username" placeholder=" " value="<?= $username ?>">
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="password" name="password" placeholder=" ">
                        <label for="">Password</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder=" " >
                        <label for="">Confirm Password</label>
                    </div>

                    <span class="text-danger"><?= $username_error ?></span>
                    <span class="text-danger"><?= $password_error ?></span>
                    <span class="text-danger"><?= $confirm_password_error ?></span>


                    <div class="row" style="justify-content: center; padding-top: 15px;">
                        <!--input type="submit" value="Register" class="primary-btn login-btn"-->
                        <button type="submit" class="primary-btn login-btn">Register</button>
                    </div>
                    <div class="register">
                        <p>Already have a account? <a href="login.php">Login</a></p>
                    </div>
                </form>

                <?php if ($registration_success): ?>
                    <div class="notification" id="notification">
                        Registration successful! You will be redirected to the login page shortly.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script>
        // Show the notification if registration is successful
        <?php if ($registration_success): ?>
            const notification = document.getElementById('notification');
            notification.style.display = 'block'; // Show notification
            setTimeout(() => {
                notification.style.opacity = 0; // Fade out effect
                setTimeout(() => {
                    window.location.href = 'login.php'; // Redirect to login page after fade out
                }, 500); // Wait for fade out to finish
            }, 3000); // Show for 3 seconds
        <?php endif; ?>
    </script>
</body>
</html>
