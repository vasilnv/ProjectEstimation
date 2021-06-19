<?php
require_once("../classes/User.php");
$phpInput = json_decode(file_get_contents('php://input'), true);
$firstname = $phpInput["firstname"];
$lastname = $phpInput["lastname"];
$username = $phpInput["username"];
$password = password_hash($phpInput["password"], PASSWORD_DEFAULT);
$email = $phpInput["email"];
$role = $phpInput["role"];
$position = $phpInput["position"];

try {
    $user = new User($firstname, $lastname, $username, $email, $password, $role, 0, $position);
    $user->registerUser();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при регистрация"]);
}
