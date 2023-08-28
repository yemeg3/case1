<?php
$servername = "localhost";
$username = "g919483h_root";
$password = "vostcorp12Qaq";
$dbname = "g919483h_root";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
