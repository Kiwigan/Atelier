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
</head>
<body>
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
                
                <div class="product-container">
                    <h1>Perfume Collection</h1>
                    <div class="products-grid">

                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "atelier";
                        
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        
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
                                echo "<a href='product_details.php?product_id=" . $row['product_id'] . "' style='text-decoration: none; color: inherit;'>";

                                echo "<div class='product-card'>";
                                echo "<img src='" . $row['product_image'] . "' alt='" . $row['product_name'] . "' class='product-image'>";
                                echo "<h2 class='product-name'>" . $row['product_name'] . "</h2>";
                                echo "<p class='product-price'>$" . number_format($row['product_price'], 2) . "</p>";
                                echo "<p class='product-details'>" . $row['product_details'] . "</p>";
                                echo "<p class='product-rating'>Rating: " . number_format($row['product_rating'], 1) . " / 5</p>";
                                echo "<button class='add-to-cart-btn'>Add to Cart</button>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No products found.</p>";
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
