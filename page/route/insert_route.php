<?php

require '../../config.php';
session_start();
if ($_SESSION["username"] == null &&  $_SESSION["username"] == '') {
  echo "<script>";
  echo "alert('กรุณาลงชื่อเข้าใช้ระบบ')";
  echo "</script>";
  header('Location:../../index.php', true, 303);
}
$waypointnum = null;
$route_id = $_SESSION['rid_addpoint'];
if (isset($_GET['waypoint'])) {
  $waypointnum = $_GET['waypoint'];
}


if (isset($_POST['addposition'])) {
  // $message="เพิ่มข้อมูลสำเร็จ";
  // header("refresh:2;data_driver.php");
  $latitudeNum = $_POST['latitude'];
  $longitudeNum = $_POST['longitude'];
  $nameLocationeNum = $_POST['namelocation'];
  $numOflocation = sizeof($nameLocationeNum);
  for ($i = 0; $i < $numOflocation; $i++) {
    // echo $latitudeNum[$i];
    // echo $longitudeNum[$i];
    // echo $nameLocationeNum[$i]; 
    // echo $nameLocationeNum[$i];
    // echo "<br>";
    $sql2 = "INSERT INTO point(po_name,po_latitude,po_longitude,rid)
                         value (:name,:lat,:long,:rid)";
    $stm = $connection->prepare($sql2);
    $stm->execute([':name' => $nameLocationeNum[$i], ':lat' => $latitudeNum[$i], ':long' => $longitudeNum[$i], ':rid' => $route_id]);
  }
  echo "<script>";
  echo "alert('บันทึกข้อมูลสำเร็จ')";
  echo "</script>";
  header("refresh:1;data_route.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Fontawesome CSS -->
  <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <!-- Custom styles for this template -->
  <link href="../../css/responside.css" rel="stylesheet">
  <link href="../../css/map.css" rel="stylesheet">

  <!-- <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD61r5MULrXwYo54E87mvXoirM_BUgHtFM&callback=initMap"> </script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyCkVnfTM23P1pUplxQhRQwa7JLqE4rBlwg"></script> -->
  <script type="text/javascript" src="../../js/addlalng.js "></script>

  <title>เพิ่มข้อมูลเส้นทาง</title>
</head>


<body onload="initMap()">
  <!-- wrapper -->
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark " id="sidebar-wrapper">
      <div class="list-group list-group-flush sticky-top ">
        <div class="sidebar-heading ">
          <center>
            <img src="../../img/LogoApp.png" class="rounded " alt="Cinque Terre" style="width: 10rem;">
          </center>
        </div>
        <a href="../driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white "><i class="fas fa-folder-open mr-2"></i>ข้อมูลคนขับ</a>
        <a href="../route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white "><i class="fas fa-folder-open mr-2"></i>จัดการเส้นทาง</a>
        <?php if ($_SESSION['type'] == 'admin') { ?>
          <a href="../admin/dataadmin.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-folder-open mr-2"></i>จัดการผู้แลระบบ</a>
        <?php } ?>
        <a href="../../checklogout.php" class="list-group-item list-group-item-action bg-dark text-danger"><i class="fas fa-power-off mr-2"></i>ออกจากระบบ</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark ">
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

      </nav>

      <!-- <style>
        #map {
          width: 100%;
          height: 500px;
          position: relative;
        }
      </style> -->
      <!-- contianer -->
      <!-- <div class="row mb-2">
        <div class="col-md-6">
          <input type="text" id="address" value="">
          <input id="submit" type="button" value="ค้นหาข้อมูล" onclick="inputaddress()">
        </div>
      </div> -->
      <div class="container-fluid ">
        <div class="card ">
          <!-- <div id="map">
          </div> -->
        </div>
      </div>
      <br>
      <!-- contianer -->
      <!-- container-fluid -->
      <div class="container-fluid">
        <!-- card -->
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2 class="text-left">กำหนดตำแหน่ง</h2>
          </div>
        </div>
        <div class="card ">
          <!-- card-header -->
          <div class="card-header">
            <script>
              function myFunction() {

                var point = prompt("กรุณาใส่จำนวนจุดที่ต้องการเพิ่ม:", "1");
                if (point == "") {
                  alert("กรุณาใส่ข้อมูลให้ถูกต้อง");
                } else if (!point.match(/^([0-9])+$/i)) {
                  alert("กรุณาใส่เฉพาะตัวเลข 0-9 เท่านั้น");
                } else {
                  num = point;
                  window.location.href = "insert_route.php?waypoint=" + num;
                }
              }
            </script>
            <button onclick="myFunction()" type="button" class="btn btn-success float-left"><i class="fas fa-plus"></i>
              จำนวนจุดที่ต้องการเพิ่ม</button>
          </div>
          <!-- /card-hearde -->
          <!-- card-body -->


          <div class="card-body scrollable">
            <!-- form -->
            <form method="POST">
              <!-- row -->
              <div class="form-row">
                <?php if ($waypointnum != null && $waypointnum != 0) { ?>
                  <?php for ($i = 1; $i <= $waypointnum; $i++) : ?>
                    <?php if ($i == 0) { ?>
                    <?php } else { ?>
                      <!-- col -->
                      <div class="col-md-6">
                        <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">
                              <h4>จุดที่ <?php echo $i; ?></h4>
                            </span>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm" >
                            <h4>ชื่อสถานที่</h4>
                          </label>
                          <input type="text" name="namelocation[]" id='name<?php echo $i ?>' style="width: 500px;" required>
                        </div>
                        <div class="form-group row">
                          <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">
                            <h4>ละติจูด</h4>
                          </label>
                          <input type="text" name="latitude[]" id='lat<?php echo $i ?>' required>
                        </div>
                        <div class="form-group row">
                          <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">
                            <h4>ลองติจูด</h4>
                          </label>
                          <input type="text" name="longitude[]" id='lng<?php echo $i ?>' required>
                        </div>
                        <div class="form-group row">
                          <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">
                            <h4>แผนที่</h4>
                          </label>
                          <a type="button" onclick="searchposition('<?php echo $i ?>')" class="btn btn-info active " data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-map-marked-alt mr-2"></i>ค้นหา</a>
                        </div>
                      </div>
                      <!-- /col -->

                    <?php } ?>
                  <?php endfor; ?>
              </div>
              <!-- /row -->
              <button type="submit" class="btn btn-success btn-lg " name="addposition">บันทึกข้อมูล</button>
            </form>
            <!-- /form -->
          <?php } else { ?>
            <h3>ระบุจำนวนจุดที่ต้องการเพิ่ม</h3>
          <?php } ?>

          </div>
          <!-- /card-body -->
        </div>
        <!-- /card -->
      </div>
      <!-- /contianer-fluid -->
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /wrapper -->


  <script src="../../node_modules/jquery/dist/jquery.slim.min.js"></script>
  <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ค้นหาตำแหน่ง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <style>
          #map {
            width: 100%;
            height: 600px;
            flex: 4;
          }
        </style>
        <div>
          <input type="text" id="address" value="">
          <input id="submit" type="button" value="ค้นหาข้อมูล" onclick="inputaddress()">
        </div>
        <div id="map"></div>
        <br>

        <div class="form-group row">
          <label class="col-sm-2 col-form-label">ตำแหน่งที่:</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="poid" value="">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">ชื่อตำแหน่ง:</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="getname" value="">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 col-form-label">ละติจูด:</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="getlat" value="">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-2 col-form-label">ละติจูด:</label>
          <div class="col-sm-10">
            <input type="text" readonly class="form-control-plaintext" id="getlng" value="">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="seva" class="btn btn-secondary" onclick="save()">บันทึก</button>
        </div>
      </div>
    </div>
  </div>