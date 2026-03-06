<?php

//Admin update page for tasks

require "includes/header.php";
require "includes/connect.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Grabs an id from the url

if(!isset($_GET['id'])){
    die("No task ID provided.");
}

$taskId = $_GET ['id'];

if($_SERVER['REQUEST_METHOD'] ==='POST'){
    //Basic sanitization

    $title = trim($_POST['title']?? '');
    $author = trim($_POST['author']?? '');
    $rating = trim($_POST['rating']?? '');
    $review_text = trim($_POST['review_text']?? '');
    
    //Validation
    if($title === '' || $author === '' || $rating === '' || $review_text === ''){
    $error = "Title, Author, Rating and a Review is required.";
    } else{
        $sql = "UPDATE reviews
        SET title = :title,
        author = :author,
        rating = :rating,
        review_text = :review_text,
        WHERE id = :id";
        
        $stmt = $pdo ->prepare($sql);

        // Bind parameters
        $stmt ->bindParam (':title', $title);
        $stmt ->bindParam (':author', $author);
        $stmt ->bindParam (':rating', $rating);
        $stmt ->bindParam (':review_text', $review_text);
        $stmt ->bindParam (':id', $taskId);

        $stmt -> execute();

        // Redirect back to the index
        header("Location: index.php");
        exit;
    }
}
//Load existing task data

$sql = "SELECT * FROM reviews WHERE id = :id";
$stmt = $pdo-> prepare($sql);
$stmt -> bindParam (':id', $taskId);
$stmt ->execute();

$task = $stmt ->fetch();

if(!$task){
    die("Task not found.");
}
?>


<main>
    <h2>Update review #<?= htmlspecialchars($task['id']); ?> </h2>

    <?php if (!empty($error)): ?>
        <p class="text-danger"><?= htmlspecialchars($error);?> </p>
    <?php endif; ?>
    
    <!-- Form pre-filled with existing data -->
    <form method = "post">
        
        <label class = "form-label"> Book title</label>
        <input type="text" name ="title" class="form-control mb-3"
        value ="<?= htmlspecialchars($task['title']); ?>"
        required>

        <label class = "form-label"> Author</label>
        <input type="text" name ="Author" class="form-control mb-3"
        value ="<?= htmlspecialchars($task['author']); ?>"
        required>

        <label class = "form-label"> Rating</label>
        <input type="text" name ="Rating" class="form-control mb-3"
        value ="<?= htmlspecialchars($task['rating']); ?>"
        required>

        <label class = "form-label"> Review Text</label>
        <input type="text" name ="review_text" class="form-control mb-3"
        value ="<?= htmlspecialchars($task['review_text']); ?>" >


        <button class= "btn btn-primary" type="submit">Save Changes</button>
        <a href ="index.php" class ="btn btn-secondary" type= "submit"> Cancel</a>

    </form>
</main>