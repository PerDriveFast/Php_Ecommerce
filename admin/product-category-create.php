<?php include 'layouts/top.php'; ?>

<?php
if (isset($_POST['form1'])) {
    try {

        if ($_POST['name'] == '') {
            throw new Exception('Name cannot be empty');
        }

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            throw new Exception('Please select a photo');
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = "product_category_" . time() . "." . $extension;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path_tmp);
        if ($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
            throw new Exception('Please upload a valid photo');
        }

        //move_uploaded_file($path_tmp, '../uploads/'.$filename);
        $source = $path_tmp;
        $destination = '../uploads/' . $filename;
        image_resize($source, $destination, 350, 400);

        $statement = $pdo->prepare("INSERT INTO product_categories (photo, name) VALUES (?, ?)");
        $statement->execute([$filename, $_POST['name']]);

        $_SESSION['success_message'] = 'Product category has been created successfully.';
        header('location: ' . ADMIN_URL . 'product-category-view.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . ADMIN_URL . 'product-category-create.php');
        exit;
    }
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Create Product Category</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>product-category-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Photo</label>
                                            <div>
                                                <input type="file" name="photo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name">
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