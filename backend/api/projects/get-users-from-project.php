<?php
require_once("../../classes/Project.php");

try {
    require_once("../../db/db.php");
    $projectId = $_GET["project"];
    $project = new Project($projectId, null, null);
    $users = $project->getUsers();
    $totalCapacity = $project->getProjectTotalUserCapacity($users);

    $tasks = $project->selectTasks();
    $projectEstimation = $project->getProjectEstimation(sizeof($tasks));

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "numberOfUsers" => sizeof($users), "totalCapacity"=>$totalCapacity, "estimatedTime" => $projectEstimation]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
