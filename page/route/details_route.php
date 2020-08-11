<?php
require '../../config.php';
$deteil_route = $_GET['detailroute'];
session_start();
if ($_SESSION["username"] == null &&  $_SESSION["username"] == '') {
    echo "<script>";
    echo "alert('กรุณาลงชื่อเข้าใช้ระบบ')";
    echo "</script>";
    header('Location:../../index.php', true, 303);
}
//แสดงข้อมูลตารางเส้นทาง
$sql1 = "SELECT * FROM  route where rid='$deteil_route'";
$stm = $connection->prepare($sql1);
$stm->execute();
$location = $stm->fetch(PDO::FETCH_ASSOC);
$json = json_encode($location);
// $index = sizeof($location);
echo '<script type="text/javascript">';
echo "var data1 = JSON.parse('$json')"; // ส่งค่า $data จาก PHP ไปยังตัวแปร data ของ Javascript
echo '</script>';
//แสดงตารางจุดผ่าน
$sql1 = "SELECT * FROM  point where rid = '$deteil_route'";
$stm = $connection->prepare($sql1);
$stm->execute();
$points = $stm->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($points);
$index = sizeof($points);
// echo $json;
echo '<script type="text/javascript">';
echo "var data = JSON.parse('$json')"; // ส่งค่า $data จาก PHP ไปยังตัวแปร data ของ Javascript
echo '</script>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="https://api.longdo.com/map/?key=8b2c05d9523bf70f5c85804f7e98de02 "></script>
    <!-- Custom styles for this template -->
    <link href="../../css/responside.css" rel="stylesheet">
    <link href="../../css/mapdetail.css" rel="stylesheet">
    <!-- <script src="../../js/detailpointmap.js"></script> -->
</head>

<body onload="init();">

    <script type="text/javascript">
        function init() {
            // var marker;
            var i;
            var marker1;
            var marker2;
            var marker3;
            var index = <?php echo $index; ?>;
            // console.log(data[0]['po_name']);
            // console.log(data[0]['po_name']);
            console.log(data1['start_route_name']);
            console.log(data1['end_route_name']);

            console.log(index);
            // alert(data[0]['po_name']);
            map = new longdo.Map({
                placeholder: document.getElementById('map')
            });
            map.location(longdo.LocationMode.Geolocation); // go to 100, 16 when created map
            map.Route.placeholder(document.getElementById('result'));
            map.zoom(false, true);
            markerstart = new longdo.Marker({
                lon: data1['start_route_pos_log'],
                lat: data1['start_route_pos_lat']
            }, {
                title: data1['start_route_name'],
                detail: 'Simple popup'
            });
            markerend = new longdo.Marker({
                lon: data1['end_route_pos_log'],
                lat: data1['end_route_pos_lat']
            });
            map.Overlays.add(markerstart);
            map.Overlays.add(markerend);
            map.Route.add(markerstart);
            map.Route.add(markerend);

            for (i = 0; i <= index; i++) {
                marker = new longdo.Marker({
                    lon: data[i]['po_longitude'],
                    lat: data[i]['po_latitude']
                });

                map.Overlays.add(marker);
                map.Route.add(marker);

            }
        }
    </script>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark " id="sidebar-wrapper">

            <div class="list-group list-group-flush">
                <div class="sidebar-heading">
                    <center>
                        <img src="../../img/LogoApp.png" class="rounded" alt="Cinque Terre" style="width: 10rem;">
                    </center>
                </div>

                <a href="../driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white "><i class="fas fa-folder-open"></i>&nbsp;ข้อมูลคนขับ</a>
                <a href="../route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white "><i class="fas fa-folder-open"></i>&nbsp;จัดการเส้นทาง</a>
                <a href="../../checklogout.php" class="list-group-item list-group-item-action bg-dark text-danger"><i class="fas fa-power-off">&nbsp;ออกจากระบบ</i></a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
                <button class="btn btn-dark" id="menu-toggle"><i class="fa fa-bars"></i></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <div class="form-inline my-2 my-lg-">
                        <a href="../../checklogout.php" class="navbar-nav mr-auto text-light">
                            <span><?php echo $_SESSION["name"]; ?>&nbsp; <?php echo $_SESSION["surname"];  ?>&nbsp;<i class="fas fa-user-shield"></i></span>
                        </a>
                    </div>
                </div>
            </nav>
            <br>
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="text-left">แผนที่แสดงตำแหน่ง</h2>
                    </div>
                    <div class="col-sm-6">
                        <ol>
                            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-clipboard-list"></i> รายละเอียด</button>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h2 class="text-left">
                                    <?php
                                    $sql1 = "SELECT * FROM route where rid = '$deteil_route'";
                                    $stm = $connection->prepare($sql1);
                                    $stm->execute();
                                    $nameroute = $stm->fetch(PDO::FETCH_ASSOC);
                                    echo $nameroute['start_route_name'] . '-' . $nameroute['end_route_name'];
                                    ?>
                                </h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="map">
                            </div>
                            <div id="result"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>

        <script src="../../node_modules/jquery/dist/jquery.slim.min.js"></script>
        <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Menu Toggle Script -->
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        </script>



</html>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">รายละเอียดของเส้นทาง</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-dark justify-content-center">
                    <thead>
                        <tr>

                            <th>
                                <center>ชื่อสถานที่่</center>
                            </th>
                            <th>
                                <center>ละติจูด</center>
                            </th>
                            <th>
                                <center>ลองจิจูด</center>
                            </th>
                            <th>
                                <center>ประเภท</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($location == true) { ?>
                            <tr>
                                <td>
                                    <center><?php echo $location['start_route_name']; ?></center>
                                </td>
                                <td>
                                    <center><?php echo $location['start_route_pos_lat']; ?></center>
                                </td>
                                <td>
                                    <center><?php echo $location['start_route_pos_log']; ?></center>
                                </td>
                                <td>
                                    <center>
                                        <?php
                                        echo 'ต้นทาง';
                                        ?>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center><?php echo $location['end_route_name']; ?></center>
                                </td>
                                <td>
                                    <center><?php echo $location['end_route_pos_lat']; ?></center>
                                </td>
                                <td>
                                    <center><?php echo $location['end_route_pos_log']; ?></center>
                                </td>
                                <td>
                                    <center>
                                        <?php
                                        echo 'ปลายทาง';
                                        ?>
                                    </center>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php foreach ($points as $point) : ?>
                            <tr>
                                <td>
                                    <center><?php echo $point['po_name']; ?></center>
                                </td>
                                <td>
                                    <center><?php echo $point['po_latitude']; ?></center>
                                </td>
                                <td>
                                    <center><?php echo $point['po_longitude']; ?></center>
                                </td>
                                <td>
                                    <center><?php echo "จุดระหว่างทาง" ?></center>
                                </td>
                            </tr>
                    </tbody>
                <?php endforeach; ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <!-- end -->
        </div>
    </div>
</div>