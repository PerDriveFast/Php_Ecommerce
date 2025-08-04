<?php include 'header.php'; ?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="index.php">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Cart</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="cart-page mt-100">
        <div class="container">
            <div class="cart-page-wrapper">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <table class="cart-table w-100">
                            <thead>
                                <tr>
                                    <th class="cart-caption heading_18">Product</th>
                                    <th class="cart-caption heading_18"></th>
                                    <th class="cart-caption text-end heading_18">Price</th>
                                    <th class="cart-caption text-center heading_18 d-none d-md-table-cell">Quantity</th>
                                    <th class="cart-caption text-end heading_18">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="cart-item">
                                    <td class="cart-item-media">
                                        <div class="mini-img-wrapper">
                                            <img class="mini-img" src="<?php echo BASE_URL; ?>dist_font/img/products/furniture/1.jpg" alt="img">
                                        </div>
                                    </td>
                                    <td class="cart-item-details">
                                        <h2 class="product-title"><a href="#">Eliot Reversible Sectional</a></h2>
                                        <p class="product-vendor">Category: Women Bag</p>
                                    </td>
                                    <td class="cart-item-price text-end">
                                        <div class="product-price">৳100.00</div>
                                    </td>
                                    <td class="cart-item-quantity">
                                        <div class="quantity d-flex align-items-center justify-content-between">
                                            <button class="qty-btn dec-qty"><img src="<?php echo BASE_URL; ?>dist_font/img/icon/minus.svg" alt="minus"></button>
                                            <input class="qty-input" type="number" name="qty" value="1" min="0">
                                            <button class="qty-btn inc-qty"><img src="<?php echo BASE_URL; ?>dist_font/img/icon/plus.svg" alt="plus"></button>
                                        </div>
                                        <a href="" class="product-remove mt-2" onClick="return confirm('Are you sure?')">Remove</a>
                                    </td>
                                    <td class="cart-item-price text-end">
                                        <div class="product-price">৳100.00</div>
                                    </td>
                                </tr>

                                <tr class="cart-item">
                                    <td class="cart-item-media">
                                        <div class="mini-img-wrapper">
                                            <img class="mini-img" src="<?php echo BASE_URL; ?>dist_font/img/products/furniture/2.jpg" alt="img">
                                        </div>
                                    </td>
                                    <td class="cart-item-details">
                                        <h2 class="product-title"><a href="#">Vita Lounge Chair</a></h2>
                                        <p class="product-vendor">Category: Women Bag</p>
                                    </td>
                                    <td class="cart-item-price text-end">
                                        <div class="product-price">৳90.00</div>
                                    </td>
                                    <td class="cart-item-quantity">
                                        <div class="quantity d-flex align-items-center justify-content-between">
                                            <button class="qty-btn dec-qty"><img src="<?php echo BASE_URL; ?>dist_font/img/icon/minus.svg" alt="minus"></button>
                                            <input class="qty-input" type="number" name="qty" value="2" min="0">
                                            <button class="qty-btn inc-qty"><img src="<?php echo BASE_URL; ?>dist_font/img/icon/plus.svg" alt="plus"></button>
                                        </div>
                                        <a href="" class="product-remove mt-2" onClick="return confirm('Are you sure?')">Remove</a>
                                    </td>
                                    <td class="cart-item-price text-end">
                                        <div class="product-price">৳180.00</div>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="cart-caption text-end heading_18">Total: ৳280</th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="d-flex justify-content-start mt-4">
                            <button type="submit" class="position-relative btn-primary text-uppercase mr_20">UPDATE CART</button>
                            <a href="checkout.php" class="position-relative btn-primary text-uppercase">
                                PROCEED TO CHECKOUT
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>