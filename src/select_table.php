<?php
    session_start();
    require('./config.php');
    if(isset($_GET['table'])){
        $sql = "UPDATE  `smartrj`.`table` SET  `status` =  '1' WHERE  `table`.`id` =  :table";
        $param = array(
          ':table' => $_GET['table']
        );
      	$sth = $database->prepare($sql);
      	$sth->execute($param);
      	$result = $sth->fetch();
      	if($sth->errorCode() == 'HY000'){
      	    $_SESSION['tableNum'] = $_GET['table'];
      	    echo 'success';
      	}else{
      	    echo 'error';
      	}
    }else{
        echo 'error';
    }