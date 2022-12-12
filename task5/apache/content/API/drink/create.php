<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";

include_once "../objects/drink.php";

$database = new Database();
$db = $database->getConnection();
$drink = new Drink($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->type)
) {
    $drink->name = $data->name;
    $drink->type = $data->type;

    $stmt = $drink->create();

    if ($stmt) {
        http_response_code(201);
        echo json_encode(array("message" => "Напиток добавлен"), JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Невозможно добавить напиток"), JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Данные неполные"), JSON_UNESCAPED_UNICODE);
}

