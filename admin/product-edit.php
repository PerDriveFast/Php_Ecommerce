<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);
$total = $statement->rowCount();
if ($total == 0) {
    header('location: ' . ADMIN_URL . 'product-view.php');
    exit;
}
?>

<?php
if (isset($_POST['form1'])) {
    try {
        if ($_POST['name'] == '') {
            throw new Exception('Name cannot be empty');
        }
        if ($_POST['slug'] == '') {
            throw new Exception('Slug cannot be empty');
        }
        // Slug validation using regex
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $_POST['slug'])) {
            throw new Exception('Slug can only contain lowercase letters, numbers, and hyphens');
        }
        // Slug uniqueness using database check
        $statement = $pdo->prepare("SELECT * FROM products WHERE slug=? AND id!=?");
        // lỗi ở đây mà ko thấy 
        $statement->execute([$_POST['slug'], $_REQUEST['id']]);



        $total = $statement->rowCount();
        if ($total) {
            throw new Exception('Slug already exists');
        }
        if ($_POST['quantity'] == '') {
            throw new Exception('Quantity cannot be empty');
        }
        // numeric validation for quantity
        if (!is_numeric($_POST['quantity'])) {
            throw new Exception('Quantity must be a number');
        }
        if ($_POST['regular_price'] == '') {
            throw new Exception('Regular Price cannot be empty');
        }
        if (!is_numeric($_POST['regular_price'])) {
            throw new Exception('Regular Price must be a number');
        }
        if ($_POST['sale_price'] == '') {
            throw new Exception('Sale Price cannot be empty');
        }
        if (!is_numeric($_POST['sale_price'])) {
            throw new Exception('Sale Price must be a number');
        }
        if ($_POST['sale_price'] > $_POST['regular_price']) {
            throw new Exception('Sale Price cannot be greater than Regular Price');
        }
        if ($_POST['short_description'] == '') {
            throw new Exception('Short Description cannot be empty');
        }
        if ($_POST['description'] == '') {
            throw new Exception('Description cannot be empty');
        }

        // Lấy dữ liệu cũ của sản phẩm
        $statement = $pdo->prepare("UPDATE products SET name=?, slug=?, product_category_id=?, quantity=?, regular_price=?, sale_price=?, short_description=?, description=?, sku=?, size=?, color=?, capacity=?, weight=?, pocket=?, water_resistant=?, warranty=? WHERE id=?");
        $statement->execute([
            $_POST['name'],
            $_POST['slug'],
            $_POST['product_category_id'],
            $_POST['quantity'],
            $_POST['regular_price'],
            $_POST['sale_price'],
            $_POST['short_description'],
            $_POST['description'],
            $_POST['sku'],
            $_POST['size'],
            $_POST['color'],
            $_POST['capacity'],
            $_POST['weight'],
            $_POST['pocket'],
            $_POST['water_resistant'],
            $_POST['warranty'],
            $_REQUEST['id']
        ]);

        $path = $_FILES['featured_photo']['name'];
        $path_tmp = $_FILES['featured_photo']['tmp_name'];

        if ($path != '') {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = "product_" . time() . "." . $extension;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mine = finfo_file($finfo, $path_tmp);
            if ($mine != 'image/jpeg' && $mine != 'image/png' && $mine != 'image/gif') {

                throw new Exception('Please upload a valid photo');
            }
            unlink('../uploads/' . $result['featured_photo']);

            $source = $path_tmp;
            $destination = '../uploads/' . $filename;
            image_resize($source, $destination, 350, 400);

            $statement = $pdo->prepare("UPDATE products SET featured_photo=? WHERE id=?");
            $statement->execute([$filename, $_REQUEST['id']]);

            $_SESSION['success_message'] = 'Product has been updated successfully';
            header('location: ' . ADMIN_URL . 'product-view.php');
            exit;
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        header('location: ' . ADMIN_URL . 'product-edit.php?id=' . $_REQUEST['id']);
        exit;
    }
}
?>


<?php
$statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Product</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>product-view.php" class="btn btn-primary"><i class="fas fa-eye"></i> View All</a>
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
                                            <label>Existing Featured Photo</label>
                                            <div>
                                                <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result['featured_photo']; ?>" alt="" style="width:140px;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Change Featured Photo</label>
                                            <div>
                                                <input type="file" name="featured_photo" id="featured_photo">
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <img id="preview_image" src="" alt="" style="width:140px; display:none;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" value="<?php echo $result['name']; ?>" required>
                                        </div>
                                    </div>

                                    <!-- Slug -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Slug</label>
                                            <input type="text" class="form-control" name="slug" value="<?php echo $result['slug']; ?>" placeholder="Leave blank to auto-generate">
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Select Category</label>
                                            <select class="form-select" name="product_category_id" required>
                                                <?php
                                                $statement = $pdo->prepare("SELECT * FROM product_categories ORDER BY name ASC");
                                                $statement->execute();
                                                $product_categories = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($product_categories as $row) {
                                                ?>
                                                    <option value="<?php echo $row['id']; ?>" <?php echo $row['id'] == $result['product_category_id'] ? 'selected' : ''; ?>> <?php echo $row['name']; ?> </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" value="<?php echo $result['quantity']; ?>" name="quantity">
                                        </div>
                                    </div>

                                    <!-- Regular Price -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Regular Price</label>
                                            <input type="text" class="form-control" value="<?php echo $result['regular_price']; ?>" name="regular_price">
                                        </div>
                                    </div>

                                    <!-- Sale Price -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Sale Price</label>
                                            <input type="text" class="form-control" value="<?php echo $result['sale_price']; ?>" name="sale_price">
                                        </div>
                                    </div>

                                    <!-- Short Description -->
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Short Description *</label>
                                            <textarea name="short_description" class="form-control h_100"><?php echo $result['short_description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label>Description *</label>
                                            <textarea name="description" class="form-control editor"><?php echo $result['description']; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>SKU</label>
                                            <input type="text" class="form-control" value="<?php echo $result['sku']; ?>" name="sku">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Size</label>
                                            <input type="number" class="form-control" value="<?php echo $result['size']; ?>" name="size">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Color</label>
                                            <input type="text" class="form-control" value="<?php echo $result['color']; ?>" name="color">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Capacity</label>
                                            <input type="text" class="form-control" value="<?php echo $result['capacity']; ?>" name="capacity">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Weight</label>
                                            <input type="text" class="form-control" value="<?php echo $result['weight']; ?>" name="weight">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Pocket</label>
                                            <input type="text" class="form-control" value="<?php echo $result['pocket']; ?>" name="pocket">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Water Resistant</label>
                                            <select class="form-select" name="water_resistant">
                                                <option value="Yes" <?php echo ($result['water_resistant'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                                                <option value="No" <?php echo ($result['water_resistant'] == 'No')  ? 'selected' : ''; ?>>No</option>

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Warranty</label>
                                            <input type="text" class="form-control" name="warranty" value="<?php echo $result['warranty']; ?>" placeholder="e.g. 12 months">
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