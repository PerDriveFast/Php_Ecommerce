<?php include 'header.php'; ?>


<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="i<?php echo BASE_URL; ?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Cart</li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Checkout</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="checkout-page mt-100">
        <div class="container">
            <div class="checkout-page-wrapper">
                <div class="row">
                    <div class="col-xl-9 col-lg-8 col-md-12 col-12">
                        <div class="section-header mb-3">
                            <h2 class="section-heading">Check out</h2>
                        </div>

                        <div class="shipping-address-area">
                            <div class="mb_30">
                                <a href="login.php" style="color:#F0686E;text-decoration:underline;">Existing Customer? Login Here</a>
                            </div>
                            <h2 class="shipping-address-heading pb-1 mb_20">Customer Information</h2>
                            <div class="shipping-address-form-wrapper">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" placeholder="Name" name="name">
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" placeholder="Email" name="email">
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" placeholder="Mobile" name="mobile">
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" placeholder="Address" name="address">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <select name="area" id="area-select" class="form-select">
                                                <option value="">Select Area</option>
                                                <option value="60">Inside Dhaka City (2-3 Working Days - ৳60)</option>
                                                <option value="120">Outside Dhaka City (3-5 Working Days - ৳120)</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="shipping-address-area billing-area">
                            <h2 class="shipping-address-heading pb-1 mb_20">Payment</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <select name="payment_method" id="payment_method" class="form-select" onchange="togglePaymentFields()">
                                            <option value="">Select Payment Method</option>
                                            <option value="Cash on Delivery">Cash on Delivery</option>
                                            <option value="bKash">bKash</option>
                                            <option value="Nagad">Nagad</option>
                                        </select>
                                    </div>

                                    <div id="bkash" class="payment-fields" style="display: none;">
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="bKash Mobile Number" name="bkash_mobile">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="bKash Transaction ID" name="bkash_transaction_id">
                                        </div>
                                    </div>

                                    <div id="nagad" class="payment-fields" style="display: none;">
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Nagad Mobile Number" name="nagad_mobile">
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" placeholder="Nagad Transaction ID" name="nagad_transaction_id">
                                        </div>
                                    </div>

                                    <button type="submit" class="checkout-page-btn btn-primary mt_20">CONFIRM ORDER</button>
                                    <div class="mt_20">
                                        <a href="cart.php" style="color:#F0686E;text-decoration:underline;">Back to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function togglePaymentFields() {
                                // Hide all payment fields first
                                document.querySelectorAll('.payment-fields').forEach(field => {
                                    field.style.display = 'none';
                                });

                                // Get selected payment method
                                const paymentMethod = document.getElementById('payment_method').value;

                                // Show the relevant fields
                                if (paymentMethod === 'bKash') {
                                    document.getElementById('bkash').style.display = 'block';
                                } else if (paymentMethod === 'Nagad') {
                                    document.getElementById('nagad').style.display = 'block';
                                }
                                // For Cash on Delivery, no additional fields are shown
                            }

                            // Initialize on page load (in case there's a default selection)
                            document.addEventListener('DOMContentLoaded', function() {
                                togglePaymentFields();
                            });
                        </script>

                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-12 col-12">
                        <div class="cart-total-area checkout-summary-area">
                            <h3 class="d-none d-lg-block mb-0 text-center heading_24 mb-4">Order summary</h4>

                                <div class="minicart-item d-flex">
                                    <div class="mini-img-wrapper">
                                        <img class="mini-img" src="<?php echo BASE_URL; ?>dist_font/img/products/furniture/1.jpg" alt="img">
                                    </div>
                                    <div class="product-info">
                                        <h2 class="product-title"><a href="#">Eliot Reversible Sectional</a></h2>
                                        <p class="product-vendor">৳100 x 1</p>
                                    </div>
                                </div>
                                <div class="minicart-item d-flex">
                                    <div class="mini-img-wrapper">
                                        <img class="mini-img" src="<?php echo BASE_URL; ?>dist_font/img/products/furniture/2.jpg" alt="img">
                                    </div>
                                    <div class="product-info">
                                        <h2 class="product-title"><a href="#">Eliot Reversible Sectional</a></h2>
                                        <p class="product-vendor">৳90 x 2</p>
                                    </div>
                                </div>

                                <div class="cart-total-box mt-4 bg-transparent p-0">
                                    <div class="subtotal-item subtotal-box">
                                        <h4 class="subtotal-title">Subtotals:</h4>
                                        <p class="subtotal-value">৳<span id="subtotal-amount">280.00</span></p>
                                    </div>
                                    <div class="subtotal-item shipping-box">
                                        <h4 class="subtotal-title">Shipping:</h4>
                                        <p class="subtotal-value">(+) ৳<span id="shipping-amount">0.00</span></p>
                                    </div>
                                    <div class="subtotal-item discount-box">
                                        <h4 class="subtotal-title">Discount:</h4>
                                        <p class="subtotal-value">(-) ৳<span id="discount-amount">20.00</span></p>
                                    </div>
                                    <hr />
                                    <div class="subtotal-item total-box">
                                        <h4 class="subtotal-title">Total:</h4>
                                        <p class="subtotal-value">৳<span id="total-amount">260.00</span></p>
                                    </div>

                                    <div class="mt-4 checkout-promo-code">
                                        <input class="input-promo-code" type="text" placeholder="Promo code" />
                                        <a href="checkout.php" class="btn-apply-code position-relative btn-secondary text-uppercase mt-3">
                                            Apply Promo Code
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get DOM elements
        const areaSelect = document.getElementById('area-select');
        const subtotalAmount = document.getElementById('subtotal-amount');
        const shippingAmount = document.getElementById('shipping-amount');
        const discountAmount = document.getElementById('discount-amount');
        const totalAmount = document.getElementById('total-amount');

        // Initial values
        const subtotal = 280.00;
        const discount = 20.00;
        let shipping = 0.00;
        let total = subtotal - discount + shipping;

        // Update the display
        function updateTotals() {
            subtotalAmount.textContent = subtotal.toFixed(2);
            shippingAmount.textContent = shipping.toFixed(2);
            discountAmount.textContent = discount.toFixed(2);
            totalAmount.textContent = total.toFixed(2);
        }

        // Handle area selection change
        areaSelect.addEventListener('change', function() {
            // Get selected shipping cost
            shipping = this.value ? parseFloat(this.value) : 0.00;

            // Calculate new total
            total = subtotal - discount + shipping;

            // Update the display
            updateTotals();
        });

        // Initialize on page load
        updateTotals();
    });
</script>

<?php include 'footer.php'; ?>