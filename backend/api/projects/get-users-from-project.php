<?php
require_once("../../db/db.php");

try {
    $projectId = $_GET["project"];
    $db = new DB();
    $sql = "SELECT userId FROM user_projects WHERE projectId = :projectId";
    $connection = $db->getConnection();

    $statement = $connection->prepare($sql);
    $statement->execute(["projectId" => $projectId]);
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);



    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "numberOfUsers" => sizeof($users)]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
