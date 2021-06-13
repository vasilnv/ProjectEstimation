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
        setcookie('username', $user['username'], time() + 86400);
        setcookie('firstname', $user['name'], time() + 86400);
        setcookie('lastname', $user['lastname'], time() + 86400);
        setcookie('role', $user['role'], time() + 86400);
        setcookie('position', $user['position'], time() + 86400);

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
