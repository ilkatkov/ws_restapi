<?php
include_once "../functions/mysql.php";

// получаем данные
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$document_number = $_POST['document_number'];

// если все поля не пустые и длина документа == 10, то отправляем запрос
if (!empty($first_name) && !empty($last_name) && !empty($phone) && !empty($document_number) && strlen($document_number) == 10 && !empty($password)) {
    http_response_code(204);
    register($first_name, $last_name, $phone, $password, $document_number);
// иначе отдаем ошибки
} else {
    $document_number_errors = array();
    if (strlen($first_name) == 0){
        $errors["first_name"] = array("field first_name can not be blank");
    }
    if (empty($last_name)){
        $errors["last_name"] = array("field last_name can not be blank");
    }
    if (empty($phone)){
        $errors["phone"] = array("field phone can not be blank");
    }
    if (empty($password)){
        $errors["password"] = array("field password can not be blank");
    }
    if (empty($document_number)){
        array_push($document_number_errors, "field document_number can not be blank");
    }
    if (strlen($document_number) != 10){
        array_push($document_number_errors, "document_number should be 10 digits!");
    }
    if (count($document_number_errors) != 0){
        $errors["document_number"] = $document_number_errors;
    }
    header("Content-Type: application/json");
    http_response_code(422);
    $result = array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors));
    echo json_encode($result);
}
