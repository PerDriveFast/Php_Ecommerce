<?php include 'layouts/top.php'; ?>
<?php
$statement = $pdo->prepare("SELECT * FROM coupons WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if ($total == 0) {
    header('location: ' . ADMIN_URL . 'coupon-view.php');
    exit;
}
?>
<?php
if (isset($_POST['form1'])) {
    try {

        if ($_POST['code'] == '') {
            throw new Exception('Code cannot be empty');
        }
        // duplicate code check
        $statement = $pdo->prepare("SELECT * FROM coupons WHERE code=? AND id!=?");
        $statement->execute([$_POST['code'], $_REQUEST['id']]);
        $total = $statement->rowCount();
        if ($total) {
            throw new Exception("Code already exists");
        }
        if ($_POST['discount'] == '') {
            throw new Exception('Discount cannot be empty');
        }
        //check if discount is numeric

        if (!is_numeric($_POST['discount'])) {
            throw new Exception("Discount must be numeric");
        }

        if ($_POST['type'] == '') {
            throw new Exception('Type cannot be empty');
        }
        if ($_POST['start_date'] == '') {
            throw new Exception('Start cannot be empty');
        }
        if ($_POST['end_date'] == '') {
            throw new Exception('End Date cannot be empty');
        }
        if ($_POST['maximum_use'] == '') {
            throw new Exception('Maximum Use cannot be empty');
        }
        //check if maximum is numeric
        if (!is_numeric($_POST['maximum_use'])) {
            throw new Exception("'Maximum Use must be numeric");
        }
        if ($_POST['status'] == '') {
            throw new Exception('Status cannot be empty');
        }





        //update the coupon
        $statement = $pdo->prepare("UPDATE coupons SET code=?, discount=?, type=?, start_date=?, end_date=?, maximum_use=?, status=? WHERE id=?");
        $statement->execute([$_POST['code'], $_POST['discount'], $_POST['type'], $_POST['start_date'], $_POST['end_date'], $_POST['maximum_use'], $_POST['status'], $_REQUEST['id']]);



        $_SESSION['success_message'] = 'Coupon has been created successfully.';
        header('location: ' . ADMIN_URL . 'coupon-view.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . ADMIN_URL . 'coupon-edit.php');
        exit;
    }
}
?>
<?php
$statement = $pdo->prepare("SELECT * FROM coupons WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Coupon</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>coupon-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Code</label>
                                            <input type="text" class="form-control" name="code" value="<?php echo $result['code']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Discount</label>
                                            <input type="text" class="form-control" name="discount" value="<?php echo $result['discount']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Type</label>
                                            <select name="type" class="form-select">
                                                <option value="">-- Select a Type --</option>
                                                <option value="Fixed" <?php if ($result['type'] == 'Fixed') echo 'selected'; ?>>Fixed</option>
                                                <option value="Percentage" <?php if ($result['type'] == 'Percentage') echo 'selected'; ?>>Percentage</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Start Date</label>
                                            <input type="text" class="form-control" name="start_date" id="datepicker" value="<?php echo $result['start_date']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>End Date</label>
                                            <input type="text" class="form-control" name="end_date" id="datepicker1" value="<?php echo $result['end_date']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Maximum Use</label>
                                            <input type="text" class="form-control" name="maximum_use" value="<?php echo $result['maximum_use']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-select">
                                                <option value="">-- Select a status --</option>
                                                <option value="Active" <?php if ($result['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                                <option value="Inactive" <?php if ($result['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                                            </select>
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
    </section>
</div>

<?php include 'layouts/footer.php'; ?>