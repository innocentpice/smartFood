<?php 
    session_start();
    require('./config.php');
    if(isset($_GET['id'])){
        $sql = "UPDATE order_recript SET status = 2 WHERE id = :id";
        $param = array(
            ':id' => $_GET['id']
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