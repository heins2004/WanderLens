<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WanderLens - Share Your Travel Adventures</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="main-header">
    <div class="logo">
        <a href="index.php" class="logo-link">
            <svg class="logo-icon" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2" fill="none"/>
                <circle cx="16" cy="16" r="8" stroke="currentColor" stroke-width="1.5" fill="none"/>
                <circle cx="16" cy="16" r="3" fill="currentColor"/>
                <path d="M10 10 L6 6 M22 10 L26 6 M22 22 L26 26 M10 22 L6 26" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span class="logo-text">WanderLens</span>
        </a>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>

            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="add_post.php">Share Trip</a></li>
                <li><a href="my_posts.php">My Adventures</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Join</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<?php if(isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) === 'index.php'): ?>
<div class="search-section-header">
    <form method="GET" action="index.php" class="search-form-header">
        <input type="text" 
               name="search" 
               class="search-input-header" 
               placeholder="Search travelers or #destinations (e.g., #Ladakh, #Bali)" 
               value="<?=isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';?>">
        <button type="submit" class="search-btn-header">Explore</button>
    </form>
</div>
<?php endif; ?>

<div class="container">
