<?php
// setup.php - Versione SEMPLICE e FORZATA
echo "<h1>🔄 Setup Database - Versione Finale</h1>";

try {
    // Elimina il vecchio file
    if (file_exists('secure.db')) {
        unlink('secure.db');
        echo "🗑️ Vecchio secure.db eliminato<br>";
    }

    $pdo = new PDO('sqlite:secure.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crea la tabella
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL
    )");

    echo "✅ Tabella users creata<br>";

    // Pulisci e inserisci utenti
    $pdo->exec("DELETE FROM users");

    $pdo->exec("INSERT INTO users (username, password) VALUES 
        ('admin', 'admin123'),
        ('user', 'pass123'),
        ('test', 'test123')");

    echo "✅ Utenti inseriti con successo<br>";
    echo "<h2 style='color:green'>🎉 SETUP COMPLETATO CORRETTAMENTE!</h2>";

    echo "<p><strong>Ora prova i login:</strong></p>";
    echo "<a href='protected_login.php'>→ Login Protetto</a><br>";
    echo "<a href='login_vulnerable.php'>→ Login Vulnerabile</a>";

} catch (Exception $e) {
    echo "<h2 style='color:red'>❌ ERRORE:</h2>";
    echo $e->getMessage();
}
?>