<<<<<<< HEAD
<?php
declare(strict_types=1);

$host = "localhost";//hostname
$db = "week_two";//database name
$user = "root";//username
$password = "";//password
=======
<?php 
declare(strict_types=1); 

$host = "localhost"; //hostname
$db = "week_two"; //database name
$user = "root"; //username
$password = ""; //password
>>>>>>> 1a34152f2636dd2ad897ed74d8dd6a77e49b6821

//points to the database
$dsn = "mysql:host=$host;dbname=$db";

<<<<<<< HEAD
//try to connect, if connect yay
try{
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p> YAY CONNECTED </p>";
}
//what happens if there is an error connecting
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
=======
//try to connect, if connected echo a yay!
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   echo "<p> YAY CONNECTED! </p>"; 
}
//what happens if there is an error connecting 
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
>>>>>>> 1a34152f2636dd2ad897ed74d8dd6a77e49b6821
}

