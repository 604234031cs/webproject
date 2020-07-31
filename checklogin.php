<?php 
    require 'config.php';
    if(isset($_POST['inputUsername']) && isset($_POST['inputPassword'])){
        $username = $_POST['inputUsername'];
        $password = $_POST['inputPassword'];
        
        $sql = "SELECT * FROM userlogin WHERE u_username=:username and u_password=:password";
        $stm = $connection->prepare($sql);
        $stm->bindValue(':username', $username);
        $stm->bindValue(':password', $password);
        $stm->execute();
        $user = $stm->fetch(PDO::FETCH_ASSOC);
        // echo $admin['username'];
        if($user['uusername']== $username && $user['upassword']==$password && $user['u_type'] =="admin"){
            session_start();
            $_SESSION["username"] = $user['uusername'];
            print 'Redirecting...';
            header('Location:page/dashboard/dashboard.php',true,303);
            exit;
        }
        else{
            echo "<script>";
            echo "alert('กรุณกรอข้อมูลให้ถูกต้อง')";
             echo "</script>";
            header("refresh:1;index.php"); 
        }
    }else{
        session_unset();
        header('Location:index.php');
    }
