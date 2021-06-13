<?php
require_once("../db/db.php");
$phpInput = json_decode(file_get_contents('php://input'), true);
$firstname = $phpInput["firstname"];
$lastname = $phpInput["lastname"];
$username = $phpInput["username"];
$password = $phpInput["password"];
$email = $phpInput["email"];
$role = $phpInput["role"];
$position = $phpInput["position"];

try {
    $db = new DB();
    $sql = "SELECT * FROM users WHERE username = :username";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["username"=>$username]);
    $user = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (sizeof($user) == 0) {
        $sql = "INSERT INTO users (name, lastname, username, password, email, role, position, capacity) VALUES (:name, :lastname, :username, :password, :email, 6, 1, 0);";
        $db = new DB();
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute(["name"=>$firstname, "lastname" => $lastname, "username" => $username, "password" => $password, "email" => $email]);

        echo json_encode(["status" => "SUCCESS", "message" => "Успешна регистрация"]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Грешни подадени данни"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при регистрация"]);
}
