<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พนักงานเสริฟ</title>

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

        $id = $_POST['waiter_id'];
        $status = 1;

        try{

        $sql = $conn->prepare("UPDATE waiter SET waiter_status = '1' WHERE waiter_id = :id");
        $sql->bindParam(":id", $id);
        $sql->execute();

        }catch(Throwable $e){
            echo $e;
        }

    }
    ?>
<div class="row">
    <div class="col-sm-4 bg-dark text-white"></div>
    <div class="col-sm-4 bg-dark text-white">
        <h1 class="text-center">พนักงานเสริฟ</h1>
    </div>
    <div class="col-sm-4 bg-dark text-white"></div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                

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
                    <th scope="col">รายการอาหาร</th>
                    <th scope="col">โต๊ะอาหาร</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $stmt = $conn->query("SELECT waiter.waiter_id, waiter.waiter_order, waiter.waiter_table, waiter.waiter_status,
                    orders.order_n, orders.order_menu, orders.order_piece, 
                    menu.menu_id, menu.menu_name,
                    cus_table.id, cus_table.name
                    FROM waiter 
                    INNER JOIN orders ON waiter.waiter_order = orders.order_n 
                    INNER JOIN menu ON orders.order_menu = menu.menu_id  
                    INNER JOIN cus_table ON waiter.waiter_table = cus_table.id 
                    WHERE waiter_status = '0'");
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
                    <td scope="row" hidden><?php echo $order['waiter_id']; ?></td>
                    <td hidden><?php echo $order['waiter_table']; ?></td>
                    <td><?php echo $order['menu_name']; ?></td>
                    <td><?php echo $order['name']; ?></td>
                    <td><?php echo $order['order_piece']; ?></td>






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
                        <input type="text" id="id" name="waiter_id" hidden>
                        <h3>อาหารถูกเสริฟเรียบร้อย ?</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-success">เสริฟเรียบร้อย</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยังไม่พร้อมเสริฟ</button>
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

        });
    });
    </script>
</body>

</html>