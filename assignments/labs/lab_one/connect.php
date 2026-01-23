<?php
declare(strict_types=1);
//Database connection settings in a variable 
$host = "localhost";
$db = "lab_one";
$user = "root";
$password = "";
//Data source name, type of database, location and database name
$dsn = "mysql:host=$host;dbname=$db";

try {
    //PDO connection 
    $pdo = new PDO($dsn, $user, $password);
    //Set the PDO error mode to exception 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>Connected successfully</p>";
} catch (PDOException $e) 
{   die ("Database connection failed: " . $e->getMessage());
    //If connection fails display error message
    echo "Connection failed: " . $e->getMessage();
}