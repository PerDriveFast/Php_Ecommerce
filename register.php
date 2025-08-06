<?php include 'header.php'; ?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<?php


if (isset($_POST['form_register'])) {

    try {

        if ($_POST['name'] == '') {
            throw new Exception("Name is required");
        }
        if ($_POST['email'] == '') {
            throw new Exception("Email is required");
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // php_select
        $statement = $pdo->prepare("SELECT * FROM customers WHERE email=?");
        $statement->execute([$_GET['email']]);
        $total = $statement->rowCount();
        if ($total) {
            throw new Exception("Email already exists");
        }
        if ($_POST['password'] == '') {
            throw new Exception("Password is required");
        }

        if ($_POST['password'] != $_POST['confirm_password']) {
            throw new Exception("Password and confirm password do not match");
        }

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(12)); // generate a random token


        $statement = $pdo->prepare("INSERT INTO customers (name, email ,password, token, status) VALUES (?, ?, ?, ?, ?)");
        $statement->execute([$_POST['name'], $_POST['email'], $password, $token, 'Inactive']);

        // Send activation email
        $email_message = "Please click on the following link in order to activate your account: <br>";
        $email_message .= '<a href="' . BASE_URL . 'register_verify.php?email=' . $_POST['email'] . '&token=' . $token . '">Activate Account</a>';

        $mail = new PHPMailer(true);
        try {
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
            $mail->Subject = 'Activate Account';
            $mail->Body = $email_message;
            $mail->send();
            $success_message = 'Please check your email and follow the steps.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }



        $_SESSION['success_message'] = "Registration successful! Please check your email to activate your account.";
        header('location: ' . BASE_URL . 'login.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . BASE_URL . 'register.php');
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
            <li>Register</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <form action="" class="login-form common-form mx-auto" method="post">
                <div class="section-header mb-3">
                    <h2 class="section-heading text-center">Register</h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Name</label>
                            <input type="text" name="name">
                        </fieldset>
                    </div>
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Email address</label>
                            <input type="email" name="email">
                        </fieldset>
                    </div>
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
                        <button type="submit" class="btn-primary d-block mt-3 btn-signin" name="form_register">CREATE ACCOUNT</button>
                        <a href="<?php echo BASE_URL; ?>login.php" class="btn-secondary mt-2 btn-signin">GO TO LOGIN PAGE</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>