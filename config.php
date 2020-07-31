<?php
$dsn = 'mysql:host=us-cdbr-east-02.cleardb.com;dbname=heroku_b90915650f24a7e;charset=utf8';
$username = 'b9ac199c9c69a9';
$password = 'b91209e9';
$options = [];
try {
$connection = new PDO($dsn, $username, $password, $options); 
// echo "Connection success......";
} catch(PDOException $e) {

}

