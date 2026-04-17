<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 require "includes/connect.php"; 
 require "includes/auth.php"; 
 $user_id = $_SESSION['user_id'];

 require "includes/header.php"; ?>

<!-- //Fetch only the tasks that belong to the logged in user -->
<?php $sql = "SELECT * FROM images WHERE user_id = :user_id ORDER BY created_at ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
  <h2 class="mb-4">Image Gallery</h2>

  <!-- Add Image Form -->
  <form action="process.php" method="post" enctype="multipart/form-data">


    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" id="title" name="title"
             class="form-control" required>
    </div>

    <!-- File Upload! -->
     <div class ="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" id="image" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
     </div>
    <button type="submit" class="btn btn-primary">Add Image</button>

  </form>

  <hr class="my-5">

  <!-- Display images -->
  <h3>All images</h3>

  <?php
    $sql = "SELECT * FROM images WHERE user_id = :user_id ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <!-- table to display the tasks -->
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Image</th>
        <th>Title</th>
      </tr>
    </thead>

    <tbody>
      <!-- foreach loop to display the images in the table  -->
      <?php foreach ($tasks as $image): ?>
        <tr>
          <td>
            <?php if(!empty($image['image_path'])): ?>
              <img src ="<?= htmlspecialchars($image['image_path']);?>" 
                    alt="Image" width="60" height="60">
            <?php else: ?>
              <span>No Image</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($image['title']); ?></td>
        </tr>
    </tbody>
    </table>
            <!-- Buttons to edit and delete the task -->

            <a href="delete.php?id=<?= $image['id']; ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>

  </table>

</main>

<?php require "includes/footer.php"; ?>
