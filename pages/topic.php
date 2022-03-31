<?php
session_start();
require_once __DIR__ . '/../templates/header.php';
unset($_SESSION['index']);
$dbh = require_once __DIR__ . '/../core/connection.php';
$id_topic = $_GET['id'];

?>
    <title>Форум Почты России - Страница темы</title>
    </head>
    <body style="background-color: #141a26; background-image: initial;">
<div class="preloader">
    <div class="preloader__row">
        <div class="preloader__item"></div>
        <div class="preloader__item"></div>
    </div>
</div>
<header class="header">
    <div class="container">
        <div class="header__wrapper">
            <div class="header__logo">
                <a class="header__logo-link" href="/index.php">
                    <img class="header__logo-img" src="/images/logo.png" alt="Лого">
                </a>
            </div>
            <div class="header__links">
                <?php
                if (isset($_SESSION['auth'])) {
                    echo '<a class="header__links link-profile" href="/pages/profile.php">Личный кабинет</a>';
                    echo '<a class="header__links link-logout" href="/core/logout.php">Выйти</a>';
                } else {
                    echo '<a class="header__links link-home" href="/index.php">Главная</a>';
                    echo '<a class="header__links link-auth" data-fancybox href="#login">Авторизация</a>';
                    echo '<a class="header__links link-register" href="/pages/register.php">Регистрация</a>';
                }
                ?>
            </div>
        </div>
    </div>
</header>
<main class="main">
    <section class="path">
        <div class="container">
            <div class="path__inner">
                <a class="path__text" href="/index.php">Главная</a>
                <span class="path__separator">/</span>
                <?php
                $id_chapter = $_SESSION['id_chapter'];
                $query_id_chapter = $dbh->query("SELECT chapter FROM chapters WHERE id = '$id_chapter'");
                $id_chapter_arr = $query_id_chapter->fetch(PDO::FETCH_ASSOC);
                echo '<span class="path__text-active">' . $id_chapter_arr['chapter'] . '</span>';
                ?>
                <span class="path__separator">/</span>
                <span class="path__text-active">Темы</span>
                <span class="path__separator">/</span>
                <?php
                $query_id_chapter = $dbh->query("SELECT topic FROM topics WHERE id = '$id_topic'");
                $id_chapter_arr = $query_id_chapter->fetch(PDO::FETCH_ASSOC);
                echo '<span class="path__text-active">' . $id_chapter_arr['topic'] . '</span>';
                ?>
                <span class="path__text-active-help">&lt;-- вы здесь</span>
            </div>
        </div>
    </section>
    <div class="container">
        <section class="messages">
            <?php
            $_SESSION['topic_id'] = $id_topic;

            $query = $dbh->query("SELECT message FROM messages WHERE id_topic = '$id_topic' LIMIT 100 OFFSET 1");
            $query2 = $dbh->query("SELECT topic FROM topics WHERE id = '$id_topic'");
//            if (mysqli_num_rows($query2) < 1) {
//                exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
//            }
            $query3 = $dbh->query("SELECT message FROM messages WHERE id_topic = '$id_topic' LIMIT 1");
            $query5 = $dbh->query("SELECT time FROM topics WHERE id = '$id_topic'");
            $time_topic = $query5->fetch(PDO::FETCH_ASSOC);

            $messages = $query->fetchAll();
            $title_topic = $query2->fetch(PDO::FETCH_ASSOC);
            $first_message = $query3->fetch(PDO::FETCH_ASSOC);

            $query_first_login = $dbh->query("SELECT u.login, u.avatar FROM users u, messages m WHERE m.id_user = u.id AND m.id_topic = '$id_topic' ORDER BY m.id LIMIT 1");
            $first_login = $query_first_login->fetch(PDO::FETCH_ASSOC);

            $query_logins = $dbh->query("SELECT u.login, u.avatar FROM users u, messages m WHERE m.id_user = u.id AND m.id_topic = '$id_topic' ORDER BY m.id LIMIT 100 OFFSET 1");
            $logins = $query_logins->fetchAll();
            echo
                '<p class="message__date-create">' . $time_topic['time'] . '</p>' .
                '<div class="message">
                <div class="message__user">' .
                '<img src="data:image/jpeg;base64,' . base64_encode($first_login['avatar']) . '" class="change__avatar__info-image" style="width: 150px; height: 150px;">';
            if ($first_login['login'] == 'Babinov') {
                echo '<p class="message__user-login" style="color: red;">' . $first_login['login'] . '</p>' . '<p style="color: red; text-align: center; margin-top: 8px; font-size: 14px;">АДМИНИСТРАТОР</p>';
            } else {
                echo '<p class="message__user-login">' . $first_login['login'] . '</p>';
                echo '
                <button class="message__user-ban" type="submit">БАН</button>';
            }
            echo
            '</div>
                <div class="message__wrapper">
                    <div class="boxw">';
            echo '<p class="message__title">' . $title_topic['topic'] . '</p>';
            echo
            '</div>';
            echo '<div class="message__text">' . $first_message['message'] . '</div>';
            echo
            '</div>
            </div>';
            $i = 0;
            foreach ($messages as $message) {
                echo
                    '<div class="message">
                <div class="message__user">' .
                    '<img src="data:image/jpeg;base64,' . base64_encode($logins[$i][1]) . '" class="change__avatar__info-image" style="width: 150px; height: 150px;">';
                if ($logins[$i][0] == 'Babinov') {
                    echo '<p class="message__user-login" style="color: red;">' . $logins[$i][0] . '</p>' . '<p style="color: red; text-align: center; margin-top: 8px; font-size: 14px;">АДМИНИСТРАТОР</p>';
                } else {
                    echo '<p class="message__user-login">' . $logins[$i][0] . '</p>';
                    echo '
                    <form action="/core/ban-user.php" method="get">' .
                        '<button class="message__user-ban" type="submit" name="ban" value="' . $logins[$i][0] . '">'. 'БАН</button>' .
                        '</form>';

                }
                echo
                '</div>
                <div class="message__wrapper" style="overflow: auto;">';
                echo
                '<div>' .
                    '<p class="message__text">' . $message[0] . '</p>';
                echo '</div>';
                echo
                '</div>
            </div>';
                ++$i;
            }
            ?>
        </section>
        <section class="message__send">
            <?php
            if (isset($_SESSION['auth'])) {
                echo
                '<textarea class="send__message-textarea" name="" id="send__message-textarea" maxlength="300" required></textarea>
                <p class="register__hint">Максимум 300 символов.</p>
            <div class="send__message-button-wrapper">
                <button class="send__message-button register__button" id="send__message-button" type="submit">
                    Отправить
                </button>
                <button class="send__message-button register__button" id="send__message-button-reset" type="reset">Сбросить</button>
            </div>
            <p class="send__message-text-error" id="send__message-text-error"></p>';
            } else {
                echo
                    '<textarea class="send__message-textarea" name="" id="send__message-textarea" maxlength="300" required disabled></textarea>
                    <p class="register__hint">Максимум 300 символов.</p>
            <div class="send__message-button-wrapper">
                <button class="send__message-button register__button" id="send__message-button" type="submit" disabled>
                Отправить
                </button>
                <button class="send__message-button register__button" id="send__message-button-reset" type="reset" disabled>Сбросить</button>
            </div>
            <p class="send__message-text-error" id="send__message-text-error"></p>' .
                    '<p class="send__message-no-auth">Вы не вошли в систему и не можете отправлять сообщения. Зарегистрируйтесь или авторизируйтесь.</p>';
            }
            ?>
        </section>
    </div>
</main>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>