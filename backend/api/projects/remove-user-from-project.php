<?php
session_start();
require_once("../../classes/Project.php");
require_once("../../db/db.php");
require_once("../../classes/UsersProjects.php");


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

    $usersProjects = new UsersProjects(null, $projectId);
    $usersProjects->deleteUserFromProject($username);

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешно премахнат служител от проект", "statusCode" => 200]);
    exit();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
    exit();
}
