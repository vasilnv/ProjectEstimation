<?php
require_once("../../db/db.php");

try {
    $projectId = $_GET["project"];
    $db = new DB();
    $sql = "SELECT * FROM tasks WHERE project = :projectId";
    $connection = $db->getConnection();

    $statement = $connection->prepare($sql);
    $statement->execute(["projectId" => $projectId]);
    $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode($tasks);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
