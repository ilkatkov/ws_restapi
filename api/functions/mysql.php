<?php
include_once "../config.php";

function register($first_name, $last_name, $phone, $password, $document_number){
    $link = connectDB();
    $query_insert = "INSERT INTO users (first_name, last_name, phone, password, document_number) VALUES ('" . mysqli_real_escape_string($link, $first_name) . "', '" . mysqli_real_escape_string($link, $last_name) . "', '" . mysqli_real_escape_string($link, $phone) . "', '" . mysqli_real_escape_string($link, $password) . "', '" . mysqli_real_escape_string($link, $document_number) . "')";
    mysqli_query(connectDB(), $query_insert);
}

?>