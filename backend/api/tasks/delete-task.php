<?php
session_start();

require_once("../../classes/Task.php");
require_once("../../classes/Project.php");

function sendUnauthorizedError() {
    http_response_code(403);
    echo json_encode(["status" => "UNAUTHORIZED", "message" => "Липсват права!", "statusCode" => 403]);
    exit();
}

$id=$_GET["task"];
try {
    require_once("../../db/db.php");
    $task = new Task($id, null, null, null, null);
    
    $projectId = $task->getTaskProjectById();
    $project = new Project($projectId, null, null);
    $managerId = $project->getProjectManagerId()["manager"];

    if (!isset($_SESSION['role']) || !isset($_SESSION['userId'])) {
        echo $_SESSION['role'];
        sendUnauthorizedError();
    }

    if($_SESSION["role"] != "Admin" && $_SESSION["position"] != "Manager") {
        sendUnauthorizedError();
    }

    if($_SESSION["role"] != "Admin" && $_SESSION["position"] == "Manager" && $managerId != $_SESSION["userId"]) {
        sendUnauthorizedError();
    }

    $task->deleteTask();
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешно изтрита задача", "statusCode" => 200]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при изтриване на задача", "statusCode" => 500]);
}

