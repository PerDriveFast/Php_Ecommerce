<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM product_categories WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if ($total == 0) {
    header('location: ' . ADMIN_URL . 'product-category-view.php');
    exit;
}
?>

<?php
if (isset($_POST['form1'])) {
    try {

        if ($_POST['name'] == '') {
            throw new Exception('Name cannot be empty');
        }

        $statement = $pdo->prepare("UPDATE product_categories SET name=? WHERE id=?");
        $statement->execute([$_POST['name'], $_REQUEST['id']]);

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];
        if ($path != '') {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = "product_category_" . time() . "." . $extension;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);
            if ($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
                throw new Exception('Please upload a valid photo');
            }

            unlink('../uploads/' . $result['photo']);

            $source = $path_tmp;
            $destination = '../uploads/' . $filename;
            image_resize($source, $destination, 350, 400);

            $statement = $pdo->prepare("UPDATE product_categories SET photo=? WHERE id=?");
            $statement->execute([$filename, $_REQUEST['id']]);
        }

        $_SESSION['success_message'] = 'Product category has been updated successfully.';
        header('location: ' . ADMIN_URL . 'product-category-view.php');
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . ADMIN_URL . 'product-category-edit.php?id=' . $_REQUEST['id']);
        exit;
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM product_categories WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Product Category</h1>
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
                                            <label>Existing Photo</label>
                                            <div>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result['photo']; ?>" alt="" style="width:140px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Change Photo</label>
                                            <div>
                                                <input type="file" name="photo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo $result['name']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form1">Update</button>
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