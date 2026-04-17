<?php 

require "includes/connect.php";
require "includes/auth.php"; // checks if user is logged in, if not redirects to login page

//Make sure we get an ID

if(!isset($_GET['id'])){
    die ("No user ID provided.");
}

$userId = $_GET['id'];

//Delete the row 
$sql = "DELETE FROM tasks WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':user_id', $_SESSION['user_id']);

$stmt-> execute();

//Redirect back to index
header("Location: index.php");
exit;