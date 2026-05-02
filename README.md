# PHP-Vuln-Lab 🔒

**Laboratorio pratico vulnerabilità web PHP. Testa SQLi, XSS, CSRF, upload sicuro vs insicuro.**

[![PHP](https://img.shields.io/badge/PHP-8.2+-pink)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange)](https://mysql.com)

<br>

## 📖 Descrizione
**Lab hands-on cybersecurity**: Confronta codice PHP **vulnerabile vs sicuro**.
- **Vulnerable:** SQLi, XSS, CSRF, file upload, session hijacking
- **Secure:** Prepared statements, escaping, CSRF token, validation
- **XAMPP ready** – 5 min setup

  <br>

**Obiettivo CV:** Web security + PHP secure coding per developer backend.

<br>

## 🛠 Tech Stack
- **Backend:** PHP 8+, MySQL/MariaDB
- **Lab:** SQL Injection, XSS, CSRF, File Upload
- **Demo:** XAMPP localhost
- **Secure:** PDO, htmlspecialchars(), token

  <br>

## 🚀 Setup (XAMPP)
```bash
1. XAMPP > Apache + MySQL START
2. Importa config/security_lab.sql
3. http://localhost/PHP-Vuln-Lab/
4. Testa attacchi → Confronta fix!
```

<br>

## 🔓 Vulnerabilità Testabili

**OWASP Top 10 con codice Vulnerable vs Secure:**

| Attack | Vulnerable | Secure Fix |
|--------|------------|------------|
| **SQLi** | `mysql_query($_GET['id'])` | PDO prepared |
| **XSS** | `echo $_POST['comment']` | `htmlspecialchars()` |
| **CSRF** | No token | `$_SESSION['token']` |
| **Upload** | No validation | MIME + size check |


<br>

## 💡 Apprendimenti
- OWASP Top 10 hands-on
- PHP secure coding patterns
- Pentest methodology base
- Prossimo: Burp Suite integration

  <br>

## ⚠️ AVVERTENZA
**Solo localhost/VM isolate!** Non deploy production.

<br>

## 📄 Licenza
MIT

<br>
---
**© 2026 Suzuka90** | PHP Security Lab | Private Access
