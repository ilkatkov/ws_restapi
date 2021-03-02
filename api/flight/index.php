<?php
include_once "../functions/mysql.php";

// получаем данные
$from = $_GET['from'];
$to = $_GET['to'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$passengers = $_GET['passengers'];

header("Content-Type: application/json");

if (!empty($date2)){
    if (!empty($from) && !empty($to) && !empty($date1) && !empty($passengers)) {
        http_response_code(200);
        echo json_encode(array("data" => array("flights_to" => flights($from, $to, $date1, $date2), "flights_back"=> flights($to, $from, $date1, $date2)))) ;
    }
} else if (!empty($from) && !empty($to) && !empty($date1) && !empty($passengers)){
    http_response_code(200);
    echo json_encode(array("data" => array("flights_to" => flights($from, $to, $date1, ""), "flights_back" => array()))) ;
}
else {
    if (empty($from)){
        $errors["from"] = array("field from can not be blank");
    }
    if (empty($to)){
        $errors["to"] = array("field to can not be blank");
    }
    if (empty($date1)){
        $errors["date1"] = array("field date1 can not be blank");
    }
    if (empty($passengers)){
        $errors["passengers"] = array("field passengers can not be blank");
    }
    header("Content-Type: application/json");
    http_response_code(422);
    $result = array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors));
    echo json_encode($result);
}
