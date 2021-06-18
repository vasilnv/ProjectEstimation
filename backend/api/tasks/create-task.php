<?php
require_once("../../db/db.php");
$phpInput = json_decode(file_get_contents('php://input'), true);
$projectName = $phpInput["project"];
$name = $phpInput["name"];
$description = $phpInput["description"];
$estimation = $phpInput["estimation"];

try {
    $db = new DB();
    $sql = "SELECT * FROM projects WHERE name = :projectname";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["projectname"=>$projectName]);
    $project = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($project) != 0) {
        $projectId = $project[0]['id'];
        $sql = "INSERT INTO tasks (project, name, description, estimation) VALUES (:project, :name, :description, :estimation);";
        $db = new DB();
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute(["project"=>$projectId, "name" => $name, "description" => $description, "estimation" => $estimation]);

        http_response_code(200);
        echo json_encode(["status" => "SUCCESS", "message" => "Успешна регистрация", "statusCode" => 200]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Няма такъв проект", "statusCode" => 400]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при регистрация", "statusCode" => 500]);
}
