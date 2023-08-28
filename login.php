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

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
        } else {
            echo "<p class='error'>Неверный пароль.</p>";
        }
    } else {
        echo "<p class='error'>Пользователь не найден.</p>";
    }
}

$conn->close();
?>
