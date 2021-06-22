<?php
session_start();
require_once("../../db/db.php");
require_once("../../classes/User.php");

function sendUnauthorizedError() {
    http_response_code(403);
    echo json_encode(["status" => "UNAUTHORIZED", "message" => "Липсват права!", "statusCode" => 403]);
    exit();
}

try {
    $phpInput = json_decode(file_get_contents('php://input'), true);

    $position = $phpInput["position"];
    $userId = $phpInput["userId"];

    if (!isset($_SESSION['role'])) {
        sendUnauthorizedError();
    }

    if($_SESSION["role"] != "Admin" && $_SESSION["position"] != "Manager") {
        sendUnauthorizedError();
    }

    $user = new User($userId, null, null, null, null, null, null, null, null);
    $user->changePosition($position);
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешна промяна на позицията"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при вход"]);
}





