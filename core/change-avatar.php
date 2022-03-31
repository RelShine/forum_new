<?php
session_start();
$dbh = require_once 'connection.php';

$id_user = $_SESSION['id_user'];
$filename = $_FILES['upload_image']['name'];

$imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

$extensions_arr = array("jpg", "png");

if (in_array($imageFileType, $extensions_arr)) {

    if (move_uploaded_file($_FILES["upload_image"]["tmp_name"], '../upload/' . $filename)) {

        $image = addslashes(file_get_contents('../upload' . DIRECTORY_SEPARATOR . $filename));
        $insert = "UPDATE users SET avatar = '$image' WHERE id = '$id_user'";
        if (mysqli_query($connection, $insert)) {
            header("Location: ../index.php");
        } else {
            echo 'Ошибка: ' . mysqli_error($connection);
        }
    } else {
        echo 'Ошибка загрузки файла - ' . $_FILES['image']['name'] . '
';
    }
}
header("Location: ../pages/profile.php");