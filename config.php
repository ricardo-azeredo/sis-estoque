<?php



$db_name = "estoque_db";
$db_host = "localhost";
$db_user = "root";
$db_pass = "root";


$pdo = new PDO("mysql:dbname=$db_name;host=$db_host",$db_user,$db_pass);