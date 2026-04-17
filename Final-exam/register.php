<?php 
require "includes/connect.php";

$errors = [];

// run when the form is submitted
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Sanatize inputs
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    //Validation
    if($username === ''){
        $errors[] = "Username is required.";
    }
    if($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "A valid email is required.";
    }
    if($password === ''){
        $errors[] = "Password is required.";
    }
    if($confirmPassword === ''){
        $errors[] = "Please confirm your password.";
    }
    if(strlen($password) < 8){
        $errors[] = "Password must be at least 8 characters long.";
    }

    if($password !== $confirmPassword){
        $errors[] = "Passwords do not match.";
    }

    //Check for an exsiting user with the same email or username
    if(empty($errors)){
        $sql ="SELECT id FROM users WHERE username = :username OR email = :email";
        $stmt = $pdo ->prepare($sql);
        $stmt ->execute(['username' => $username, 'email' => $email]);
    
    if($stmt ->fetch()){
        $errors[] = "Username or email already exists.";
    }
}

//Inset the new user into the database and auto login the user
if(empty($errors)){
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo ->prepare ($sql);
    $stmt ->execute(['username' => $username, 'email' => $email, 'password' => $hashedPassword]);

    //Auto login the user
    $_SESSION['user_id'] = $pdo ->lastInsertId();
    $_SESSION['username'] = $username;
    header('Location: index.php');
    exit();
}
}
require "includes/header.php";

?>

<body>
    <main class="container register">
        <h1 class="text-center"> Register </h1>
        <!---Show any validation errrors to the user--->
        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="register.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($username ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"> Register </button>
        </form>

    </main>
</body>

<?php require "includes/footer.php"; ?>