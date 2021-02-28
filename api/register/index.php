<?php
include_once "../functions/mysql.php";

$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$phone = $_GET['phone'];
$password = $_GET['password'];
$document_number = $_GET['document_number'];


if (!empty($first_name) && !empty($last_name) && !empty($phone) && !empty($document_number) && strlen($document_number) == 10 && !empty($password)) {
    http_response_code(204);
    register($first_name, $last_name, $phone, $password, $document_number);
} else {
    $errors = array();
    if (empty($first_name)){
        array_push($errors, "Empty first_name!");
    }
    if (empty($last_name)){
        array_push($errors, "Empty last_name!");
    }
    if (empty($phone)){
        array_push($errors, "Empty phone!");
    }
    if (empty($password)){
        array_push($errors, "Empty password!");
    }
    if (empty($document_number)){
        array_push($errors, "Empty document_number!");
    }
    if (strlen($document_number) != 10){
        array_push($errors, "document_number should be 10 digits!");
    }
    header("Content-Type: application/json");
    http_response_code(422);
    $result = array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors));
    
    echo json_encode($result);
}
