<?php 
    session_start();
    require('./config.php');
    if(isset($_SESSION['rOder'])){
      
        $sql = "SELECT price FROM order_recript WHERE status >= 1 AND username = '".$_SESSION['account']['username']."' AND r_id = '".$_SESSION['rOder']."'";
        $sth = $database->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        $sumary = 0;
        foreach ($result as $result) {
          $sumary += $result['price'];
        }
        $nat = $sumary - ($sumary * $_SESSION['account']['discount'] / 100);
        $sql = "UPDATE receipt SET `sumary` =  '".$sumary."', `nat` =  '".$nat."' WHERE username = '".$_SESSION['account']['username']."' AND id = '".$_SESSION['rOder']."'";
        $sth = $database->prepare($sql);
        $sth->execute();
        $result = $sth->fetch();      
      
      
        $sql = "UPDATE receipt SET status = 1 WHERE status = 0 AND username = :username AND id = ".$_SESSION['rOder'];
        $param = array(
            ':username' => $_SESSION['account']['username']
        );
      	$sth = $database->prepare($sql);
      	$sth->execute($param);
      	$sth->fetch();
      	
      	$sql = "UPDATE  `smartrj`.`table` SET  `status` =  '0' WHERE  `table`.`id` =  '".$_SESSION['tableNum']."'";
      	$sth = $database->prepare($sql);
      	$sth->execute();
      	$sth->fetch();
        if($sth->errorCode() == 'HY000'){
            $msgCheckBill = true;
            session_unset();
        }
    }else{
        echo 'error';
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurant</title>
    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.1/css/bulma.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./public/css/custom.css" />
  </head>
  <body>
      <?php
        if($msgCheckBill == true){;
      ?>
      <script>
          alert('ขอบคุณที่ใช้บริการ');
          window.location = 'http://'+window.location.hostname+'/';
      </script>
      <?php }?>
  </body>
</html>