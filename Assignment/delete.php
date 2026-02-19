<?php 

require "includes/connect.php";

//Make sure we get an ID

if(!isset($_GET['id'])){
    die ("No task ID provided.");
}

$taskId = $_GET['id'];

//Delete the row 
$sql = "DELETE FROM tasks WHERE id = :id";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':id', $taskId);

$stmt-> execute();

//Redirect back to index
header("Location: index.php");
exit;