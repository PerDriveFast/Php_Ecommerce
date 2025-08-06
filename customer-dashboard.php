<?php include 'header.php'; ?>
<?php

if (!isset($_SESSION['customer'])) {
    header('location: ' . BASE_URL . 'login.php');
}

?>
<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Customer Dashboard</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <div class="col-md-12">
                <div class="customer-menu">
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>customer-dashboard.php">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>customer-order.php">Orders</a></li>
                        <li><a href="<?php echo BASE_URL; ?>customer-wishlist.php">Wishlist</a></li>
                        <li><a href="<?php echo BASE_URL; ?>customer-profile.php">Profile</a></li>
                        <li><a href="<?php echo BASE_URL; ?>logout.php">Logout</a></li>
                    </ul>
                </div>
                <div class="customer-page-content">
                    <h2 class="mb-4">Welcome, <?php echo $_SESSION['customer']['name']; ?></h2>
                    <p class="text_16">This is your dashboard where you can manage your orders, profile, and more.</p>
                    <p class="text_16">If you have any questions or need assistance, feel free to contact our support team.</p>
                </div>
            </div>
        </div>
    </div>
</main>





<?php include "footer.php"; ?>