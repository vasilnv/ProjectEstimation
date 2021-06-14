<?php
session_start();
$phpInput = json_decode(file_get_contents('php://input'), true);
$newCapacity = $phpInput["newCapacity"];

$userId= $_SESSION['userId'];

try {
    require_once ("../../db/db.php");
    $db = new DB();
    $sql = "UPDATE users SET capacity=:capacity WHERE id=:userId";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["capacity" => $newCapacity, "userId" => $userId]);
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешна промяна на работните часове"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при вход"]);
}


