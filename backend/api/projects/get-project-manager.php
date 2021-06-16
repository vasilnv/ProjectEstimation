<?php
require_once("../../db/db.php");

try {
    $projectId = $_GET["project"];
    $db = new DB();
    $sql = "SELECT manager FROM projects WHERE id = :projectId";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectId" => $projectId]);
    $managerId = $statement->fetch();

    $sql = "SELECT name FROM users WHERE id = :managerId;";
    $statement = $connection->prepare($sql);
    $statement->execute(["managerId" => $managerId["manager"]]);
    $managerName = $statement->fetch(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode(["status" => "SUCCESS", "managerName" => $managerName["name"]]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Internal server error"]);
}
