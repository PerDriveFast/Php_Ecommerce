<?php include 'header.php'; ?>
<?php

if (!isset($_SESSION['customer'])) {
    header('location: ' . BASE_URL . 'login.php');
}

?>

<?php

if (isset($_POST['form_profile'])) {
    try {

        if ($_POST['name'] == '') {
            throw new Exception("Name can not be empty");
        }

        if ($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }

        // email check in database
        $q = $pdo->prepare("SELECT * FROM customers WHERE email=? AND id!=?");
        $q->execute([$_POST['email'], $_SESSION['customer']['id']]);
        $total = $q->rowCount();
        if ($total) {
            throw new Exception("Email already exists");
        }

        if ($_POST['phone'] == '') {
            throw new Exception("Phone can not be empty");
        }

        if ($_POST['address'] == '') {
            throw new Exception("Address can not be empty");
        }

        $customer_id = $_SESSION['customer']['id'];

        $q = $pdo->prepare("UPDATE customers SET name=?, email=?, phone=?, address=? WHERE id=?");
        $q->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'], $customer_id]);

        if ($_POST['password'] != '') {
            if ($_POST['password'] != $_POST['confirm_password']) {
                throw new Exception("Password and Confirm Password do not match");
            }
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $q = $pdo->prepare("UPDATE customers SET password=? WHERE id=?");
            $q->execute([$hashed_password, $customer_id]);
        }

        $_SESSION['customer']['name'] = $_POST['name'];
        $_SESSION['customer']['email'] = $_POST['email'];
        $_SESSION['customer']['phone'] = $_POST['phone'];
        $_SESSION['customer']['address'] = $_POST['address'];




        $_SESSION['success_message'] = "Profile update successfully";
        header('location: ' . BASE_URL . 'customer-profile.php');
        exit();
    } catch (Exception $ex) {
        $error_message = $ex->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . BASE_URL . 'customer-profile.php');
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
            <li>Customer Profile</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <div class="col-md-12">
                <div class="customer-menu">
                    <ul>
                        <?php include "customer-sidebar.php"; ?>

                    </ul>
                </div>
                <div class="customer-page-content">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" value="<?php echo $_SESSION['customer']['name']; ?>" class="form-control"></input>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" value="<?php echo $_SESSION['customer']['email']; ?>" class="form-control"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Phone</label>
                                <input type="phone" name="phone" value="<?php echo $_SESSION['customer']['phone']; ?>" class="form-control"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Address</label>
                                <input type="text" name="address" value="<?php echo $_SESSION['customer']['address']; ?>" class="form-control"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control"></label>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control"></label>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" name="form_profile">Update Profile</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>





<?php include "footer.php"; ?>