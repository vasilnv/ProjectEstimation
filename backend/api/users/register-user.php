<?php
require_once("../../classes/User.php");
require_once("../../db/db.php");
$phpInput = json_decode(file_get_contents('php://input'), true);
$firstname = $phpInput["firstname"];
$lastname = $phpInput["lastname"];
$username = $phpInput["username"];
$password = password_hash($phpInput["password"], PASSWORD_DEFAULT);
$email = $phpInput["email"];
$position = $phpInput["position"];

try {
    $db = new DB();
    $sql = "SELECT id FROM positions WHERE name = :position";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["position"=>$position]);
    $positionId = $statement->fetch();

    $user = new User(null, $firstname, $lastname, $username, $email, $password, 8, 0, $positionId["id"]);
    $user->registerUser();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при регистрация"]);
}
