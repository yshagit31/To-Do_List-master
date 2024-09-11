<?php
include 'connection.php';
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$title = mysqli_real_escape_string($conn, trim($request->title));
$priority = mysqli_real_escape_string($conn, trim($request->priority));
$status = 'pending'; // Set status to 'pending' by default
$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO tasks (title, priority, status, created_at) VALUES ('{$title}', '{$priority}', '{$status}', '{$date}')";

if(mysqli_query($conn,$sql)) {
    http_response_code(201);
    $task = [
        'title' => $title,
        'priority' => $priority,
        'status' => $status,
        'created_at' => $date,
        'task_id' => mysqli_insert_id($conn)
    ];
    echo json_encode($task);
} else {
    http_response_code(422);
}

mysqli_close($conn);


?>





