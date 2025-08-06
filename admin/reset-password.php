<?php include 'layouts/top.php'; ?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<?php
$statement = $pdo->prepare("SELECT * FROM admins WHERE email=? AND token=?");
$statement->execute([$_REQUEST['email'], $_REQUEST['token']]);
$total = $statement->rowCount();
if (!$total) {
    header('location: ' . ADMIN_URL . 'login.php');
    exit;
}
?>

<?php
if (isset($_POST['form_reset_password'])) {
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

<section class="section">
    <div class="container container-login">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary border-box">
                    <div class="card-header card-header-auth">
                        <h4 class="text-center">Reset Password</h4>
                    </div>
                    <div class="card-body card-body-auth">

                        <form method="POST" action="">
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="retype_password" placeholder="Retype Password" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg w_100_p" name="form_reset_password">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'layouts/footer.php'; ?>