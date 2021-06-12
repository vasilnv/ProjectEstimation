<?php

class DB {
    private $connection;

    function __construct() {
        $host = "localhost";
        $name = "ProjectEstimation";
        $username = "root";
        $password = "";

        $dsn = "mysql:host=$host; dbname=$name";

        $this->connection = new PDO($dsn, $username, $password);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
