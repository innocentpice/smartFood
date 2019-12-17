<?php 
    session_start();
    require('./config.php');
    if(isset($_GET['id'])){
        $sql = "DELETE FROM order_recript WHERE `order_recript`.`id` = :id AND username = :username";
        $param = array(
            ':id' => $_GET['id'],
            ':username' => $_SESSION['account']['username']
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