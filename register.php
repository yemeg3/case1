<?php include("session_start.php"); ?>

<?php
$servername = "localhost";
$username = "g919483h_root";
$password = "vostcorp12Qaq";
$dbname = "g919483h_root";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

    if ($conn->query($query) === TRUE) {
        echo "Регистрация успешна!";

    } else {
        echo "Ошибка при регистрации: " . $conn->error;
    }
}

$conn->close();
?>
<br><a href="index.php">На главную</a></br>
