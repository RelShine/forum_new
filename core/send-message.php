<?php
session_start();
$dbh = require_once 'connection.php';

$message = $_POST['message'];
$login = $_SESSION['login'];
$idTopic = $_SESSION['topic_id'];
$idChapter = $_SESSION['id_chapter'];

$getIdUser = $dbh->prepare('SELECT `id` FROM `users` WHERE `login` = :login');
$getIdUser->execute(['login' => $login]);
$idUserArr = $getIdUser->fetch(PDO::FETCH_ASSOC);
$idUser = $idUserArr['id'];

$insertMessage = $dbh->prepare('INSERT INTO `messages` VALUES (NULL, :message, :idUser, :idTopic, :idChapter)');
$insertMessage->execute(['message' => $message, 'idUser' => $idUser, 'idTopic' => $idTopic, 'idChapter' => $idChapter]);

echo 1;
exit();