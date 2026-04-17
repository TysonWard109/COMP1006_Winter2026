<?php
require "includes/auth.php"; // checks if user is logged in, if not redirects to login page

$user_id = $_SESSION['user_id'];

require "includes/connect.php"; // connection to database

require "includes/header.php"; // header file with bootstrap and navigation
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Checks if form was submitted via post, if not show an error message and stop the script from running
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}



//Sanitize user input using filer_input and trim to remove whitespace
$title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));


//Image upload handling
$errors = [];


$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] !==UPLOAD_ERR_NO_FILE) {
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK){
        $errors[] = "Error uploading file.";
    } else{

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        $detectedType = mime_content_type($_FILES['image']['tmp_name']);

        if (!in_array($detectedType, $allowedTypes)){
            $errors[] = "Invalid file type. Only JPG, PNG and WEBP are allowed.";
        } else {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $safeFilename = uniqid('task_', true) . '.' . strtolower($extension);
            $destination = __DIR__ . '/uploads/' . $safeFilename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                $imagePath = 'uploads/' . $safeFilename;
            } else {
                $errors[] = "Failed to move uploaded file.";
            }
        }
    }
}


//Server side validation

if ($title === null || $title === '' ) {
    $errors[] = "Title is required.";
}
if ($imagePath === null) {
    $errors[] = "Image is required.";
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
$sql = "INSERT INTO tasks (title, image_path) VALUES (:title, :image_path)";

$stmt =$pdo ->prepare ($sql);

//Bind the user input to the placeholders in the sql statement
$stmt->bindParam (':title', $title);
$stmt->bindParam (':image_path' , $imagePath);

//Execute the statement to insert the data into the database
$stmt -> execute();

//Confirmation message and a link back to the main page
require "includes/header.php";
?>
<div class= "alert alert-success">
    <h2> Image Added Succesfully! </h2>
    <p> Image <strong> <?=  htmlspecialchars ($title)?></strong> has been added under Images<strong> </p>


    
    <?php if ($imagePath): // If an image is uploaded show a message about the image being uploaded succesfully?>
        <p> An image was uploaded for this task. </p>
        <img src="<?= htmlspecialchars($imagePath); ?>" alt="Task Image" width="100" height="100">
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary" type="submit">Back to Task List</a>
</div>
<?php
// require "includes/footer.php";
?>