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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
    $subscriber_id = $_SESSION["user_id"];
    $user_id_to_subscribe = $_POST["user_id"]; 

    $query = "INSERT INTO subscriptions (user_id, subscriber_id) VALUES ('$user_id_to_subscribe', '$subscriber_id')";

    if ($conn->query($query) === TRUE) {
        echo "Вы успешно подписались на пользователя!";
        echo '<a href="index.php" class="link">На главную</a>';
    } else {
        echo "Ошибка при подписке: " . $conn->error;
    }
}

$conn->close();
?>
