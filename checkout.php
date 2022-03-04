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
    if(isset($_SESSION['cart_item'])){

        /** คำนวณยอดเต็มทั้งหมด */
        $total = array_sum(array_map(function($value){
            return $value['menu_price'] * $value['amount'];
        }, $_SESSION['cart_item']));
        
    } else {
        header("location: ./");
    }
?>
    <div class="flex-container">
        <div class="container py-3">
            <!-- <h3 class="mb-4">ระบบตะกร้าสั่งซื้อสินค้าอย่างง่ายด้วย PHP MySQL Bootstrap5</h3> -->
            <nav class="navbar navbar-light bg-white border-0 shadow-sm rounded-3 mb-4">
                <div class="container-fluid">
                    <a href="./" aria-current="page" class="navbar-brand">
                        <span class="brand-center">
                            <!-- <img src="https://appzstory.dev/_nuxt/img/logo.37c9600.png" width="50px" class="me-2"> 
                            <span class="d-none d-md-block"> AppzStory Studio <br> สอนเขียนเว็บไซต์ </span> -->
                        </span>
                    </a>
                    <span class="text-end position-relative">
                        <div class="btn-group">
                            <a href="./cart.php" class="btn btn-outline-secondary">แก้ไขตะกร้าสินค้า</a> 
                        </div>
                    </span>
                </div>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <form action="createorder.php" method="POST">

                                <!-- <h5 class="card-title">ข้อมูลลูกค้า</h5>

                                <div class="row px-3 px-md-5 py-3">

                                    <div class="col-md-6 mb-3">
                                        <label for="order_name" class="form-label">โต๊ะ</label>   
                                        <input type="text" class="form-control" id="order_name" name="order_name" placeholder="ชื่อ-นามสกุล" required>
                                    </div>                                    
                                </div> -->
                                <hr>
                                <h5 class="card-title">สรุปรายการสั่งซื้อ</h5>
                                <?php if(!empty($_SESSION['cart_item'])): ?>
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <thead>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>รูปภาพ</th>
                                                    <th>สินค้า</th>
                                                    <th>ราคาต่อชิ้น</th>
                                                    <th>จำนวน</th>
                                                    <th>ราคารวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $number = 0;
                                                    foreach ($_SESSION['cart_item'] as $key => $value):
                                                        $number++;
                                                ?>
                                                <tr class="products">
                                                    <td><?php echo $number;?></td>
                                                    <td><img src="<?php echo "uploads/".$value['img'] ?>" class="img-fluid" width="150px" alt=""></td>
                                                    <td><?php echo $value['menu_name'] ?></td>
                                                    <td>฿<?php echo number_format($value['menu_price'], 2) ?></td>
                                                    <td><?php echo $value['amount'] ?></td>
                                                    <td>฿<?php echo number_format($value['menu_price'] * $value['amount'], 2) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <tr class="pt-3">
                                                    <td colspan="5" class="text-end py-3">รวมเป็นเงินทั้งสิ้น :</td>
                                                    <td class="text-danger fw-bold py-3"><?php echo number_format($total, 2); ?> บาท</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="btn-group float-end">
                                        <input type="submit" name="submit" class="btn btn-danger px-5" value="สั่งอาหาร">
                                    </div>
                                <?php else: ?>
                                    <div class="text-center p-3">
                                        <p class="h4">ไม่มีสินค้าในตะกร้า</p>
                                        <a href="./">หน้ารวมสินค้า</a>
                                    </div>
                                <?php endif; ?>
                            </form>
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