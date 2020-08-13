<?php 
    require 'config.php';
    if(isset($_POST['inputUsername']) && isset($_POST['inputPassword'])){
        $username = $_POST['inputUsername'];
        $password = $_POST['inputPassword'];
        $sql = "SELECT * FROM admin WHERE username=:username and password=:password";
        $stm = $connection->prepare($sql);
        $stm->bindValue(':username', $username);
        $stm->bindValue(':password', $password);
        $stm->execute();
        $user = $stm->fetch(PDO::FETCH_ASSOC);
        // echo $admin['username'];
        if($user['username']== $username && $user['password']==$password){
            session_start();
            $_SESSION["id"] = $user['id'];
            $_SESSION["name"] = $user['name'];
            $_SESSION["surname"] = $user['surname'];
            $_SESSION["username"] = $user['username'];
            $_SESSION["sex"] = $user['sex'];
            $_SESSION['type'] = $user['type'];
            print 'Redirecting...';
            header('Location:page/driver_data/data_driver.php',true,303);
            exit;
        }
        else{
            echo "<script>";
            echo "alert('กรุณกรอข้อมูลให้ถูกต้อง')";
             echo "</script>";
            header("refresh:1;index.php"); 
        }
    } 
