<?php
require_once("../../classes/Project.php");

try {
    require_once("../../db/db.php");
    $projectId = $_GET["project"];
    $project = new Project($projectId, null, null);

    $tasks = $project->selectTasks();

    $projectEstimation = $project->getProjectEstimation(sizeof($tasks));

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "numberOfTasks" => sizeof($tasks), "estimatedProjectTime" => $projectEstimation]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
