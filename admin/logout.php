<?php
include "layouts/top.php";

unset($_SESSION['admin']);
$_SESSION['toast_message'] = "Logout successful!";
header('location: ' . ADMIN_URL . 'login.php');
exit;
