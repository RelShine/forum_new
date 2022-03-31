<?php
session_start();
$dbh = require_once 'connection.php';

$chapterTitle = $_POST['chapter_title'];

$countChapters = $dbh->prepare('SELECT COUNT(`id`) as count FROM `chapters` WHERE `chapter` = :chapterTitle');
$countChapters->execute(['chapterTitle' => $chapterTitle]);
$chaptersArr = $countChapters->fetchColumn();
if ($chaptersArr['count'] > 0) {
    echo 'chapter-exist';
    exit();
}

$insertChapter = $dbh->prepare('INSERT INTO `chapters` VALUES (NULL, :chapterTitle)');
$insertChapter->execute(['chapterTitle' => $chapterTitle]);

echo 1;
exit();