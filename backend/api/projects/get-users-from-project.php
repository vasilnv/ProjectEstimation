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

    $totalCapacity=0;
    for ($x = 0; $x < sizeof($users); $x++) {
        $userId = $users[$x]["userId"];
        $sql = "SELECT capacity FROM users WHERE id = :userId;";
        $connection = $db->getConnection();

        $statement = $connection->prepare($sql);
        $statement->execute(["userId" => $userId]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        $totalCapacity += $user["capacity"];
    }


    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "numberOfUsers" => sizeof($users), "totalCapacity"=>$totalCapacity]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
