<?php

try {
    $dbh = new PDO('mysql:host=localhost;dbname=z904372i_dark', 'z904372i_dark', 'sansanich2281337Q');
} catch (PDOException $e) {
    die('Ошибка: ' . $e->getMessage());
}

return $dbh;