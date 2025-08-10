<?php ?>

<!-- footer start -->
<footer class="mt-100 overflow-hidden footer-style-2">
    <div class="footer-bottom bg-5">
        <div class="container">
            <div
                class="footer-bottom-inner d-flex flex-wrap justify-content-md-between justify-content-center align-items-center">
                <ul class="footer-bottom-menu list-unstyled d-flex flex-wrap align-items-center mb-0">
                    <li class="footer-menu-item"><a href="<?php echo BASE_URL; ?>privacy.php">Privacy policy</a></li>
                    <li class="footer-menu-item"><a href="<?php echo BASE_URL; ?>terms.php">Terms & Conditions</a></li>
                </ul>
                <p class="copyright footer-text">Copyright © John Doe. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
<!-- footer end -->

<!-- scrollup start -->
<button id="scrollup">
    <i class="fas fa-chevron-up" style="color:#fff;"></i>
</button>
<!-- scrollup end -->


<!-- drawer menu start -->
<div class="offcanvas offcanvas-start d-flex d-lg-none" tabindex="-1" id="drawer-menu">
    <div class="offcanvas-wrapper">
        <div class="offcanvas-header border-btm-black">
            <h5 class="drawer-heading">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column justify-content-between">
            <nav class="site-navigation">
                <ul class="main-menu list-unstyled">
                    <li class="menu-list-item nav-item active">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>">Home</a>
                    </li>
                    <li class="menu-list-item nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>shop.php">Shop</a>
                    </li>
                    <li class="menu-list-item nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>blog.php">Blog</a>
                    </li>
                    <li class="menu-list-item nav-item has-dropdown">
                        <div class="mega-menu-header">
                            <a class="nav-link active" href="<?php echo BASE_URL; ?>about-us.php">
                                Pages
                            </a>
                            <span class="open-submenu">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </div>
                        <div class="submenu-transform submenu-transform-desktop">
                            <div class="offcanvas-header border-btm-black">
                                <h5 class="drawer-heading btn-menu-back d-flex align-items-center">
                                    <i class="fas fa-chevron-left mr_10"></i>
                                    <span class="menu-back-text">Pages</span>
                                </h5>
                            </div>
                            <ul class="submenu list-unstyled">
                                <li class="menu-list-item nav-item-sub">
                                    <a class="nav-link-sub nav-text-sub" href="<?php echo BASE_URL; ?>about-us.php">About Us</a>
                                </li>
                                <li class="menu-list-item nav-item-sub">
                                    <a class="nav-link-sub nav-text-sub" href="<?php echo BASE_URL; ?>faq.php">FAQ</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-list-item nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>contact.php">Contact</a>
                    </li>
                </ul>
            </nav>
            <ul class="utility-menu list-unstyled">
                <li class="utilty-menu-item">
                    <a class="announcement-text" href="tel:+8801912721070">
                        <span class="utilty-icon-wrapper">
                            <i class="fas fa-phone"></i>
                        </span>
                        Call: +01912000000
                    </a>
                </li>
                <li class="utilty-menu-item">
                    <a class="announcement-login announcement-text" href="<?php echo BASE_URL; ?>login.php">
                        <span class="utilty-icon-wrapper">
                            <i class="far fa-user"></i>
                        </span>
                        <span>User Login</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- drawer menu end -->


<!-- all js -->
<script src="<?php echo BASE_URL; ?>dist_font/js/vendor.js"></script>
<script src="<?php echo BASE_URL; ?>dist_admin/js/iziToast.min.js"></script>
<script src="<?php echo BASE_URL; ?>dist_font/js/main.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.4.1.min.js"></script>
</div>
<?php if (isset($error_message)): ?>
    <script>
        iziToast.error({
            message: '<?php echo $error_message; ?>',
            position: 'topRight',
            timeout: 4000,
            color: 'red',
            icon: 'fa fa-times',
        });
    </script>
<?php endif; ?>


<?php if (isset($success_message)): ?>
    <script>
        iziToast.success({
            message: '<?php echo $success_message; ?>',
            position: 'topRight',
            timeout: 3000,
            color: 'green',
            icon: 'fa fa-check',
        });
    </script>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        iziToast.success({
            message: '<?php echo $_SESSION['success_message']; ?>',
            position: 'topRight',
            timeout: 3000,
            color: 'green',
            icon: 'fa fa-check',
        });
    </script>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>


<?php if (isset($_SESSION['error_message'])): ?>
    <script>
        iziToast.success({
            message: '<?php echo $_SESSION['error_message']; ?>',
            position: 'topRight',
            timeout: 3000,
            color: 'red',
            icon: 'fa fa-times',
        });
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>


<?php if (isset($_SESSION['toast_message'])): ?>
    <script>
        iziToast.success({
            message: '<?php echo addslashes($_SESSION['toast_message']); ?>',
            position: 'topRight',
            timeout: 3000,
            color: 'yellow',
            icon: 'fa fa-check'
        });
    </script>
    <?php unset($_SESSION['toast_message']); ?>
<?php endif; ?>
</body>

</html>