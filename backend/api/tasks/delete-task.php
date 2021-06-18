<?php
require_once("../../db/db.php");

$id=$_GET["task"];
try {
    $db = new DB();
    $sql = "DELETE FROM tasks WHERE id = :task";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["task"=>$id]);
    $project = $statement->fetchAll(PDO::FETCH_ASSOC);
    $projectId = $project[0]['id'];
    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "message" => "Успешна регистрация", "statusCode" => 200]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при регистрация", "statusCode" => 500]);
}

