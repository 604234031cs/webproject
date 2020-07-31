<?php 
    require '../../config.php'; 
    $del = $_GET['del'];
    // echo $bookdel;
    $sql = "DELETE FROM driver WHERE d_id = '$del'";
    $stm = $connection->prepare($sql);
    if($stm->execute()){
        $sql = "DELETE FROM car_driver WHERE uusername = '$del'";
        $stm = $connection->prepare($sql);
        $stm->execute();
        echo "<script>";
        echo "alert('ลบข้อมูลสำเร็จ')";
         echo "</script>";
        header("refresh:2;data_driver.php"); 
    }else{
        echo "<script>";
        echo "alert('เกิดข้อผิดพลาด')";
         echo "</script>";
        header("refresh:2;data_driver.php"); 
    }
?>

