<?php


class Project
{
    public $id;
    public $name;
    public $manager;

    function __construct($name, $manager) {
        $this->name = $name;
        $this->manager = $manager;
    }

    public function checkIfProjectExists() {
        require_once("../../db/db.php");
        $db = new DB();
        $sql = "SELECT * FROM projects WHERE name=:projectName";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectName" => $this->name]);
        $projectExist = $statement->fetchAll(PDO::FETCH_ASSOC);
        $flag = false;
        if (sizeof($projectExist) != 0) {
            $flag = true;
        }
        return $flag;
    }

    public function createProject() {
        require_once("../../db/db.php");
        $db = new DB();
        $sql = "INSERT INTO projects (name, manager) VALUES (:projectName, :manager)";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectName" => $this->name, "manager" => $_SESSION['userId']]);

    }
}