<?php
require_once("../../classes/Task.php");
require_once("../../classes/Project.php");
session_start();

$phpInput = json_decode(file_get_contents('php://input'), true);
$projectName = $phpInput["project"];
$name = $phpInput["name"];
$description = $phpInput["description"];
$estimation = $phpInput["estimation"];

function sendUnauthorizedError() {
    http_response_code(403);
    echo json_encode(["status" => "UNAUTHORIZED", "message" => "Липсват права!", "statusCode" => 403]);
    exit();
}

try {
    require_once("../../db/db.php");
    $project = new Project(null, $projectName, null);
    $projectData = $project->getProjectByName();

    if (!isset($_SESSION['role']) || !isset($_SESSION['userId'])) {
        sendUnauthorizedError();
    }

    if($_SESSION["role"] != "Admin" && $_SESSION["position"] != "Manager") {
        sendUnauthorizedError();
    }

    if($_SESSION["role"] != "Admin" && $_SESSION["position"] == "Manager" && $projectData[0]["manager"] != $_SESSION["userId"]) {
        sendUnauthorizedError();
    }

    if (sizeof($projectData) != 0) {
//        echo json_encode(["status" => "ERROR", "message" => "Няма такъв проект", "statusCode" => 400]);
        $task = new Task(null, $projectData[0]['id'], $name, $description, $estimation);
        $task->createTask();
        http_response_code(200);
        echo json_encode(["status" => "SUCCESS", "message" => "Успешна регистрация", "statusCode" => 200]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Няма такъв проект", "statusCode" => 400]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при регистрация", "statusCode" => 500]);
}
