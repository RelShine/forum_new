<?php

session_start();

if (isset($_SESSION['auth'])) {
    header("Location: /index.php");
}

require_once __DIR__ . '/../templates/header.php';

unset($_SESSION['index']);
?>
    <title>Форум Почты России - Регистрация</title>
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
                    <a class="header__links link-auth" data-fancybox href="#login">Авторизация</a>
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
                    <span class="path__text-active">Регистрация</span>
                    <span class="path__text-active-help">&lt;-- вы здесь</span>
                </div>
            </div>
        </section>
        <section class="register">
            <div class="container">
                <div class="register__wrapper register__login-wrapper">
                    <h3 class="register__title">Введите логин</h3>
                    <div class="register__input-login-wrapper">
                        <input class="register_input register__login" id="register__login" type="text" name="login"
                               required minlength="5" maxlength="20">
                        <p class="register__text">Логин...</p>
                    </div>
                    <p class="register__hint">Должен быть уникальным. 5-20 символов.</p>
                </div>
                <div class="register__wrapper register__email-wrapper">
                    <h3 class="register__title">Введите адрес электронной почты</h3>
                    <div class="register__input-email-wrapper">
                        <input class="register_input register__email" id="register__email" type="text" name="email"
                               required minlength="10" maxlength="50">
                        <p class="register__text">Адрес электронной почты...</p>
                    </div>
                    <p class="register__hint">Должен быть уникальным и корректным. 10-50 символов.</p>
                </div>
                <div class="register__wrapper register__password-wrapper">
                    <h3 class="register__title">Введите пароль</h3>
                    <div class="register__password-inner">
                        <div class="register__password-text-inner">
                            <div class="register__input-password-wrapper">
                                <input class="register_input register__password" id="register__password"
                                       type="password"
                                       name="password"
                                       required minlength="10" maxlength="30">
                                <p class="register__text">Пароль...</p>
                            </div>
                            <div class="register__password-input-inner">
                                <div class="register__input-password-confirm-wrapper">
                                    <input class="register_input register__password-confirm"
                                           id="register__password-confirm" type="password"
                                           name="password_confirm" required minlength="10" maxlength="30">
                                    <p class="register__text">Подтвердите пароль...</p>
                                    <p class="register__hint">Должен совпадать. 10-30 символов.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="error__msg">
                    <p class="error__msg-text" id="error__msg-text"></p>
                </div>
                <div class="register__button-wrapper">
                    <button class="register__button" id="register__button" type="submit">Зарегистрироваться</button>
                    <button class="register__button" id="register__button-reset" type="reset">Сбросить</button>
                </div>
            </div>
        </section>
    </main>
<?php
require_once __DIR__ . '/../templates/footer.php';
?>