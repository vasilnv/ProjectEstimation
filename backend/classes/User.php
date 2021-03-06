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

    function __construct($id, $name, $lastName, $username, $email, $password, $role, $capacity, $position) {
        $this->id = $id;
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

    public function checkPassword() {
        $db = new DB();
        $sql = "SELECT password FROM users WHERE username = :username";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute(["username" => $this->username]);
        $passDB = $statement->fetch(PDO::FETCH_ASSOC);
        $flag = false;
        if (password_verify($this->password, $passDB['password'])) {
            $this->password = $passDB['password'];
            $flag=true;
        }
        return $flag;

    }

    public function login() {
        $db = new DB();
        $sql = "SELECT users.id, users.name, users.lastname, users.username, roles.name as role, positions.name as position FROM users JOIN roles ON users.role = roles.id JOIN positions ON users.position = positions.id WHERE users.username = :username AND users.password = :password";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["username" => $this->username, "password" => $this->password]);
        return $statement->fetch();
    }

    public function changeCapacity($newCapacity) {
        $db = new DB();
        $sql = "UPDATE users SET capacity=:capacity WHERE id=:userId";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["capacity" => $newCapacity, "userId" => $this->id]);
    }

    public function changeRole($newPosition) {
        $db = new DB();
        $sql = "UPDATE users set position=:position where id=:userId";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["position" => $newPosition, "userId" => $this->id]);
    }

//    public static function getUsers() {
//        $db = new DB();
//        $sql = "SELECT users.id, users.name, lastname, username, email, positions.name as position FROM users inner join positions on positions.id = users.position;";
//        $connection = $db->getConnection();
//        $statement = $connection->prepare($sql);
//
//        $statement->execute();
//        return $statement->fetchAll(PDO::FETCH_ASSOC);
//    }


}