<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" >
  <!-- Custom styles for this template -->
  <link href="css/responside.css" rel="stylesheet">

</head>

<body>

<div class="d-flex" id="wrapper">
  <!-- Sidebar -->
  <div class="bg-dark " id="sidebar-wrapper">
    <div class="sidebar-heading"><i class="fas fa-user-shield text-white">  Admin</i> </div>
    <div class="list-group list-group-flush">
      <a href="driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white">ข้อมูลคนขับ</a>
      <a  href="route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white">จัดการเส้นทาง</a>
    </div>
  </div>
  <!-- /#sidebar-wrapper -->

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
      <button class="btn btn-dark" id="menu-toggle"><i class="fa fa-bars"></i></button>
    </nav>

    <div class="container-fluid">
          <div class="card">
              <div class="card-header">
                  sd           
              </div>
              <div class="card-body">
                  sd
              </div>
          </div>
    </div>
  </div>
<!-- /#page-content-wrapper -->
</div>


<script src="node_modules/jquery/dist/jquery.slim.min.js" ></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" ></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>
