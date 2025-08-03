<?php
$dbhost = 'localhost';
$dbname = 'ecommerce_project';
$dbuser = 'root';
$dbpass = 'thanhtrung123@#Z';
try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error :" . $exception->getMessage();
}
define("BASE_URL", "http://localhost:3000/");

define("ADMIN_URL", BASE_URL . "admin/");

define("SMTP_HOST", "sandbox.smtp.mailtrap.io");
define("SMTP_PORT", "2525");
define("SMTP_USERNAME", "a6d25a0e0a8146");
define("SMTP_PASSWORD", "bf2187cb80b927");
define("SMTP_FROM", "no-reply@example.com");
define("SMTP_ENCRYPTION", "tls");
