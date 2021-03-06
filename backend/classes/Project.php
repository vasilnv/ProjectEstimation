<?php


class Project
{
    public $id;
    public $name;
    public $manager;

    function __construct($id, $name, $manager) {
        $this->id = $id;
        $this->name = $name;
        $this->manager = $manager;
    }

    public function getProjectByName() {
        $db = new DB();
        $sql = "SELECT * FROM projects WHERE name=:projectName";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectName" => $this->name]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function checkIfProjectExists() {
        $projectData = $this->getProjectByName();
        $flag = false;
        if (sizeof($projectData) != 0) {
            $flag = true;
        }
        return $flag;
    }

    public function createProject() {
        $db = new DB();
        $sql = "INSERT INTO projects (name, manager) VALUES (:projectName, :manager)";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectName" => $this->name, "manager" => $_SESSION['userId']]);
    }

    public function getProjectName() {
        $db = new DB();
        $sql = "SELECT name FROM projects WHERE id = :projectId";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectId" => $this->id]);
        $projectName = $statement->fetch();
        return $projectName;

    }

    public function getProjectManager() {
        $db = new DB();
        $managerId = $this->getProjectManagerId();
        $connection = $db->getConnection();

        $sql = "SELECT name FROM users WHERE id = :managerId;";
        $statement = $connection->prepare($sql);
        $statement->execute(["managerId" => $managerId["manager"]]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getProjectManagerId() {
        $db = new DB();
        $sql = "SELECT manager FROM projects WHERE id = :projectId";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectId" => $this->id]);
        return $statement->fetch();
    }


    public function selectTasks() {
        $db = new DB();
        $sql = "SELECT id FROM tasks WHERE project = :projectId";
        $connection = $db->getConnection();

        $statement = $connection->prepare($sql);
        $statement->execute(["projectId" => $this->id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjectEstimation($numberOfTasks) {
        $db = new DB();

        $sql = "SELECT estimation FROM tasks WHERE project = :projectId";
        $connection = $db->getConnection();

        $statement = $connection->prepare($sql);
        $statement->execute(["projectId" => $this->id]);
        $estimations = $statement->fetchAll(PDO::FETCH_ASSOC);

        $projectTime = 0;

        for ($x = 0; $x < $numberOfTasks; $x++) {
            $projectTime += $estimations[$x]["estimation"];
        }
        return $projectTime;
    }

    public function getUsers() {
        $db = new DB();
        $sql = "SELECT userId FROM user_projects WHERE projectId = :projectId";
        $connection = $db->getConnection();

        $statement = $connection->prepare($sql);
        $statement->execute(["projectId" => $this->id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjectTotalUserCapacity($users) {
        $db = new DB();
        $totalCapacity=0;
        for ($x = 0; $x < sizeof($users); $x++) {
            $userId = $users[$x]["userId"];
            $sql = "SELECT capacity, weight FROM users JOIN positions ON position = positions.id WHERE users.id = :userId;";
            $connection = $db->getConnection();

            $statement = $connection->prepare($sql);
            $statement->execute(["userId" => $userId]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            $totalCapacity += $user["capacity"] * $user["weight"];
        }
        return $totalCapacity;
    }

    public static function getProjectsManagers() {
        $db = new DB();
        $sql = "SELECT users.name as firstname, users.lastname, users.username, projects.name as projectName FROM projects JOIN users ON users.id = projects.manager";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getProjectsTasks() {
        $db = new DB();
        $sql = "SELECT tasks.name as taskName, tasks.estimation, projects.name as projectName FROM projects JOIN tasks ON tasks.project = projects.id";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProjectsUsersWithoutManager() {
        $db = new DB();
        $sql = "SELECT users.name as firstname, users.lastname, users.username, projects.name as projectName FROM projects JOIN user_projects ON user_projects.projectId = projects.id AND user_projects.userId <> projects.manager JOIN users ON user_projects.userId = users.id;";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}