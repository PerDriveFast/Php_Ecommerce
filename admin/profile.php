<?php
include "layouts/top.php";
?>

<?php

if (isset($_POST['form_update'])) {
    try {
        if ($_POST['full_name'] == '') {
            throw new Exception("Full Name can not be empty");
        }
        if ($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }

        $statement = $pdo->prepare("Update users SET full_name=?, email=? WHERE id=?");
        $statement->execute([$_POST['full_name'], $_POST['email'], $_SESSION['admin']['id']]);

        $success_message = 'Profile data is updated successfully';


        // Update session data
        $_SESSION['admin']['full_name'] = $_POST['full_name'];
        $_SESSION['admin']['email'] = $_POST['email'];
        // $_SESSION['admin']['photo'] = $_FILES['photo']['name'] ?? $_SESSION['admin']['photo'];
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Profile</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            if (isset($error_message)) {
                                //echo $error_message;
                            ?><script>
                                    alert("<?php echo $error_message; ?>")
                                </script><?php
                                        }
                                        if (isset($success_message)) {
                                            //echo $success_message;
                                            ?><script>
                                    alert("<?php echo $success_message; ?>")
                                </script><?php
                                        }

                                            ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php if ($_SESSION['admin']['photo'] == ''): ?>
                                            <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="" class="profile-photo w_100_p">
                                        <?php else: ?>
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $_SESSION['admin']['photo']; ?>" alt="" class="profile-photo w_100_p">

                                        <?php endif; ?>
                                        <input type="file" class="mt_10" name="photo">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-4">
                                            <label class="form-label">Name *</label>
                                            <input type="text" class="form-control" name="full_name" value="<?php echo $_SESSION['admin']['full_name']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Email *</label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $_SESSION['admin']['email']; ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="new_password">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Retype Password</label>
                                            <input type="password" class="form-control" name="retype_password">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label"></label>
                                            <button type="submit" class="btn btn-primary" name="form_update">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>















<?php include "layouts/footer.php"; ?>