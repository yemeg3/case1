<?php include("session_start.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Создать пост</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1 class="page-title">Создать пост</h1>

    <form action="" method="POST" class="post-form">
        <label for="title" class="form-label">Заголовок:</label>
        <input type="text" name="title" class="form-input" required><br>
        <label for="content" class="form-label">Содержание:</label>
        <textarea name="content" class="form-textarea" required></textarea><br>
        <label for="tags" class="form-label">Теги (через запятую):</label>
        <input type="text" name="tags" class="form-input"><br>
        <label for="spoiler" class="form-label">Спойлер:</label>
        <input type="checkbox" name="spoiler" class="form-checkbox"><br>
        <button type="submit" class="form-button">Создать пост</button>
    </form>

    <a href="index.php" class="link">На главную</a>
</body>
</html>

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
    $title = $_POST["title"];
    $content = $_POST["content"];
    $tags = $_POST["tags"];
    $spoiler = isset($_POST["spoiler"]) ? 1 : 0; // Проверяем, был ли выбран спойлер
    $user_id = $_SESSION["user_id"];

    $query = "INSERT INTO posts (title, content, tags, spoiler, user_id)
              VALUES ('$title', '$content', '$tags', '$spoiler', '$user_id')";

    if ($conn->query($query) === TRUE) {
        echo "Пост успешно создан!";
    } else {
        echo "Ошибка при создании поста: " . $conn->error;
    }
}

$conn->close();
?>
