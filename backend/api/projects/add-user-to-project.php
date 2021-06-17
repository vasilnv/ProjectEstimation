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
    $username = $phpInput["username"];
    $projectId = (int) $phpInput["project"];

    if (!isset($_SESSION['role']) || !isset($_SESSION['userId'])) {
        sendUnauthorizedError();
    }

    if($_SESSION["role"] != "Admin" && $_SESSION["role"] != "Manager") {
        sendUnauthorizedError();
    }

    $db = new DB();
    $sql = "SELECT manager FROM projects WHERE id = :projectId";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);
    $statement->execute(["projectId" => $projectId]);
    $managerId = $statement->fetch()["manager"];

    if($_SESSION["role"] == "Manager" && $managerId != $_SESSION["userId"]) {
        sendUnauthorizedError();
    }



    $sql = "INSERT INTO user_projects (userId, projectId) SELECT id, :projectId FROM users WHERE username = :username";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectId" => $projectId, "username" => $username]);

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешно добавен служител към проект", "statusCode" => 200]);
    exit();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
    exit();
}
