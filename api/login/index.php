<?php
include_once "../functions/mysql.php";

// получаем данные
$phone = $_POST['phone'];
$password = $_POST['password'];

// если поля не пустые, то делаем запрос
if (!empty($phone) && !empty($password)) {
    $login = login($phone, $password);
    // если получаем один аккаунт, то выводим токен
    if ($login == 1) {
        $token = getToken($phone);
        $result = array("data" => array("token" => $token));
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode($result);
    }
    // иначе выводим ошибку о неверных данных
    else{
        header("Content-Type: application/json");
        http_response_code(401);
        $result = array("error" => array("code" => http_response_code(), "message" => "Unauthorized", "errors" => array("phone" => array("phone or password incorrect"))));
        echo json_encode($result);

    }
}
// иначе выводим ошибку о пропущенных полях
else if (empty($phone) || empty($password)) {
    if (empty($phone)) {
        $errors["phone"] = array("field phone can not be blank");
    }
    if (empty($password)) {
        $errors["password"] = array("field password can not be blank");
    }
    header("Content-Type: application/json");
    http_response_code(422);
    $result = array("error" => array("code" => http_response_code(), "message" => "Validation error", "errors" => $errors));
    echo json_encode($result);
}

