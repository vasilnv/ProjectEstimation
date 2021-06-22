<?php
session_start();

require_once("../../db/db.php");
require_once ("../../classes/Project.php");
$phpInput = json_decode(file_get_contents('php://input'), true);
$projectName = $phpInput["projectName"];

function sendUnauthorizedError() {
    http_response_code(403);
    echo json_encode(["status" => "UNAUTHORIZED", "message" => "Липсват права!", "statusCode" => 403]);
    exit();
}

try {
    if (!isset($_SESSION['role'])) {
        sendUnauthorizedError();
    }

    if($_SESSION["role"] != "Admin" && $_SESSION["position"] != "Manager") {
        sendUnauthorizedError();
    }

    $project = new Project(null, $projectName, null);

    $db = new DB();
    $isProjectCreated = $project->checkIfProjectExists();
    if ($isProjectCreated) {
        http_response_code(409);
        echo json_encode(["status" => "ERROR", "message" => "Проект с такова име съществува", "statusCode" => 409]);
    } else {
        $project->createProject();
        http_response_code(201);
        echo json_encode(["status" => "SUCCESS", "message" => "Проект създаден успешно"]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
