$(document).ready(function () {
    $("#register__button-reset").click(function () {
        $("#register__login").val('');
        $("#register__email").val('');
        $("#register__password").val('');
        $("#register__password-confirm").val('');
    });
});

$(document).ready(function () {
    $("#send__message-button-reset").click(function () {
        $("#send__message-textarea").val('');
    });
});

$(document).ready(function () {
    $("#login__button").click(function () {
        let login = $("#login__login").val().trim();
        let password = $("#login__password").val().trim();
        if (login != "" && password != "") {
            $.ajax({
                url: '/core/login-user.php',
                type: 'post',
                data: {login: login, password: password},
                success: function (response) {
                    let msg = "";
                    if (response == 1) {
                        window.location = "/index.php";
                    } else if (response === 'login-incorrect-slash') {
                        msg = 'В поле логина вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'password-incorrect-slash') {
                        msg = 'В поле пароля вы ввели запрещенный символ. ("\\")';
                    } else if (response == 0) {
                        msg = "Пользователь не найден.";
                    } else {
                        msg = "Ошибка авторизации.";
                    }
                    $("#auth__msg-text").html(msg);
                }
            });
        }
    });
});

$(document).ready(function () {
    $("#register__button").click(function () {
        let login = $("#register__login").val().trim();
        let email = $("#register__email").val().trim();
        let password = $("#register__password").val().trim();
        let password_confirm = $("#register__password-confirm").val().trim();
        if (login != "" && email != "" && password != "" && password_confirm != "") {
            $.ajax({
                url: '/core/register-user.php',
                type: 'post',
                data: {login: login, email: email, password: password, password_confirm: password_confirm},
                success: function (response) {
                    let msg = "";
                    if (response == 1) {
                        window.location = "/index.php";
                    } else if (response === 'login-incorrect-slash') {
                        msg = 'В поле логина вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'login-incorrect-html') {
                        msg = 'В поле логина вы ввели запрещенные символы. ("&", """, "\'", "<", ">")';
                    } else if (response === 'email-incorrect-slash') {
                        msg = 'В поле адреса эл. почты вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'password-incorrect-differ') {
                        msg = 'Введенные пароли различаются.';
                    } else if (response === 'password-incorrect-slash') {
                        msg = 'В поле пароля вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'email-incorrect') {
                        msg = 'Эл. почта невалидна.';
                    } else if (response === 'login-exist') {
                        msg = 'Пользователь с таким логином уже существует.';
                    } else if (response === 'email-exist') {
                        msg = 'Пользователь с такой эл. почтой уже существует.';
                    } else {
                        msg = "Ошибка регистрации.";
                    }
                    $("#error__msg-text").html(msg);
                }
            });
        }
    });
});

$(document).ready(function () {
    $("#change__email-button").click(function () {
        let email_old = $("#change__email-input-old").val().trim();
        let email_new = $("#change__email-input-new").val().trim();
        let email_new_confirm = $("#change__email-input-new-confirm").val().trim();
        if (email_old != "" && email_new != "" && email_new_confirm != "") {
            $.ajax({
                url: '/core/change-email.php',
                type: 'post',
                data: {email_old: email_old, email_new: email_new, email_new_confirm: email_new_confirm},
                success: function (response) {
                    let msg = "";
                    if (response == 1) {
                        new Noty({
                            type: 'success',
                            layout: 'topCenter',
                            theme: 'sunset',
                            text: '<p style="text-align: center; font-size: 20px;">Эл. почта успешно изменена</p>',
                            timeout: 2000,
                            animation: {
                                open: 'animate__animated animate__rollIn',
                                close: 'animate__animated animate__rollOut'
                            }
                        }).show();
                    } else if (response === 'email-incorrect-slash') {
                        msg = 'В поле эл. почты вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'email-incorrect') {
                        msg = 'Эл. почта невалидна.';
                    } else if (response === 'email-incorrect-differ') {
                        msg = 'Введенные почты различаются.';
                    } else if (response == 0) {
                        msg = 'Пользователь с такой почтой не найден. Либо вы вводите чужую.';
                    } else {
                        msg = "Ошибка.";
                    }
                    $("#change__email-text-error").html(msg);
                }
            });
        }
    });
});

$(document).ready(function () {
    $("#change__password-button").click(function () {
        let password_old = $("#change__password-input-old").val().trim();
        let password_new = $("#change__password-input-new").val().trim();
        let password_new_confirm = $("#change__password-input-new-confirm").val().trim();
        if (password_old != "" && password_new != "" && password_new_confirm != "") {
            $.ajax({
                url: '/core/change-password.php',
                type: 'post',
                data: {
                    password_old: password_old,
                    password_new: password_new,
                    password_new_confirm: password_new_confirm
                },
                success: function (response) {
                    let msg = "";
                    if (response == 1) {
                        new Noty({
                            type: 'success',
                            layout: 'topCenter',
                            theme: 'sunset',
                            text: '<p style="text-align: center; font-size: 20px;">Пароль успешно изменен</p>',
                            timeout: 2000,
                            animation: {
                                open: 'animate__animated animate__rollIn',
                                close: 'animate__animated animate__rollOut'
                            }
                        }).show();
                    } else if (response === 'password-incorrect-slash') {
                        msg = 'В поле пароля вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'password-incorrect-differ') {
                        msg = 'Введенные пароли различаются.';
                    } else if (response == 0) {
                        msg = 'Пользователь с таким паролем не найден. Либо вы вводите чужой.';
                    } else {
                        msg = "Ошибка.";
                    }
                    $("#change__password-text-error").html(msg);
                }
            });
        }
    });
});

$(document).ready(function () {
    $("#send__message-button").click(function () {
        let message = $("#send__message-textarea").val().trim();
        if (message != "") {
            $.ajax({
                url: '/core/send-message.php',
                type: 'post',
                data: {
                    message: message,
                },
                success: function (response) {
                    let msg = "";
                    if (response == 1) {
                        location.reload();
                        new Noty({
                            type: 'success',
                            layout: 'topCenter',
                            theme: 'sunset',
                            text: '<p style="text-align: center; font-size: 20px;">Отправлено</p>',
                            timeout: 2000,
                            animation: {
                                open: 'animate__animated animate__rollIn',
                                close: 'animate__animated animate__rollOut'
                            }
                        }).show();
                    } else if (response === 'message-incorrect-slash') {
                        msg = 'В поле отправки вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'message-incorrect-html') {
                        msg = 'В поле отправки вы ввели запрещенные символы. ("&", """, "\'", "<", ">")';
                    } else {
                        msg = "Ошибка.";
                    }
                    $("#send__message-text-error").html(msg);
                }
            });
        }
    });
});

$(document).ready(function () {
    $("#create__topic-button").click(function () {
        let topic_title = $("#create__topic-textarea-title").val().trim();
        let topic_message = $("#create__topic-textarea-text").val().trim();
        if (topic_title != "" && topic_message != "") {
            $.ajax({
                url: '/core/add-topic.php',
                type: 'post',
                data: {
                    topic_title: topic_title,
                    topic_message: topic_message
                },
                success: function (response) {
                    let msg = "";
                    if (response == 1) {
                        window.location = "/index.php";
                    } else if (response === 'topic-title-incorrect-slash') {
                        msg = 'В поле заголовка вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'topic-title-incorrect-html') {
                        msg = 'В поле заголовка вы ввели запрещенные символы. ("&", """, "\'", "<", ">")';
                    } else if (response === 'topic-message-incorrect-slash') {
                        msg = 'В поле сообщения вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'topic-message-incorrect-html') {
                        msg = 'В поле сообщения вы ввели запрещенные символы. ("&", """, "\'", "<", ">")';
                    } else {
                        msg = "Ошибка.";
                    }
                    $("#change__password-text-error-2").html(msg);
                }
            });
        }
    });
});

$(document).ready(function () {
    $("#create__chapter-button").click(function () {
        let chapter_title = $("#create__chapter-textarea-title").val().trim();
        if (chapter_title != "") {
            $.ajax({
                url: '/core/add-chapter.php',
                type: 'post',
                data: {
                    chapter_title: chapter_title
                },
                success: function (response) {
                    let msg = "";
                    if (response == 1) {
                        window.location = "/index.php";
                    } else if (response === 'chapter-incorrect-slash') {
                        msg = 'В поле заголовка вы ввели запрещенный символ. ("\\")';
                    } else if (response === 'chapter-incorrect-html') {
                        msg = 'В поле заголовка вы ввели запрещенные символы. ("&", """, "\'", "<", ">")';
                    } else if (response === 'chapter-exist') {
                        msg = 'Такой раздел уже существует.';
                    } else {
                        msg = "Ошибка.";
                    }
                    $("#change__password-text-error").html(msg);
                }
            });
        }
    });
});
