<?php
include 'connection.php';

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$taskId = mysqli_real_escape_string($conn, trim($request->taskId));

$sql = "DELETE FROM tasks WHERE task_id = '{$taskId}'";

if(mysqli_query($conn,$sql)) {
    http_response_code(204);
} else {
    http_response_code(422);
}

mysqli_close($conn);

?>
