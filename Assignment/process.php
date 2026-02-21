<?php
require "includes/connect.php"; // connection to database
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Checks if form was submitted via post, if not show an error message and stop the script from running
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

// Validate reCAPTCHA
$recaptchaSecret = "6LfMwnIsAAAAABiivprQ0QUzxbdeYPs27qTd8jpg";
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptchaResponse)) {
    die("Please complete the reCAPTCHA.");
}

$verify = file_get_contents(
    "https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse"
);

$responseData = json_decode($verify);

if (!$responseData->success) {
    die("reCAPTCHA verification failed.");
}


//Sanitize user input using filer_input and trim to remove whitespace
$task_name = trim(filter_input(INPUT_POST, 'task_name', FILTER_SANITIZE_SPECIAL_CHARS));
$category = trim(filter_input(INPUT_POST, 'category',
FILTER_SANITIZE_SPECIAL_CHARS));
$priority = trim(filter_input(INPUT_POST, 'priority', FILTER_SANITIZE_SPECIAL_CHARS));
$due_date = $_POST['due_date'];
$time_spent = filter_input(INPUT_POST, 'time_spent', FILTER_VALIDATE_FLOAT);

//Server side validation
$errors = [];

if ($task_name === null || $task_name === '' ) {
    $errors[] = "Task Name is required.";
}
if ($category === null || $category === '') {
    $errors [] = "Category is required.";
}
if ($priority === null || $priority === '') {
    $errors [] = "Priority is required.";
}
if ($due_date === null || $due_date === '') {
    $errors [] = "Due Date is required.";
}
if ($time_spent === null || $time_spent === false) {
    $errors [] = "Time spent must be a valid numeber.";
}

// If there are any errors display them and stop the script
if (!empty($errors)) { 
    require "includes/header.php";
    echo "<div class='alert alert-danger'><ul>";
    echo "<h2> Please fix the following errors: </h2>";
    echo "<ul>";
    foreach ($errors as $error) { 
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "</div>";
    require "includes/footer.php";
    exit;
}

//Prearing the sql statement with placeholders to prevent sql injection
$sql = "INSERT INTO tasks (task_name, category, priority, due_date, time_spent) VALUES (:task_name, :category, :priority, :due_date, :time_spent)";

$stmt =$pdo ->prepare ($sql);

//Bind the user input to the placeholders in the sql statement
$stmt->bindParam (':task_name' , $task_name);
$stmt->bindParam (':category' , $category);
$stmt->bindParam (':priority' , $priority);
$stmt->bindParam (':due_date' , $due_date);
$stmt->bindParam (':time_spent' , $time_spent);

//Execute the statement to insert the data into the database
$stmt -> execute();

//Confirmation message and a link back to the main page
require "includes/header.php";
?>
<div class= "alert alert-success">
    <h2> Task Added Succesfully! </h2>
    <p> Task <strong> <?=  htmlspecialchars ($task_name)?></strong> has been added under category<strong> <?= htmlspecialchars ($category)?> </strong> with priority <strong><?= htmlspecialchars ($priority)?> </strong> and is due on <strong><?= htmlspecialchars ($due_date)?> </strong>. You have spent <strong><?= htmlspecialchars ($time_spent)?> </strong> hours on this task. </p>
    <a href="index.php" class="btn btn-primary" type="submit">Back to Task List</
</div>
<?php
// require "includes/footer.php";
?>