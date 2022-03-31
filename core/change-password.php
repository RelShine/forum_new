<?php
session_start();
$connection = require_once 'connection.php';

$login = $_SESSION['login'];
$password_old = $_POST['password_old'];
$password_new = $_POST['password_new'];
$password_new_confirm = $_POST['password_new_confirm'];

$password_old_spec = mysqli_real_escape_string($connection, $password_old);
$password_new_spec = mysqli_real_escape_string($connection, $password_new);
$password_new_confirm_spec = mysqli_real_escape_string($connection, $password_new_confirm);

if ($password_old !== $password_old_spec || $password_new !== $password_new_spec || $password_new_confirm !== $password_new_confirm_spec) {
    echo 'password-incorrect-slash';
    exit();
}

$query_password = mysqli_query($connection, "SELECT password FROM users WHERE login = '$login'");
if (mysqli_num_rows($query_password) < 1) {
    echo 0;
    exit();
}

$password_arr = mysqli_fetch_assoc($query_password);
$password_hash = $password_arr['password'];

if (!password_verify($password_old_spec, $password_hash)) {
    echo 0;
    exit();
}

if ($password_new_spec !== $password_new_confirm_spec) {
    echo 'password-incorrect-differ';
    exit();
}

$password_new_hash = password_hash($password_new_spec, PASSWORD_BCRYPT);

$update = mysqli_query($connection, "UPDATE users SET password = '$password_new_hash' WHERE login = '$login'");
echo 1;
exit();