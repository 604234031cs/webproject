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

// session_start();
// $route_name = $_SESSION['r_name'];
// $route_id = $_SESSION['rid'];
//
// $message = "";
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
    $sql2 = "INSERT INTO point(po_name,po_latitude,po_longitude,rid,type)
                         value (:name,:lat,:long,:rid,'จุดผ่าน')";
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
  <script type="text/javascript" src="https://api.longdo.com/map/?key=8b2c05d9523bf70f5c85804f7e98de02 "></script>
  <script src="../../js/test.js"></script>
  <title>เพิ่มข้อมูลเส้นทาง</title>
</head>


<body onload="init();">
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
        <a href="../dashboard/dashboard.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-folder-open"></i>&nbsp;dashboard</a>
        <a href="../driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white "><i class="fas fa-folder-open"></i>&nbsp;ข้อมูลคนขับ</a>
        <a href="../route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white "><i class="fas fa-folder-open"></i>&nbsp;จัดการเส้นทาง</a>
        <a href="../../checklogout.php" class="list-group-item list-group-item-action bg-dark text-danger"><i class="fas fa-power-off">&nbsp;ออกจากระบบ</i></a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark ">
        <button class="btn btn-dark" id="menu-toggle"><i class="fa fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
          </ul>
          <div class="form-inline my-2 my-lg-">
            <a href="../../checklogout.php" class="navbar-nav mr-auto text-light">
              <span><?php echo $_SESSION["name"]; ?>&nbsp; <?php echo $_SESSION["surname"];  ?>&nbsp;<i class="fas fa-user-shield"></i></span>
            </a>
          </div>

      </nav>

      <!-- contianer -->
      <div class="container-fluid">
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
        <div class="card">
          <?php if (!empty($message)) : ?>
            <div class="alert alert-success">
              <?php
              ?>
            </div>
          <?php endif; ?>
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


          <style>
            input {
              width: 50%;
            }
          </style>
          <div class="card-body">
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
                          <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">
                            <h4>ชื่อสถานที่</h4>
                          </label>
                          <input type="text" name="namelocation[]">
                        </div>
                        <div class="form-group row">
                          <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">
                            <h4>ละติจูด</h4>
                          </label>
                          <input type="text" name="latitude[]">
                        </div>
                        <div class="form-group row">
                          <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">
                            <h4>ลองติจูด</h4>
                          </label>
                          <input type="text" name="longitude[]">
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