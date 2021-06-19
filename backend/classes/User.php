<?php


class User
{
    public $id;
    public $name;
    public $lastName;
    public $username;
    public $email;
    public $password;
    public $role;
    public $capacity;
    public $position;

    function __construct($name, $lastName, $username, $email, $password, $role, $capacity, $position) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->capacity = $capacity;
        $this->position = $position;
    }

    public function registerUser() {
        require_once("../db/db.php");
        $db = new DB();
        $sql = "SELECT * FROM users WHERE username = :username";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["username"=>$this->username]);
        $user = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($user) == 0) {
            $sql = "INSERT INTO users (name, lastname, username, password, email, role, position, capacity) VALUES (:name, :lastname, :username, :password, :email, 6, 1, 0);";
            $connection = $db->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute(["name"=>$this->name, "lastname" => $this->lastName, "username" => $this->username, "password" => $this->password, "email" => $this->email]);
            echo json_encode(["status" => "SUCCESS", "message" => "Успешна регистрация"]);
        } else {
            http_response_code(400);
            echo json_encode(["status" => "ERROR", "message" => "Грешни подадени данни"]);
        }

    }


}