<?php include 'header.php'; ?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="i<?php echo BASE_URL; ?>">Home</a></li>
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
                            <input type="email">
                        </fieldset>
                    </div>
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Password</label>
                            <input type="password">
                        </fieldset>
                    </div>
                    <div class="col-12 mt-3">
                        <a href="forget-password.php" class="text_14 d-block">Forgot your password?</a>
                        <button type="submit" class="btn-primary d-block mt-4 btn-signin">SIGN IN</button>
                        <a href="register.php" class="btn-secondary mt-2 btn-signin">CREATE AN ACCOUNT</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>