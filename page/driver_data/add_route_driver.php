<?php
    require '../../config.php';

    if(isset($_POST['addroute'])){
        $d_id = $_POST['driver_id'];
        $rid = $_POST['routeadd'];
        $sql2 = "UPDATE driver set rid='$rid' where d_id= '$d_id'";
        $stm = $connection->prepare($sql2);
        if($stm->execute()){
            echo "<script>";
            echo "alert('กำหนดเส้นทางเรียบร้อย')";
            echo "</script>";
            header("refresh:1;data_driver.php");
        }else {
            echo "<script>";
            echo "alert('เกิดข้อผิดพลาด')";
            echo "</script>";
            header("refresh:1;data_driver.php");
          }
    }
