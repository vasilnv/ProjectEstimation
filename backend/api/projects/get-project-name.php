<?php
require_once("../../classes/Project.php");

try {
    require_once("../../db/db.php");
    $projectId = $_GET["project"];
    $project = new Project($projectId, null, null);

    $projectName = $project->getProjectName();
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "projectName" => $projectName["name"]]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
