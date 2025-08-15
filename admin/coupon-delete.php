<?php include 'layouts/top.php'; ?>
<?php
$statement = $pdo->prepare("SELECT * FROM coupons WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if ($total == 0) {
    header('location: ' . ADMIN_URL . 'coupon-view.php');
    exit;
}
$statement = $pdo->prepare("DELETE FROM coupons WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$_SESSION['success_message'] = 'Coupon has been deleted successfully.';
header('location: ' . ADMIN_URL . 'coupon-view.php');
exit;
