<?php
// dashboard.php - Versione semplice
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: protected_login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: protected_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>✅ Dashboard - Benvenuto <?= htmlspecialchars($_SESSION['user']) ?>!</h1>
    <p><a href="?logout=1">Logout</a></p>
    <p><a href="protected_login.php">Torna al Login</a> |
    <a href="login_vulnerable.php">→ Login Vulnerabile</a>
    </p>
</body>
</html>