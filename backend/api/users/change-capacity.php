<?php
session_start();
$phpInput = json_decode(file_get_contents('php://input'), true);
$newCapacity = $phpInput["newCapacity"];

try {

    if (!isset($_SESSION['userId'])) {
        http_response_code(401);
        echo json_encode(["status" => "UNAUTHORIZED", "message" => "Не си вписан в акаунт!", "statusCode" => 401]);
        exit();
    }

    if($newCapacity < 0) {
        http_response_code(422);
        echo json_encode(["status" => "UNPROCESSABLE DATA", "message" => "Работните часове трябва да са >= 0", "statusCode" => 422]);
        exit();
    }
    require_once ("../../db/db.php");
    require_once ("../../classes/User.php");
    $user = new User($_SESSION['userId'], null, null, null, null, null, null, null, null);
    $user->changeCapacity($newCapacity);
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешна промяна на работните часове"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при вход"]);
}


