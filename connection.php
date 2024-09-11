<?php
$conn = mysqli_connect('localhost', 'root', '', 'todolist',3308);
if (!$conn) {
    
    die("Error while connecting...!" . mysqli_connect_error($conn));
} 

?>