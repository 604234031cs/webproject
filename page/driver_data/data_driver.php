<?php
require '../../config.php';
$message = "";
$perpage = 5;
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

$sql1 = "SELECT * FROM driver where d_username like '%$search%' or d_name like '%$search%' limit {$start},{$perpage}  ";
$stm = $connection->prepare($sql1);
$stm->execute();
$drivers = $stm->fetchAll(PDO::FETCH_ASSOC);
// $message = $driver['name'];
$sql3 = "SELECT * From route";
$stm = $connection->prepare($sql3);
$stm->execute();
$loadroutes = $stm->fetchAll();

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

  <title>ข้อมูลคนขับรถ</title>
</head>

<body>
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark" id="sidebar-wrapper">
      <div class="list-group list-group-flush sticky-top">
        <div class="sidebar-heading">
          <center>
            <img src="../../img/LogoApp.png" class="rounded" alt="Cinque Terre" style="width: 10rem;">
          </center>
        </div>

        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="fas fa-folder-open mr-2"></i>ข้อมูลคนขับ</a>
        <a href="../route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white">
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
                  <i class="fas fa-user-cog"></i> ข้อมูลส่วนตัว
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
            <h2 class="text-left">ข้อมูลคนขับรถ</h2>
          </div>
        </div>
        <div class="card">
          <div class="card-header ">
            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">
              <i class="fas fa-user-plus"></i> เพิ่มข้อมูลคนขับ</button>
          </div> <!-- end-card-header -->
          <div class="card-body">
            <!-- start-card-body -->
            <div class="float-right">
              <form method="post">
                รหัสคนขับ :
                <input type="text" name="key_word">
                <button type="submit" class="btn  ">
                  <i class="fas fa-search"></i></button>
              </form>
              <br>
            </div>

            <table class="table table table-striped justify-content-center">

            <thead class="thead-dark">
                <!-- start-table-->
                <tr>
                  <th>
                    <center>ชื่อเข้าใช้ระบบ</center>
                  </th>
                  <th>
                    <center>ชื่อ-นามสกุล</center>
                  </th>
                  <th>
                    <center>เบอร์โทรติดต่อ</center>
                  </th>
                  <th>
                    <center>เพศ</center>
                  </th>
                  <th>
                    <center>การทำงาน</center>
                  </th>
                  <th>
                    <center></center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php if ($drivers != null) { ?>
                  <?php foreach ($drivers as $driver) : ?>
                    <tr>
                      <td>
                        <center><?php echo $driver['d_username']; ?></center>
                      </td>
                      <td>
                        <center><?php echo $driver['d_name'] . "&nbsp;&nbsp;&nbsp;" . $driver['d_lastname']; ?></center>
                      </td>
                      <td>
                        <center><?php echo $driver['phone']; ?></center>
                      </td>
                      <td>
                        <center><?php echo $driver['sex']; ?></center>
                      </td>
                      <td>
                        <center>
                          <?php if ($driver['status_driver'] == '0') {
                            echo "Offline";
                          } elseif ($driver['status_driver'] == '1') {
                            echo "Online";
                          }
                          ?>
                        </center>
                      </td>
                      <td>
                        <center>
                          <a type="button" onclick="showdatadriver('<?php echo $driver['d_name']; ?>','<?php echo $driver['d_lastname']; ?>','<?php echo $driver['phone']; ?>',
                      '<?php echo $driver['sex']; ?>', '<?php echo $driver['rid']; ?>')" class="btn btn-primary btn-sm active " data-toggle="modal" data-target="#datadriver">
                            <i class="fas fa-folder-open mr-2"></i>View</a>
                          <a href="details_driver.php?detaildriver=<?= $driver['d_id']; ?>" class="btn btn-info btn-sm active "><i class="fas fa-user-edit mr-2"></i>Edit</a>
                          <a onclick="return confirm('ต้องการลบข้อมูลคนขับหรือไม่?')" href="driver_Delete.php?del=<?= $driver['d_id']; ?>" class="btn btn-danger btn-sm active">
                          <i class="fas fa-trash-alt mr-2"></i>Delet</a>
                        </center>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="6">
                      <h4> ไม่พบข้อมูลคนขับในฐานข้อมูล</h4>
                    </td>
                  </tr>

                <?php  } ?>
              </tbody>

            </table> <!-- end-table-->
            <?php
            $sql1 = "SELECT * FROM  driver";
            $stm = $connection->prepare($sql1);
            $stm->execute();
            $row = $stm->fetchAll(PDO::FETCH_ASSOC);
            $total_record = $stm->rowCount();
            $total_page = ceil($total_record / $perpage);
            ?>
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                <li class="page-item"><a class="page-link" href="data_driver.php?page=1">Previous</a></li>
                <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                  <li class="page-item"><a class="page-link" href="data_driver.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
                <li class="page-item"><a class="page-link" href="data_driver.php?page=<?php echo $total_page; ?>">Next</a></li>
              </ul>
            </nav>
          </div> <!-- end-card-body -->
        </div><!-- end-card -->
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

  <!-- javascript ส่งค่าไม่ Modal -->
  <script>
    function showdatadriver(name, lname, phone, sex, rid) {
      $('#datadriver').modal('show');
      setTimeout(function() {
        document.getElementById("show_name").value = name;
        document.getElementById("show_lname").value = lname;
        document.getElementById("show_phone").value = phone;
        document.getElementById("show_sex").value = sex;
        document.getElementById("show_rid").value = rid;
        }, 200); 

    }
  </script>

  <div class="modal fade  " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลคนขับ</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body ">
          <!-- form add data driver -->
          <form action="add_driver_dabase.php" method="POST">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputName">ชื่อ</label>
                <input type="text" class="form-control" id="inputName" name="name" required>
              </div>
              <div class="form-group col-md-6">
                <label for="inputLastname">นามสกุล</label>
                <input type="text" class="form-control" id="inputLastname" name="lastname" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputName">Name</label>
                <input type="text" class="form-control" id="inputNameEng" name="nameEng" required>
              </div>
              <div class="form-group col-md-6">
                <label for="inputLastname">Surname</label>
                <input type="text" class="form-control" id="inputLastnameEng" name="lastnameEng" required>
              </div>
            </div>


            <div class="form-group col-md-6">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sex" value="ชาย" checked>
                <label class="form-check-label" for="exampleRadios1">
                  ชาย
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="sex" id="exampleRadios2" value="หญิง">
                <label class="form-check-label" for="exampleRadios2">
                  หญิง
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPhonenumber">เบอร์โทรติดต่อ</label>
              <input type="text" class="form-control" id="inputPhoneNumber" name="phonenumber" required>
            </div>

            <!-- <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputName">Username</label>
                <input type="text" class="form-control" id="inputName" name="username" placeholder="" required>
              </div>
            </div> -->
            <div class="form-group">
              <label for="exampleFormControlSelect1">กำหนดเส้นทาง</label>
              <select class="form-control" id="exampleFormControlSelect1" name="routeadd">
                <?php foreach ($loadroutes as $loadroute) : ?>
                  <option value="<?php echo $loadroute['rid']; ?>"><?php echo $loadroute['start_route_name'] . '-' . $loadroute['end_route_name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
        </div>
        <div class="modal-footer bg-success">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="insertdriver">เพิ่มข้อมูลคนขับ</button>
        </div>
        </form>
        <!-- end -->
      </div>
    </div>
  </div>


  <!-- รายละเอียดคนขับ -->
  <div class="modal fade  " id="datadriver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h5 class="modal-title" id="exampleModalLabel">รายละเอียดคนขับ</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body ">
          <!-- form add data driver -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputName">ชื่อ</label>
              <input type="text" class="form-control" id="show_name" name="showd_name" readonly>
            </div>
            <div class="form-group col-md-6">
              <label for="inputLastname">นามสกุล</label>
              <input type="text" class="form-control" id="show_lname" name="show_lname" readonly>
            </div>
          </div>

          <div class="form-group">
            <label for="inputPhonenumber">เพศ</label>
            <input type="text" class="form-control" id="show_sex" name="phonenumber" readonly>
          </div>

          <div class="form-group">
            <label for="inputPhonenumber">เบอร์โทรติดต่อ</label>
            <input type="text" class="form-control" id="show_phone" name="phonenumber" readonly>
          </div>

          <div class="form-group">
            <label for="inputPhonenumber"></label>
            <input type="text" class="form-control" id="show_rid" name="phonenumber" readonly>
          </div>

          <!-- <div class="form-group">
            <label for="exampleFormControlSelect1">ประจำเส้นทาง</label>
            <select class="form-control" id="exampleFormControlSelect1" name="routeadd">
              <?php foreach ($loadroutes as $loadroute) : ?>
                <option value="<?php echo $loadroute['rid']; ?>"><?php echo $loadroute['start_route_name'] . '-' . $loadroute['end_route_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div> -->
        </div>
        <div class="modal-footer bg-warning">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <!-- end -->
      </div>
    </div>
  </div>
</body>

</html>


<!-- Modal -->