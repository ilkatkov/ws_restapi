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
    $result = mysqli_query($link, $query_select) or trigger_error(mysqli_error($link) . $query_select);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    return count($data);
}

function searchAirports($string){
    $link = connectDB();
    $query_select = "SELECT name, iata FROM `airports` WHERE `name` LIKE '%" . mysqli_real_escape_string($link, $string) . "%' OR `iata` LIKE '%" . mysqli_real_escape_string($link, $string) . "%' OR `city` LIKE '%" . mysqli_real_escape_string($link, $string) . "%'";
    $result = mysqli_query($link, $query_select) or trigger_error(mysqli_error($link) . $query_select);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    return $data;
}
?>