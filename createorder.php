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
    <title>Meepoong Manage Restaurant</title>
    <link rel="shortcut icon" type="image/x-icon" href="icon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
</head>
<body>
<?php
    // require 'connect.php';
    require_once "config/db.php";

    /** เช็คว่ามีข้อมูลสินค้าในตะกร้า session หรือไม่ */
    if(isset($_SESSION['cart_item']) && isset($_POST['submit'])){
        try{
            /** เพิ่มข้อมูลลงใน orders */

            // $params = array(
            //     'order_name' => $_POST['order_name'],
            //     'order_email' => $_POST['order_email'],
            //     'order_phone' => $_POST['order_phone'],
            //     'order_address' => $_POST['order_address'],

            //     'created_at' => date("Y-m-d H:i:s"),
            //     'updated_at' => date("Y-m-d H:i:s")
            // );

            // $sql = "INSERT INTO order (order_id, order_table, order_menu, order_piece) 
            //         VALUES (:order_id, :order_table, :order_menu, :order_piece)";
            // $stmt = $conn->prepare($sql);
            // $stmt->execute($params);
            // $lastInsertId = $conn->lastInsertId();
            
            // if($lastInsertId){


                $order_id = "order".rand(1000,9999);

                $order_time = date("Y-m-d H:i:s");
                $status = 0;

                foreach ($_SESSION['cart_item'] as $value) {
                    /** เพิ่มข้อมูลลงใน order_details */

                    $sql = $conn->prepare("INSERT INTO orders (order_id, order_table, order_menu, order_piece, order_time, order_status) VALUES( :order_id, :order_table, :order_menu, :order_piece, :order_time, :order_status);");
                    $sql->bindParam(":order_id", $order_id);                                      
                    $sql->bindParam(":order_table", $_SESSION['table']);
                    $sql->bindParam(":order_menu", $value['menu_id']);
                    $sql->bindParam(":order_piece", $value['amount']);
                    $sql->bindParam(":order_time", $order_time);
                    $sql->bindParam(":order_status", $status);

                    $sql->execute();
                }

                unset( $_SESSION['cart_item'] );
            // }
            // session_destroy();

        } catch(Throwable $e) {
            echo $e;

            // echo '<script> alert("ระบบผิดพลาด โปรดติดต่อผู้ดูแลระบบ")</script>'; 
            // header('Refresh:0; url=./');
        }
    } else {
        header("location: cus_test.php");
    }
?>
    <div class="flex-container">
        <div class="container py-3">
            <h3 class="mb-4">กรุณารอสักครู่..คำสั้งซื้อได้ถึงห้องครัวแล้ว</h3>
            <nav class="navbar navbar-light bg-white border-0 shadow-sm rounded-3 mb-4">
                <div class="container-fluid">
                    <a href="./" aria-current="page" class="navbar-brand">
                        <span class="brand-center">
                            <!-- <img src="https://appzstory.dev/_nuxt/img/logo.37c9600.png" width="50px" class="me-2"> 
                            <span class="d-none d-md-block"> AppzStory Studio <br> สอนเขียนเว็บไซต์ </span> -->
                        </span>
                    </a>
                    <span class="text-end position-relative me-3">
                        <div class="btn-group">
                            <a href="cus_test.php" class="btn btn-outline-secondary">กลับสู่หน้าหลัก</a> 
                        </div>
                    </span>
                </div>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body text-center">
                            <div class="alert alert-success" role="alert">
                                สร้างรายการเสร็จเรียบร้อย !
                            </div>
                            <!-- <ul class="list-group">
                                <li class="list-group-item border-0">รหัสสั่งซื้อ: #<?php echo str_pad($lastInsertId, 5, '0', STR_PAD_LEFT); ?> </li>
                                <li class="list-group-item border-0">ชื่อ: <?php echo $_POST['order_name'] ?> </li>
                                <li class="list-group-item border-0">เวลาสั่งซื้อ: <?php echo date("d/m/Y H:i:s") ?> </li>
                            </ul> -->
                            <hr>
                            <a href="cus_test.php"> กลับสู่หน้าหลัก </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <p class="author fw-bolder text-secondary text-center">
            สอนเขียนเว็บไซต์ด้วยตัวเอง <span class="text-pink fs-3" style="vertical-align: sub;">♥️</span>
            <a class="border-bottom border-2 border-primary text-decoration-none" href="https://appzstory.dev">AppzStory Studio</a>
            </p> -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>