<?php
include_once "../functions/mysql.php";

// получаем данные
$query = $_GET['query'];

// если запрос пустой, то будем передавать в result пустой массив
if (empty($query)){
    $airports = array();
}
else {
    $airports = searchAirports($query);
}

header("Content-Type: application/json");
http_response_code(200);
$result = array("data" => array("items" => $airports));
echo json_encode($result);

?>