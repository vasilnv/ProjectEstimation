<?php
require_once("../../db/db.php");
$phpInput = json_decode(file_get_contents('php://input'), true);

$id = $phpInput["id"];
$name = $phpInput["name"];
$lastname = $phpInput["lastname"];
$username = $phpInput["username"];
$email = $phpInput["email"];
$position = $phpInput["position"];

try {
    $db = new DB();
    $sql = "UPDATE users set name='$name', lastname='$lastname', username='$username', email='$email', position='$position' where id='$id'";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($data) != 0) {
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Няма потрбител с това id", "statusCode" => 400]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при промяната на юзъри", "statusCode" => 500]);
}
