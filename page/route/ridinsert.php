<?php
require '../../config.php';
session_start();
$_SESSION['rid_addpoint'] = $_GET['addpoint'];
echo  $_SESSION['rid_addpoint'];
header('Location:insert_route.php');
