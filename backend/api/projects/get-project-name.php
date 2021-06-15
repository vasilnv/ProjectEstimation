<?php
require_once("../../db/db.php");

try {
    $projectId = $_GET["project"];
    $db = new DB();
    $sql = "SELECT name FROM projects WHERE id = :projectId";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectId" => $projectId]);
    $projectName = $statement->fetch();

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "projectName" => $projectName["name"]]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
