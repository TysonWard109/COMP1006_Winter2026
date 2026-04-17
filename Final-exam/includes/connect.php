<?php
declare(strict_types=1);
//Datanase connection settings
$host = "localhost"; //Hostname
$db = "Gallery_App"; //Database name
$user = "root"; //Username
$password = ""; //Password

$dsn = "mysql:host=$host;dbname=$db";

//try to connect, if connected echo a yay!
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
//what happens if there is an error connecting 
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}