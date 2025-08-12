<?php include "header.php"; ?>

<?php
if (isset($_SESSION['product_id'])) {
    if (count($_SESSION['product_id']) == 0) {
        unset($_SESSION['product_id']);
        unset($_SESSION['product_quantity']);
    }
}

if (isset($_POST['form_plus'])) {
    try {
        $statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
        $statement->execute([$_POST['id']]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $key = array_search($_POST['id'], $_SESSION['product_id']);
        if ($_SESSION['product_quantity'][$key] + 1 > $result['quantity']) {
            throw new Exception('Số lượng sản phẩm vượt quá tồn kho.');
        }

        $_SESSION['product_quantity'][$key] += 1;
        $_SESSION['success_message'] = "Đã cập nhật số lượng sản phẩm.";
        header('location: ' . BASE_URL . 'cart.php');
        exit;
    } catch (Exception $ex) {
        $_SESSION['error_message'] = $ex->getMessage();
        header('location: ' . BASE_URL . 'cart.php');
        exit;
    }
}

if (isset($_POST['form_minus'])) {
    try {
        $key = array_search($_POST['id'], $_SESSION['product_id']);
        $_SESSION['product_quantity'][$key] -= 1;

        if ($_SESSION['product_quantity'][$key] <= 0) {
            unset($_SESSION['product_id'][$key]);
            unset($_SESSION['product_quantity'][$key]);
            $_SESSION['product_id'] = array_values($_SESSION['product_id']);
            $_SESSION['product_quantity'] = array_values($_SESSION['product_quantity']);
        }
        $_SESSION['success_message'] = "Đã cập nhật số lượng sản phẩm.";
        header('location: ' . BASE_URL . 'cart.php');
        exit;
    } catch (Exception $ex) {
        $_SESSION['error_message'] = $ex->getMessage();
        header('location: ' . BASE_URL . 'cart.php');
        exit;
    }
}

if (isset($_POST['form_remove'])) {
    try {
        $key = array_search($_POST['id'], $_SESSION['product_id']);
        unset($_SESSION['product_id'][$key]);
        unset($_SESSION['product_quantity'][$key]);
        $_SESSION['product_id'] = array_values($_SESSION['product_id']);
        $_SESSION['product_quantity'] = array_values($_SESSION['product_quantity']);

        $_SESSION['success_message'] = "Đã xóa sản phẩm khỏi giỏ hàng.";
        header('location: ' . BASE_URL . 'cart.php');
        exit;
    } catch (Exception $ex) {
        $_SESSION['error_message'] = $ex->getMessage();
        header('location: ' . BASE_URL . 'cart.php');
        exit();
    }
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

                        <?php if (!isset($_SESSION['product_id'])): ?>
                            <div class="text-danger">Cart is empty!</div>
                        <?php else: ?>
                            <table class="cart-table" style="width:100%;">
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
                                    <?php
                                    $i = 0;
                                    $arr_product_id = [];
                                    foreach ($_SESSION['product_id'] as $value) {
                                        $i++;
                                        $arr_product_id[$i] = $value;
                                    }

                                    $i = 0;
                                    $arr_product_quantity = [];
                                    foreach ($_SESSION['product_quantity'] as $value) {
                                        $i++;
                                        $arr_product_quantity[$i] = $value;
                                    }
                                    ?>
                                    <?php $total = 0; ?>
                                    <?php for ($i = 1; $i <= count($arr_product_id); $i++): ?>
                                        <?php
                                        $statement = $pdo->prepare("SELECT p.*, pc.name as category_name, pc.id as category_id
                                                                    FROM products p
                                                                    JOIN product_categories pc
                                                                    ON p.product_category_id = pc.id
                                                                    WHERE p.id=?");
                                        $statement->execute([$arr_product_id[$i]]);
                                        $product_data = $statement->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <tr class="cart-item">
                                            <td class="cart-item-media">
                                                <div class="mini-img-wrapper">
                                                    <img class="mini-img" src="<?php echo BASE_URL; ?>uploads/<?php echo $product_data['featured_photo']; ?>" alt="img">
                                                </div>
                                            </td>
                                            <td class="cart-item-details">
                                                <h2 class="product-title"><a href="<?php echo BASE_URL; ?>product/<?php echo $product_data['slug']; ?>"><?php echo $product_data['name']; ?></a></h2>
                                                <p class="product-vendor">Category: <a href="<?php echo BASE_URL; ?>shop.php?name=&category=<?php echo $product_data['category_id']; ?>&availability=&min_price=&max_price"><?php echo $product_data['category_name']; ?></a></p>
                                            </td>
                                            <td class="cart-item-price text-end">
                                                <div class="product-price">$<?php echo number_format($product_data['sale_price'], 2); ?></div>
                                            </td>
                                            <td class="cart-item-quantity">
                                                <div class="quantity">
                                                    <form action="" method="post" class="d-flex align-items-center justify-content-between">
                                                        <input type="hidden" name="id" value="<?php echo $arr_product_id[$i]; ?>">
                                                        <button type="submit" class="qty-btn dec-qty" name="form_minus"><img src="<?php echo BASE_URL; ?>dist_font/img/icon/minus.svg" alt="minus"></button>
                                                        <input class="qty-input" type="number" value="<?php echo $arr_product_quantity[$i]; ?>" disabled>
                                                        <button type="submit" class="qty-btn inc-qty" name="form_plus"><img src="<?php echo BASE_URL; ?>dist_font/img/icon/plus.svg" alt="plus"></button>
                                                    </form>
                                                </div>
                                                <form action="" method="post" class="text-center">
                                                    <input type="hidden" name="id" value="<?php echo $arr_product_id[$i]; ?>">
                                                    <button type="submit" class=" mt-2" onClick="return confirm('Are you sure?')" name="form_remove" style="color:red;background:#fff;display:inline-block;">Remove</button>
                                                </form>
                                            </td>
                                            <td class="cart-item-price text-end">
                                                <?php
                                                $subtotal = $arr_product_quantity[$i] * $product_data['sale_price'];
                                                ?>
                                                <div class="product-price">$<?php echo number_format($subtotal, 2); ?></div>
                                            </td>
                                        </tr>
                                        <?php
                                        $total += $subtotal;
                                        ?>
                                    <?php endfor; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="cart-caption text-end heading_18">Total: $<?php echo number_format($total, 2); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="d-flex justify-content-start mt-4">
                                <a href="<?php echo BASE_URL; ?>checkout" class="position-relative btn-primary text-uppercase">
                                    PROCEED TO CHECKOUT
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Popup thông báo -->
<div id="cart-notification" class="cart-notification">
    <div class="cart-notification-content">
        <div class="check-icon">
            <svg viewBox="0 0 52 52">
                <circle class="check-circle" cx="26" cy="26" r="25" fill="none" />
                <path class="check-mark" fill="none" d="M14 27l7 7 17-17" />
            </svg>
        </div>
        <p></p>
    </div>
</div>

<style>
    .cart-notification {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
    }

    .cart-notification-content {
        text-align: center;
        color: white;
        animation: fadeInOut 2s ease forwards;
    }

    .check-icon {
        width: 80px;
        height: 80px;
        margin: auto;
    }

    .check-icon svg {
        width: 100%;
        height: 100%;
        stroke: #00c853;
        stroke-width: 3;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .check-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke: #00c853;
        animation: strokeCircle 0.6s forwards;
    }

    .check-mark {
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke: #00c853;
        animation: strokeCheck 0.4s 0.6s forwards;
    }

    .cart-notification p {
        margin-top: 15px;
        font-size: 18px;
        font-weight: bold;
    }

    @keyframes strokeCircle {
        to {
            stroke-dashoffset: 0;
        }
    }

    @keyframes strokeCheck {
        to {
            stroke-dashoffset: 0;
        }
    }

    @keyframes fadeInOut {
        0% {
            opacity: 0;
            transform: scale(0.9);
        }

        20% {
            opacity: 1;
            transform: scale(1);
        }

        80% {
            opacity: 1;
        }

        100% {
            opacity: 0;
            transform: scale(0.9);
        }
    }
</style>

<script>
    function showCartNotification(message = "Sản phẩm đã được thêm vào Giỏ hàng") {
        const popup = document.getElementById('cart-notification');
        const text = popup.querySelector('p');
        text.textContent = message;

        popup.style.display = 'flex';
        setTimeout(() => {
            popup.style.display = 'none';
        }, 2000);
    }

    // Hiển thị thông báo nếu có trong session
    <?php if (!empty($_SESSION['success_message'])): ?>
        showCartNotification("<?php echo $_SESSION['success_message']; ?>");
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error_message'])): ?>
        showCartNotification("<?php echo $_SESSION['error_message']; ?>");
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
</script>

<?php include "footer.php"; ?>