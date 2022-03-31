<?php
session_start();
$dbh = require_once 'connection.php';

$login = $_SESSION['login'];
$title = $_POST['topic_title'];
$message = $_POST['topic_message'];
$idChapter = $_SESSION['id_chapter'];

$getIdUser = $dbh->prepare('SELECT `id` FROM `users` WHERE `login` = :login');
$getIdUser->execute(['login' => $login]);
$idUserArr = $getIdUser->fetch(PDO::FETCH_ASSOC);
$idUser = $idUserArr['id'];

$insertTopic = $dbh->prepare('INSERT INTO `topics` VALUES (NULL, :title, now(), :idChapter)');
$insertTopic->execute(['title' => $title, 'idChapter' => $idChapter]);

$getIdTopic = $dbh->prepare('SELECT `id` FROM `topics` WHERE `topic` = :title');
$getIdTopic->execute(['title' => $title]);
$idTopicArr = $getIdTopic->fetch(PDO::FETCH_ASSOC);
$idTopic = $idTopicArr['id'];

$insertFirstMessage = $dbh->prepare('INSERT INTO `messages` VALUES (NULL, :message, :idUser, :idTopic, :idChapter)');
$insertFirstMessage->execute(['message' => $message, 'idUser' => $idUser, 'idTopic' => $idTopic, 'idChapter' => $idChapter]);

echo 1;
exit();