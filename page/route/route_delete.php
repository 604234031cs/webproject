<?php
require '../../config.php';

if(isset($_GET['delroute'])){
  $delroute = $_GET['delroute'];
$sql1 = "DELETE FROM point_of_pass_car where rid ='$delroute'";
$stm = $connection->prepare($sql1);
if ($stm->execute()) {
  $sql2 = "DELETE FROM route where rid ='$delroute'";
  $stm = $connection->prepare($sql2);
  $stm->execute();
  echo "<script>";
  echo "alert('ลบเส้นทางสำเร็จ')";
  echo "</script>";
  header("refresh:1;data_route.php");
} else {
  echo "Error";
}
}else if(isset($_GET['delpoint'])){
  $delpoint = $_GET['delpoint'];
  $sql1 = "DELETE FROM point_of_pass_car where po_id ='$delpoint'";
  $stm = $connection->prepare($sql1);
  $stm->execute();
  echo "<script>";
  echo "alert('ลบข้อมูลสำเร็จ')";
  echo "</script>";
  header("refresh:1;edit_route.php");
}
