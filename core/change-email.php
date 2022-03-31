<?php
session_start();
$dbh = require_once 'connection.php';

$login = $_SESSION['login'];
$emailOld = $_POST['email_old'];
$emailNew = $_POST['email_new'];
$emailNewConfirm = $_POST['email_new_confirm'];

if (!filter_var($emailOld, FILTER_VALIDATE_EMAIL)) {
    echo 'email-incorrect';
    exit();
}

if (!filter_var($emailNew, FILTER_VALIDATE_EMAIL)) {
    echo 'email-incorrect';
    exit();
}

if (!filter_var($emailNewConfirm, FILTER_VALIDATE_EMAIL)) {
    echo 'email-incorrect';
    exit();
}

if ($emailNew !== $emailNewConfirm) {
    echo 'email-incorrect-differ';
    exit();
}

$countEmail = $dbh->prepare('SELECT COUNT(`email`) as count, `email` FROM `users` WHERE `login` = :login AND `email` = :emailOld');
$countEmail->execute(['login' => $login, 'emailOld' => $emailOld]);
$emailArr = $countEmail->fetch(PDO::FETCH_ASSOC);
if ($emailArr['count'] > 0) {
    echo 0;
    exit();
}

$updateEmail = $dbh->prepare('UPDATE `users` SET `email` = :emailNew WHERE `login` = :login');
$updateEmail->execute(['emailNew' => $emailNew, 'login' => $login]);

echo 1;
exit();