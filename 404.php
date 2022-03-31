<?php
session_start();
require_once __DIR__ . '/templates/header.php';
unset($_SESSION['index']);
?>
    <title>Форум Почты России - 404</title>
    </head>
    <body>
    <div class="preloader">
        <div class="preloader__row">
            <div class="preloader__item"></div>
            <div class="preloader__item"></div>
        </div>
    </div>
    <main class="main">
        <section class="not__found">
            <div class="not__found-wrapper">
                <h1 class="not__found-title">К сожалению, данной страницы не существует.</h1>
                <p class="not__found-text">Возможно, вы ошиблись, набирая адрес в строке браузера.</p>
                <strong class="not__found-code">404</strong>
                <a class="not__found-help" href="/index.php">Вернуться на главную страницу</a>
            </div>
        </section>
    </main>
<?php
require_once __DIR__ . '/templates/footer.php';
?>