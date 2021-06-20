<?php
require_once("../../classes/Task.php");

$projectId = $_GET["project"];
try {
    require_once("../../db/db.php");
    $taskSelector = new Task(null, $projectId, null, null, null);
    $tasks = $taskSelector->getAllTasksForProject();

    http_response_code(200);
    echo json_encode($tasks);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
