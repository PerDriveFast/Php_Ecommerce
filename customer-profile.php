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
            <li>Customer Profile</li>
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
                        <?php include "customer-sidebar.php"; ?>

                    </ul>
                </div>
                <div class="customer-page-content">

                </div>
            </div>
        </div>
    </div>
</main>





<?php include "footer.php"; ?>