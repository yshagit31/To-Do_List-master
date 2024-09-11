<?php
include 'connection.php';
$sql = "SELECT * FROM tasks";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $tasks = array();
    while($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
    echo json_encode($tasks);
} else {
    echo json_encode(array());
}
mysqli_close($conn);
?>
