<?php
include("session_start.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Мой блог</title>
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
    <h1 class="page-title">Добро пожаловать в мой блог</h1>

    <?php if (isset($_SESSION["user_id"])) : ?>

        <h2>Новый пост</h2>
        <a href="create_post.php" class="link">Создать пост</a>


        <h2>Последние 5 постов пользователей, на которых вы подписаны:</h2>
        <?php
        $servername = "localhost";
        $username = "g919483h_root";
        $password = "vostcorp12Qaq";
        $dbname = "g919483h_root";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_id = $_SESSION["user_id"];

        $query_subscriptions = "SELECT user_id FROM subscriptions WHERE subscriber_id = '$user_id'";
        $result_subscriptions = $conn->query($query_subscriptions);

        if ($result_subscriptions->num_rows > 0) {
            $user_ids = array();
            while ($row_subscription = $result_subscriptions->fetch_assoc()) {
                $user_ids[] = $row_subscription["user_id"];
            }

            $user_ids_str = implode(",", $user_ids);
            $query_latest_posts = "SELECT p.*, u.username
                                  FROM posts p
                                  INNER JOIN users u ON p.user_id = u.id
                                  WHERE p.user_id IN ($user_ids_str)
                                  ORDER BY p.id DESC
                                  LIMIT 5";

            $result_latest_posts = $conn->query($query_latest_posts);

            if ($result_latest_posts->num_rows > 0) {
                while ($row_latest_post = $result_latest_posts->fetch_assoc()) {
                    echo "<h3>" . $row_latest_post["title"] . "</h3>";
                    if (isset($row_latest_post["spoiler"]) && $row_latest_post["spoiler"] == 1) {
                        echo "<div class='spoiler'>";
                        echo "<p class='spoiler-text'>" . $row_latest_post["content"] . "</p>";
                        echo "<button class='spoiler-button'>Показать спойлер</button>";
                        echo "</div>";
                    } else {
                        echo "<p>" . $row_latest_post["content"] . "</p>";
                    }
                    echo "<p>Автор: " . $row_latest_post["username"] . "</p>";
                    echo "<hr>";
                }
            } else {
                echo "Нет последних постов от подписанных пользователей.";
            }
        } else {
            echo "Вы пока ни на кого не подписаны.";
        }

        $conn->close();
        ?>


        <h2>Публичные посты</h2>
        <a href="posts.php" class="link">Посмотреть публичные посты</a>
        <a href="logout.php" class="link">Выйти</a>

    <?php else : ?>

        <h2>Регистрация</h2>
        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required class="form-input">
            <input type="password" name="password" placeholder="Пароль" required class="form-input">
            <button type="submit" class="button">Зарегистрироваться</button>
        </form>

        <h2>Вход</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Имя пользователя" required class="form-input">
            <input type="password" name="password" placeholder="Пароль" required class="form-input">
            <button type="submit" class="button">Войти</button>
        </form>
    <?php endif; ?>

</body>
</html>
