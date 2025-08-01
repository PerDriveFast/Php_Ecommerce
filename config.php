<?php
$dbhost = 'localhost';
$dbname = 'admin_panel_php';
$dbuser = 'root';
$dbpass = 'thanhtrung123@#Z';
try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error :" . $exception->getMessage();
}
define("BASE_URL", "http://localhost:3000/");

define("SMPT_HOST", "sandbox.smtp.mailtrap.io");
define("SMPT_PORT", "2525");
define("SMPT_USERNAME", "a6d25a0e0a8146");
define("SMPT_PASSWORD", "bf2187cb80b927");

//define("ADMIN_URL", BASE_URL . "admin/");
