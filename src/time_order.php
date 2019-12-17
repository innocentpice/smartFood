<?php
  session_start();
  require('./config.php');
  
  if(empty($_SESSION['account'])){
    return false;
    echo 'plz Login';
    exit();
  }
  
  if(isset($_GET['confirmMenu'])){
    
    $sql = "UPDATE order_recript SET status = 1 WHERE status = 0 AND username = '".$_SESSION['account']['username']."' AND r_id = '".$_SESSION['rOder']."'";
    $sth = $database->prepare($sql);
	  $sth->execute();
	  $result = $sth->fetch();
	  
  }
  
  $sql = "SELECT order_recript.*,food.title,food.maketime,food.price as fprice FROM order_recript INNER JOIN food ON order_recript.foodID = food.id WHERE status >= 1 AND username = '".$_SESSION['account']['username']."' AND r_id = '".$_SESSION['rOder']."'";
	$sth = $database->prepare($sql);
	$sth->execute();
	$orList = $sth->fetchAll();
	
	$sql = "SELECT * FROM receipt WHERE status = 0 AND username = '".$_SESSION['account']['username']."' AND id = '".$_SESSION['rOder']."'";
	$sth = $database->prepare($sql);
	$sth->execute();
	$receipt = $sth->fetch();
	
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
    <?php require('./navbar.php');?>
        <div class="column">
            <section class="hero">
                <div class="hero-body">
                    <div class="container has-text-centered">
                        <h1 class="title">Smart Restaurant</h1>
                        <h2 class="subtitle">เวลาที่อาหารแต่ละเมนูจะมาส่งลูกค้า</h2>
                        <h3 class="subtitle">เมื่อแม่ครัวเริ่มทำเมนูใดแล้ว ลูกค้าสามารถรับรู้ได้ว่ารายการอาหารจะมาส่งในอีกกี่นาที</h3>
                    </div>
                </div>
            </section>
        </div>
        <div class="container">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>เมนู</th>
                  <th>จำนวน</th>
                  <th>เวลาต่อเมนู</th>
                  <th>เวลารวม</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;foreach($orList as $item){$i++?>
                <tr>
                  <td><?=$i?></td>
                  <td><?=$item['title']?></td>
                  <td><?=$item['foodNum']?></td>
                  <td><?=$item['maketime']?></td>
                  <td></td>

                </tr>
                <?php }?>
              </tbody>
            <thead>
                <tr>
                  <th colspan="4">เวลารวมของเมนูทั้งหมด</th>
                  
                </tr>
              </thead>
            </table>
        </div>
        
        <div class="field is-grouped columns">
            <p class="column has-text-centered">
                <a href="./menu.php" class="button is-primary is-outlined is-medium">สั่งอาหารเพิ่ม</a>
            </p>
        </div>
  </body>
</html>