<!-- 
 **** AppzStory Shopping Cart System PHP MySQL ****
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 -->
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Meepoong Manage Restaurant</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="shortcut icon" type="image/x-icon" href="icon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prompt">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- Favicon -->
      <link href="img/favicon.ico" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

<!-- Icon Font Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Libraries Stylesheet -->
<link href="lib/animate/animate.min.css" rel="stylesheet">
<link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
<link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

<!-- Customized Bootstrap Stylesheet -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

    <?php
        require 'connect.php';
        /** ดึงข้อมูลสินค้า */
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        /** เพิ่มข้อมูลสินค้าลงในตะกร้าแล้วหรือไม่ */
        if(isset($_GET['cart']) && ($_GET['cart'] == 'success')){
            echo "<script>
                    Swal.fire({
                        text: 'คุณได้ทำการเพิ่มสินค้าลงในตะกร้าแล้ว',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    window.history.replaceState(null, null, window.location.pathname)
                </script>";
        }
    ?>
    <div class="flex-container">
        <div class="container py-3">
            <h3 class="mb-4">ระบบตะกร้าสั่งซื้อสินค้าอย่างง่ายด้วย PHP MySQL Bootstrap5</h3>
            <nav class="navbar navbar-light bg-white border-0 shadow-sm rounded-3 mb-4">
                <div class="container-fluid">
                    <a href="./" aria-current="page" class="navbar-brand">
                        <span class="brand-center">
                            <img src="https://appzstory.dev/_nuxt/img/logo.37c9600.png" width="50px" class="me-2"> 
                            <span class="d-none d-md-block"> AppzStory Studio <br> สอนเขียนเว็บไซต์ </span>
                        </span>
                    </a>
                    <span class="text-end position-relative ">
                        <div class="btn-group">
                            <a class="btn btn-white btn-sm" href="cart.php">
                                ตะกร้าของคุณ <i class="fas fa-shopping-cart fa-2x"></i>
                                <span class="position-absolute translate-middle badge rounded-pill bg-danger z-10">
                                    <?php echo isset($_SESSION['cart_item']) ? count($_SESSION['cart_item']) : 0; ?>
                                </span>
                            </a>
                            <button type="button" class="btn btn-sm btn-white dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <?php if(!empty($_SESSION['cart_item'])): ?>
                                <ul class="dropdown-menu dropdown-menu-end" style="font-size: 0.9rem;">
                                    <?php 
                                        foreach ($_SESSION['cart_item'] as $value):
                                    ?>
                                    <li class="dropdown-item" style="width: 270px">  
                                        <img src="<?php echo $value['p_img'] ?>" class="img-fluid" width="50px" alt="AppzStory">
                                        <span><?php echo substr($value['p_name'], 0 , 20) ?>... </span>
                                        <span class="badge rounded-pill bg-danger">
                                            <?php echo $value['p_amount'] ?>
                                        </span>
                                    </li>
                                    <?php endforeach; ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-end" href="cart.php">ดูตะกร้าของคุณ</a></li>
                                </ul>
                            <?php else: ?>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item">ไม่มีสินค้าในตะกร้า</li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </span>
                </div>
            </nav>
            <div class="row">
            <?php
                while ($row = $result->fetch(PDO::FETCH_ASSOC)):
            ?>
                <div class="col-md-6 mb-4">
                    <div class="shadow rounded p-3 bg-body h-100">
                        <div class="row">
                            <div class="col-lg-5 mb-3 mb-lg-0">
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <img src="<?php echo $row['p_img'] ?>" class="img-cover" alt="AppzStory">
                                </div>
                            </div>
                            <div class="col-lg-7 ps-lg-0">
                            <div class="card-body text-center text-lg-start p-0">
                                <h5 class="card-title"><?php echo $row['p_name'] ?></h5>
                                <div class="rate mb-3">
                                    <i class="fas fa-star text-danger"></i>
                                    <i class="fas fa-star text-danger"></i>
                                    <i class="fas fa-star text-danger"></i>
                                    <i class="fas fa-star text-danger"></i>
                                    <i class="fas fa-star text-danger"></i>
                                </div>
                                <div class="card-text">
                                    <div class="variants mb-5">
                                        <p><?php echo $row['p_title'] ?></p>
                                    </div>
                                </div>
                                <div class="card-price d-flex align-items-center justify-content-between">
                                    <span class="fw-bold text-danger">฿<?php echo number_format($row['price'],2) ?></span>
                                    <a href="updatecart.php?p_id=<?php echo $row['p_id'] ?>" class="btn btn-outline-primary" type="button">
                                        <i class="fas fa-cart-plus"></i> เพิ่มไปยังตะกร้า
                                    </a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
            <p class="author fw-bolder text-secondary text-center">
            สอนเขียนเว็บไซต์ด้วยตัวเอง <span class="text-pink fs-3" style="vertical-align: sub;">♥️</span>
            <a class="border-bottom border-2 border-primary text-decoration-none" href="https://appzstory.dev">AppzStory Studio</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>