<?php
require '../../config.php';
if (isset($_POST['insertroute'])) {
    // ข้อมูลเส้นทาง 'ต้นทาง-ปลายทาง'

    $route_id = $_POST['rid'];
    $start_routes_name = $_POST['start'];
    $end_routes_name = $_POST['end'];
    $start_po_lat = $_POST['start_po_lat'];
    $start_po_log = $_POST['start_po_log'];
    $end_po_lat = $_POST['end_po_log'];
    $end_po_log = $_POST['end_po_log'];
    $type_main = '1';
    $route_i = $_POST['i'];
    // ตรวสอบข้อมูลเข้า
    // echo $route_id;
    // echo $start_routes_name;
    // echo $end_routes_name;
    // echo $start_po_lat;
    // echo $start_po_log;
    // echo $end_po_lat;
    // echo $end_po_log;

    // เพิ่มต้นทางปลายทางลงdatabase
    $sql1 = "INSERT into route(rid, start_route_name, end_route_name, start_route_pos_lat, start_route_pos_log, end_route_pos_lat, end_route_pos_log,type_main,i)
                Value ('$route_id','$start_routes_name','$end_routes_name','$start_po_lat','$start_po_log','$end_po_lat','$end_po_log','$type_main',$route_i)";
    $stm = $connection->prepare($sql1);
    if ($stm->execute()) {
        echo "<script>";
        echo "alert('เพิ่มข้อมูลสำเร็จ')";
        echo "</script>";
        header("refresh:1;data_route.php");
    } else {
        echo "<script>";
        echo "alert('ไม่สามารถเพิ่มข้อมูลได้')";
        echo "</script>";
        header("refresh:1;data_route.php");
    }
}
