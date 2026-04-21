<?php
$servername = "172.21.144.1";
$username = "store_app";
$password = "password";
$dbname = "store_dev";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
