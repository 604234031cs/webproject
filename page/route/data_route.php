<?php
require '../../config.php';
$message = "";
$perpage = 5;
// ดึงข้อมูลจาก database
session_start();
if ($_SESSION["username"] == null &&  $_SESSION["username"] == '') {
  echo "<script>";
  echo "alert('กรุณาลงชื่อเข้าใช้ระบบ')";
  echo "</script>";
  header('Location:../../index.php', true, 303);
}
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}

$search = isset($_POST['key_word']) ? $_POST['key_word'] : '';

$start = ($page - 1) * $perpage;
$sql1 = "SELECT * FROM route where rid like '%$search%' or start_route_name like '%$search%'  or end_route_name like '%$search%'   limit {$start},{$perpage}";
$stm = $connection->prepare($sql1);
$stm->execute();
$routes = $stm->fetchAll();
// $message = $driver['name'];
$index = sizeof($routes);
$sql2 = "SELECT * FROM route ORDER BY rid DESC LIMIT 1 ";
$stm = $connection->prepare($sql2);
$stm->execute();
$check_id = $stm->fetch(PDO::FETCH_ASSOC);





?>
<title>จัดการข้อมูลเส้นทาง</title>
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
  <!-- <script type="text/javascript" src="https://api.longdo.com/map/?key=8b2c05d9523bf70f5c85804f7e98de02 "></script> -->
  
  <!-- Custom styles for this template -->
  <link href="../../css/responside.css" rel="stylesheet">

</head>

<body onload="initMap()">
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark" id="sidebar-wrapper">
      <div class="list-group list-group-flush sticky-top">
        <div class="sidebar-heading">
          <center>
            <img src="../../img/LogoApp.png" class="rounded" alt="Cinque Terre" style="width: 10rem;">
          </center>
        </div>

        <a href="../driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white ">
          <i class="fas fa-folder-open mr-2"></i>ข้อมูลคนขับ</a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="fas fa-folder-open mr-2"></i>จัดการเส้นทาง</a>
        <?php if ($_SESSION['type'] == 'admin') { ?>
          <a href="../admin/dataadmin.php" class="list-group-item list-group-item-action bg-dark text-white ">
            <i class="fas fa-folder-open mr-2"></i>จัดการผู้แลระบบ</a>
        <?php } ?>
        <a href="../../checklogout.php" class="list-group-item list-group-item-action bg-dark text-danger">
          <i class="fas fa-power-off mr-2"></i>ออกจากระบบ</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ">
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
      <br>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2 class="text-left">ข้อมูลเส้นทาง</h2>
          </div>
        </div>
        
        <div class="card">
          <div class="card-header">
            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i>
              เพิ่มข้อมูลเส้นทาง</button>
          </div>
          <!-- card-body -->
          <div class="card-body">
            <!-- table -->
            <div class="float-right">
              <form method="post">
                รหัส/ต้นทาง/ปลายทาง :
                <input type="text" name="key_word">
                <button type="submit" class="btn  ">
                  <i class="fas fa-search"></i></button>
              </form>
              <br>
            </div>
            <table class="table table-striped  justify-content-center">
            <thead class="thead-dark">
                <tr>
                  <th style="width:20%;">
                    <center>รหัสเส้นทาง</center>
                  </th>
                  <th style="width:20%;">
                    <center>ต้นทาง</center>
                  </th>
                  <th style="width:20%;">
                    <center>ปลายทาง</center>
                  </th>
                  <th style="width:20%;">
                    <center></center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php if ($routes != null) { ?>
                  <?php foreach ($routes as $route) : ?>
                    <tr>
                      <td>
                        <center><?php echo $route['rid']; ?> </center>
                      </td>
                      <td>
                        <center><?php echo $route['start_route_name']; ?></center>
                      </td>
                      <td>
                        <center><?php echo $route['end_route_name']; ?></center>
                      </td>
                      <td>
                        <center>
                          <a href="details_route.php?detailroute=<?= $route['rid']; ?>" class="btn btn-primary  btn-sm active"><i class="fas fa-folder-open mr-2"></i>View</a>
                          <a href="ridinsert.php?addpoint=<?= $route['rid']; ?>" class="btn btn-Success  btn-sm active"><i class="fas fa-map-marker-alt mr-2"></i>Addpoint</a>
                          <a href="ridedit.php?editrid=<?= $route['rid']; ?>" class="btn btn-info  btn-sm active"><i class="fas fa-edit mr-2"></i>Edit</a>
                          <a onclick="return confirm('ต้องการลบข้อมูลเส้นทางนี้หรือไม่?')" href="route_delete.php?delroute=<?= $route['rid']; ?>" class="btn btn-danger  btn-sm active">
                            <i class="fas fa-trash-alt mr-2"></i>Delet</a>
                        </center>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="6">
                      <h4> ไม่พบข้อมูลเส้นทางในฐานข้อมูล</h4>
                    </td>
                  </tr>

                <?php  } ?>
              </tbody>

            </table>

            <?php
            $sql1 = "SELECT * FROM  route";
            $stm = $connection->prepare($sql1);
            $stm->execute();
            $row = $stm->fetchAll(PDO::FETCH_ASSOC);
            $total_record = $stm->rowCount();
            $total_page = ceil($total_record / $perpage);
            ?>
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                <li class="page-item"><a class="page-link" href="data_route.php?page=1"> Previous</a></li>
                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                  <li class="page-item"><a class="page-link" href="data_route.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item"><a class="page-link" href="data_route.php?page=<?php echo $total_page; ?>">Next</a></li>
              </ul>
            </nav>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">กำหนดต้นทาง-ปลายทาง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body" >
        <!-- form add data driver -->
        <style>
        #map {
          width: 100%;
          height: 600px;
          flex: 4;
        }
      </style>
      <div >
        <input type="text" id ="address" value="">
            <input id="submit" type="button" value="ค้นหาข้อมูล" onclick="codeAddress()">
      </div>
      <div id="map"></div>
        <form method="POST" action="add_route_database.php">
          <div class="row mb-2">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="inputIddriver"><span>ระบุต้นทาง</span></label>
                <input type="text" class="form-control" id="startroute" name="start" required>
                <div class="form-row mb-2">
                  <div class="form-group col-md-6">
                    <label for="inputName">ตำแหน่งละติจูดต้นทาง</label>
                    <input type="text" class="form-control" id="waypoint" name="start_po_lat" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputName">ตำแหน่งลองจิจูดต้นทาง</label>
                    <input type="text" class="form-control" id="waypoint" name="start_po_log" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="inputIddriver">ระบุปลายทาง</label>
                <input type="text" class="form-control" id="endroute" name="end">
                <div class="form-row mb-2">
                  <div class="form-group col-md-6">
                    <label for="inputName">ตำแหน่งละติจูดปลายทาง</label>
                    <input type="text" class="form-control" id="waypoint" name="end_po_lat" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputName">ตำแหน่งลองจิจูดปลายทาง</label>
                    <input type="text" class="form-control" id="waypoint" name="end_po_log" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="insertroute">เพิ่มข้อมูลเส้นทาง</button>
          </div>

        </form>
        <!-- end -->
      </div>
    </div>
  </div>

</body>

</html>

