<?php
require_once("../../db/db.php");
$phpInput = json_decode(file_get_contents('php://input'), true);

$userId = $phpInput["userId"];
$position = $phpInput["position"];

try {
    $db = new DB();
    $sql = "UPDATE users set position=:position where userId=:userId";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["userId" => $userId, "position" => $position]);
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешна промяна на позицията"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при вход"]);
}





