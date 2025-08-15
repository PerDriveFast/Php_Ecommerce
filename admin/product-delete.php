<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if ($total == 0) {
    header('location: ' . ADMIN_URL . 'product-view.php');
    exit;
}

unlink('../uploads/' . $result['featured_photo']);

$statement = $pdo->prepare("DELETE FROM products WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$_SESSION['success_message'] = 'Product has been deleted successfully.';
header('location: ' . ADMIN_URL . 'product-view.php');
exit;
