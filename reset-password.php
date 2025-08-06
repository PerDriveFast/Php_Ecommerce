<?php include 'header.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM customers WHERE email=? AND token=?");
$statement->execute([$_REQUEST['email'], $_REQUEST['token']]);
$total = $statement->rowCount();
if (!$total) {
    header('location: ' . BASE_URL . 'login.php');
    exit;
}
?>

<?php
if (isset($_POST['form_rest_password'])) {
    try {

        if ($_POST['password'] == '' || $_POST['confirm_password'] == '') {
            throw new Exception("Password can not be empty");
        }

        if ($_POST['password'] != $_POST['confirm_password']) {
            throw new Exception("Passwords do not match");
        }

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $statement = $pdo->prepare("UPDATE customers SET token=?, password=? WHERE email=? AND token=?");
        $statement->execute(['', $password, $_REQUEST['email'], $_REQUEST['token']]);

        $_SESSION['success_message'] = 'Password has been reset successfully. You can now login with your new password.';
        header('location: ' . BASE_URL . 'login');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . BASE_URL . 'reset-password.php?email=' . $_REQUEST['email'] . '&token=' . $_REQUEST['token']);
        exit;
    }
}
?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="i<?php echo BASE_URL; ?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Reset Password</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <form action="" class="login-form common-form mx-auto" method="post">
                <div class="section-header mb-3">
                    <h2 class="section-heading text-center">Reset Password</h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Password</label>
                            <input type="password" name="password">
                        </fieldset>
                    </div>
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Confirm Password</label>
                            <input type="password" name="confirm_password">
                        </fieldset>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn-primary d-block btn-signin" name="form_rest_password">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>