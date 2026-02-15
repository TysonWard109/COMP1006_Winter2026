<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "includes/connect.php"; // connect to the database
require "includes/header.php";
//  TODO: connect to the database 

//   TODO: Grab form data (no validation or sanitization for this lab)
$first_name = $_POST ['first_name'];
$last_name = $_POST ['last_name'];
$email = $_POST ['email'];

/*
  1. Write an INSERT statement with named placeholders
  2. Prepare the statement
  3. Execute the statement with an array of values
  4.

*/
//This is my inset statement with named placeholders
$sql = "INSERT INTO subscribers (first_name, last_name, email) VALUES (:first_name,
:last_name, :email)";

//This is my prepare statement
$stmt = $pdo -> prepare($sql);

//This is my execute statement with an array of values
$stmt -> execute([
    ':first_name' => $first_name,
    ':last_name' => $last_name,
    ':email' => $email
]);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <main class="container mt-4">
        <h2>Thank You for Subscribing</h2>

        <!-- TODO: Display a confirmation message -->
        <!-- Example: "Thanks, Name! You have been added to our mailing list." -->
        <p>Thank you <?= $first_name ?> <?= $last_name?> you have been added to our mailing list!</p>

        <p class="mt-3">
            <a href="subscribers.php">View Subscribers</a>
        </p>
    </main>
</body>
<?php include "includes/footer.php"; ?>
</html>