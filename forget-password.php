<?php include 'header.php'; ?>



<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<?php
if (isset($_POST['form_forget_password'])) {
    try {

        if ($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }

        $q = $pdo->prepare("SELECT * FROM customers WHERE email=? AND status=?");
        $q->execute([$_POST['email'], 'Active']);
        $total = $q->rowCount();
        if (!$total) {
            throw new Exception("Email is not found");
        }

        $token = bin2hex(random_bytes(12));
        $statement = $pdo->prepare("UPDATE customers SET token=? WHERE email=?");
        $statement->execute([$token, $_POST['email']]);

        $email_message = "Please click on the following link in order to reset the password: <br>";
        $email_message .= '<a href="' . BASE_URL . 'reset-password.php?email=' . $_POST['email'] . '&token=' . $token . '">Reset Password</a>';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->setFrom(SMTP_FROM);
        $mail->addAddress($_POST['email']);
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password';
        $mail->Body = $email_message;
        $mail->send();
        $_SESSION['success_message'] = 'Please check your email and follow the steps.';
        header('location: ' . BASE_URL . 'forget-password.php');
        exit();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . BASE_URL . 'forget-password.php');
        exit();
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
            <li>Forget Password</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <form action="" class="login-form common-form mx-auto" method="post">
                <div class="section-header mb-3">
                    <h2 class="section-heading text-center">Forget Password</h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Email address</label>
                            <input type="email" name="email">
                        </fieldset>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn-primary d-block btn-signin" name="form_forget_password">SUBMIT</button>
                        <a href="<?php echo BASE_URL; ?>login.php" class="text_14 d-block mt-4">Back to Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>