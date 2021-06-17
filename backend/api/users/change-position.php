<?php
session_start();
require_once("../../db/db.php");

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

    if($_SESSION["role"] != "Admin" && $_SESSION["role"] != "Manager") {
        sendUnauthorizedError();
    }

    $db = new DB();
    $sql = "UPDATE users set position=:position where id=:userId";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["position" => $position, "userId" => $userId]);
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешна промяна на позицията"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при вход"]);
}





