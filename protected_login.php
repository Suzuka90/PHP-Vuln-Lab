<?php
// protected_login.php - Login Protetto con WAF + Prepared Statements
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: protected_login.php');
    exit;
}

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_POST) {
    require_once 'waf.php';

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // === MODIFICA DIDATTICA ===
    // Se viene inserito un payload di SQL Injection tipico, forziamo la password a vuota
    // Così puoi provare "admin'--" e vedere che non funziona
    $suspicious_patterns = ['--', "'", "OR ", "OR\t", "1=1", "union"];
    $is_suspicious = false;

    foreach ($suspicious_patterns as $pattern) {
        if (stripos($username, $pattern) !== false) {
            $is_suspicious = true;
            break;
        }
    }

    if ($is_suspicious) {
        $password = '';  // Forza password vuota per dimostrazione
    }
    // ========================

    try {
        $pdo = new PDO('sqlite:secure.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crea la tabella automaticamente se non esiste
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL
        )");

        // Inserisci utenti di default se non esistono
        $stmt = $pdo->prepare("INSERT OR IGNORE INTO users (username, password) VALUES (?, ?)");
        $stmt->execute(['admin', 'admin123']);
        $stmt->execute(['user', 'pass123']);
        $stmt->execute(['test', 'test123']);

        // Login protetto con Prepared Statements
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);

        if ($stmt->fetch()) {
            $_SESSION['user'] = $username;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Credenziali errate';
        }

    } catch (Exception $e) {
        $error = 'Errore database: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>🔒 Login Protetto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .warning { color: #d32f2f; }
        .info { background: #e8f4fd; padding: 10px; border-left: 4px solid #2196F3; }
    </style>
</head>
<body>
    <h1>🛡️ Login Protetto (WAF + Prepared Statements)</h1>
    
    <form method="POST">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password"><br><br>
        <button type="submit">Login</button>
    </form>

    <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($is_suspicious) && $is_suspicious): ?>
        <div class="info">
            <strong>ℹ️ Modalità studio attiva:</strong><br>
            Rilevato possibile tentativo di SQL Injection.<br>
            La password è stata forzata a vuota per dimostrazione.
        </div>
    <?php endif; ?>
    <br>        <br><br><br>
    <h3> Credenziali di Test:</h3>
    <ul>
        <li>Username: <code>admin </code></li> 
         <li>Password: <code>admin123 </code></li>
         <br><br>

        <li>Username: <code>user </code> </li> 
           <li> Password: <code>pass123 </code></li>
    </ul>
    <br>

    <br>
    <h3>🔥 Payload da provare nel campo Username:</h3>
    <ul>
        <li><code>admin' -- </code> ← (lascia password vuota)</li>
    </ul> <br> <br> 
    <hr>

    <p><a href="login_vulnerable.php">→ Vai al Login Vulnerabile</a></p>
    <p><a href="setup.php">Riesegui Setup Database</a></p>
</body>
</html>