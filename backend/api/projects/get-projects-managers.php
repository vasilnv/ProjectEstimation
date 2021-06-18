<?php
require_once("../../db/db.php");

try {
    $db = new DB();
    $sql = "SELECT users.name as firstname, users.lastname, users.username, projects.name as projectName FROM projects JOIN users ON users.id = projects.manager";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
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


