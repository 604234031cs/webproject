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
$sql1 = "SELECT * FROM admin 
        where id like '%$search%' or
         username like '%$search%'  or 
         name like '%$search%'  or 
         surname like '%$search%'   
         limit {$start},{$perpage}";
$stm = $connection->prepare($sql1);
$stm->execute();
$admins = $stm->fetchAll();
// $message = $driver['name'];
$index = sizeof($admins);
$sql2 = "SELECT * FROM admin ORDER BY id DESC LIMIT 1 ";
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
    <script type="text/javascript" src="https://api.longdo.com/map/?key=8b2c05d9523bf70f5c85804f7e98de02 "></script>
    <script type="text/javascript" src="../../js/test.js "></script>
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
                <a href="../driver_data/data_driver.php" class="list-group-item list-group-item-action bg-dark text-white ">
                    <i class="fas fa-folder-open mr-2"></i>ข้อมูลคนขับ</a>
                <a href="../route/data_route.php" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-folder-open mr-2"></i>จัดการเส้นทาง</a>
                <?php if ($_SESSION['type'] == 'm_admin') { ?>
                    <a href="" class="list-group-item list-group-item-action bg-dark text-white ">
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
                    <!-- <div class="form-inline my-2 my-lg-">
                       
                    </div> -->
            </nav>
            <br>
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="text-left">ข้อมูลผู้แลระบบ</h2>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-user-shield"></i>
                            เพิ่มข้อมูลผู้ดูแลระบบ</button>
                    </div>
                    <!-- card-body -->
                    <div class="card-body">
                        <!-- table -->
                        <div class="float-right">
                            <form method="post">
                                ค้นหา :
                                <input type="text" name="key_word">
                                <button type="submit" class="btn  ">
                                    <i class="fas fa-search"></i></button>
                            </form>
                            <br>
                        </div>
                        <table class="table table-striped  justify-content-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th>
                                        <center>ชื่อเข้าใช้ระบบ</center>
                                    </th>
                                    <th>
                                        <center>ชื่อ-นามสกุล</center>
                                    </th>
                                    <th>
                                        <center>เพศ</center>
                                    </th>
                                    <th>
                                        <center>เบอร์โทรติดต่อ</center>
                                    </th>
                                    <th>
                                        <center>ประเภท</center>
                                    </th>
                                    <th>
                                        <center>การจัดการ</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($admins != null) { ?>
                                    <?php foreach ($admins as $admin) : ?>
                                        <?php if ($admin['type'] == 'personnel') { ?>
                                            <tr>
                                                <td>
                                                    <center><?php echo $admin['username']; ?> </center>
                                                </td>
                                                <td>
                                                    <center><?php echo $admin['name'] . "&nbsp;&nbsp;&nbsp;" . $admin['surname']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?php echo $admin['sex']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?php echo $admin['phone']; ?></center>
                                                </td>
                                                <td>
                                                    <center><?php if ($admin['type'] == 'personnel') {
                                                                echo 'ผู้ดูแลระบบ';
                                                            }
                                                            ?>
                                                    </center>
                                                </td>
                                                <td>
                                                    <center>
                                                        <a href="" class="btn btn-primary btn-sm active">
                                                            <i class="fas fa-search mr-2"></i>View</a>
                                                        <a href="" class="btn btn-warning btn-sm active" onclick="editadmin('<?php echo $admin['username']; ?>','<?php echo $admin['name']; ?>','<?php echo $admin['surname']; ?>',
                                                            '<?php echo $admin['phone']; ?>', '<?php echo $admin['type']; ?>','<?php echo $admin['sex']; ?>')" data-toggle="modal" data-target="#editadmin">
                                                            <i class="fas fa-edit mr-2 "></i>Edit</a>
                                                        <a onclick="return confirm('ต้องการลบข้อมูลผู้แลระบบหรือนี้หรือไม่?')" href="admin_Delete.php?del=<?= $admin['id']; ?>" class="btn btn-danger btn-sm active">
                                                            <i class="fas fa-trash-alt mr-2"></i>Delet</a>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="6">
                                            <h4>ไม่พบข้อมูลเส้นทางในฐานข้อมูล</h4>
                                            <!-- <?php header("refresh:1;dataadmin.php"); ?> -->
                                        </td>
                                    </tr>
                                <?php  } ?>
                            </tbody>
                        </table>
                        <?php
                        $sql1 = "SELECT * FROM  admin";
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

    <script>
        function editadmin(username, name, surname, phone, type, sex) {
            $('#editadmin').modal('show');
            setTimeout(function() {
                document.getElementById("show_username").value = username;
                document.getElementById("show_name").value = name;
                document.getElementById("show_surname").value = surname;
                document.getElementById("show_phone").value = phone;
                document.getElementById("show_type").value = type;
                document.getElementById("show_sex").value = sex;
            }, 200);
        }
    </script>

























    <!-- เพิ่มข้อมูลผู้ดูแลระบบ -->
    <div class="modal fade  " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลผู้ดูแลระบบ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <!-- form add data driver -->
                    <form action="addadmin.php" method="POST">
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
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Username</label>
                                <input type="text" class="form-control" id="inputName" name="username" placeholder="" required>
                            </div>
                        </div>
                </div>
                <div class="modal-footer bg-success">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="insertadmin">เพิ่มข้อมูลผู้ดูแลระบบ</button>
                </div>
                </form>
                <!-- end -->
            </div>
        </div>
    </div>


    <!-- แก้ไขข้อมูลผู้ดูแลระบบ -->
    <div class="modal fade  " id="editadmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">รายละเอียดคนขับ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- body -->
                <form action="addadmin.php" method="POST">
                    <div class="modal-body ">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" id="show_username" name="show_username" readonly>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>ชื่อ</label>
                                <input type="text" class="form-control" id="show_name" name="showd_name">
                            </div>
                            <div class="form-group col-md-6">
                                <label>นามสกุล</label>
                                <input type="text" class="form-control" id="show_surname" name="show_surname">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>เพศ</label>
                            <input type="text" class="form-control" id="show_sex" name="show_sex" readonly>
                        </div>

                        <div class="form-group">
                            <label>เบอร์โทรติดต่อ</label>
                            <input type="text" class="form-control" id="show_phone" name="show_phone" readonly>
                        </div>

                        <div class="form-group">
                            <label>ประเภทผู้ดูแลระบบ</label>
                            <input type="text" class="form-control" id="show_type" name="show_type" readonly>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                               เปลี่ยนรหัสผ่านผู้ดูแลระบบ
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                        </div>
                    </div>
                    <!-- endbody -->
                    <div class="modal-footer bg-warning">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="insertadmin">แก้ไข</button>
                    </div>
                </form>
                <!-- end -->
            </div>
        </div>
    </div>
</body>

</html>