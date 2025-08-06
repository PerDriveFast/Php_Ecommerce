<?php
include "header.php";

unset($_SESSION['customer']);
$_SESSION['toast_message'] = "Logout successful!";
header('location: ' . BASE_URL . 'login.php');
exit;
?>

<?php include "footer.php"; ?>