<?php include 'header.php'; ?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Products</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->


<main id="MainContent" class="content-for-layout">
    <div class="collection mt-100">
        <div class="container">
            <div class="row flex-row-reverse">
                <?php
                $q = $pdo->prepare("SELECT * FROM products");
                $q->execute();
                $total = $q->rowCount();
                ?>

                <!-- product area start -->
                <div class="col-lg-9 col-md-12 col-12">
                    <div class="filter-sort-wrapper d-flex justify-content-between flex-wrap">
                        <div class="collection-title-wrap d-flex align-items-end">
                            <h2 class="collection-title heading_24 mb-0">All products</h2>
                            <p class="collection-counter text_16 mb-0 ms-2">(237 items)</p>
                        </div>
                        <div class="filter-sorting">
                            <div class="filter-drawer-trigger mobile-filter d-flex align-items-center d-lg-none">
                                <span class="mobile-filter-icon me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-filter">
                                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                    </svg>
                                </span>
                                <span class="mobile-filter-heading">Filter and Sorting</span>
                            </div>
                        </div>
                    </div>
                    <div class="collection-product-container">
                        <div class="row">

                            <?php
                            $per_page = 3;
                            $total_pages = ceil($total / $per_page);

                            if (!isset($_REQUEST['p'])) {
                                $start = 1;
                            } else {
                                $start = $per_page * ($_REQUEST['p'] - 1) + 1;
                            }


                            $j = 0;
                            $k = 0;
                            $arr1 = [];
                            $res = $q->fetchAll();
                            foreach ($res as $row) {
                                $j++;
                                if ($j >= $start) {
                                    $k++;
                                    if ($k > $per_page) {
                                        break;
                                    }
                                    $arr1[] = $row['id'];
                                }
                            }
                            $statement = $pdo->prepare("SELECT * FROM products");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            $total_row = $statement->rowCount();
                            foreach ($result as $row) {
                                if (!in_array($row['id'], $arr1)) {
                                    continue;
                                }
                            ?>

                                <div class="col-lg-4 col-md-6 col-6">
                                    <div class="new-item">
                                        <div class="product-card">
                                            <div class="product-card-img">
                                                <a class="hover-switch" href="<?php echo BASE_URL; ?>product.php?slug=<?php echo $row['slug']; ?>">
                                                    <img class="primary-img" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="">
                                                </a>

                                                <form action="" method="post" class="product-card-action product-card-action-2">
                                                    <button type="submit" class="addtocart-btn btn-primary" name="form_add_to_cart">
                                                        ADD TO CART
                                                    </button>
                                                </form>


                                                <form action="" method="post">
                                                    <button type="submit" class="wishlist-btn card-wishlist" name="form_wishlist">
                                                        <i class="far fa-heart" style="color:#000;font-size:20px;"></i></button>
                                                </form>
                                            </div>
                                            <div class="product-card-details text-center">
                                                <h3 class="product-card-title"><a href="<?php echo BASE_URL; ?>product.php?slug=<?php echo $row['slug']; ?>"><?php echo $row['name']; ?></a>
                                                </h3>
                                                <div class="product-card-price">
                                                    <span class="product-price regular-price">$<?php echo $row['sale_price']; ?></span>
                                                    <?php if ($row['regular_price'] > $row['sale_price']): ?>
                                                        <del class="card-price-compare text-decoration-line-through">$<?php echo $row['regular_price']; ?></del>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>

                    <?php if ($per_page < $total_row): ?>
                        <div class="pagination justify-content-center mt-100">
                            <nav>
                                <ul class="pagination m-0 d-flex align-items-center">

                                    <?php
                                    $common_url = BASE_URL . 'shop.php';


                                    if (isset($_REQUEST['p'])) {
                                        if ($_REQUEST['p'] == 1) {
                                    ?>
                                            <li class="item">
                                                <a class="link" href="javascript:void;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-left">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg>
                                                </a>
                                            </li>
                                        <?php
                                        } else {
                                        ?>
                                            <li class="item">
                                                <a class="link" href="<?php echo $common_url; ?>&p=<?php echo $_REQUEST['p'] - 1; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-left">
                                                        <polyline points="15 18 9 12 15 6"></polyline>
                                                    </svg>
                                                </a>
                                            </li>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <li class="item">
                                            <a class="link" href="javascript:void;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-left">
                                                    <polyline points="15 18 9 12 15 6"></polyline>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>


                                    <?php
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                    ?>
                                        <li class="item"><a class="link" href="<?php echo $common_url; ?>&p=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php
                                    }
                                    ?>


                                    <?php
                                    if (isset($_REQUEST['p'])) {
                                        if ($_REQUEST['p'] == $total_pages) {
                                    ?>
                                            <li class="item">
                                                <a class="link" href="javascript:void;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg>
                                                </a>
                                            </li>
                                        <?php
                                        } else {
                                        ?>
                                            <li class="item">
                                                <a class="link" href="<?php echo $common_url; ?>&p=<?php echo $_REQUEST['p'] + 1; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-right">
                                                        <polyline points="9 18 15 12 9 6"></polyline>
                                                    </svg>
                                                </a>
                                            </li>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <li class="item">
                                            <a class="link" href="<?php echo $common_url; ?>&p=2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-right">
                                                    <polyline points="9 18 15 12 9 6"></polyline>
                                                </svg>
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>


                </div>
                <!-- product area end -->

                <!-- sidebar start -->
                <div class="col-lg-3 col-md-12 col-12">
                    <div class="collection-filter filter-drawer">

                        <div class="filter-widget">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom"
                                data-bs-toggle="collapse" data-bs-target="#filter-availability">
                                Title or content
                            </div>
                            <div class="mt_20">
                                <input type="text" name="search" class="form-control" placeholder="Search...">

                            </div>
                        </div>
                        <!--Product Categories Session  -->


                        <div class="filter-widget">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom"
                                data-bs-toggle="collapse" data-bs-target="#filter-collection">
                                Categories
                                <span class="faq-heading-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </div>
                            <div id="filter-collection" class="accordion-collapse collapse show">
                                <ul class="filter-lists list-unstyled mb-0">
                                    <?php
                                    $statement = $pdo->prepare("SELECT * FROM product_categories ORDER BY name ASC ");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($result as $row) {
                                    ?>

                                        <li class="filter-item">
                                            <label class="filter-label">
                                                <input type="checkbox" name="category" />
                                                <span class="filter-checkbox rounded me-2"></span>
                                                <span class="filter-text"><?php echo $row['name'] ?></span>
                                            </label>
                                        </li>
                                    <?php
                                    }
                                    ?>


                                </ul>
                            </div>
                        </div>

                        <!-- Availability -->

                        <div class="filter-widget">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom"
                                data-bs-toggle="collapse" data-bs-target="#filter-availability">
                                Availability
                                <span class="faq-heading-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </div>
                            <div id="filter-availability" class="accordion-collapse collapse show">
                                <ul class="filter-lists list-unstyled mb-0">
                                    <li class="filter-item">
                                        <label class="filter-label">
                                            <input type="checkbox" />
                                            <span class="filter-checkbox rounded me-2"></span>
                                            <span class="filter-text">In Stock</span>
                                        </label>
                                    </li>
                                    <li class="filter-item">
                                        <label class="filter-label">
                                            <input type="checkbox" />
                                            <span class="filter-checkbox rounded me-2"></span>
                                            Out of Stock
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="filter-widget">
                            <div class="filter-header faq-heading heading_18 d-flex align-items-center justify-content-between border-bottom"
                                data-bs-toggle="collapse" data-bs-target="#filter-price">
                                Price
                                <span class="faq-heading-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </div>
                            <div id="filter-price" class="accordion-collapse collapse show">
                                <div class="filter-price d-flex align-items-center justify-content-between">
                                    <div class="filter-field">
                                        <input class="field-input" type="number" placeholder="৳0" min="0"
                                            max="2000.00">
                                    </div>
                                    <div class="filter-separator px-3">To</div>
                                    <div class="filter-field">
                                        <input class="field-input" type="number" min="0" placeholder="৳595.00"
                                            max="2000.00">
                                    </div>
                                </div>
                            </div>
                        </div>





                        <!-- Add this script at the end of your HTML -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Define all filter groups you want this behavior applied to
                                const filterGroups = [
                                    '#filter-vendor',
                                    '#filter-price',
                                    '#filter-collection',
                                    '#filter-availability'
                                ];

                                // Loop through each group and apply the radio-like behavior
                                filterGroups.forEach(group => {
                                    const checkboxes = document.querySelectorAll(`${group} input[type="checkbox"]`);

                                    checkboxes.forEach(checkbox => {
                                        checkbox.addEventListener('change', function() {
                                            if (this.checked) {
                                                // Uncheck others in the same group
                                                checkboxes.forEach(cb => {
                                                    if (cb !== this) cb.checked = false;
                                                });
                                            }
                                        });
                                    });
                                });
                            });
                        </script>


                        <button type="submit" class="form-control btn btn-primary">Apply Filters</button>

                    </div>
                </div>
                <!-- sidebar end -->
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>