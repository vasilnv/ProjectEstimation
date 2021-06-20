<?php
class DB {
    private $connection;

    function __construct() {
        $db_configs = parse_ini_file(__DIR__ . "/../../configs/db.ini");
        $host = $db_configs['host'];
        $name = $db_configs['name'];
        $username = $db_configs['user'];
        $password = $db_configs['pass'];

        $dsn = "mysql:host=$host; dbname=$name";

        $this->connection = new PDO($dsn, $username, $password);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
