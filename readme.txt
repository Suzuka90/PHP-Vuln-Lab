# 🔒 PHP Security Lab

Laboratorio educativo per imparare le vulnerabilità web più comuni in PHP (SQL Injection, WAF, Prepared Statements, ecc.).

## 🎯 Obiettivo

Dimostrare la differenza tra una versione **vulnerabile** e una versione **protetta** di un sistema di login.

## 📁 Struttura del Progetto

- `login_vulnerable.php` → Login **vulnerabile** a SQL Injection
- `protected_login.php` → Login **protetto** con WAF + Prepared Statements
- `dashboard.php` → Dashboard dopo il login
- `waf.php` → Web Application Firewall (semplice)
- `setup.php` → Script per inizializzare il database

## Credenziali di Test

- **Username:** `admin`  
  **Password:** `admin123`

- **Username:** `user`  
  **Password:** `pass123`

## 🔥 Dimostrazioni

### 1. SQL Injection (nel login vulnerabile)
Prova questi payload nel campo **Username**:

- `admin' OR '1'='1`
- `' OR '1'='1' -- `
- `admin' -- `

### 2. WAF (nel login protetto)
Il WAF dovrebbe bloccare molti attacchi SQLi comuni.

## 🛡️ Tecniche di Protezione Implementate

- Web Application Firewall (WAF)
- Prepared Statements (PDO)
- `htmlspecialchars()` per prevenire XSS
- `session_regenerate_id()`
- Auto-creazione tabella nel login protetto

