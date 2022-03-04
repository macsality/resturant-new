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

    <script src="qrcode.min.js"></script>
</head>

<body>
    <?php    
    require_once "config/db.php";

    /** ดึงข้อมูลสินค้า */
    // $sql = "SELECT * FROM orders WHERE status = '0'";
    // $result = $conn->query($sql);

    if(isset($_POST['add_table'])){

        $rand = rand(1000, 9999);
        $id = $_POST['id'];
        $qr = 'http://csit.psru.ac.th/~6012231014/tem/cus_test.php?qr='.$rand;


        try{   

        $sql = $conn->prepare("UPDATE cus_table SET qr = :qr, status = '1'  WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":qr", $qr);
        $sql->execute();

        }catch(Throwable $e){
            echo $e;
        }

    }
    ?>

    <div class="row">
        <div class="col-sm-4 bg-dark text-white"></div>
        <div class="col-sm-4 bg-dark text-white">
            <h1 class="text-center">โต๊ะ</h1>
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
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">Qr</th>

                </tr>
            </thead>
            <tbody>
                <?php 
                    $stmt = $conn->query("SELECT * FROM `cus_table`");
                    $stmt->execute();
                    $tables = $stmt->fetchAll();

                    if (!$tables) {
                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                    } else {

                    $i = 0;
                    foreach($tables as $table)  {  
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td scope="row"><?php echo $table['id']; ?></td>
                    <td scope="row"><?php echo $table['name']; ?></td>
                    <td>
                        <button type="button" class="btn btn-warning editBtn
                        <?php if($table['status'] == "1"){ echo "disabled";}?>
                        " data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            
                            จอง
                        </button>
                    </td>
                    <?php 
                        if($table['status'] == "1"){

                        ?>

                        <td>
                            <button type="button" class="btn btn-warning qrBtn" data-bs-toggle="modal"
                                data-bs-target="#QrModal">
                                ดู
                            </button>
                        </td>

                    <?php
                        }
                        ?>


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
                        <input type="text" id="id" name="id" hidden>

                        <h3>เปิด <span id="table"></span> ?</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_table" class="btn btn-success">ตกลง</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Modal -->

       <!-- Modal -->
       <div class="modal fade" id="QrModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">อัพเดตสถานะ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                <div id="qrcode"></div>
                <button id="btnQr" onclick="Qr()">gen</button>


        <script type="text/javascript">
            


            function Qr(){
                // const ran = "Qr_" +rand(1000,9999)/

                // const text = document.getElementById('textQr')
                // const btnQr = document.getElementById('btnQr')

                const showQr = document.getElementById("qrcode")

                var text = 'http://csit.psru.ac.th/~6012231014/tem/cus_test.php?qr=555'

                new QRCode(showQr, text);
            }

        </script>

                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_table" class="btn btn-success">ปริ้น</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
               

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
            $('#table').html(data[2])



        });
    });
    </script>


</body>

</html>