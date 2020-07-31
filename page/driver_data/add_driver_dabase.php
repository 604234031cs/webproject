<?php
require '../../config.php';

if (isset($_POST['insertdriver'])) {
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $phone = $_POST['phonenumber'];
  // $carnumber = $_POST['carnumber'];
  $route = $_POST['routeadd'];
  $sex = $_POST['sex'];
  $username = $_POST['username'];
  $password = $_POST['password'];
// echo $sex;
  $sql2 = "INSERT into driver(name,lastname,sex,phone,username,password,status_driver,rid,type) value(:name,:lastname,:sex,:phone,:username,:password,'0',:rid,'driver')";
  $stm = $connection->prepare($sql2);
  if ($stm->execute([':name' => $name, ':lastname' => $lastname,':phone' => $phone,':rid' => $route,':sex'=>$sex,':username'=>$username,':password'=>$password])) {
    echo "<script>";
    echo "alert('เพิ่มข้อมูลสำเร็จ')";
    echo "</script>";
    header("refresh:1;data_driver.php");
  } else {
    echo "<script>";
    echo "alert('ไม่สามารถเพิ่มได้เนื่องจากรหัสคนขับมีอยู่แล้ว')";
    echo "</script>";
  }
}
