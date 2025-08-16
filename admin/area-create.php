<?php include 'layouts/top.php'; ?>

<?php
if (isset($_POST['form1'])) {
    try {

        if ($_POST['name'] == '') {
            throw new Exception('Name cannot be empty');
        }

        // duplicate code check
        $statement = $pdo->prepare("SELECT * FROM areas WHERE id=?");
        $statement->execute([$_POST['name']]);
        $total = $statement->rowCount();
        if ($total) {
            throw new Exception("Name already exists");
        }
        if ($_POST['charge'] == '') {
            throw new Exception('Charge cannot be empty');
        }
        //check if charge is numeric
        if (!is_numeric($_POST['charge'])) {
            throw new Exception("Charge must be numeric");
        }





        $statement = $pdo->prepare("INSERT INTO areas 
    (name, charge) 
    VALUES (?, ?)");
        $statement->execute([
            $_POST['name'],
            $_POST['charge'],
        ]);



        $_SESSION['success_message'] = 'Area has been created successfully.';
        header('location: ' . ADMIN_URL . 'area-view.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . ADMIN_URL . 'area-create.php');
        exit;
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create Area</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>area-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Name *</label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Charge *</label>
                                            <input type="text" class="form-control" name="charge">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form1">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>

<?php include 'layouts/footer.php'; ?>