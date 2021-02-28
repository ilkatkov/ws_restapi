<?php
function connectDB()
{
    // установка часового пояса
    date_default_timezone_set('Europe/Moscow');

    // настройки БД
    $host = 'localhost';
    $user = 'root';
    $password = 'password';
    $db_name = 'ws_rest_api';

    // подключение к БД и установка кодировки
    $link = mysqli_connect($host, $user, $password, $db_name);
    mysqli_query($link, "SET NAMES 'utf8mb4'");
    mysqli_query($link, "SET CHARACTER SET 'utf8mb4'");
    mysqli_query($link, "SET SESSION collation_connection = 'utf8mb4_general_ci'");
    return $link;
}
?>