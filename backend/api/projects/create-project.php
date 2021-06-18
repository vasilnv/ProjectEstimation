<?php
session_start();

require_once("../../db/db.php");

$phpInput = json_decode(file_get_contents('php://input'), true);
$projectName = $phpInput["projectName"];

try {
    $db = new DB();
    $sql = "SELECT * FROM projects WHERE name=:projectName";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectName" => $projectName]);
    $projectExist = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($projectExist) != 0) {
        http_response_code(409);
        echo json_encode(["status" => "ERROR", "message" => "Проект с такова име съществува", "statusCode" => 409]);
    } else {
        $sql = "INSERT INTO projects (name, manager) VALUES (:projectName, :manager)";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectName" => $projectName, "manager" => $_SESSION['userId']]);

        http_response_code(201);
        echo json_encode(["status" => "SUCCESS", "message" => "Проект създаден успешно"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
