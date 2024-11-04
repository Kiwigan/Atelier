<?php
function getDatabaseConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "atelier";
    $port = "3306"; //rmb to change port

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if(!$conn){
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
};
?>