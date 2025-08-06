<?php include "header.php"; ?>
<?php
if (isset($_SESSION['customer'])) {
    header('location: ' . BASE_URL . 'customer-dashboard.php');
}
?>
<?php
if (isset($_POST['form_login'])) {
    try {
        if ($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }
        if ($_POST['password'] == '') {
            throw new Exception("Password can not be empty");
        }

        $q = $pdo->prepare("SELECT * FROM customers WHERE email=? AND status=?");
        $q->execute([$_POST['email'], 'Active']);
        $total = $q->rowCount();
        if (!$total) {
            throw new Exception("Email is not found");
        } else {
            $result = $q->fetch(PDO::FETCH_ASSOC);
            if (!password_verify($_POST['password'], $result['password'])) {
                throw new Exception("Password does not match");
            }
        }
        $_SESSION['customer'] = $result;
        $_SESSION['success_message'] = "Login successful!";
        header('location: ' . BASE_URL . 'customer-dashboard.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . BASE_URL . 'login.php');
        exit;
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
            <li>Login</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <form action="" class="login-form common-form mx-auto" method="post">
                <div class="section-header mb-3">
                    <h2 class="section-heading text-center">Login</h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Email address</label>
                            <input type="text" name="email">
                        </fieldset>
                    </div>
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Password</label>
                            <input type="password" name="password">
                        </fieldset>
                    </div>
                    <div class="col-12 mt-3">
                        <a href="<?php echo BASE_URL; ?>forget-password.php" class="text_14 d-block">Forgot your password?</a>
                        <button type="submit" class="btn-primary d-block mt-4 btn-signin" name="form_login">SIGN IN</button>
                        <a href="<?php echo BASE_URL; ?>register.php" class="btn-secondary mt-2 btn-signin">CREATE AN ACCOUNT</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>