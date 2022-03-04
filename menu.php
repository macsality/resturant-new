<?php 

    // session_start();

    require_once "config/db.php";

    if (isset($_GET['delete'])) {

        $delete_id = $_GET['delete'];
        $deletestmt = $conn->query("DELETE FROM menu WHERE menu_id = $delete_id");
        $deletestmt->execute();

        if ($deletestmt) {
            echo "<script>alert('Data has beesn deleted successfully');</script>";
            $_SESSION['success'] = "Data has been deleted succesfully";
            header("refresh:0; url=menu.php");
        }
        
    }

     if (isset($_POST['add_menu'])) {


        $name = $_POST['menu_name'];
        $price = $_POST['menu_price'];
        $img = $_FILES['img'];

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
        $filePath = 'uploads/'.$fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($img['size'] > 0 && $img['error'] == 0) {

                if (move_uploaded_file($img['tmp_name'], $filePath)) {
                    
                    $sql = $conn->prepare("INSERT INTO menu(menu_id, menu_name, menu_price, img) VALUES(null, :menu_name, :menu_price, :img)");
                    $sql->bindParam(":menu_name", $name);
                    $sql->bindParam(":menu_price", $price);
                    $sql->bindParam(":img", $fileNew);
                    $sql->execute();

                    if ($sql) {
                        $_SESSION['success'] = "Data has been inserted successfully";
                        header("location: menu.php");
                    } else {
                        $_SESSION['error'] = "Data has not been inserted successfully";
                        header("location: menu.php");
                    }
                }
            }
        }
        
    }

    if (isset($_POST['update_menu'])) {

        // echo print_r($_POST);

        $menu_id = $_POST['menu_id'];
        $menu_name = $_POST['menu_name'];
        $menu_price = $_POST['menu_price'];
        $img = $_FILES['img2'];
        $img1 = $_POST['img1'];


        $upload = $_FILES['img2']['name'];

        if(empty($upload)){
            echo "1234";
        }

        if ($upload != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
            $filePath = 'uploads/'.$fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($img['size'] > 0 && $img['error'] == 0) {
                   move_uploaded_file($img['tmp_name'], $filePath);
                }
            }

        } else {
            $fileNew = $img1;
        }

        $sql = $conn->prepare("UPDATE menu SET menu_name = :menu_name, menu_price = :menu_price, img = :img WHERE menu_id = :id");
        $sql->bindParam(":id", $menu_id);
        $sql->bindParam(":menu_name", $menu_name);
        $sql->bindParam(":menu_price", $menu_price);
        $sql->bindParam(":img", $fileNew);
        $sql->execute();

        if ($sql) {
            $_SESSION['success'] = "Data has been updated successfully";
            header("location: menu.php");
        } else {
            $_SESSION['error'] = "Data has not been updated successfully";
            header("location: menu.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการเมนูอาหาร</title>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>


    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มรายการอาหาร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ชื่อเมนู :</label>
                            <input type="text" required class="form-control" name="menu_name">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ราคา:</label>
                            <input type="text" required class="form-control" name="menu_price">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">img:</label>
                            <input type="file" required class="form-control" name="img">
                        </div>                       

                        <div class="modal-footer">
                            <button type="submit" name="add_menu" class="btn btn-primary">เพิ่มรายการอาหาร</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>จัดการเมนูอาหาร</h1>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#userModal"
                    data-bs-whatever="@mdo">เพิ่มรายการอาหาร</button>
            </div>
            <div>
        <div class="row">
            <div class="col-md-6">
                <a class="text-light btn btn-dark" href="manage.php">กลับสู่หน้า manager</a>
            </div>
        </div>
    </div>
        </div>
        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success">
            <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']); 
                ?>
        </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger">
            <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                ?>
        </div>
        <?php } ?>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ลำดับ</th>
                    <th scope="col" hidden>menu_id</th>
                    <th scope="col">ชื่อเมนู</th>
                    <th scope="col">ราคา</th>
                    <th scope="col">รูปภาพประกอบ</th>
                    <th scope="col">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $stmt = $conn->query("SELECT * FROM menu");
                    $stmt->execute();
                    $menus = $stmt->fetchAll();

                    if (!$menus) {
                        echo "<p><td colspan='6' class='text-center'>No data available</td></p>";
                    } else {

                    $i = 0;
                    foreach($menus as $menu)  {  
                        $i++;
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td scope="row" hidden><?php echo $menu['menu_id']; ?></td>
                    <td><?php echo $menu['menu_name']; ?></td>
                    <td><?php echo $menu['menu_price']; ?></td>
                    <td hidden><?php echo $menu['img']; ?></td>
                    <td width="250px"><img class="rounded" width="100%" src="uploads/<?php echo $menu['img']; ?>" alt=""></td>
              

                    <td>
                        <button type="button" class="btn btn-warning editBtn" data-bs-toggle="modal"
                            data-bs-target="#modal_edit">
                            แก้ไขรายการอาหาร
                        </button>
                        
                        <a onclick="return confirm('ต้องการจะลบจริงๆใช่หรือไม่ ?');"
                            href="?delete=<?php echo $menu['menu_id']; ?>" class="btn btn-danger">ลบรายการ</a>
                    </td>

                </tr>
                <?php }  } ?>
            </tbody>
        </table>
    </div>



    <!-- Modal edit-->
    <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" id="id" name="menu_id" hidden>
                    <input type="text" id="menu_img" name="img1" hidden>


                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">menu name:</label>
                            <input type="text" id="menu_name" required class="form-control" name="menu_name">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">menu price:</label>
                            <input type="text" id="menu_price" required class="form-control" name="menu_price">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">img:</label>
                            <input type="file" class="form-control" name="img2">
                        </div>       


                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_menu" class="btn btn-primary">update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Modal edit-->


    <script>
          $(document).ready(function() {
                $('.editBtn').on('click', function() {

                    $tr = $(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();
                    console.log(data);
                    $('#id').val(data[1]);
                    $('#menu_name').val(data[2]);  
                    $('#menu_price').val(data[3]);
                    $('#menu_img').val(data[4]);

                });
            });
    </script>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
    let imgInput = document.getElementById('imgInput');
    let previewImg = document.getElementById('previewImg');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            previewImg.src = URL.createObjectURL(file)
        }
    }
    </script>
</body>

</html>