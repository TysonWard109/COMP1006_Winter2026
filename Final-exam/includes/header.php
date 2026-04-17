<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <title>Time Tracker</title>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <!-- Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="index.php">
            Time Tracker
        </a>
            <div class="d-flex gap-2">
            <!-- Always visible -->
            <a href="index.php" class="btn btn-success">
                Add Image
            </a>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <!-- LOGGED IN STATE -->
                <span class="navbar-text text-white me-2">
                    👤 <?= htmlspecialchars($_SESSION['username']); ?>
                </span>
                <a href="logout.php" class="btn btn-danger">
                    Logout
                </a>
            <?php else: ?>
                <!-- LOGGED OUT STATE -->
                <a href="login.php" class="btn btn-primary">
                    Login
                </a>
                <a href="register.php" class="btn btn-outline-light">
                    Register
                </a>
            <?php endif; ?>
            </div>
        </div>
    </nav>
<div class ="container mt-4">
