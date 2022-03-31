<?php
session_start();
$connection = require_once 'connection.php';

$login = $_SESSION['login'];
$title = $_POST['topic_title'];
$message = $_POST['topic_message'];
$id_topic = $_SESSION['id_topic'];
$id_chapter = $_SESSION['id_chapter'];
$id_chapter2 = $_SESSION['chapter0'];

$topic_title_spec = mysqli_real_escape_string($connection, $title);
if ($topic_title_spec !== $title) {
    echo 'topic-title-incorrect-slash';
    exit();
}

$topic_title_spec_html = htmlspecialchars($topic_title_spec);
if ($topic_title_spec_html !== $topic_title_spec) {
    echo 'topic-title-incorrect-html';
    exit();
}

$topic_message_spec = mysqli_real_escape_string($connection, $message);
if ($topic_message_spec !== $message) {
    echo 'topic-message-incorrect-slash';
    exit();
}

$topic_message_spec_html = htmlspecialchars($topic_message_spec);
if ($topic_message_spec_html !== $topic_message_spec) {
    echo 'topic-message-incorrect-html';
    exit();
}


$query1 = mysqli_query($connection, "SELECT id FROM users WHERE login = '$login'");

$id_user_arr = mysqli_fetch_assoc($query1);
$id_user = $id_user_arr['id'];

$query2 = mysqli_query($connection, "INSERT INTO topics VALUES (NULL, '$title', now(), '$id_chapter2')");

$query4 = mysqli_query($connection, "SELECT id FROM topics WHERE topic = '$title'");
$query4_arr = mysqli_fetch_assoc($query4);
$query4_var = $query4_arr['id'];

$query3 = mysqli_query($connection, "INSERT INTO messages VALUES (NULL, '$message', '$id_user', '$query4_var', '$id_chapter2')");

echo 1;
exit();