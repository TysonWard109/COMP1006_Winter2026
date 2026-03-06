 <?php
 require "includes/connect.php";
 require "includes/header.php";
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
    
    
    
    
//Checks if form was submitted via post, if not show an error message and stop the script from running
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die ("Invalid request");
}

//Sanatize user input using filter_input and trim to remove any whitespace/
$title =trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
$author = trim(filter_input(INPUT_POST, 'author',FILTER_SANITIZE_SPECIAL_CHARS));
$rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
$review_text = trim(filter_input(INPUT_POST, 'review_text', FILTER_SANITIZE_SPECIAL_CHARS)); 

//SERVER SIDE VALIDATION
$errors = []; 
if ($title === null || $title === ''){
    $errors[] = 'Book title is required.';
 }
if ($author === null || $author === ''){
     $errors[] = 'Author name is required.';
}
if ($rating === null || $rating === false || $rating <1 || $rating >5){
    $errors [] = 'Rating must be a number between 1 and 5.';
 }
if ($review_text === null || $review_text === ''){
    $errors [] = 'Review text is required, Thank you for your feedback.';
}

//If we find any errors we will display them and stop the script from running and ask the user to fix them
if (!empty($errors)) {
    echo "<div class='alert alert-danger'><ul>";
    echo "<h2> Please fix the following errors: </h2>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul></div>";
    exit;
    }
 
//Prearing the sql statement with placeholders to prevent sql injection
$sql = "INSERT INTO reviews (title, author, rating, review_text) VALUES (:title, :author, :rating, :review_text)";

$stmt =$pdo ->prepare ($sql);


//Bind the user input to the placeholders in the sql statement
$stmt->bindParam (':title' , $title);
$stmt->bindParam (':author' , $author);
$stmt->bindParam (':rating' , $rating);
$stmt->bindParam (':review_text' , $review_text);

//Execute the statement to insert the data into the database
$stmt -> execute();



require "includes/header.php";
?>
<div class= "alert alert-success">
    <h2> Book review added succesfully! </h2>
    <p> Title <strong> <?=  htmlspecialchars ($title)?></strong> Written By<strong> <?= htmlspecialchars ($author)?> </strong> with a rating of <strong><?= htmlspecialchars ($rating)?> </strong> along with a review  <strong><?= htmlspecialchars ($review_text)?> </strong>.</p>
