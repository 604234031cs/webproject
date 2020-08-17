<?php
require '../../config.php';
if (isset($_POST['insertdriver'])) {
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $nameEng = $_POST['nameEng'];
  $lastnameEng = substr($_POST['lastnameEng'], 0, 3);
  $username = $nameEng . "_" . substr($_POST['lastnameEng'], 0, 3);
  $phone = $_POST['phonenumber'];
  // $carnumber = $_POST['carnumber'];
  $route = $_POST['routeadd'];
  $sex = $_POST['sex'];
  // $username = $_POST['username'];
  // echo $sex;
  $sql2 = "INSERT into driver(d_name,d_lastname,sex,phone,d_username,d_password,status_driver,rid) values(:name,:lastname,:sex,:phone,:username,:password,'0','$route')";
  $stm = $connection->prepare($sql2);
  if ($stm->execute([':name' => $name, ':lastname' => $lastname, ':phone' => $phone, ':sex' => $sex, ':username' => $username, ':password' => md5($phone)])) {
    echo "<script>";
    echo "alert('เพิ่มข้อมูลสำเร็จ')";
    echo "</script>";
    header("refresh:1;data_driver.php");
  } else {
    echo "<script>";
    echo "alert('ไม่สามารถเพิ่มได้เนื่องจากรหัสคนขับมีอยู่แล้ว')";
    echo "</script>";
    header("refresh:1;data_driver.php");
  }
}
