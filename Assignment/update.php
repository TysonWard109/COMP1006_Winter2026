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

//If a form is submitted, update the row

if($_SERVER['REQUEST_METHOD'] ==='POST'){
    //Basic sanitization

    $taskName = trim($_POST['task_name']?? '');
    $category = trim($_POST['category']?? '');
    $priority = trim($_POST['priority']?? '');
    $dueDate = trim($_POST['due_date']?? '');
    $timeSpent = trim($_POST['time_spent']?? 0);
    
    //Validation
    if($taskName === '' || $category === '' || $priority === ''){
    $error = "Task name, category and priority are required.";
    } else{
        $sql = "UPDATE tasks
        SET task_name = :task_name,
        category = :category,
        priority = :priority,
        due_date = :due_date,
        time_spent = :time_spent
        WHERE id = :id";
        
        $stmt = $pdo ->prepare($sql);

        // Bind parameters
        $stmt ->bindParam (':task_name', $taskName);
        $stmt ->bindParam (':category', $category);
        $stmt ->bindParam (':priority', $priority);
        $stmt ->bindParam (':due_date', $dueDate);
        $stmt ->bindParam (':time_spent', $timeSpent);
        $stmt ->bindParam (':id', $taskId);

        $stmt -> execute();

        // Redirect back to the index
        header("Location: index.php");
        exit;
    }
}

//Load existing task data

$sql = "SELECT * FROM tasks WHERE id = :id";
$stmt = $pdo-> prepare($sql);
$stmt -> bindParam (':id', $taskId);
$stmt ->execute();

$task = $stmt ->fetch();

if(!$task){
    die("Task not found.");
}
?>

<main class = "container mt-4">
    <h2>Update Task #<?= htmlspecialchars($task['id']); ?> </h2>

    <?php if (!empty($error)): ?>
        <p class="text-danger"><?= htmlspecialchars($error);?> </p>
    <?php endif; ?>

    <form method = "post">
        
        <label class = "form-label"> Task Name</label>
        <input type="text" name ="task_name" class="form-control mb-3"
        value ="<?= htmlspecialchars($task['task_name']); ?>"
        required>

        <label class = "form-label"> Category</label>
        <input type="text" name ="category" class="form-control mb-3"
        value ="<?= htmlspecialchars($task['category']); ?>"
        required>

        <label class = "form-label"> Priority</label>
        <input type="text" name ="priority" class="form-control mb-3"
        value ="<?= htmlspecialchars($task['priority']); ?>"
        required>

        <label class = "form-label"> Due Date</label>
        <input type="text" name ="due_date" class="form-control mb-3"
        value ="<?= htmlspecialchars($task['due_date']); ?>" >
        
        <label class = "form-label"> Time Spent(hours)</label>
        <input type="number" step="0.1" min="0" name="time_spent" class="form-control mb-4" value="<?= (float)$task['time_spent']; ?>">

        <button class= "btn btn-primary"Save Changes</button>
        <a href ="index.php" class ="btn btn-secondary"> Cancel</a>
        
    </form>
</main>

<?php require "includes/footer.php"; ?>