<?php
require '../../config.php';
session_start();
$_SESSION['rid_edi'] = $_GET['editrid'];
// echo  $_SESSION['rid_edi'];
header('Location:edit_route.php');
