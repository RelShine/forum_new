<?php
session_start();
$dbh = require_once 'connection.php';

$login = $_POST['login'];
$password = $_POST['password'];

$queryPassword = $dbh->prepare('SELECT COUNT(`password`) as count, `password`, `id` FROM `users` WHERE `login` = :login');
$queryPassword->execute(['login' => $login]);
$countPassword = $queryPassword->fetch(PDO::FETCH_ASSOC);

if ($countPassword['count'] < 1) {
    echo 0;
    exit();
}

$res = password_verify($password, $countPassword['password']);
if ($res) {
    $_SESSION['auth'] = 'yes';
    $_SESSION['login'] = $login;
    $_SESSION['id_user'] = $countPassword['id'];
    echo 1;
    exit();
}
echo 0;