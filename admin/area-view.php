<?php include 'layouts/top.php'; ?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Area</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL ?>area-create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add new</a>
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

                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Charge</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $statement = $pdo->prepare("SELECT * FROM areas");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $i++;
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['name']; ?> </td>
                                                <td><?php echo $row['charge']; ?> </td>
                                                <td class="pt_10 pb_10">
                                                    <a href="<?php echo ADMIN_URL ?>area-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                    <a href="<?php echo ADMIN_URL ?>area-delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onClick="return confirm('Are you sure?');"><i class="fas fa-trash"></i></a>
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