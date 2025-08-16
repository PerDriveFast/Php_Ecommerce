<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo ADMIN_URL; ?>dashboard.php">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo ADMIN_URL; ?>dashboard.php"></a>
        </div>

        <ul class="sidebar-menu">


            <li class="<?php if ($cur_page == 'dashboard.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li class="<?php if ($cur_page == 'product-category-view.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>product-category-view.php"><i class="far fa-file"></i> <span>Product Category</span></a></li>
            <li class="<?php if ($cur_page == 'product-view.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>product-view.php"><i class="fa-brands fa-product-hunt"></i><span>Product</span></a></li>

            <li class="<?php if ($cur_page == 'coupon-view.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>coupon-view.php"><i class="fa-brands fa-product-hunt"></i><span>Coupon</span></a></li>
            <li class="<?php if ($cur_page == 'coupon-view.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>area-view.php"><i class="fa-brands fa-product-hunt"></i><span>Area</span></a></li>
            <!-- <li class="nav-item dropdown active">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-hand-point-right"></i><span>Dropdown Items</span></a>
                <ul class="dropdown-menu">
                    <li class="active"><a class="nav-link" href=""><i class="fas fa-angle-right"></i> Item 1</a></li>
                    <li class=""><a class="nav-link" href=""><i class="fas fa-angle-right"></i> Item 2</a></li>
                </ul>
            </li> -->

            <!-- <li class=""><a class="nav-link" href=""><i class="fas fa-hand-point-right"></i> <span>Setting</span></a></li>

            <li class=""><a class="nav-link" href=""><i class="fas fa-hand-point-right"></i> <span>Form</span></a></li>

            <li class=""><a class="nav-link" href=""><i class="fas fa-hand-point-right"></i> <span>Table</span></a></li>

            <li class=""><a class="nav-link" href=""><i class="fas fa-hand-point-right"></i> <span>Invoice</span></a></li> -->

        </ul>
    </aside>
</div>