<?php
session_start();
require_once __DIR__ . '/../templates/header.php';
unset($_SESSION['index']);
$dbh = require_once __DIR__ . '/../core/connection.php';
$id = $_GET['id'];
$idChapters = $dbh->prepare('SELECT COUNT(`id`) as count, `chapter` FROM `chapters` WHERE `id` = :id');
$idChapters->execute(['id' => $id]);
$arrIdChapters = $idChapters->fetch(PDO::FETCH_ASSOC);
if ($arrIdChapters['count'] < 1) {
    exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
}
?>
    <title>Форум Почты России - Страница тем</title>
    </head>
    <body>
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
                echo '<span class="path__text-active">' . $arrIdChapters['chapter'] . '</span>';
                ?>
                <span class="path__separator">/</span>
                <span class="path__text-active">Темы</span>
                <span class="path__text-active-help">&lt;-- вы здесь</span>
            </div>
        </div>
    </section>
    <section class="chapters">
        <div class="container">
            <div class="chapters__headers">
                <h3 class="chapters__header">Темы</h3>
                <h3 class="chapters__header chapters__header-last-message">Последнее сообщение</h3>
            </div>
            <?php
            $_SESSION['id_chapter'] = $id; // chapter0
            $query = $dbh->query("SELECT * FROM topics WHERE id_chapter = '$id'");
            //$id_query = $dbh->query("SELECT id FROM topics WHERE id_chapter = '$id'");
            //$id_query3 = $id_query->fetch(PDO::FETCH_ASSOC);

            if (isset($id_query3)) {
                $_SESSION['id_topic'] = $id_query3['id'];
            }
            $topics = $query->fetchAll();
            //$id_topics = $id_query->fetchAll();
            $id_topic = 0;
            $query11 = $dbh->query("SELECT t.id FROM messages m, topics t, chapters c, users u WHERE t.id_chapter = c.id AND t.id_chapter = '$id' GROUP BY t.id");
            $query11_res = $query11->fetchAll();
            $arr = [];
            $index = 0;

            foreach ($query11_res as $test11 => $key) {
                $arr[$index] = $key[0];
                ++$index;
            }

            $arr2 = [];
            $index2 = 0;
            $query22_res = [0, 0, 0];
            foreach ($arr as $test22 => $key2) {
                $query22 = $dbh->query("SELECT m.id, m.message, m.id_topic FROM messages m, topics t, chapters c, users u WHERE m.id_user = u.id AND m.id_topic = t.id AND m.id_chapter = c.id AND m.id_chapter = '$id' AND m.id_chapter = t.id_chapter AND m.id_topic = '$arr[$index2]' ORDER BY m.id DESC LIMIT 1");
                $query22_res = $query22->fetchAll();
                $arr2[$index2] = $key2[0];
                ++$index2;
            }

            $index = 0;

            $query_test = $dbh->query("SELECT m.id FROM messages m, topics t, chapters c, users u WHERE m.id_user = u.id AND m.id_topic = t.id AND m.id_chapter = c.id AND m.id_chapter = '$id' ORDER BY m.id");
            $test_arr = $query_test->fetchAll();

            foreach ($topics as $topic) {
                $query_last_message = $dbh->query("SELECT u.login, u.avatar, m.message FROM users u, messages m, chapters c, topics t WHERE m.id_user = u.id AND t.id_chapter = '$id' AND m.id_topic = '$arr2[$id_topic]' AND t.id = m.id_topic AND c.id = t.id_chapter ORDER BY m.id DESC LIMIT 1");
                $last_message_arr = $query_last_message->fetch(PDO::FETCH_ASSOC);
                $chet = 0;
                if (strlen($last_message_arr['message']) > 10) {
                    $last_message_arr['message'] = 'Читайте в теме';
                    ++$chet;
                }
                echo '<div class="chapters__chapter">' .
                    '<a class="chapter__title" href="/pages/topic.php?id=' . $query11_res[$id_topic][0] . '">' . $topic[1] . '</a>' .
                    '<div class="chapter__user">' .
                    '<div class="chapter__user-avatar-wrapper">' .
                    '<img src='.$last_message_arr['avatar'].' class="chapter__user-avatar" alt="Аватар" width="42" height="42">' .
                    '</div>' .
                    '<div class="chapter__user-wrapper">';
                if ($last_message_arr['login'] == 'Babinov') {
                    echo '<p class="chapter__user-nick" style="color: red; text-align: center;">' . $last_message_arr['login'] . '</p>' . '<p style="color: red; text-align: center; margin-top: -8px; font-size: 14px;">АДМИНИСТРАТОР</p>';
                } else {
                    echo '<p class="chapter__user-nick">' . $last_message_arr['login'] . '</p>';
                }
                echo
                    '<p class="chapter__user-nick">' . $last_message_arr['message'] . '</p>' .
                    '</div>' .
                    '</div>' .
                    '</div>';
                ++$id_topic;
            }
            ?>
            <div>
                <?php
                if (isset($_SESSION['auth'])) {
                    echo
                    '<p style="background-color: #183368; padding: 8px 0">
                    <a data-fancybox href="#create" style="display: flex; justify-content: center; align-items: center">
                        <img src="/images/add-icon.svg" alt="Добавить">
                    </a>
                </p>';
                } else {
                    echo
                    '<p style="background-color: #183368; padding: 8px 0">
                    <a style="display: flex; justify-content: center; align-items: center">
                        <img src="/images/add-icon.svg" alt="Добавить">
                    </a>
                </p>
                <p class="send__message-no-auth">Вы не вошли в систему и не можете добавлять темы. Зарегистрируйтесь или авторизируйтесь.</p>';
                }
                ?>
            </div>
        </div>
    </section>
</main>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>