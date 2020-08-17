<?php
require '../../config.php';
$driverid = $_GET['detaildriver'];

session_start();
if ($_SESSION["username"] == null &&  $_SESSION["username"] == '') {
    echo "<script>";
    echo "alert('กรุณาลงชื่อเข้าใช้ระบบ')";
    echo "</script>";
    header('Location:../../index.php', true, 303);
}
if (isset($_POST['edit_data'])) {
    $edit_name = $_POST['edit_name'];
    $edit_lastname = $_POST['edit_lastname'];
    $edit_phone = $_POST['edit_phonenumber'];
    $edit_route = $_POST['edit_routeadd'];
    $sql = "UPDATE driver SET d_name='$edit_name',d_lastname='$edit_lastname',phone='$edit_phone',rid='$edit_route' 
    where d_id='$driverid'";
    $stm = $connection->prepare($sql);
    if ($stm->execute()) {
        echo "<script>";
        echo "alert('แก้ไขข้อมูลสำเร็จ')";
        echo "</script>";
    } else {
        echo "<script>";
        echo "alert('เกิดข้อผิดพลาด')";
        echo "</script>";
    }
}
$sql1 = "SELECT driver.d_id,driver.d_name,driver.d_lastname,driver.phone,route.rid,route.start_route_name,route.end_route_name
    FROM route,driver
    WHERE route.rid = driver.rid
    and driver.d_id = '$driverid'";
$stm = $connection->prepare($sql1);
$stm->execute();
$drivers = $stm->fetch(PDO::FETCH_ASSOC);
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
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="../../css/responside.css" rel="stylesheet">

</head>

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
                    <i class="fas fa-folder-open mr-2"></i>จัดการผู้แลระบบ</a>
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
                                    <i class="fas fa-user-cog"></i>ข้อมูลส่วนตัว
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="../../checklogout.php" class="dropdown-item" style="color:red;">
                                    <i class="fas fa-power-off mr-2"></i>ออกจากระบบ
                                </a>
                        </li>

                    </ul>
                </div>
            </nav>
            <div class="container mt-5 ">

                <div class="card ">
                    <div class="card-header">
                        <div class="col">
                            <h2 class="text-left">แก้ไขข้อมูลคนขับ</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="inputIddriver">รหัสคนขับ</label>
                                <input type="text" class="form-control" id="inputIddriver" name="edit_id" value="<?php echo $drivers['d_id'] ?>" required readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName">ชื่อ</label>
                                    <input type="text" class="form-control" id="inputName" name="edit_name" value="<?php echo $drivers['d_name'] ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputLastname">นามสกุล</label>
                                    <input type="text" class="form-control" id="inputLastname" name="edit_lastname" value="<?php echo $drivers['d_lastname'] ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPhonenumber">เบอร์โทรติดต่อ</label>
                                <input type="text" class="form-control" id="inputPhoneNumber" name="edit_phonenumber" value="<?php echo $drivers['phone'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">กำหนดเส้นทาง</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="edit_routeadd">
                                    <option value="<?php echo $drivers['rid']; ?>"><?php echo $drivers['start_route_name'] . '-' . $drivers['end_route_name']; ?></option>
                                    <?php foreach ($loadroutes as $loadroute) : ?>
                                        <option value="<?php echo $loadroute['rid']; ?>"><?php echo $loadroute['start_route_name'] . '-' . $loadroute['end_route_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="edit_data">แก้ไขข้อมูลคนขับ</button>
                                <button type="reset" class="btn btn-danger" name="edit_data">ยกเลิก</button>
                            </div>
                        </form>
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
</body>

</html>