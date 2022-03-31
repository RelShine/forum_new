<?php

use App\Database;

session_start();

require_once __DIR__ . '/templates/header.php';
require_once __DIR__ . '/vendor/autoload.php';

$dbh = new Database;
$dbh->connect();

if (isset($_SESSION['auth'])) {
    $login = $_SESSION['login'];

    $queryExist = $dbh->prepare('SELECT COUNT(`login`) FROM `users` WHERE `login` = :login');
    $queryExist->execute(['login' => $login]);
    $arrExist = $queryExist->fetchColumn();

    if (count($arrExist) > 0) {
        $_SESSION['index'] = 'yes';
    } else {
        session_destroy();
    }
//    $queryBan = $dbh->query('SELECT `login`, `banned` FROM `users` WHERE `banned` = 1");
//
//    $ban_arr = mysqli_fetch_all($query_ban);
//    foreach ($ban_arr as $ban_user) {
//        if ($ban_user[0] === $login) {
//            exit('Вы были заблокированы');
//        }
//    }
}
?>
    <title>Форум Почты России - Главная страница</title>
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
                    echo '<a class="header__links link-home" data-fancybox href="#login">Авторизация</a>';
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
                <span class="path__text-active">Главная</span>
                <span class="path__text-active-help">&lt;-- вы здесь</span>
            </div>
        </div>
    </section>
    <section class="chapters">
        <div class="container">
            <div class="chapters__headers">
                <h3 class="chapters__header">Разделы</h3>
            </div>
            <?php
            $chapters = $dbh->query('SELECT * FROM `chapters`');
            $arrChapters = $chapters->fetchAll();

            foreach ($arrChapters as $chapter) {
                $id_chapter = $chapter[0];
                $nameChapter = $chapter[1];
                echo <<<HEREDOC
                <div class="chapters__chapter">
                    <a class="chapter__title" href="/pages/topics.php?id=$id_chapter">$nameChapter</a>
                </div>
                HEREDOC;
            }

            if (isset($_SESSION['login'])) {
                $admins = $dbh->prepare("SELECT COUNT(`role`) as count FROM users WHERE role = 3 AND login = :login");//
                $admins->execute(['login' => $login]);
                $arrAdmins = $admins->fetchColumn();

                if ($arrAdmins > 0) {
                    echo <<<HEREDOC
                    <p class="chapters__admin-text">
                        <a class="chapters__admin-link" data-fancybox href="#chapter__create">
                            <img class="chapters__admin-image" src="/images/add-icon.svg" alt="Добавить">
                        </a>
                        <span class="chapters__admin-info-pc">АДМИН ДОСТУП</span>
                    </p>
                    <span class="chapters__admin-info-mobile">АДМИН ДОСТУП</span>
                    HEREDOC;
                }
            }
            ?>
        </div>
    </section>
</main>
<?php
require_once __DIR__ . '/templates/footer.php';
?>