<?php
require_once("../../db/db.php");

try {
    $projectId = $_GET["project"];
    $db = new DB();
    $sql = "SELECT t1.username, t1.name, t1.lastname, SUM(isProject) as isInProject FROM (SELECT username, name, lastname, CASE WHEN user_projects.projectId = :projectId THEN 1 ELSE 0 END AS isProject FROM users LEFT JOIN user_projects ON user_projects.userId = users.id) as t1 GROUP BY username";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectId" => $projectId]);
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($data) != 0) {
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(["status" => "ERROR", "message" => "Няма такъв проект", "statusCode" => 404]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
