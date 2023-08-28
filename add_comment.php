<?php
include("session_start.php");
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_id"]) && isset($_POST["comment"])) {
    $post_id = $_POST["post_id"];
    $comment = $_POST["comment"];
    $user_id = $_SESSION["user_id"];

    $query_insert_comment = "INSERT INTO comments (post_id, user_id, comment)
                             VALUES ('$post_id', '$user_id', '$comment')";

    if ($conn->query($query_insert_comment) === TRUE) {
        header("Location: posts.php");
        exit();
    } else {
        echo "Ошибка при добавлении комментария: " . $conn->error;
    }
}

$conn->close();
?>
