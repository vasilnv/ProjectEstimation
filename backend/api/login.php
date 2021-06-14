<?php
session_start();

require_once("../db/db.php");

$phpInput = json_decode(file_get_contents('php://input'), true);
$username = $phpInput["username"];
$password = $phpInput["password"];

try {
    $db = new DB();
    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    $connection = $db->getConnection();
    $statement = $connection->prepare($sql);

    $statement->execute(["username" => $username, "password" => $password]);
    $user = $statement->fetch();

    if (sizeof($user) != 0) {
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
