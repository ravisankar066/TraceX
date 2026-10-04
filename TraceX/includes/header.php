<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function clean($value) {
    return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? clean($page_title) . " | TraceX" : "TraceX" ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <a href="index.php" class="brand"><span>TR</span> TraceX</a>
    <nav>
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION["user_id"])): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="investigate.php">Investigate</a>
            <a href="evidence.php">Evidence</a>
            <a href="report.php">Report</a>
            <a href="logout.php" class="nav-button">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php" class="nav-button">Get Started</a>
        <?php endif; ?>
    </nav>
</header>
<main>