<?php
session_start();

require_once("../../db/db.php");

$phpInput = json_decode(file_get_contents('php://input'), true);
$projectName = $phpInput["projectName"];

try {
    $db = new DB();
    $sql = "INSERT INTO projects (name, manager) VALUES (:projectName, :manager)";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectName" => $projectName, "manager" => $_SESSION['userId']]);

    http_response_code(201);
    echo json_encode(["status" => "SUCCESS", "message" => "Проект създаден успешно"]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
