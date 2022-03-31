<?php
session_start();
$dbh = require_once 'connection.php';

$chapterTitle = $_POST['chapter_title'];

$query = $dbh->prepare('SELECT COUNT(`id`) as count FROM `chapters` WHERE `chapter` = :chapterTitle');
$query->execute(['chapterTitle' => $chapterTitle]);
$queryArr = $query->fetchColumn();
if ($queryArr['count'] > 0) {
    echo 'chapter-exist';
    exit();
}

$query = $dbh->prepare('INSERT INTO `chapters` VALUES (NULL, :chapterTitle)');
$query->execute(['chapterTitle' => $chapterTitle]);

echo 1;
exit();