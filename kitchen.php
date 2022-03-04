<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ห้องครัว</title>

    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</head>

<body>
    <?php    
    require_once "config/db.php";

    /** ดึงข้อมูลสินค้า */
    // $sql = "SELECT * FROM orders WHERE status = '0'";
    // $result = $conn->query($sql);
    if(isset($_POST['update'])){

        $id = $_POST['order_id'];
        $table = $_POST['table'];
        $status = 1;
        $status_waiter = 0;

        try{

        

        $sqlW = $conn->prepare("INSERT INTO waiter(waiter_id, waiter_order, waiter_table, waiter_status) 
        VALUES(null, :waiter_order, :waiter_table, :waiter_status)");
        $sqlW->bindParam(":waiter_order", $id);
        $sqlW->bindParam(":waiter_table", $table);
        $sqlW->bindParam(":waiter_status", $status_waiter);
        $sqlW->execute();

        $sql = $conn->prepare("UPDATE orders SET order_status = :order_status WHERE order_n = :id");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":order_status", $status);
        $sql->execute();

        }catch(Throwable $e){
            echo $e;
        }

    }
    ?>
    <div class="row">
    <div class="col-sm-4 bg-dark text-white"></div>
    <div class="col-sm-4 bg-dark text-white">
        <h1 class="text-center">ห้องครัว</h1>
    </div>
    <div class="col-sm-4 bg-dark text-white"></div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                

                <a class="text-light btn btn-dark" href="index.html">back</a>
            </div>
            
            <!-- <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#userModal"
                    data-bs-whatever="@mdo">Add Menu</button>
            </div> -->
        </div>
        <hr>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ลำดับ</th>
                    <th scope="col">เลขที่รายการอาหาร</th>
                    <th scope="col">ชื่อเมนู</th>
                    <th scope="col">โต๊ะที่สั่ง</th>
                    <th scope="col">วัน/เวลา ที่สั่ง</th>
                    <!-- <th scope="col">Img</th> -->
                    <th scope="col">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $stmt = $conn->query("SELECT orders.order_n, orders.order_id, orders.order_table, orders.order_menu,
                    orders.order_piece, orders.order_time, orders.order_status,
                    menu.menu_id, menu.menu_name,
                    cus_table.id, cus_table.name
                    FROM orders 
                    INNER JOIN menu ON orders.order_menu = menu.menu_id    
                    INNER JOIN cus_table ON orders.order_table = cus_table.id  
                    WHERE order_status = '0'");
                    $stmt->execute();
                    $orders = $stmt->fetchAll();

                    if (!$orders) {
                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                    } else {

                    $i = 0;
                    foreach($orders as $order)  {  
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td scope="row" hidden><?php echo $order['order_n']; ?></td>
                    <td scope="row"><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['menu_name']; ?></td>
                    <td hidden><?php echo $order['order_table']; ?></td>
                    <td><?php echo $order['name']; ?></td>
                    <td><?php echo $order['order_time']; ?></td>
                    <!-- <td width="250px"><img class="rounded" width="100%" src="uploads/<?php echo $order['img']; ?>" alt=""></td> -->


                    <td>
                        <button type="button" class="btn btn-warning editBtn" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            รอดำเนินการ
                        </button>
                    </td>

                </tr>
                <?php }  } ?>
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">อัพเดตสถานะ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="text" id="id" name="order_id" hidden>
                        <input type="text" id="table" name="table" hidden>

                        <h3>อาหาร อยู่ในสถานะพร้อมเสริฟ ?</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-success">พร้อมเสริฟ</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยังไม่พร้อม</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Modal -->


    <script>
    $(document).ready(function() {
        $('.editBtn').on('click', function() {

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            console.log(data);
            $('#id').val(data[1]);
            $('#table').val(data[4]);


        });
    });
    </script>
</body>

</html>