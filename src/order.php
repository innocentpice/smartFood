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
  
  
  $sql = "SELECT order_recript.*,food.title,food.price as fprice FROM order_recript INNER JOIN food ON order_recript.foodID = food.id WHERE status >= 1 AND username = '".$_SESSION['account']['username']."' AND r_id = '".$_SESSION['rOder']."'";
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
                        <h2 class="subtitle">รายการที่สั่งซื้อทั้งหมด</h2>
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
                  <th>สถานะ/เวลาในการเสริฟ</th>
                  <th>ราคา</th>
                  <th>รวม</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;foreach($orList as $item){$i++?>
                <tr>
                  <td><?=$i?></td>
                  <td><?=$item['title']?></td>
                  <td><?=$item['foodNum']?></td>
                  <td>
                    <?php if($item['status'] == 1){ ?>
                      <?php if($item['maketime'] == '0000-00-00 00:00:00'){echo 'กำลังเตรียม';}else{echo $item['maketime'];}?>
                    <?php }else{echo 'ได้รับอาหารเรียบร้อย';}?>
                  </td>
                  <td><?=$item['fprice']?></td>
                  <td><?=$item['price']?></td>
                </tr>
                <?php }?>
              </tbody>
            <thead>
                <tr>
                  <th colspan="5">ราคารวมทั้งหมด</th>
                  <th><?=$receipt['sumary']?></th>
                </tr>
                <tr>
                  <th colspan="5">ส่วนลด</th>
                  <td><?=($receipt['sumary']*$receipt['discount']/100)?> (<?=$receipt['discount']?>%)</td>
                </tr>
                <tr>
                  <th colspan="5">ราคาสุทธิ</th>
                  <th><?=$receipt['nat']?></th>
                </tr>
              </thead>
            </table>
        </div>
        
        <div class="field is-grouped columns">
            <p class="column has-text-centered">
                <a href="./menu.php" class="button is-primary is-outlined is-medium">สั่งอาหารเพิ่ม</a>
                <a href="./checkbill.php" class="button is-info is-outlined is-medium">ชำระเงิน</a>
            </p>
        </div>
        
        <script>
          setInterval(()=>{
            window.location = 'http://'+window.location.hostname+'/order.php';
          },5000);
        </script>
  </body>
</html>