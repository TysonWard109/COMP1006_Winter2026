<?php require "includes/header.php"; ?>
<?php require "includes/connect.php"; ?>

<main>
  <h2 class="mb-4">Time Tracker</h2>

  <!-- Add Task Form -->
  <form action="process.php" method="post">

    <div class="mb-3">
      <label for="task_name" class="form-label">Task Name</label>
      <input type="text" id="task_name" name="task_name"
             class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="category" class="form-label">Category</label>
      <input type="text" id="category" name="category"
             class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="priority" class="form-label">Priority</label>
      <select id="priority" name="priority"
              class="form-select" required>
        <option value="">Choose priority</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="due_date" class="form-label">Due Date</label>
      <input type="date" id="due_date" name="due_date"
             class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="time_spent" class="form-label">Time Spent (hours)</label>
      <input type="number" id="time_spent" name="time_spent"
             class="form-control" step="0.25" min="0" required>
    </div>

    <button type="submit" class="btn btn-primary">Add Task</button>

  </form>

  <hr class="my-5">

  <!-- Display Tasks -->
  <h3>All Tasks</h3>

  <?php
    $sql = "SELECT * FROM tasks ORDER BY due_date ASC";
    $stmt = $pdo->query($sql);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Task</th>
        <th>Category</th>
        <th>Priority</th>
        <th>Due Date</th>
        <th>Hours</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($tasks as $task): ?>
        <tr>
          <td><?= htmlspecialchars($task['task_name']); ?></td>
          <td><?= htmlspecialchars($task['category']); ?></td>
          <td><?= htmlspecialchars($task['priority']); ?></td>
          <td><?= htmlspecialchars($task['due_date']); ?></td>
          <td><?= htmlspecialchars($task['time_spent']); ?></td>
          <td>
            <a href="update.php?id=<?= $task['id']; ?>">Edit</a> |
            <a href="delete.php?id=<?= $task['id']; ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>

  </table>

</main>

<?php require "includes/footer.php"; ?>
