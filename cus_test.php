<?php
    require_once "config/db.php";

    $qr = $_GET['qr'];

    echo $qr;

    $stmt = $conn->query("SELECT * FROM cus_table WHERE qr LIKE '%$qr' AND status = '1'");
    $stmt->execute();
    $users = $stmt->fetchAll();

    if (!$users) {
        header('location: index.html');


    } else {    
 
    
    


?>
<!--
 **** AppzStory Shopping Cart System PHP MySQL ****
 *
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบตะกร้าสั่งซื้อสินค้าอย่างง่าย appzstory.dev</title>
    <link rel="shortcut icon" type="image/x-icon" href="icon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prompt">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    // require 'connect.php';

    /** ดึงข้อมูลสินค้า */
    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);

    /** เพิ่มข้อมูลสินค้าลงในตะกร้าแล้วหรือไม่ */
    if (isset($_GET['cart']) && ($_GET['cart'] == 'success')) {
        echo "<script>
                    Swal.fire({
                        text: 'คุณได้ทำการเพิ่มสินค้าลงในตะกร้าแล้ว',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    window.history.replaceState(null, null, window.location.pathname)
                </script>";
    }

    if (isset($_POST['btnStart'])) {

        $table = $_POST['table'];
        $status = 1;

        $stmt = $conn->query("SELECT * FROM cus_table WHERE id = '$table'");
        $stmt->execute();
        $tables = $stmt->fetchAll();

        foreach ($tables as $tablee) {
            $sta = $tablee['status'];
        }

        if ($sta == 0) {

            $sql = $conn->prepare("UPDATE cus_table SET status = :status WHERE id = :id");
            $sql->bindParam(":id", $table);
            $sql->bindParam(":status", $status);
            $sql->execute();

            if ($sql) {
                echo "<script>
                    Swal.fire({
                        text: 'เปิดโต๊ะละนะ อิอิ ^^',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    window.history.replaceState(null, null, window.location.pathname)
                </script>";
                $_SESSION['table'] = $table;
            }
        } else {

            echo "<script>
                    Swal.fire({
                        text: 'โต๊ะนี้ไม่ว่าง กรุณาเลือกโต๊ะอื่นนะคะ',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    window.history.replaceState(null, null, window.location.pathname)
                </script>";

            // echo "เปิดใช้งานโต๊ะนี้แล้ว";

        }
    }
    if (isset($_POST['cls'])) {

        $status = 0;
        $table = $_SESSION['table'];

        if (isset($_SESSION['table'])) {

            $sql = $conn->prepare("UPDATE cus_table SET status = :status WHERE id = :id");
            $sql->bindParam(":id", $table);
            $sql->bindParam(":status", $status);
            $sql->execute();
        }

        session_destroy();

        header("location: index.html");
    }


    ?>

    <div class="flex-container">
        <div class="container py-3">

            <!-- <h3 class="mb-4">ระบบตะกร้าสั่งซื้อสินค้าอย่างง่ายด้วย PHP MySQL Bootstrap5</h3> -->
            <nav class="navbar navbar-light bg-white border-0 shadow-sm rounded-3 mb-4">
                <div class="container-fluid">


                    <div class="l">
                        <!-- <button class="btn btn-dark"><a class="text-light" href="index.html"> กลับ</a></button> -->

                        <form action="" method="post">
                            <button class="btn btn-dark" type="submit" name="cls">ลุกออกจากโต๊ะ</button>
                        </form>

                    </div>

                    <!-- <a href="./" aria-current="page" class="navbar-brand">
                        <span class="brand-center">
                            <img src="https://appzstory.dev/_nuxt/img/logo.37c9600.png" width="50px" class="me-2">
                            <span class="d-none d-md-block"> AppzStory Studio <br> สอนเขียนเว็บไซต์ </span>
                        </span>
                    </a> -->

                    <div class="eiei">

                        <?php
                        $sql1 = "SELECT * FROM cus_table";
                        $result1 = $conn->query($sql1);
                        ?>
                        <form action="" method="post">

                            <select class="form-select-sm" name="table" id="">
                                <?php
                                while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) :
                                ?>
                                <option value="<?php echo $row1['id'] ?>"><?php echo $row1['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                            <button class="btn btn-dark" type="submit" name="btnStart">เริ่มเลือกอาหาร</button>
                            <!-- <button class="btn btn-dark" type="submit" name="btnEnd">หยุด</button> -->
                        </form>
                    </div>

                    <div class="">

                    </div>

                    <span class="text-end position-relative ">
                        <div class="btn-group">
                            <a class="btn btn-white btn-sm" href="cart.php">
                                ตะกร้าของคุณ <i class="fas fa-shopping-cart fa-2x"></i>
                                <span class="position-absolute translate-middle badge rounded-pill bg-danger z-10">
                                    <?php echo isset($_SESSION['cart_item']) ? count($_SESSION['cart_item']) : 0; ?>
                                </span>
                            </a>
                            <button type="button" class="btn btn-sm btn-white dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropdown</span>
                            </button>
                            <?php if (!empty($_SESSION['cart_item'])) : ?>
                            <ul class="dropdown-menu dropdown-menu-end" style="font-size: 0.9rem;">
                                <?php
                                        foreach ($_SESSION['cart_item'] as $value) :
                                        ?>
                                <li class="dropdown-item" style="width: 270px">
                                    <img src="<?php echo "uploads/" . $value['img'] ?>" class="img-fluid" width="50px"
                                        alt="aa">
                                    <span><?php echo substr($value['menu_name'], 0, 20) ?>... </span>
                                    <span class="badge rounded-pill bg-danger">
                                        <?php echo $value['amount'] ?>
                                    </span>
                                </li>
                                <?php endforeach; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-end" href="cart.php">ดูตะกร้าของคุณ</a></li>
                            </ul>
                            <?php else : ?>
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
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) :
                    ?>
                <div class="col-md-6 mb-4">
                    <div class="shadow rounded p-3 bg-body h-100">
                        <div class="row">
                            <div class="col-lg-5 mb-3 mb-lg-0">
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <img src="<?php echo "uploads/" . $row['img'] ?>" class="img-cover" alt="AppzStory">
                                </div>
                            </div>
                            <div class="col-lg-7 ps-lg-0">
                                <div class="card-body text-center text-lg-start p-0">
                                    <h5 class="card-title"><?php echo $row['menu_name'] ?></h5>
                                    <div class="rate mb-3">
                                        <i class="fas fa-star text-danger"></i>
                                        <i class="fas fa-star text-danger"></i>
                                        <i class="fas fa-star text-danger"></i>
                                        <i class="fas fa-star text-danger"></i>
                                        <i class="fas fa-star text-danger"></i>
                                    </div>
                                    <!-- <div class="card-text">
                                    <div class="variants mb-5">
                                        <p><?php echo $row['p_title'] ?></p>
                                    </div>
                                </div> -->
                                    <div class="card-price d-flex align-items-center justify-content-between">
                                        <span
                                            class="fw-bold text-danger">฿<?php echo number_format($row['menu_price'], 2) ?></span>

                                        <a href="updatecart.php?menu_id=<?php echo $row['menu_id'] ?>"
                                            class="btn btn-outline-primary" type="button">
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



            <!-- <p class="author fw-bolder text-secondary text-center">
                สอนเขียนเว็บไซต์ด้วยตัวเอง <span class="text-pink fs-3" style="vertical-align: sub;">♥️</span>
                <a class="border-bottom border-2 border-primary text-decoration-none"
                    href="https://appzstory.dev">AppzStory Studio</a>
            </p> -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#btnStart").click(function() {
            $(".eiei").hide();
        });
    });
    </script>
</body>

</html>

<?php
    }
?>