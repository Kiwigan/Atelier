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

// Check if search term is set
if (isset($_GET['search_term'])) {
    $search_term = $conn->real_escape_string($_GET['search_term']);
    $sql = "SELECT * FROM perfumes WHERE product_name LIKE '%$search_term%'";
    $result = $conn->query($sql);
} else {
    $result = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($product = $result->fetch_assoc()): ?>
                
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</body>
</html>
