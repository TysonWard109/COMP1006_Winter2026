<?php
//TODO:
require "includes/connect.php";

/*
  TODO:
  1. Write a SELECT query to get all subscribers
  2. Add ORDER BY subscribed_at DESC
  3. Prepare the statement
  4. Execute the statement
  5. Fetch all results into $subscribers
*/

//This is my select statmement to get all subscribers with an order by descending
$sql = "SELECT * FROM subscribers ORDER BY subscribed_at DESC";
//Prepare statment
$stmt = $pdo -> prepare($sql);
//Execute statment
$stmt -> execute();
//Fetch all results into $subscribers
$subscribers = $stmt -> fetchAll(PDO::FETCH_ASSOC);

// $subscribers = []; // placeholder
?>

<main class="container mt-4">
  <h1>Subscribers</h1>

  <?php if (count($subscribers) === 0): ?>
    <p>No subscribers yet.</p>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Subscribed</th>
        </tr>
      </thead>
      <tbody>
        <!-- TODO: Loop through $subscribers and output each row -->
         <?php foreach ($subscribers as $subscriber): ?>
          <tr>
            <td><?= $subscriber['id']  ?></td>
            <td><?= $subscriber['first_name']  ?></td>
            <td><?= $subscriber['last_name']  ?></td>
            <td><?= $subscriber['email']  ?></td>
            <td><?= $subscriber['subscribed_at']  ?></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p class="mt-3">
    <a href="index.php">Back to Subscribe Form</a>
  </p>
</main>

<?php require "includes/footer.php"; ?>
