<?php
session_start();
$connection = require_once 'connection.php';

$login = $_SESSION['login'];
$email_old = $_POST['email_old'];
$email_new = $_POST['email_new'];
$email_new_confirm = $_POST['email_new_confirm'];

$email_old_spec = mysqli_real_escape_string($connection, $email_old);
$email_new_spec = mysqli_real_escape_string($connection, $email_new);
$email_new_confirm_spec = mysqli_real_escape_string($connection, $email_new_confirm);

if ($email_old !== $email_old_spec || $email_new !== $email_new_spec || $email_new_confirm !== $email_new_confirm_spec) {
    echo 'email-incorrect-slash';
    exit();
}

if (!filter_var($email_old_spec, FILTER_VALIDATE_EMAIL)) {
    echo 'email-incorrect';
    exit();
}

if (!filter_var($email_new_spec, FILTER_VALIDATE_EMAIL)) {
    echo 'email-incorrect';
    exit();
}

if (!filter_var($email_new_confirm_spec, FILTER_VALIDATE_EMAIL)) {
    echo 'email-incorrect';
    exit();
}

$query_check = mysqli_query($connection, "SELECT email FROM users WHERE login = '$login' AND email = '$email_old_spec'");

if (mysqli_num_rows($query_check) < 1) {
    echo 0;
    exit();
}

$email_old_arr = mysqli_fetch_assoc($query_check);
$email_old = $email_old_arr['email'];

if ($email_new_spec !== $email_new_confirm_spec) {
    echo 'email-incorrect-differ';
    exit();
}

$update = mysqli_query($connection, "UPDATE users SET email = '$email_new' WHERE login = '$login'");
echo 1;
exit();