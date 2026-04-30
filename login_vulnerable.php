<?php
// login_vulnerable.php - VERSIONE VULNERABILE (SQL Injection Demo) - FINALE
session_start();

$error = '';
$sql_error = '';
$query = '';

if ($_POST) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $pdo = new PDO('sqlite:secure.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // ❌ VULNERABILE: Concatenazione diretta di stringhe (classico SQL Injection)
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

        $result = $pdo->query($query);
        
        if ($result && $result->fetch()) {
            $_SESSION['user'] = $username;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Credenziali errate';
        }
    } catch (Exception $e) {
        $error = 'Errore durante il login';
        $sql_error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>🔓 Login Vulnerabile</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .warning { color: #d32f2f; font-weight: bold; }
        code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }
        .sql-error { background: #ffebee; padding: 10px; border-left: 4px solid #d32f2f; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>🔓 Login Vulnerabile (SQL Injection Demo)</h1>
    <p class="warning">⚠️ Questo login è INTENZIONALMENTE vulnerabile</p>
    
    <form method="POST">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password"><br><br>
        <button type="submit">Login Vulnerabile</button>
    </form>

    <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($sql_error): ?>
        <div class="sql-error">
            <strong>SQL Error (per debug didattico):</strong><br>
            <?= htmlspecialchars($sql_error) ?><br><br>
            <strong>Query eseguita:</strong><br>
            <code><?= htmlspecialchars($query) ?></code>
        </div>
    <?php endif; ?>
        <br><br><br>
      <br>
    <h3> Credenziali di Test:</h3>
   <ul>
        <li>Username: <code>admin </code></li> 
         <li>Password: <code>admin123 </code></li>
         <br><br>

        <li>Username: <code>user </code> </li> 
           <li> Password: <code>pass123 </code></li>
    </ul>
    <br>

    <h3>🔥 Payload da provare nel campo Username:</h3>
    <ul>
        <li><code>admin' -- </code> ← (lascia password vuota)</li>
    </ul> <br> <br> 
    <hr>
    <p>
        <a href="protected_login.php">→ Vai al Login Protetto</a><br><br>
        <a href="setup.php">Riesegui Setup Database</a>
    </p>
</body>
</html>