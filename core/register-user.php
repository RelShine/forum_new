<?php
session_start();
$dbh = require_once 'connection.php';

$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['password_confirm'];

if ($password !== $passwordConfirm) {
    echo 'password-incorrect-differ';
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'email-incorrect';
    exit();
}

$queryLogin = $dbh->prepare('SELECT COUNT(`login`) as countLogin FROM `users` WHERE `login` = :login');
$queryLogin->execute(['login' => $login]);
$arrLogin = $queryLogin->fetch(PDO::FETCH_ASSOC);
if ($arrLogin['countLogin'] > 0) {
    echo 'login-exist';
    exit();
}

$queryEmail = $dbh->prepare('SELECT COUNT(`email`) as countEmail FROM `users` WHERE `email` = :email');
$queryEmail->execute(['email' => $email]);
$arrEmail = $queryEmail->fetch(PDO::FETCH_ASSOC);
if ($arrEmail['countEmail'] > 0) {
    echo 'email-exist';
    exit();
}

$password_h = password_hash($password, PASSWORD_BCRYPT);

$file = '/images/user-avatar.png';
$insert_user = $dbh->prepare('INSERT INTO `users` VALUES (NULL, :login, :email, :password_h, :file, 1, 0)');
$insert_user->execute(['login' => $login, 'email' => $email, 'password_h' => $password_h, 'file' => $file]);

$query_id_user = $dbh->prepare('SELECT `id` FROM `users` WHERE `login` = :login');
$query_id_user->execute(['login' => $login]);

$id_user_arr = $query_id_user->fetch(PDO::FETCH_ASSOC);

$_SESSION['auth'] = 'yes';
$_SESSION['login'] = $login;
$_SESSION['id_user'] = $id_user_arr['id'];

echo 1;
exit();