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

}