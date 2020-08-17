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
    <!-- <script type="text/javascript" src="https://api.longdo.com/map/?key=8b2c05d9523bf70f5c85804f7e98de02 "></script> -->
    <!-- <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD61r5MULrXwYo54E87mvXoirM_BUgHtFM&callback=initMap&libraries=&v=weekly">
    </script> -->

    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD61r5MULrXwYo54E87mvXoirM_BUgHtFM&libraries=places"></script> -->
    <!-- <script defer src="https://maps.googleapis.com/maps/api/directions/json?origin=Toronto&destination=Montreal&key=AIzaSyAj0VNGE0a_5VnsvQpxUkLBMI4fXeLb7eE"></script> -->
    <link href="../../css/responside.css" rel="stylesheet">
    <!-- <script src="../../js/detailpointmap.js"></script> -->
</head>

<script type="text/javascript">
    var maps, infoWindow, geocoder;
    var info;
    var markerstart;
    var markerend;
    var markerpoint;
    const image =
        "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
    var index = <?php echo $index; ?>;

    function initMap() {

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                const directionsService = new google.maps.DirectionsService();
                const directionsRenderer = new google.maps.DirectionsRenderer();
                maps = new google.maps.Map(document.getElementById('map'), {
                    center: pos,
                    zoom: 12
                });

                markerstart = new google.maps.Marker({
                    position: new google.maps.LatLng(data1['start_route_pos_lat'], data1['start_route_pos_log']),
                    map: maps,
                    icon: image
                });
                markerend = new google.maps.Marker({
                    position: new google.maps.LatLng(data1['end_route_pos_lat'], data1['end_route_pos_log']),
                    map: maps,
                    icon: image
                });
                for (let i = 0; i <= index; i++) {
                    markerpoint = new google.maps.Marker({
                        position: new google.maps.LatLng(data[i]['po_latitude'], data[i]['po_longitude']),
                        map: maps,
                    });
                }
            }, function() {
                handleLocationError(true, infoWindow, maps.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, maps.getCenter());
        }

        directionsRenderer.setMap(maps);
        // calculateAndDisplayRoute(directionsService, directionsRenderer);
    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        const waypts = ['ตลาดกิมหยง'];
        // for (let i = 0; i <= index; i++) {
        //     waypts.push({
        //         location: new google.maps.LatLng(data[i]['po_latitude'], data[i]['po_longitude']),
        //         stopover: false
        //     });
        // }
        directionsService.route({
                origin: new google.maps.LatLng(data1['start_route_pos_lat'], data1['start_route_pos_log']),
                destination: new google.maps.LatLng(data1['end_route_pos_lat'], data1['end_route_pos_log']),
                waypoints: waypts,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.DRIVING
            },
            (response, status) => {
                if (status === "OK") {
                    directionsRenderer.setDirections(response);
                    const route = response.routes[0];
                    const summaryPanel = document.getElementById("directions-panel");
                    summaryPanel.innerHTML = "";
                    // For each route, display summary information.
                    for (let i = 0; i < route.legs.length; i++) {
                        const routeSegment = i + 1;
                        summaryPanel.innerHTML +=
                            "<b>Route Segment: " + routeSegment + "</b><br>";
                        summaryPanel.innerHTML += route.legs[i].start_address + " to ";
                        summaryPanel.innerHTML += route.legs[i].end_address + "<br>";
                        summaryPanel.innerHTML += route.legs[i].distance.text + "<br><br>";
                    }
                } else {
                    window.alert("Directions request failed due to " + status);
                }
            }
        );
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(maps);

    }
</script>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark " id="sidebar-wrapper">

            <div class="list-group list-group-flush">
                <div class="sidebar-heading">
                    <center>
                        <img src="../../img/LogoApp.png" class="rounded" alt="Cinque Terre" style="width: 10rem;">
                    </center>
                </div>

                <a href="../driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white ">
                    <i class="fas fa-folder-open mr-2"></i>ข้อมูลคนขับ</a>
                <a href="../route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white ">
                    <i class="fas fa-folder-open mr-2"></i>จัดการเส้นทาง</a>
                <?php if ($_SESSION['type'] == 'admin') { ?>
                    <a href="../admin/dataadmin.php" class="list-group-item list-group-item-action bg-dark text-white ">
                        <i class="fas fa-folder-open mr-2 "></i>จัดการผู้แลระบบ</a>
                <?php } ?>
                <a href="../../checklogout.php" class="list-group-item list-group-item-action bg-dark text-danger">
                    <i class="fas fa-power-off mr-2"></i>ออกจากระบบ</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
                <button class="btn btn-dark" id="menu-toggle"><i class="fa fa-bars"></i></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown" aria-labelledby="navbarDropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style="color:white;"><?php echo $_SESSION['name']; ?>&nbsp;<?php echo $_SESSION['surname']; ?>
                                <i class="fas fa-user-shield"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <div class="dropdown-divider"></div>
                                <a href="../account/account.php" class="dropdown-item">
                                    <i class="fas fa-user-cog mr-2"></i>ข้อมูลส่วนตัว
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="../../checklogout.php" class="dropdown-item" style="color:red;">
                                    <i class="fas fa-power-off mr-2"></i>ออกจากระบบ
                                </a>
                        </li>

                    </ul>
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
                        <style>
                            #map {
                                width: 100%;
                                height: 700px;
                            }
                        </style>
                        <div class="card-body">
                            <div id="control">
                                <div id="map">
                                </div>
                                <div id="directions-panel"></div>
                            </div>
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