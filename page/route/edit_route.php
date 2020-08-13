 <?php
  require '../../config.php';
  $message = "";
  $perpage = 5;
  session_start();
  // echo $_GET['editrid'];
  $editrid = $_SESSION['rid_edi'];
  if ($_SESSION["username"] == null &&  $_SESSION["username"] == '') {
    echo "<script>";
    echo "alert('กรุณาลงชื่อเข้าใช้ระบบ')";
    echo "</script>";
    header('Location:../../index.php', true, 303);
  }
  // echo $_POST['editrid'];
  if (isset($_POST['editsr_er'])) {
    //   // ข้อมูลแก้ไขจาก form เส้นทาง 'ต้นทาง-ปลายทาง'
    //   $route_id = $_POST['rid'];
    $editstart_routes_name = $_POST['editstart'];
    $editend_routes_name = $_POST['editend'];
    $editstart_po_lat = $_POST['editstart_po_lat'];
    $editstart_po_log = $_POST['editstart_po_log'];
    $editend_po_lat = $_POST['editend_po_lat'];
    $editend_po_log = $_POST['editend_po_log'];
    $type_main = '1';
    echo $editend_po_lat;
    // อัพเดทใน database
    $sql = "UPDATE route SET start_route_name='$editstart_routes_name',
        end_route_name='$editend_routes_name',start_route_pos_lat='$editstart_po_lat',
        start_route_pos_log='$editstart_po_log',end_route_pos_lat='$editend_po_lat',
        end_route_pos_log='$editend_po_log' where rid='$editrid'";
    $stm = $connection->prepare($sql);
    if ($stm->execute()) {
      echo "<script>";
      echo "alert('แก้ไขข้อมูลสำเร็จ')";
      echo "</script>";
    }
  } else if (isset($_POST['formedit'])) {
    $editpo_id = $_POST['editpo_id'];
    $editpo_name = $_POST['editpo_name'];
    $editpo_lat = $_POST['editpo_latitude'];
    $editpo_log = $_POST['editpo_longitude'];

    $sql = "UPDATE point SET po_name='$editpo_name',po_latitude='$editpo_lat',po_longitude='$editpo_log' WHERE po_id = '$editpo_id' ";
    $stm = $connection->prepare($sql);
    if ($stm->execute()) {
      echo "<script>";
      echo "alert('แก้ไขข้อมูลสำเร็จ')";
      echo "</script>";
    }
  }

  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  $sql1 = "SELECT * FROM route where rid = '$editrid'";
  $stm = $connection->prepare($sql1);
  $stm->execute();
  $editroutes = $stm->fetch(PDO::FETCH_ASSOC);
  // echo $editroutes['rid'];
  // $message = $driver['name'];
  $start = ($page - 1) * $perpage;
  $sql2 = "SELECT * FROM point where rid='$editrid' limit {$start},{$perpage}";
  $stm = $connection->prepare($sql2);
  $stm->execute();
  $points = $stm->fetchAll(PDO::FETCH_ASSOC);
  $index = sizeof($points);
  ?>

 <title>จัดการข้อมูลเส้นทาง</title>
 <!-- <link href="../css/style_route_page.css" rel="stylesheet" > -->
 <!-- <script src="../js/fncCreateElement.js"></script> -->
 <!-- <div id="map"></div> -->
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

         <a href="../driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white "><i class="fas fa-folder-open mr-2"></i>ข้อมูลคนขับ</a>
         <a href="../route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-folder-open mr-2"></i>จัดการเส้นทาง</a>
         <?php if ($_SESSION['type'] == 'm_admin') { ?>
           <a href="../admin/dataadmin.php" class="list-group-item list-group-item-action bg-dark text-white "><i class="fas fa-folder-open mr-2"></i>จัดการผู้แลระบบ</a>
         <?php } ?>
         <a href="../../checklogout.php" class="list-group-item list-group-item-action bg-dark text-danger"><i class="fas fa-power-off mr-2"></i>ออกจากระบบ</i></a>
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
         </div>
       </nav>
       <br>
       <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-sm-6">
             <h2 class="text-left">แก้ไขข้อมูล</h2>
           </div>
         </div>
         <!-- card -->
         <div class="card card-default">
           <!-- card-header -->
           <div class="card-header">
             <h3 class="card-title">ต้นทาง-ปลายทาง</h3>
           </div>
           <!-- /card-header -->
           <!-- card-body -->
           <div class="card-body">
             <!-- form -->
             <form method="post">
               <!-- row -->
               <div class="row">
                 <!-- col -->
                 <div class="col-md-6">
                   <div class="form-group">
                     <label>
                       <h4><b>ต้นทาง</b></h4>
                     </label>
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <span class="input-group-text">ชื่อสถานที่</i></span>
                       </div>
                       <input type="text" class="form-control" value="<?php echo $editroutes['start_route_name']; ?>" name="editstart">
                     </div>
                   </div>
                   <div class="form-group">
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <span class="input-group-text">ละติจูด</i></span>
                       </div>
                       <input type="text" class="form-control" value="<?php echo $editroutes['start_route_pos_lat']; ?>" name="editstart_po_lat">
                     </div>
                   </div>
                   <div class="form-group">
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <span class="input-group-text">ลองติจูด</i></span>
                       </div>
                       <input type="text" class="form-control" value="<?php echo $editroutes['start_route_pos_log']; ?>" name="editstart_po_log">
                     </div>
                   </div>
                 </div>
                 <!-- col -->
                 <div class="col-md-6">
                   <div class="form-group">
                     <label>
                       <h4><b>ปลายทาง</b></h4>
                     </label>
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <span class="input-group-text">ชื่อสถานที่</i></span>
                       </div>
                       <input type="text" class="form-control" value="<?php echo $editroutes['end_route_name']; ?>" name="editend">
                     </div>
                   </div>
                   <div class="form-group">
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <span class="input-group-text">ละติจูด</i></span>
                       </div>
                       <input type="text" class="form-control" value="<?php echo $editroutes['end_route_pos_lat']; ?>" name="editend_po_lat">
                     </div>
                   </div>
                   <div class="form-group">
                     <div class="input-group">
                       <div class="input-group-prepend">
                         <span class="input-group-text">ลองติจูด</i></span>
                       </div>
                       <input type="text" class="form-control" value="<?php echo $editroutes['end_route_pos_log']; ?>" name="editend_po_log">
                     </div>
                   </div>
                 </div>
                 <!-- /col -->
               </div>
               <!-- /row -->
               <button type="submit" class="btn btn-info" name="editsr_er">แก้ไขเส้นทาง</button>
               <button type="reset" class="btn btn-danger">ยกเลิก</button>
             </form>
             <!-- /form -->
           </div>
           <!-- /card-body -->
           <div class="card-footer">
           </div>
         </div>
         <!-- /card -->
         <br>
         <!-- card -->
         <div class="card card-default">
           <!-- card-header -->
           <div class="card-header">
             <h3 class="card-title">ระหว่างทาง</h3>
           </div>
           <!-- /card-header -->
           <!-- card-body -->
           <div class="card-body">
             <table class="table table-striped  justify-content-center">
               <thead>
                 <tr>
                   <th>
                     <center>รหัส</center>
                   </th>
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
                     <center></center>
                   </th>
                 </tr>
               </thead>
               <tbody>
                 <?php foreach ($points as $point) : ?>
                   <tr>

                     <td>
                       <center><?php echo $point['po_id']; ?></center>
                     </td>
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
                       <center>
                       <div class="btn-group btn-group-sm">
                        <a type="button" onclick="setval('<?php echo $point['po_id']; ?>','<?php echo $point['po_name']; ?>','<?php echo $point['po_latitude']; ?>','<?php echo $point['po_longitude']; ?>')" class="btn btn-info active " data-toggle="modal" data-target="#editModal">
                           <i class="fas fa-map-marker-alt mr-2"></i>Edit</a>
                         <a onclick="return confirm('ต้องการลบข้อมูลนี้หรือไม่?')" href="route_delete.php?delpoint=<?= $point['po_id']; ?>" class="btn btn-danger btn-sm  active"><i class="fas fa-trash-alt mr-2"></i>Delete</a>
                      </div>
                       </center>

                     </td>
                     <td>

                     </td>
                     </form>
                   </tr>

               </tbody>
             <?php endforeach; ?>
             </table>
             <?php
              $sql1 = "SELECT * FROM  point where rid = '$editrid'";
              $stm = $connection->prepare($sql1);
              $stm->execute();
              $row = $stm->fetchAll(PDO::FETCH_ASSOC);
              $total_record = $stm->rowCount();
              $total_page = ceil($total_record / $perpage);
              ?>
             <nav aria-label="Page navigation example">
               <ul class="pagination justify-content-end">
                 <li class="page-item"><a class="page-link" href="edit_route.php?page=1"> Previous</a></li>
                 <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                   <li class="page-item"><a class="page-link" href="edit_route.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                 <?php } ?>
                 <li class="page-item"><a class="page-link" href="edit_route.php?page=<?php echo $total_page; ?>">Next</a></li>
               </ul>
             </nav>
           </div>
           <!-- /card-body -->
         </div>
         <!-- /card -->
       </div>
       <!-- /#page-content-wrapper -->
     </div>
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

   <script>
     function setval(id, name, lat, log) {
       console.log(id);
       $('#editModal').modal('show'); //เผื่อ modal ไม่ขึ้นนะครับ

       setTimeout(function() {
         document.getElementById("showd_id").value = id;
         document.getElementById("showd_name").value = name;
         document.getElementById("showd_lat").value = lat;
         document.getElementById("showd_log").value = log;

       }, 200); // setTimeout เพราะว่าเผื่อเวลาที่ใช้ในการเปิด modal ครับ
     }
   </script>
 </body>

 </html>

 <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title">Modal Heading</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
       <div class="modal-body">
         <form method="POST">
           <div class="form-group">
             <label for="inputIddriver">Position Id</label>
             <input type="text" class="form-control" name="editpo_id" id="showd_id" readonly>
           </div>
           <div class="form-group">
             <label for="inputIddriver">ชื่อสถานที่</label>
             <input type="text" class="form-control" name="editpo_name" id="showd_name">
           </div>
           <div class="form-group">
             <label for="inputIddriver">ละติจูด</label>
             <input type="text" class="form-control" name="editpo_latitude" id="showd_lat">
           </div>
           <div class="form-group">
             <label for="inputIddriver">ลองจิจูด</label>
             <input type="text" class="form-control" name="editpo_longitude" id="showd_log">
           </div>
       </div>
       <div class="modal-footer">
         <button type="submit" class="btn btn-primary" name="formedit">แก้ไขข้อมูล</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
       </form>
     </div>
   </div>
 </div>