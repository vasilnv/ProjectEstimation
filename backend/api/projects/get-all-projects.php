<?php

require_once("../db/db.php");

try {
    $db = new DB();
    $sql = "SELECT id, name, manager FROM projects;";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($data) != 0) {
        http_response_code(200);
        echo json_encode(["status" => "SUCCESS", "message" => $data]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Няма потрбители", "statusCode" => 400]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при взимането на юзъри", "statusCode" => 500]);
}


