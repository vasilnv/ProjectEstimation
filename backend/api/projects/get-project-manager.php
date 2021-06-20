<?php
require_once("../../classes/Project.php");

try {
    require_once("../../db/db.php");
    $projectId = $_GET["project"];
    $project = new Project($projectId, null, null);
    $managerName = $project->getProjectManager();
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "managerName" => $managerName["name"]]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
