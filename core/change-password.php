<?php
session_start();
$dbh = require_once 'connection.php';

$login = $_SESSION['login'];
$passwordOld = $_POST['password_old'];
$passwordNew = $_POST['password_new'];
$passwordNewConfirm = $_POST['password_new_confirm'];

if ($passwordNew !== $passwordNewConfirm) {
    echo 'password-incorrect-differ';
    exit();
}

$countPassword = $dbh->prepare('SELECT COUNT(`password`) as count, `password` FROM `users` WHERE `login` = :login');
$countPassword->execute(['login' => $login]);
$passwordArr = $countPassword->fetch(PDO::FETCH_ASSOC);
if ($passwordArr['count'] > 0) {
    echo 0;
    exit();
}
$passwordHash = $passwordArr['password'];

if (!password_verify($passwordOld, $passwordHash)) {
    echo 0;
    exit();
}

$passwordNewHash = password_hash($passwordNew, PASSWORD_BCRYPT);

$updatePassword = $dbh->prepare('UPDATE `users` SET `password` = :passwordNewHash WHERE `login` = :login');
$updatePassword->execute(['passwordNewHash' => $passwordNewHash, 'login' => $login]);

echo 1;
exit();