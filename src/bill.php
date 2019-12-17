<?php 
  session_start();
  require('./config.php');
  if(empty($_GET['id'])){echo 'error emprty id'; return false;}
  $sql = "SELECT order_recript.*, receipt.*, food.title ,food.price as fprice, order_recript.id as order_id, receipt.status as b_status  "
        ."FROM order_recript "
        ."INNER JOIN food ON order_recript.foodID = food.id "
        ."INNER JOIN receipt ON order_recript.r_id = receipt.id "
        ."WHERE r_id = ".$_GET['id'];
  $sth = $database->prepare($sql);
  $sth->execute();
  $tasks = $sth->fetchAll();
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
    <div class="column">
        <section class="hero">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h1 class="title">Smart Restaurant</h1>
                    <h2 class="subtitle">ใบเสร็จรับเงิน</h2>
                </div>
            </div>
        </section>
    </div>
    <?php $i=0;$d=0;$tableIndex = 'S00';foreach($tasks as $item){$i++;$d++;?>
      <?php if($tableIndex != $item['r_id']){ $tableIndex = $item['r_id'];?>  
      <div class="columns">
          <div class="column is-half is-offset-one-quarter">
            Bill NO. <?=$item['r_id']?> ( โต๊ะ <?=$item['tableNum']?> )
            &nbsp;ID: <?=$item['username']?>
          <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>เมนู</th>
              <th>จำนวน</th>
              <th>ราคา</th>
              <th>รวม</th>
            </tr>
          </thead>
    <?php }?>
          <tbody>
            <tr>
              <td><?=$d?></td>
              <td><?=$item['title']?></td>
              <td><?=$item['foodNum']?></td>
              <td><?=$item['fprice']?></td>
              <td><?=$item['price']?></td>
            </tr>
          </tbody>
    <?php if($tasks[$i]['r_id'] != $tableIndex){$d=0;?>
        <thead>
            <tr>
              <th colspan="4">ราคารวมทั้งหมด</th>
              <th><?=$item['sumary']?></th>
            </tr>
            <tr>
              <th colspan="4">ส่วนลด</th>
              <td><?=($item['sumary']*$item['discount']/100)?> (<?=$item['discount']?>%)</td>
            </tr>
            <tr>
              <th colspan="4">ราคาสุทธิ</th>
              <th><?=$item['nat']?></th>
            </tr>
          </thead>
        </table>
    <?php }?>
    <?php }?>
          </div>
      </div>
  </body>
</html>