<?php
include("session_start.php");
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];


    $query_check_author = "SELECT user_id, title, content FROM posts WHERE id = '$post_id'";
    $result_check_author = $conn->query($query_check_author);

    if ($result_check_author->num_rows === 1) {
        $row_check_author = $result_check_author->fetch_assoc();
        if ($row_check_author["user_id"] == $_SESSION["user_id"]) {
          
            $title = $row_check_author["title"];
            $content = $row_check_author["content"];
        } else {
            echo "<p class='error-message'>У вас нет прав для редактирования этого поста.</p>";
            exit();
        }
    } else {
        echo "<p class='error-message'>Пост не найден.</p>";
        exit();
    }
} else {

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"]) && isset($_POST["content"])) {
    $post_id = $_GET["post_id"];
    $new_title = $_POST["title"];
    $new_content = $_POST["content"];

    $query_update_post = "UPDATE posts SET title = '$new_title', content = '$new_content' WHERE id = '$post_id'";

    if ($conn->query($query_update_post) === TRUE) {
        echo "<p>Пост успешно обновлен.</p>";
        echo '<a href="index.php" class="link">На главную</a>';
        exit();
    } else {
        echo "<p class='error-message'>Ошибка при обновлении поста: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Редактировать пост</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1 class="page-title">Редактировать пост</h1>

    <form action="" method="POST" class="post-form">
        <input type="text" name="title" value="<?php echo $title; ?>" class="form-input" required>
        <textarea name="content" class="form-textarea" required><?php echo $content; ?></textarea>
        <button type="submit" class="form-button">Сохранить изменения</button>
    </form>

    <a href="index.php" class="link">На главную</a>
</body>
</html>
