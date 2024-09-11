<?php
include 'connection.php';
// Query to get the count of tasks for each priority
$sql = "SELECT priority, COUNT(*) as count FROM tasks GROUP BY priority";
$result = mysqli_query($conn, $sql);

$taskCounts = [
    'high' => 0,
    'medium' => 0,
    'low' => 0
];

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        switch ($row['priority']) {
            case 'High':
                $taskCounts['high'] = (int) $row['count'];
                break;
            case 'Medium':
                $taskCounts['medium'] = (int) $row['count'];
                break;
            case 'Low':
                $taskCounts['low'] = (int) $row['count'];
                break;
        }
    }
}

echo json_encode($taskCounts);

mysqli_close($conn);
?>
