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

function flights($to, $from, $date1, $date2){
    $link = connectDB();
    $query_select = "SELECT * FROM airports WHERE iata = '" . mysqli_real_escape_string($link, $from) . "'";
    $result = mysqli_query($link, $query_select) or trigger_error(mysqli_error($link) . $query_select);
    for ($from_data = []; $row = mysqli_fetch_assoc($result); $from_data[] = $row);
    // var_dump($from_data);
    $query_select = "SELECT * FROM airports WHERE iata = '" . mysqli_real_escape_string($link, $to) . "'";
    $result = mysqli_query($link, $query_select) or trigger_error(mysqli_error($link) . $query_select);
    for ($to_data = []; $row = mysqli_fetch_assoc($result); $to_data[] = $row);
    // var_dump($to_data);
    $from_id = $from_data[0]['id'];
    $to_id = $to_data[0]['id'];
    $query_select = "SELECT id, flight_code, time_from, time_to, cost FROM flights WHERE from_id = '" .mysqli_real_escape_string($link, $from_id) . "' AND to_id = '" . mysqli_real_escape_string($link, $to_id) . "'";
    $result = mysqli_query($link, $query_select) or trigger_error(mysqli_error($link) . $query_select);


    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    // var_dump($data);
    $return_data = array();
    for ($flight = 0; $flight < count($data); $flight++){
    $flight_id = $data[$flight]['id'];
    $flight_code = $data[$flight]['flight_code'];
    $time_from = $data[$flight]['time_from'];
    $time_to = $data[$flight]['time_to'];
    $cost = $data[$flight]['cost'];
    array_push($return_data, array("flight_id" => $flight_id, "flight_code" => $flight_code, "from" => array("city" => $from_data[0]['city'], "airport" => $from_data[0]['name'], "iata" => $from, "date" => $date1, "time" => $time_from), "to" => array("city" => $to_data[0]['city'], "airport" => $to_data[0]['name'], "iata" => $to, "date" => $date2, "time" => $time_to), "cost" => (int)$cost, "availability" => 156));
    }
    return $return_data;
}
?>