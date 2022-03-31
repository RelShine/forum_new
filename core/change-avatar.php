<?php
session_start();
$dbh = require_once 'connection.php';

$idUser = $_SESSION['id_user'];
$filename = $_FILES['upload_image']['name'];

$imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

$extensionsArr = ['jpg', 'png'];

if (in_array($imageFileType, $extensionsArr)) {

    if (move_uploaded_file($_FILES['upload_image']['tmp_name'], '../images/' . $filename)) {

        $avatar = '/images' . DIRECTORY_SEPARATOR . $filename;
        $insertAvatar = $dbh->prepare('UPDATE `users` SET `avatar` = :avatar WHERE `id` = :idUser');
        $insertAvatar->execute(['avatar' => $avatar, 'idUser' => $idUser]);
        header("Location: ../index.php");
    } else {
        echo 'Ошибка загрузки файла: ' . $_FILES['image']['name'];
    }
}
header("Location: ../pages/profile.php");