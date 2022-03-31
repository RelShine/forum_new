<?php
session_start();
$dbh = require_once __DIR__ . '/../core/connection.php';
if (!isset($_SESSION['auth'])) {
    header("Location: /index.php");
}
require_once __DIR__ . '/../templates/header.php';
unset($_SESSION['index']);
?>
    <title>Форум Почты России - Профиль</title>
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
                <a class="header__links link-home" href="/index.php">Главная</a>
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
                <span class="path__text-active">Профиль</span>
                <span class="path__text-active-help">&lt;-- вы здесь</span>
            </div>
        </div>
    </section>
    <section class="change__avatar">
        <div class="container">
            <h3 class="change__avatar-title">
                Сменить аватар
            </h3>
            <div class="change__avatar__info-wrapper">
                <?php
                $id_user = $_SESSION['id_user'];
                $query_avatar = $dbh->prepare('SELECT `avatar` FROM `users` WHERE `id` = :id_user');
                $query_avatar->execute(['id_user' => $id_user]);
                $avatar_arr = $query_avatar->fetch(PDO::FETCH_ASSOC);
                echo '<img src='.$avatar_arr['avatar'].' class="change__avatar__info-image" style="width: 300px; height: 300px;">';
                ?>
                <p class="change__avatar__info-text">Поддерживаются только файлы формата jpg, png.
                    Рекомендуются квадратные картинки, так как картинка
                    будет сжата до размера 300x300 для отображения в профиле (или до 150x150 в случае маленького
                    разрешения),
                    и до 150x150 в темах.</p>
            </div>
            <div class="change__avatar__action-wrapper">
                <form action="/core/change-avatar.php" method="post" enctype="multipart/form-data">
                    <div class="change__avatar__action-label-wrapper">
                        <label class="change__avatar__action-label" for="avatar__input">Сменить аватар</label>
                    </div>
                    <input class="change__avatar__action-input" id="avatar__input" name="upload_image" type="file"
                           required accept="image/jpeg,image/png">
                    <button class="change__avatar__action-button change__button" type="submit">Сохранить</button>
                </form>
            </div>
        </div>
    </section>
    <section class="change__email">
        <div class="container">
            <h3 class="change__email-title">
                Сменить адрес электронной почты
            </h3>
            <div class="change__email-box">
                <div class="change__email-inner">
                    <div class="change__email-wrapper change__email-current-wrapper">
                        <input class="register_input change__email-input" id="change__email-input-old" type="text"
                               required maxlength="50">
                        <p class="change__email-text">Действующий адрес эл. почты...</p>
                    </div>
                    <div class="change__email-wrapper change__email-new-wrapper">
                        <input class="register_input change__email-input" id="change__email-input-new" type="text"
                               required maxlength="50">
                        <p class="change__email-text">Новый адрес эл. почты...</p>
                    </div>
                    <div class="change__email-wrapper change__email-new-confirm-wrapper">
                        <input class="register_input change__email-input" id="change__email-input-new-confirm"
                               type="text" required maxlength="50">
                        <p class="change__email-text">Подтвердите новый адрес эл. почты...</p>
                    </div>
                    <p class="register__hint">Максимум 50 символов.</p>
                </div>
                <div class="change__email-image-wrapper">
                    <img class="change__email-image" src="/images/curly-brace.svg" alt="">
                    <p class="change__email-text-help">Должен быть корректным и совпадать.</p>
                </div>
            </div>
            <p class="change__email-text-error" id="change__email-text-error"></p>
            <button class="change__email-button change__button" id="change__email-button" type="submit">Сохранить
            </button>
        </div>
    </section>
    <section class="change__password">
        <div class="container">
            <h3 class="change__password-title">
                Сменить пароль
            </h3>
            <div class="change__password-box">
                <div class="change__password-inner">
                    <div class="change__password-wrapper change__password-current-wrapper">
                        <input class="register_input change__password-input" id="change__password-input-old"
                               type="password" required maxlength="30">
                        <p class="change__password-text">Действующий пароль...</p>
                    </div>
                    <div class="change__password-wrapper change__password-new-wrapper">
                        <input class="register_input change__password-input" id="change__password-input-new"
                               type="password" required maxlength="30">
                        <p class="change__password-text">Новый пароль...</p>
                    </div>
                    <div class="change__password-wrapper change__password-new-confirm-wrapper">
                        <input class="register_input change__password-input" id="change__password-input-new-confirm"
                               type="password" required maxlength="30">
                        <p class="change__password-text">Подтвердите новый пароль...</p>
                    </div>
                    <p class="register__hint">Максимум 30 символов.</p>
                </div>
                <div class="change__password-image-wrapper">
                    <img class="change__password-image" src="/images/curly-brace.svg" alt="">
                    <p class="change__password-text-help">Должен совпадать.</p>
                </div>
            </div>
            <p class="change__password-text-error" id="change__password-text-error"></p>
            <button class="change__password-button change__button" id="change__password-button" type="submit">
                Сохранить
            </button>
        </div>
    </section>
</main>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>