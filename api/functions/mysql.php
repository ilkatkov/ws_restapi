<?php
include_once "../config.php";

function register($first_name, $last_name, $phone, $password, $document_number){
    $link = connectDB();
    $query_insert = "INSERT INTO users (first_name, last_name, phone, password, document_number) VALUES ('" . mysqli_real_escape_string($link, $first_name) . "', '" . mysqli_real_escape_string($link, $last_name) . "', '" . mysqli_real_escape_string($link, $phone) . "', '" . mysqli_real_escape_string($link, $password) . "', '" . mysqli_real_escape_string($link, $document_number) . "')";
    mysqli_query($link, $query_insert);
}
function getToken($phone){
    return md5(microtime() + $phone + time());
}
function login($phone, $password){
    $link = connectDB();
    $query_select = "SELECT id FROM `users` WHERE `phone` LIKE '" . mysqli_real_escape_string($link, $phone) . "' AND `password` LIKE '" . mysqli_real_escape_string($link, $password) . "'";
    //$query_select = "SELECT * FROM `users` WHERE `id` = 3 AND `first_name` LIKE 'Ilya'";
    // var_dump($query_select);
    $result = mysqli_query($link, $query_select) or trigger_error(mysqli_error($link) . $query_select);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    return count($data);
}
?>