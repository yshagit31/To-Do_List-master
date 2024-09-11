<?php
include 'connection.php';

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$taskId = mysqli_real_escape_string($conn, trim($request->taskId));
$status = mysqli_real_escape_string($conn, trim($request->status));

// $status = $status ? 'completed' : 'pending';
$status = ($status === 'completed') ? 'pending' : 'completed';

$sql = "UPDATE tasks SET status = '{$status}' WHERE task_id = '{$taskId}'";

if(mysqli_query($conn,$sql)) {
    http_response_code(200);
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(422);
    echo json_encode(['status' => 'error']);
}

mysqli_close($conn);
?>
