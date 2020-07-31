<?php
require '../../config.php';
$rid= $_GET['id'];
$sql3 = "SELECT * From route where rid='$rid'";
$stm = $connection->prepare($sql3);
$stm->execute();
$loadroute = $stm->fetch();

 echo  $loadroute['start_route_name'] . '-' . $loadroute['end_route_name']; ?>
