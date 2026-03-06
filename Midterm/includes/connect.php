<?php
declare(strict_types=1);
//Datanase connection settings
$host="localhost";
$db="book_manager";
$user="root";
$password="";


$dsn = "mysql:host=$host;dbname=$db";

try{
    //PDO Connection
    $pdo = new PDO ($dsn, $user, $password);
    //Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) 
{   //If connection fails display error message
    echo "Connection failed: " . $e->getMessage();
}