<?php 
require "includes/header.php";
require "includes/connect.php";

session_start();

$errors = [];

//Run when the form is submitted
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //Get form inputs and sanitize them
    $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    //Basic validation to make sure the feilds are not empty
    if($usernameOrEmail === '' || $password === ''){
        $errors[] = "Username/email and password are required.";
    } else {
        //SQL query to find a user with the matching username or email
        $sql = "SELECT id, username, email, password FROM users WHERE username = :login OR email = :login LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $usernameOrEmail);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        //Check if a user was found and if the password is correct
        if($user && password_verify($password, $user['password'])){
            //Regenerate session ID for security
            session_regenerate_id(true);

            //Store user information in session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            //Redirect to the index page
            header("Location: index.php");
            exit();
        } else {
            //If login fails, store an error message
            $errors[] = "Invalid username/email or password.";
        }
    }
    }
    ?>
 <main class = "container mt-4">
    <h2>Login</h2>

    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="username_or_email" class="form-label">Username or Email</label>
            <input type="text" class="form-control" id="username_or_email" name="username_or_email" value="<?php echo htmlspecialchars($usernameOrEmail ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
 </main>  
 <?php require "includes/footer.php"; ?> 