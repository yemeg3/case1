<?php include("session_start.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Публичные посты</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .spoiler-text {
            color: transparent;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        .spoiler.visible .spoiler-text {
            color: initial;
            text-shadow: none;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const spoilerButtons = document.querySelectorAll('.spoiler-button');

            spoilerButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const spoiler = this.closest('.spoiler');
                    spoiler.classList.add('visible');
                });
            });
        });
    </script>
</head>
<body>
    <h1>Публичные посты</h1>

    <?php
    $servername = "localhost";
    $username = "g919483h_root";
    $password = "vostcorp12Qaq";
    $dbname = "g919483h_root";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['tag'])) {
        $selected_tag = $_GET['tag'];
        $tag_condition = "WHERE tags LIKE '%$selected_tag%'";
    } else {
        $tag_condition = "";
    }

    $query = "SELECT p.*, u.username
              FROM posts p
              INNER JOIN users u ON p.user_id = u.id
              $tag_condition
              ORDER BY p.id DESC";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h3>" . $row["title"] . "</h3>";

            if (isset($row["spoiler"]) && $row["spoiler"] == 1) {
                echo "<div class='spoiler'>";
                echo "<p class='spoiler-text'>" . $row["content"] . "</p>";
                echo "<button class='spoiler-button'>Показать спойлер</button>";
                echo "</div>";
            } else {
                echo "<p>" . $row["content"] . "</p>";
            }

            echo "<p>Теги: " . $row["tags"] . "</p>";
            echo "<p>Автор: " . $row["username"] . "</p>";

            if (isset($_SESSION["user_id"])) {
                echo "<form action='add_comment.php' method='POST'>";
                echo "<input type='hidden' name='post_id' value='" . $row["id"] . "'>";
                echo "<textarea name='comment' required></textarea>";
                echo "<button type='submit' class='button'>Добавить комментарий</button>";
                echo "</form>";
            }

             $query_comments = "SELECT c.*, u.username
                    FROM comments c
                    INNER JOIN users u ON c.user_id = u.id
                    WHERE c.post_id = '" . $row["id"] . "'";
 $result_comments = $conn->query($query_comments);

 if ($result_comments->num_rows > 0) {
     echo "<h4>Комментарии:</h4>";
     while ($row_comment = $result_comments->fetch_assoc()) {
         echo "<p><strong>" . $row_comment["username"] . ":</strong> " . $row_comment["comment"] . "</p>";
     }
 } else {
     echo "<p>Пока нет комментариев.</p>";
 }
            if (isset($_SESSION["user_id"])) {
                         $user_id = $_SESSION["user_id"];
                         $author_id = $row["user_id"];
                         $query_subscribed = "SELECT * FROM subscriptions WHERE user_id = '$author_id' AND subscriber_id = '$user_id'";
                         $result_subscribed = $conn->query($query_subscribed);

                         if ($result_subscribed->num_rows > 0) {
                             echo "<button disabled>Вы подписаны</button>";
                         } else {
                             echo "<form action='subscribe.php' method='POST'>";
                             echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
                             echo "<button type='submit'>Подписаться на " . $row["username"] . "</button>";
                             echo "</form>";
                         }

                        
                         if ($row["user_id"] == $user_id) {
                             echo "<form action='edit_post.php' method='GET'>";
                             echo "<input type='hidden' name='post_id' value='" . $row["id"] . "'>";
                             echo "<button type='submit'>Изменить</button>";
                             echo "</form>";

                             echo "<form action='delete_post.php' method='POST'>";
                             echo "<input type='hidden' name='post_id' value='" . $row["id"] . "'>";
                             echo "<button type='submit'>Удалить</button>";
                             echo "</form>";
                         }
                     }

                     echo "<hr>";
                 }
             } else {
                 echo "<p>Постов пока нет.</p>";
             }

             $conn->close();
             ?>

             <form action="posts.php" method="GET">
                 <label for="tag">Укажите тег:</label>
                 <input type="text" name="tag" id="tag">
                 <button type="submit" class='button'>Сортировать по тегу</button>
             </form>

             <a href="index.php" class='button'>На главную</a>
         </body>
         </html>
