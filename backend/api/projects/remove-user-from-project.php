<?php
session_start();
require_once("../../db/db.php");

try {

    $phpInput = json_decode(file_get_contents('php://input'), true);
    $username = $phpInput["username"];
    $projectId = (int) $phpInput["project"];

    if (!$_SESSION["role"] || !$_SESSION["userId"]) {
        http_response_code(403);
        echo json_encode(["status" => "UNAUTHORIZED", "message" => "Липсват права!", "statusCode" => 403]);
        exit();
    }

    if($_SESSION["role"] != "Admin" && $_SESSION["role"] != "Manager") {
        http_response_code(403);
        echo json_encode(["status" => "UNAUTHORIZED", "message" => "Липсват права!", "statusCode" => 403]);
        exit();
    }

    $db = new DB();
    $sql = "SELECT manager FROM projects WHERE id = :projectId";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);
    $statement->execute(["projectId" => $projectId]);
    $managerId = $statement->fetch()["manager"];

    if($_SESSION["role"] == "Manager" && $managerId != $_SESSION["userId"]) {
        http_response_code(403);
        echo json_encode(["status" => "UNAUTHORIZED", "message" => "Липсват права!", "statusCode" => 403]);
        exit();
    }



    $sql = "DELETE user_projects FROM user_projects JOIN users on user_projects.userId = users.id WHERE user_projects.projectId = :projectId AND users.username = :username";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectId" => $projectId, "username" => $username]);

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешно премахнат служител от проект", "statusCode" => 200]);
    exit();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
    exit();
}
