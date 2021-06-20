<?php

class UsersProjects
{
    public $userId;
    public $projectId;

    function __construct($userId, $projectId) {
        $this->userId = $userId;
        $this->projectId = $projectId;
    }

    public function addUserToProject($username) {
        $db = new DB();
        $sql = "INSERT INTO user_projects (userId, projectId) SELECT id, :projectId FROM users WHERE username = :username";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectId" => $this->projectId, "username" => $username]);

    }
    public function deleteUserFromProject($username) {
        $db = new DB();
        $sql = "DELETE user_projects FROM user_projects JOIN users on user_projects.userId = users.id WHERE user_projects.projectId = :projectId AND users.username = :username";
        $connection = $db->getConnection();
        $statement = $connection->prepare($sql);

        $statement->execute(["projectId" => $this->projectId, "username" => $username]);

    }

}