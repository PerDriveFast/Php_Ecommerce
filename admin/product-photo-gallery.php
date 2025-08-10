<?php include 'layouts/top.php'; ?>
<?php
$statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$existing_data = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if ($total == 0) {
    header('location: ' . ADMIN_URL . 'product-view.php');
    exit;
}
?>

<?php
if (isset($_POST['form1'])) {
    try {



        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            throw new Exception('Please select a photo');
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = "product_photo_" . time() . "." . $extension;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path_tmp);
        if ($mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif') {
            throw new Exception('Please upload a valid photo');
        }

        //move_uploaded_file($path_tmp, '../uploads/'.$filename);
        $source = $path_tmp;
        $destination = '../uploads/' . $filename;
        image_resize($source, $destination, 420, 500);

        $statement = $pdo->prepare("INSERT INTO product_photos (product_id,photo) VALUES (?,?)");
        $statement->execute([$_REQUEST['id'], $filename]);

        $_SESSION['success_message'] = 'Product photo has been created successfully.';
        header('location: ' . ADMIN_URL . 'product-photo-gallery.php?id=' . $_REQUEST['id']);
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . ADMIN_URL . 'product-photo-gallery.php?id=' . $_REQUEST['id']);
        exit;
    }
}
?>
<?php
if (isset($_POST['form2'])) {
    try {
        // Lấy thông tin ảnh trước khi xóa
        $statement = $pdo->prepare("SELECT photo FROM product_photos WHERE id=?");
        $statement->execute([$_POST['product_photo_id']]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result && file_exists('../uploads/' . $result['photo'])) {
            unlink('../uploads/' . $result['photo']);
        }

        // Xóa bản ghi
        $statement = $pdo->prepare("DELETE FROM product_photos WHERE id=?");
        $statement->execute([$_POST['product_photo_id']]);

        $_SESSION['success_message'] = 'Product photo has been deleted successfully.';
    } catch (Exception $ex) {
        $_SESSION['error_message'] = $ex->getMessage();
    }
    header('location: ' . ADMIN_URL . 'product-photo-gallery.php?id=' . $_REQUEST['id']);
    exit;
}


?>
<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Photo Gallery of Product: <?php echo $existing_data['name']; ?></h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>product-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> Show All Products</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $statement = $pdo->prepare("SELECT * FROM product_photos WHERE product_id=?");
                                        $statement->execute([$_REQUEST['id']]);
                                        $total =    $statement->rowCount();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        if ($total == 0) {
                                        ?>
                                            <tr>
                                                <td colspan="3" class="text-center">No Data Found</td>
                                            </tr>
                                        <?php

                                        }
                                        foreach ($result as $row) {
                                            $i++;
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" style="width: 100px;">
                                                </td>

                                                </td>
                                                <td class="pt_10 pb_10">
                                                    <form action="" method="post">
                                                        <input type="hidden" name="product_photo_id" value="<?php echo $row['id'] ?>">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="product_photo_id" value="<?php echo $row['id'] ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm" name="form2"
                                                                onClick="return confirm('Are you sure?');">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>


                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="photo">Photo *</label>
                                    <input type="file" name="photo" class="form-control" id="featured_photo">
                                </div>
                                <div style="margin-top: 10px;">
                                    <img id="preview_image" src="" alt="" style="width:140px; display:none;">
                                </div>
                                <button type="submit" class="btn btn-primary" name="form1">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'layouts/footer.php'; ?>