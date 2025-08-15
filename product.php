 <?php include 'header.php'; ?>
 <?php
    $statement = $pdo->prepare("SELECT * FROM products WHERE slug=?");
    $statement->execute([$_REQUEST['slug']]);
    $product_data = $statement->fetch(PDO::FETCH_ASSOC);
    $total = $statement->rowCount();
    if ($total == 0) {
        header('location: ' . BASE_URL);
        exit;
    }

    $statement = $pdo->prepare("SELECT * FROM product_categories WHERE id=?");
    $statement->execute([$product_data['product_category_id']]);
    $category_data = $statement->fetch(PDO::FETCH_ASSOC);
    ?>

 <?php
    if (isset($_POST['form_add_to_cart'])) {
        try {

            $statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
            $statement->execute([$_POST['id']]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if ($result['quantity'] == 0) {
                throw new Exception("Product is out of stock 11.");
            }

            if (!isset($_SESSION['product_id'])) {
                $_SESSION['product_id'][1] = $_POST['id'];
                $_SESSION['product_quantity'][1] = 1;
            } else {
                $key = array_search($_POST['id'], $_SESSION['product_id']);
                if ($_SESSION['product_quantity'][$key] + 1 > $result['quantity']) {
                    throw new Exception("Product quantity exceeds available stock 22.");
                }
                if ($key !== false) {
                    $_SESSION['product_quantity'][$key] += 1;
                } else {
                    $key = count($_SESSION['product_id']) + 1;
                    $_SESSION['product_id'][$key] = $_POST['id'];
                    $_SESSION['product_quantity'][$key] = 1;
                }
            }

            $_SESSION['success_message'] = "Product added to cart successfully.";
            header("location: " . BASE_URL . "cart.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location: " . BASE_URL);
            exit();
        }
    }
    ?>

 <?php
    if (isset($_POST['form_add_to_cart_with_quantity'])) {
        try {

            $statement = $pdo->prepare("SELECT * FROM products WHERE id=?");
            $statement->execute([$_POST['id']]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if ($result['quantity'] == 0) {
                throw new Exception("Product is out of stock.");
            }



            if (!isset($_SESSION['product_id'])) {
                if ($_POST['quantity'] > $result['quantity']) {
                    throw new Exception("Product quantity exceeds available stock.");
                }
                $_SESSION['product_id'][1] = $_POST['id'];
                $_SESSION['product_quantity'][1] = $_POST['quantity'];
            } else {
                $key = array_search($_POST['id'], $_SESSION['product_id']);

                if ($key !== false) {
                    if ($_SESSION['product_quantity'][$key] + $_POST['quantity'] > $result['quantity']) {
                        throw new Exception("Product quantity exceeds available stock.");
                    }
                    $_SESSION['product_quantity'][$key] += $_POST['quantity'];
                } else {
                    $key = count($_SESSION['product_id']) + 1;
                    $_SESSION['product_id'][$key] = $_POST['id'];
                    $_SESSION['product_quantity'][$key] = $_POST['quantity'];
                }
            }

            $_SESSION['success_message'] = "Product added to cart successfully.";
            header("location: " . BASE_URL . "cart.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header("location: " . BASE_URL . "product.php?slug=" . $_REQUEST['slug']);
            exit();
        }
    }
    ?>
 <!-- breadcrumb start -->
 <div class="breadcrumb">
     <div class="container">
         <ul class="list-unstyled d-flex align-items-center m-0">
             <li><a href="i<?php echo BASE_URL; ?>">Home</a></li>
             <li class="ml_10 mr_10">
                 <i class="fas fa-chevron-right"></i>
             </li>
             <li><?php echo $category_data['name']; ?></li>
             <li class="ml_10 mr_10">
                 <i class="fas fa-chevron-right"></i>
             </li>
             <li><?php echo $product_data['name']; ?></li>
         </ul>
     </div>
 </div>
 <!-- breadcrumb end -->

 <main id="MainContent" class="content-for-layout">
     <div class="product-page mt-100">
         <div class="container">
             <div class="row">
                 <div class="col-lg-6 col-md-12 col-12">
                     <div class="product-gallery product-gallery-vertical d-flex">
                         <div class="product-img-large">
                             <div class="img-large-slider common-slider" data-slick='{
                                "slidesToShow": 1,
                                "slidesToScroll": 1,
                                "dots": false,
                                "arrows": false,
                                "asNavFor": ".img-thumb-slider"
                            }'>

                                 <div class="img-large-wrapper">
                                     <a href="<?php echo BASE_URL; ?>uploads/<?php echo $product_data['featured_photo']; ?>" data-fancybox="gallery">
                                         <img src="<?php echo BASE_URL; ?>uploads/<?php echo $product_data['featured_photo']; ?>" alt="img">
                                     </a>
                                 </div>

                                 <?php
                                    $statement = $pdo->prepare("SELECT * FROM product_photos WHERE product_id=?");
                                    $statement->execute([$product_data['id']]);
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                     <div class="img-large-wrapper">
                                         <a href="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" data-fancybox="gallery">
                                             <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="img">
                                         </a>
                                     </div>
                                 <?php
                                    }
                                    ?>

                             </div>
                         </div>
                         <div class="product-img-thumb">
                             <div class="img-thumb-slider common-slider" data-vertical-slider="true" data-slick='{
                                "slidesToShow": 5, 
                                "slidesToScroll": 1,
                                "dots": false,
                                "arrows": true,
                                "infinite": false,
                                "speed": 300,
                                "cssEase": "ease",
                                "focusOnSelect": true,
                                "swipeToSlide": true,
                                "asNavFor": ".img-large-slider"
                            }'>
                                 <div>
                                     <div class="img-thumb-wrapper">
                                         <img src="<?php echo BASE_URL; ?>uploads/<?php echo $product_data['featured_photo']; ?>" alt="img">
                                     </div>
                                 </div>
                                 <?php
                                    $statement = $pdo->prepare("SELECT * FROM product_photos WHERE product_id=?");
                                    $statement->execute([$product_data['id']]);
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    ?>
                                     <div>
                                         <div class="img-thumb-wrapper">
                                             <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="img">
                                         </div>
                                     </div>
                                 <?php
                                    }
                                    ?>

                             </div>
                             <div class="activate-arrows show-arrows-always arrows-white d-none d-lg-flex justify-content-between mt-3"></div>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-6 col-md-12 col-12">
                     <div class="product-details ps-lg-4">
                         <div class="mb-3">
                             <?php if ($product_data['quantity'] > 0): ?>
                                 <span class="product-availability" style="background-color: #1ea51e; color: #fff;">In Stock</span>
                             <?php else: ?>
                                 <span class="product-availability" style="background-color: red; color: #fff;">Out of Stock</span>
                             <?php endif; ?>
                         </div>
                         <h2 class="product-title mb-3"><?php echo $product_data['name']; ?></h2>

                         <div class="product-price-wrapper mb-4">
                             <span class="product-price regular-price">$<?php echo $product_data['sale_price']; ?></span>
                             <?php if ($product_data['regular_price'] > $product_data['sale_price']): ?>
                                 <del class="card-price-compare text-decoration-line-through">$<?php echo $product_data['regular_price']; ?></del>
                             <?php endif; ?>
                         </div>

                         <div class="product-vendor product-meta mb-3">
                             <strong class="label">Category:</strong> <?php echo $category_data['name']; ?>
                         </div>

                         <div class="product-short-description">
                             <p>
                                 <?php echo $product_data['short_description'] ?>
                             </p>
                         </div>
                         <form class="product-form" action="" method="post">
                             <input type="hidden" name="id" value="<?php echo $product_data['id']; ?>">
                             <div class="misc d-flex align-items-end justify-content-between mt-4">
                                 <div class="d-flex align-items-center justify-content-between">
                                     <input type="number" name="quantity" value="1" min="1" style="text-align: center;" max="<?php echo $product_data['quantity']; ?>">
                                 </div>
                             </div>
                             <div class="product-form-buttons d-flex align-items-center justify-content-between mt-4">
                                 <button type="submit" class="position-relative btn-atc btn-add-to-cart loader" name="form_add_to_cart_with_quantity">ADD TO CART</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!-- product tab start -->
     <div class="product-tab-section mt-100" data-aos="fade-up" data-aos-duration="700">
         <div class="container">
             <div class="tab-list product-tab-list">
                 <nav class="nav product-tab-nav">
                     <a class="product-tab-link tab-link active" href="#pdescription" data-bs-toggle="tab">Description</a>
                     <a class="product-tab-link tab-link" href="#pspecification" data-bs-toggle="tab">Specification</a>
                 </nav>
             </div>
             <div class="tab-content product-tab-content">
                 <div id="pdescription" class="tab-pane fade show active">
                     <div class="row">
                         <div class="col-lg-12 col-md-12 col-12">
                             <div class="desc-content">
                                 <p>
                                     <?php echo $product_data['description']; ?>
                                 </p>

                             </div>
                         </div>
                     </div>
                 </div>
                 <div id="pspecification" class="tab-pane fade">
                     <div class="desc-content">
                         <div class="table-responsive">
                             <table class="table table-bordered">
                                 <tr>
                                     <td>SKU</td>
                                     <td><?php echo $product_data['sku']; ?></td>
                                 </tr>
                                 <tr>
                                     <td>Size</td>
                                     <td><?php echo $product_data['size']; ?></td>
                                 </tr>
                                 <tr>
                                     <td>Color</td>
                                     <td><?php echo $product_data['color']; ?></td>
                                 </tr>
                                 <tr>
                                     <td>Capacity</td>
                                     <td><?php echo $product_data['capacity']; ?></td>
                                 </tr>

                                 <tr>
                                     <td>Weight</td>
                                     <td><?php echo $product_data['weight']; ?></td>
                                 </tr>
                                 <tr>
                                     <td>Pocket</td>
                                     <td><?php echo $product_data['pocket']; ?></td>
                                 </tr>
                                 <tr>
                                     <td>Water Resistance</td>
                                     <td><?php echo $product_data['water_resistant']; ?></td>
                                 </tr>
                                 <tr>
                                     <td>Warrant</td>
                                     <td><?php echo $product_data['warranty']; ?></td>
                                 </tr>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- product tab end -->

     <?php

        $statement = $pdo->prepare("SELECT * FROM products WHERE id!=? AND product_category_id=? ORDER BY id DESC");
        $statement->execute([$product_data['id'], $product_data['product_category_id']]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $total = $statement->rowCount();
        ?>

     <?php
        if ($total >  0):


        ?>


         <!-- you may also like start -->
         <div class="featured-collection-section mt-100 home-section overflow-hidden">
             <div class="container">
                 <div class="section-header">
                     <h2 class="section-heading">You may also like</h2>
                 </div>

                 <div class="product-container position-relative">
                     <div class="common-slider" data-slick='{
                "slidesToShow": 4, 
                "slidesToScroll": 1,
                "dots": false,
                "arrows": true,
                "responsive": [
                {
                    "breakpoint": 1281,
                    "settings": {
                    "slidesToShow": 3
                    }
                },
                {
                    "breakpoint": 768,
                    "settings": {
                    "slidesToShow": 2
                    }
                }
                ]
            }'>


                         <?php


                            foreach ($result as $row) {
                            ?>
                             <div class="new-item">
                                 <div class="product-card">
                                     <div class="product-card-img">
                                         <a class="hover-switch" href="<?php echo BASE_URL ?>product.php?slug=<?php echo $row['slug']; ?>">
                                             <img class="primary-img" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="">
                                         </a>

                                         <form action="" method="post" class="product-card-action product-card-action-2">
                                             <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
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
                                         <h3 class="product-card-title"><a href="<?php echo BASE_URL ?>product.php?slug=<?php echo $row['slug']; ?>"><?php echo $row['name']; ?></a>
                                         </h3>
                                         <div class="product-card-price">
                                             <span class="product-price regular-price">$<?php echo $product_data['sale_price']; ?></span>
                                             <?php if ($product_data['regular_price'] > $product_data['sale_price']): ?>
                                                 <del class="card-price-compare text-decoration-line-through">$<?php echo $product_data['regular_price']; ?></del>
                                             <?php endif; ?>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         <?php
                            }
                            ?>



                     </div>
                     <div class="activate-arrows show-arrows-always article-arrows arrows-white"></div>
                 </div>
             </div>
         </div>
         <!-- you may also lik end -->
     <?php endif; ?>
 </main>

 <?php include 'footer.php'; ?>