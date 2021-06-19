<?php
session_start();
require_once("../classes/User.php");

$phpInput = json_decode(file_get_contents('php://input'), true);
$username = $phpInput["username"];
$password = $phpInput["password"];

try {
    $user = new User(null, null, $username, null, $password, null, null, null);
    $isPasswordCorrect=$user->checkPassword();

    if ($isPasswordCorrect) {
        $loggedUser = $user->login();
        if ($loggedUser) {
            $_SESSION['username'] = $loggedUser['username'];
            $_SESSION['firstname'] = $loggedUser['name'];
            $_SESSION['lastname'] = $loggedUser['lastname'];
            $_SESSION['role'] = $loggedUser['role'];
            $_SESSION['position'] = $loggedUser['position'];
            $_SESSION['userId'] = $loggedUser['id'];

            http_response_code(200);
            echo json_encode(["status" => "SUCCESS", "message" => "Успешeн вход"]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "ERROR", "message" => "Грешно подадени данни"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => "ERROR", "message" => "Грешна парола"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при вход"]);
}
