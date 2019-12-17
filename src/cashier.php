<?php 
  session_start();
  require('./config.php');
  
  $sql = "SELECT order_recript.*, receipt.*, food.title ,food.price as fprice, order_recript.id as order_id, receipt.status as b_status  "
        ."FROM order_recript "
        ."INNER JOIN food ON order_recript.foodID = food.id "
        ."INNER JOIN receipt ON order_recript.r_id = receipt.id "
        ."WHERE receipt.status <= 1 "
        ."ORDER BY receipt.status DESC, receipt.id ASC";
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
                    <h2 class="subtitle">รายการที่สั่งจากลูกค้า</h2>
                </div>
            </div>
        </section>
    </div>
    <div class="container">
    <?php $i=0;$d=0;$tableIndex = 'S00';foreach($tasks as $item){$i++;$d++;?>
      <?php if($tableIndex != $item['r_id']){ $tableIndex = $item['r_id'];?>  
      <article class="message <?php if($item['b_status'] == 1){ echo 'is-success';}else{ echo 'is-info';}?>" id="task_<?=$item['r_id']?>">
        <div class="message-header">
          <p>
            Bill NO. <?=$item['r_id']?>
            <span>
              ( โต๊ะ <?=$item['tableNum']?> )
            </span>
          </p>
        </div>
        <div class="message-body">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Order NO.</th>
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
                <td><?=$item['order_id']?></td>
                <td><?=$item['title']?></td>
                <td><?=$item['foodNum']?></td>
                <td><?=$item['fprice']?></td>
                <td><?=$item['price']?></td>
              </tr>
            </tbody>
        <?php if($tasks[$i]['r_id'] != $tableIndex){$d=0;?>
            <thead>
              <tr>
                <th colspan="5">ราคารวมทั้งหมด</th>
                <th><?=$item['sumary']?></th>
              </tr>
              <tr>
                <th colspan="5">ส่วนลด</th>
                <th><?=($item['sumary']*$item['discount']/100)?> (<?=$item['discount']?>%)</th>
              </tr>
              <tr>
                <th colspan="5">ราคาสุทธิ</th>
                <th><?=$item['nat']?></th>
              </tr>
            </thead>
          </table>
          <div class="field is-grouped columns">
            <p class="column has-text-centered">
              <?php if($item['b_status'] == 1){ ?>
                <a href="./bill.php?id=<?=$item['r_id']?>" class="button is-primary is-outlined is-medium" target="_blank">พิมพ์ใบเสร็จ</a>
                <button onclick="order_complete(<?=$item['r_id']?>);" class="button is-success is-outlined is-medium">ชำระเงิน</button>
              <?php }?>
            </p>
          </div>
        </div>
      </article>
        <?php }?>
      <?php }?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      function order_complete(id){
        if(confirm('ต้องการชำระเงิน ?') == 1){
          var url = './order_complete.php?id=' + id;
          $.ajax({
            url: url,
            context: document.body
          }).done(function(res) {
            if(res == 'success'){
              alert('ชำระเงินเรียบร้อย ขอบคุณครับ');
              $('#task_'+id).remove();
            }else{
              alert('ระบบมีปัญหา ไม่สามารถชำระเงินได้ตอนนี้');
            }
          });
        }
      }
      setInterval(()=>{
        window.location = 'http://'+window.location.hostname+'/cashier.php';
      },5000);
    </script>
  </body>
</html>