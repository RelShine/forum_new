<?php
session_start();
$connection = require_once 'connection.php';

$message = $_POST['message'];
$login = $_SESSION['login'];

$id_topic = $_SESSION['topic_id'];
$id_chapter = $_SESSION['chapter0'];

$message_spec = mysqli_real_escape_string($connection, $message);

if ($message_spec !== $message) {
    echo 'message-incorrect-slash';
    exit();
}

$message_spec_html = htmlspecialchars($message_spec);

if ($message_spec_html !== $message_spec) {
    echo 'message-incorrect-html';
    exit();
}

$query1 = mysqli_query($connection, "SELECT id FROM users WHERE login = '$login'");
if (mysqli_num_rows($query1) < 1) {
    echo 0;
    exit();
}

$id_user_arr = mysqli_fetch_assoc($query1);
$id_user = $id_user_arr['id'];

$query2 = mysqli_query($connection, "INSERT INTO messages VALUES (NULL, '$message_spec_html', '$id_user', '$id_topic', '$id_chapter')");

echo 1;
exit();