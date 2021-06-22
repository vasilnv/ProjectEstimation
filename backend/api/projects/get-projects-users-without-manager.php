<?php
require_once("../../db/db.php");
require_once("../../classes/Project.php");

try {
    $data=Project::getProjectsUsersWithoutManager();
    if (sizeof($data) != 0) {
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(200);
        echo json_encode([]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при взимането на проекти", "statusCode" => 500]);
}


