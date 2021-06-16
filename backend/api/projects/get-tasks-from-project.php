<?php
require_once("../../db/db.php");

try {
    $projectId = $_GET["project"];
    $db = new DB();
    $sql = "SELECT id FROM tasks WHERE project = :projectId";
    $connection = $db->getConnection();

    $statement = $connection->prepare($sql);
    $statement->execute(["projectId" => $projectId]);
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT estimation FROM tasks WHERE project = :projectId";
    $connection = $db->getConnection();

    $statement = $connection->prepare($sql);
    $statement->execute(["projectId" => $projectId]);
    $estimations = $statement->fetchAll(PDO::FETCH_ASSOC);

    $projectTime =0;

    for ($x = 0; $x < sizeof($users); $x++) {
        $projectTime += $estimations[$x]["estimation"];
    }

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "numberOfTasks" => sizeof($users), "estimatedProjectTime" => $projectTime]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
