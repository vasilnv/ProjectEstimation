<?php
require_once("../../classes/Task.php");

$id=$_GET["task"];
try {
    require_once("../../db/db.php");
    $task = new Task($id, null, null, null, null);
    $task->deleteTask();
    echo json_encode(["status" => "SUCCESS", "message" => "Успешно изтрита задача", "statusCode" => 200]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "ERROR", "message" => "Грешка при изтриване на задача", "statusCode" => 500]);
}

