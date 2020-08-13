<?php 
    require '../../config.php'; 
    $del = $_GET['del'];
    // echo $bookdel;
    $sql = "DELETE FROM admin WHERE id = '$del'";
    $stm = $connection->prepare($sql);
    if($stm->execute()){
        echo "<script>";
        echo "alert('ลบข้อมูลสำเร็จ')";
         echo "</script>";
        header("refresh:2;dataadmin.php"); 
    }else{
        echo "<script>";
        echo "alert('เกิดข้อผิดพลาด')";
         echo "</script>";
        header("refresh:2;data_driver.php"); 
    }
?>

