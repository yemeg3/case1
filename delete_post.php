<?php
include("session_start.php");
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST["post_id"];

    $query = "DELETE FROM posts WHERE id = '$post_id'";

    if ($conn->query($query) === TRUE) {
        echo "Пост успешно удален.";
        echo '<a href="index.php" class="link">На главную</a>';
    } else {
        echo "Ошибка при удалении поста: " . $conn->error;
    }
}

$conn->close();
?>
