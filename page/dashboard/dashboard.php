<?php
session_start();
if (!isset($_SESSION["username"])) {
  echo "<script>";
  echo "alert('กรุณาเข้าสู่ระบบ')";
  echo "</script>";
  header("refresh:1;index.php");
} else {
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
</head>

<body>

  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark " id="sidebar-wrapper">
      <div class="sidebar-heading">
        <center>
          <!-- <i class="fas fa-user-shield text-white ">
          </i> -->
          <img src="../../img/LogoApp.png" class="rounded" alt="Cinque Terre" style="width: 10rem;">

        </center>
        <center><button type="button" class="btn btn-dark">
            <i class="far fa-bell"></i> &nbsp;แจ้งเตือน &nbsp;&nbsp;<span class="badge badge-light">9</span>
            <span class="sr-only">unread messages</span>
          </button>
        </center>
      </div>
      <div class="list-group list-group-flush">
        <a href="dashboard.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-folder-open"></i>&nbsp;dashboard</a>
        <a href="../driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-folder-open"></i>&nbsp;ข้อมูลคนขับ</a>
        <a href="../route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-folder-open"></i>&nbsp;จัดการเส้นทาง</a>
        <a href="../../checklogin.php" class="list-group-item list-group-item-action bg-dark text-danger"><i class="fas fa-power-off">&nbsp;ออกจากระบบ</i></a>
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
            <a href="../../checklogin.php" class="navbar-nav mr-auto text-light"><i class="fas fa-power-off"></i></a>
          </div>
        </div>
      </nav>
      <style>
        .container-fluid {
          border-style: solid;
          border-color: red;

        }

        .card {
          padding: 200px;
          margin: 50px;
          border-style: dashed;
          border-color: blue;
          background-color: yellow;
        }
      </style>
      <div class="container-fluid">
        <div class="card ">
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

</body>

</html>