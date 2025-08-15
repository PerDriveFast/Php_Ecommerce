<?php include 'layouts/top.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Coupon</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL ?>coupon-create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add new</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example1" style="text-align: center;">
                                    <thead>
                                        <tr>

                                            <th>Code</th>
                                            <th>Discount</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Maximum Use</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $statement = $pdo->prepare("SELECT * FROM coupons");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['code']; ?> </td>
                                                <td><?php echo $row['discount']; ?> </td>
                                                <td><?php echo $row['type']; ?> </td>
                                                <td><?php echo $row['start_date']; ?> </td>
                                                <td><?php echo $row['end_date']; ?> </td>
                                                <td><?php echo $row['maximum_use']; ?> </td>
                                                <td>
                                                    <?php
                                                    if ($row['status'] == "Active") {
                                                        echo "<span class='badge badge-success'>Active</span>";
                                                    } else {
                                                        echo "<span class='badge badge-danger'>Inactive</span>";
                                                    }
                                                    ?>
                                                </td>

                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL ?>coupon-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL ?>coupon-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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