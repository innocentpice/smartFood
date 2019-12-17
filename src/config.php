<?php
$db_host = 'localhost';
$db_name = 'smartrj';
$db_username = 'root';
$db_password = '';

try {
    $database = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

define('URL_Path',"http://localhost");
date_default_timezone_set("Asia/Bangkok");