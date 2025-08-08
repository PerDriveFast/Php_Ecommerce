<?php include 'layouts/top.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Products</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>product-create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Sale Price</th>
                                            <th>Regular Price</th>
                                            <th>Stock</th>
                                            <th>Category</th>
                                            <th class="w_100">Photos</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $statement = $pdo->prepare("SELECT p.*,
                                                                    pc.name AS category_name 
                                                                    FROM products p
                                                                    JOIN product_categories pc 
                                                                    ON p.product_category_id = pc.id
                                                                    ORDER BY p.name ASC
                                                                ");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="" style="width: 140px;">
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['slug']; ?></td>
                                                <td>$<?php echo $row['sale_price']; ?></td>
                                                <td>$<?php echo $row['regular_price']; ?></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td><?php echo $row['category_name']; ?></td>
                                                <td>
                                                    <a href="<?php echo ADMIN_URL; ?>product-photo-gallery.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Photo Gallery</a>
                                                </td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL; ?>product-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL; ?>product-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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
            </div>
        </div>
    </section>
</div>

<?php include 'layouts/footer.php'; ?>