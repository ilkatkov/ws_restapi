<?php
include_once "../functions/mysql.php";

// получаем данные
$from = $_POST['flight_from'];
$back = $_POST['flight_back'];
$passengers = $_POST['passengers'];
// var_dump($from);
// var_dump($back);
// var_dump($passengers);

header("Content-Type: application/json");

if (!empty($passengers)) {
    $valid_passengers = true;
    for ($row = 0; $row < count($passengers); $row++) {
        // var_dump($passengers[$row]['document_number']);
        if (strlen($passengers[$row]['document_number']) != 10 || empty($passengers[$row]['birth_date']) || empty($passengers[$row]['first_name']) || empty($passengers[$row]['last_name'])) {
            $valid_passengers = false;
            break;
        }
    }
}

// если все поля не пустые, то отправляем запрос
if (!empty($from['id']) && !empty($back['id']) && !empty($from['date']) && !empty($back['date']) && !empty($passengers) && $valid_passengers) {
    http_response_code(201);
    $result = array("data" => array("code" => booking($from, $back)));
    // иначе отдаем ошибки
} else {
    $document_number_errors = array();
    if (strlen($from['id']) == 0) {
        $errors["flight_from"] = array("field flight_from id can not be blank");
    }
    if (strlen($from['date']) == 0) {
        $errors["flight_from"] = array("field flight_from date can not be blank");
    }

    if (strlen($back['id']) == 0) {
        $errors["flight_back"] = array("field flight_back id can not be blank");
    }
    if (strlen($back['date']) == 0) {
        $errors["flight_back"] = array("field flight_back date can not be blank");
    }

    if (empty($passengers)) {
        $errors["passengers"] = array("field passengers can not be blank");
    }
    if (!empty($passengers)) {
        for ($row = 0; $row < count($passengers); $row++) {
            if (empty($passengers[$row]['document_number'])) {
                array_push($document_number_errors, "field document_number in passenger " . (string)($row + 1) .  " can not be blank");
            }
            if (strlen($passengers[(string)$row]['document_number']) != 10) {
                array_push($document_number_errors, "document_number in passenger " . (string)($row + 1) .  " should be 10 digits!");
            }
            if (empty($passengers[$row]['birth_date'])) {
                array_push($document_number_errors, "field birth_date in passenger " . (string)($row + 1) .  " can not be blank");
            }
            if (empty($passengers[$row]['first_name'])) {
                array_push($document_number_errors, "field first_name in passenger " . (string)($row + 1) .  " can not be blank");
            }
            if (empty($passengers[$row]['last_name'])) {
                array_push($document_number_errors, "field last_name in passenger " . (string)($row + 1) .  " can not be blank");
            }
        }
    }
    if (count($document_number_errors) != 0) {
        $errors["document_number"] = $document_number_errors;
    }
    // header("Content-Type: application/json");
    http_response_code(422);
    $result = array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors));
}
echo json_encode($result);
// var_dump($result);
