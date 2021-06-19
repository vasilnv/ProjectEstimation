<?php
session_start();
require_once("../../classes/Project.php");
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

    $project = new Project($projectId, null, null);
    $managerId = $project->getProjectManagerId()["manager"];

    if($_SESSION["role"] == "Manager" && $managerId != $_SESSION["userId"]) {
        sendUnauthorizedError();
    }

    $db = new DB();
    $sql = "DELETE user_projects FROM user_projects JOIN users on user_projects.userId = users.id WHERE user_projects.projectId = :projectId AND users.username = :username";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectId" => $projectId, "username" => $username]);

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешно премахнат служител от проект", "statusCode" => 200]);
    exit();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
    exit();
}
