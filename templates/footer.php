<div class="login__window" id="login">
    <h3 class="auth__title">Авторизация</h3>
    <div class="register__input-login-wrapper">
        <input class="register_input register__login login__login" id="login__login" type="text" name="login" required
               maxlength="20">
        <p class="register__text">Логин:</p>
    </div>
    <p class="register__hint">5-20 символов.</p>
    <div class="register__input-password-wrapper">
        <input class="register_input register__password login__password" id="login__password" type="password" name="password"
               required maxlength="30">
        <p class="register__text">Пароль:</p>
    </div>
    <p class="register__hint">6-30 символов.</p>
    <button class="register__button login__button" id="login__button" type="submit">Войти</button>
    <div class="auth__msg">
        <p class="auth__msg-text" id="auth__msg-text"></p>
    </div>
</div>
<div class="topic__window" id="create">
    <h3 class="create__topic-title">Создание темы</h3>
    <p class="create__topic-text">Заголовок темы</p>
    <textarea class="create__topic-textarea-title" name="title" id="create__topic-textarea-title" required maxlength="30"></textarea>
    <p class="register__hint">Максимум 30 символов.</p>
    <p class="create__topic-text">Текст темы</p>
    <textarea class="create__topic-textarea-text" name="text" id="create__topic-textarea-text" required maxlength="300"></textarea>
    <p class="register__hint">Максимум 300 символов.</p>
    <button class="register__button create__topic-button" id="create__topic-button" type="submit">Отправить</button>
    <p class="change__password-text-error" id="change__password-text-error-2"></p>
</div>
<div class="topic__window" id="chapter__create">
    <h3 class="create__topic-title">Создание раздела</h3>
    <p class="create__topic-text">Заголовок раздела</p>
    <textarea class="create__topic-textarea-title" name="title__chapter" id="create__chapter-textarea-title" required maxlength="30"></textarea>
    <p class="register__hint">Максимум 30 символов.</p>
    <button class="register__button create__topic-button" id="create__chapter-button" type="submit">Отправить</button>
    <p class="change__password-text-error" id="change__password-text-error"></p>
</div>
<footer class="footer">
    <div class="container">
        <p class="footer__text">Copyright &copy; 2021. Не является официальным форумом АО "Почта России" и не претендует
            не
            на какие права.</p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="/js/noty.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-noty/2.4.1/jquery.noty.min.js"></script>
<?php
if (isset($_SESSION['auth']) && isset($_SESSION['index'])) {
    echo '<script>
    new Noty({
        type: \'success\',
        layout: \'topCenter\',
        theme: \'sunset\',
        text: \'<p style="text-align: center; font-size: 20px;">Успешный вход</p>\',
        timeout: 1000,
        animation: {
            open: \'animate__animated animate__rollIn\',
            close: \'animate__animated animate__rollOut\'
        }
    }).show();
</script>';
}
?>
<script>
    $(window).on('load', function () {
        $('.preloader').fadeOut().end().delay(400).fadeOut('slow');
    });
</script>
<script src="/js/main.js"></script>
</body>
</html>