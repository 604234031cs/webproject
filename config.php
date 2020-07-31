<?php
$dsn = 'mysql:host=localhost;dbname=projectend;charset=utf8';
$username = 'root';
$password = '';
$options = [];
try {
$connection = new PDO($dsn, $username, $password, $options); 
// echo "Connection success......";
} catch(PDOException $e) {

}

