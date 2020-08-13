<?php
require '../../config.php';
if (isset($_POST['insertadmin'])) {
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $phone = $_POST['phonenumber'];
  $sex = $_POST['sex'];
  $sql2 = "INSERT into admin(name,surname,username,password,sex,type,phone) values(:name,:surname,:username,:password,:sex,'personnel',:phone)";
  $stm = $connection->prepare($sql2);
  if ($stm->execute([':name' => $name, ':surname' => $lastname, ':phone' => $phone, ':sex' => $sex, ':username' => $username, ':password' => $phone])) {
    echo "<script>";
    echo "alert('เพิ่มข้อมูลสำเร็จ')";
    echo "</script>";
    header("refresh:1;dataadmin.php");
  } else {
    echo "<script>";
    echo "alert('ไม่สามารถเพิ่มได้เนื่องจากรหัสคนขับมีอยู่แล้ว')";
    echo "</script>";
    header("refresh:1;dataadmin.php");
  }
}
