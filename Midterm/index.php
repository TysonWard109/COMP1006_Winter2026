<?php require "includes/connect.php"; ?>
<?php require "includes/header.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Review Submission</title>
</head>
<body>

    <h1>Submit a Book Review</h1>

    <form action="process.php" method="POST">

        <label for="title">Book Title:</label>
        <input type="text" id="title" name="title">

        <label for="author">Author:</label>
        <input type="text" id="author" name="author">

        <label for="rating">Rating (1 to 5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5">

        <label for="review_text">Review:</label>
        <textarea id="review_text" name="review_text" rows="6" cols="40"></textarea>

        <button type="submit">Submit Review</button>

    </form>

    <?php
    $sql = "SELECT * FROM reviews ORDER BY title ASC";
    $stmt = $pdo->query($sql);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <tbody>
      <!-- foreach loop to display the tasks in the table  -->
      <?php foreach ($tasks as $task): ?>
        <tr>
          <td><?= htmlspecialchars($task['title']); ?></td>
          <td><?= htmlspecialchars($task['author']); ?></td>
          <td><?= htmlspecialchars($task['rating']); ?></td>
          <td><?= htmlspecialchars($task['review_text']); ?></td>
            <!-- Buttons to edit and delete the task -->
            <a href="update.php?id=<?= $task['id']; ?>">Edit</a> |
            <a href="delete.php?id=<?= $task['id']; ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    
    <p>
        <a href="admin.php">Go to Admin Page</a>
    </p>

</body>
</html>