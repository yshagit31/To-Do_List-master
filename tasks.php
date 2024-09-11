<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "todolist";

// Create connection
$conn = new mysqli($servername, $username, $password, $database,3308);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// API endpoint to get all tasks
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        echo json_encode($tasks);
    } else {
        echo "No tasks found.";
    }
}

// API endpoint to add a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $task = $data['task'];
    $date = $data['date'];
    $priority = $data['priority'];
    $isDone = $data['isDone'];

    $sql = "INSERT INTO tasks (task, date, priority, isDone) VALUES ('$task', '$date', '$priority', '$isDone')";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $response = array("id" => $last_id, "task" => $task, "date" => $date, "priority" => $priority, "isDone" => $isDone);
        echo json_encode($response);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
