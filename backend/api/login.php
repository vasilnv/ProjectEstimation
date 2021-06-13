<?php
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
        setcookie('username', $user['username']);
        setcookie('firstname', $user['name']);
        setcookie('lastname', $user['lastname']);
        setcookie('role', $user['role']);
        setcookie('position', $user['position']);

        http_response_code(200);
        echo json_encode(["status" => "SUCCESS", "message" => "Успешeн вход", 'username' => $_SESSION['username']]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Грешно подадени данни", 'username' => $phpInput["username"]]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при вход"]);
}
