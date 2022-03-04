<?php
    /**
     **** AppzStory Shopping Cart System PHP MySQL ****
    * 
    * @link https://appzstory.dev
    * @author Yothin Sapsamran (Jame AppzStory Studio)
    */
    // require 'connect.php';
    require_once "config/db.php";

    /** เช็คว่ามี param p_id เข้ามาหรือไม่ */
    if(isset($_GET["menu_id"])) {

        $menu_id = intval($_GET["menu_id"]);
        
        /** ตรวจสอบฐานข้อมูลในสินค้านั้นๆ */
        $stmt = $conn->query("SELECT * FROM menu WHERE menu_id = '$menu_id' ");
        $count = $stmt->rowCount();
        /** เช็คว่าเจอข้อมูลสินค้าหรือไม่ */
        if(intval($count)){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            /** เก็บข้อมูลสินค้าใส่ array */
            $itemArray = array(intval($result["menu_id"]) => array(
                'menu_name'=> $result["menu_name"], 
                'menu_id'=> intval($result["menu_id"]),
                'img'=> $result["img"],  
                'amount' => 1 ,
                'menu_price'=>$result["menu_price"])
            );
            $found = false;
            /** เช็คว่า session cart เป็นค่าว่างหรือไม่ */
            if(!empty($_SESSION["cart_item"])) {
                /** วนลูปข้อมูล session cart ที่มีอยู่ด้วย foreach */
                foreach($_SESSION["cart_item"] as $key => $value) {
                    /** เช็คว่าเคยมี product id ใน session นี้หรือไม่  */
                    if($result["menu_price"] == $value['menu_price']) {
                        $found= true;
                        /** เช็คว่าจำนวนสินค้า เป็นค่าว่างหรือไม่ */
                        if(empty($_SESSION["cart_item"][$key]["amount"])) {
                            $_SESSION["cart_item"][$key]["amount"] = 0;
                        }
                        /** เพิ่มจำนวนสินค้าเพิ่มขึ้น +1 */
                        $_SESSION["cart_item"][$key]["amount"] += 1;
                        break;
                    }
                }
                /** เช็คว่าเจอสินค้าตัวเดิมใน session หรือไม่ */
                if(!$found) {
                    /** เพิ่มสินค้าตัวใหม่เข้าไปใน array */
                    $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                }
            } else {
                /** ยังไม่ได้สร้าง session ให้นำข้อมูลสินค้าชุดแรกมาใส่ */
                $_SESSION["cart_item"] = $itemArray;
            }
            /** เมื่อสำเร็จส่งกลับหน้าเดิมพร้อมแจ้งเตือน */
            header("location: cus_test.php?cart=success");
            exit();
        }
    }

    /** ไม่ว่าจะเกิดกรณีอะไรเกิดขึ้น ก็ให้กลับไปหน้าเดิม */
    header("location: cus_test.php");
    exit();
  
?>