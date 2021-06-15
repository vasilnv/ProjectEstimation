<?php
session_start();

require_once("../db/db.php");

$phpInput = json_decode(file_get_contents('php://input'), true);
$username = $phpInput["username"];
$password = $phpInput["password"];

try {
    $db = new DB();
    $sql = "SELECT users.id, users.name, users.lastname, users.username, roles.name as role, positions.name as position FROM users JOIN roles ON users.role = roles.id JOIN positions ON users.position = positions.id WHERE users.username = :username AND users.password = :password";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["username" => $username, "password" => $password]);
    $user = $statement->fetchAll(PDO::FETCH_ASSOC)[0];

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['firstname'] = $user['name'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['position'] = $user['position'];
        $_SESSION['userId'] = $user['id'];

        http_response_code(200);
        echo json_encode(["status" => "SUCCESS", "message" => "Успешeн вход"]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Грешно подадени данни"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при вход"]);
}
