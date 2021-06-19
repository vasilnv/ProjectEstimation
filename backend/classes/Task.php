<?php


class Task
{
    public $id;
    public $project;
    public $name;
    public $description;
    public $estimation;

    function __construct($id, $project, $name, $description, $estimation)
    {
        $this->id = $id;
        $this->project = $project;
        $this->name = $name;
        $this->description = $description;
        $this->estimation = $estimation;
    }

    public function createTask() {
        $db = new DB();
        $sql = "INSERT INTO tasks (project, name, description, estimation) VALUES (:project, :name, :description, :estimation);";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute(["project" => $this->project, "name" => $this->name, "description" => $this->description, "estimation" => $this->estimation]);
    }

    public function deleteTask() {
        $db = new DB();
        $sql = "DELETE FROM tasks WHERE id = :task";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["task"=>$this->id]);
    }

    public function getAllTasksForProject() {
        $db = new DB();
        $sql = "SELECT * FROM tasks WHERE project = :projectId";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute(["projectId" => $this->project]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

}