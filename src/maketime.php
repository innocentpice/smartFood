<?php 
    session_start();
    require('./config.php');
    if(isset($_GET['id']) && isset($_GET['mtime'])){
        $t = time() + $_GET['mtime'];
        $mtime = date("Y-m-d H:i:s",$t);
        $sql = "UPDATE order_recript SET maketime = :mtime WHERE id = :id";
        $param = array(
            ':id' => $_GET['id'],
            ':mtime' => $mtime
        );
      	$sth = $database->prepare($sql);
      	$sth->execute($param);
      	$sth->fetch();
        if($sth->errorCode() == 'HY000'){
            echo 'success';
        }
    }else{
        echo 'error';
    }