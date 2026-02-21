<?php
declare(strict_types=1);
//Database connection settings 
$host = "localhost";
$db = "Time_Tracker";
$user = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$db";

try {
    //PDO connection 
    $pdo = new PDO($dsn, $user, $password);
    //Set the PDO error mode to exception 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) 
{   //If connection fails display error message
    echo "Connection failed: " . $e->getMessage();
}