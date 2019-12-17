<?php
    session_start();
    require('./config.php');
    if(isset($_GET['fid']) && isset($_GET['fnum']) && isset($_GET['fprice'])){
        $sql = "INSERT INTO  `smartrj`.`order_recript` ( `id` , `r_id` , `username` , `tableNum` , `foodID` , `foodNum` , `price` , `status` ) VALUES ( NULL, :r_id,  :username,  :tableNum,  :foodID,  :foodNum,  :foodPrice,  '0' );";
        $param = array(
            ':r_id' => $_SESSION['rOder'],
            ':username' => $_SESSION['account']['username'],
            ':tableNum' => $_SESSION['tableNum'],
            ':foodID' => $_GET['fid'],
            ':foodNum' => $_GET['fnum'],
            ':foodPrice' => $_GET['fprice']*$_GET['fnum']
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

