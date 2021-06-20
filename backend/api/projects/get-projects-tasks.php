<?php
require_once("../../db/db.php");
require_once("../../classes/Project.php");

try {
    $data=Project::getProjectsTasks();
    if (sizeof($data) != 0) {
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Няма проекти", "statusCode" => 400]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при взимането на проекти", "statusCode" => 500]);
}


