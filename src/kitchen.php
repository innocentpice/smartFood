<?php 
  session_start();
  require('./config.php');
  
  $sql = "SELECT order_recript.*, food.title, food.mtime "
        ."FROM order_recript "
        ."INNER JOIN food ON order_recript.foodID = food.id "
        ."WHERE r_id "
        ."IN ("
        ."SELECT id AS r_id "
        ."FROM receipt "
        ."WHERE tableNum "
        ."IN ("
        ."SELECT id AS tableNum "
        ."FROM  `table` "
        ."WHERE table.status = 1 "
        .") "
        ."AND receipt.status = 0 "
        .") "
        ."AND STATUS =1 "
        ."ORDER BY tableNum";
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
                    <h3>เวลาปัจจุบัน
                      <span id="nowtime">
                        <script>
                          document.write(Date());
                        </script>
                      </span>
                    </h3>
                </div>
            </div>
        </section>
    </div>
    <div class="container" id="app">
      <?php $i=0;$d=0;$tableIndex = 'S00';foreach($tasks as $item){$i++;$d++;?>
        <?php if($tableIndex != $item['tableNum']){ $tableIndex = $item['tableNum'];?>
        <article class="message is-info" id="tls<?=$item['tableNum']?>">
            <div class="message-header">
                <p>โต๊ะ <?=$item['tableNum']?></p>
                <button class="delete"></button>
            </div>
            <div class="message-body">
                <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Order NO.</th>
                  <th>ชื่อเมนู</th>
                  <th>จำนวน</th>
                  <th>เวลาเสริฟ</th>
                </tr>
              </thead>
              <tbody id="task_list<?=$item['tableNum']?>">
        <?php }?>
        
                <tr id="task_item<?=$item['id']?>">
                  <td><?=$d?></td>
                  <td><?=$item['id']?></td>
                  <td><?=$item['title']?></td>
                  <td><?=$item['foodNum']?></td>
                  <td><?php if($item['maketime'] == '0000-00-00 00:00:00'){echo 'กำลังเตรียม';}else{echo $item['maketime'];}?></td>
                  <td>  
                    <div class="block">
                      <?php if($item['maketime'] == '0000-00-00 00:00:00'){?>
                      <button class="button is-primary" onclick="maketime(<?=$item['id']?>,<?=$item['mtime']?>);">ทำเมนู</button>
                      <?php }?>
                      <button class="button is-info" onclick="update(<?=$item['id']?>);">เสริฟ</button>
                      <button class="button is-danger" onclick="cancelfood(<?=$item['id']?>);">ยกเลิกรายการ</button>
                    </div>
                  </td>
                </tr>
                
        <?php if($tasks[$i]['tableNum'] != $tableIndex){$d=0;?>        
              </tbody>
            </table>
            </div>
        </article>
        <?php }?>
      <?php }?>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      function maketime(id,mTi){
        if(confirm('ทำเมนูนี้ ?')){
          var url = './maketime.php?id=' + id + '&mtime=' + mTi;
          $.ajax({
            url: url,
            context: document.body
          }).done(function(res) {
              if(res == 'success'){
                var target = '#task_item'+id;
                $(target).remove();
                if($('#task_list'+id).html() == ''){
                  $('#tls'+id).remove();
                }
                window.location = 'http://'+window.location.hostname+'/kitchen.php';
              }
          });
        }
      }function cancelfood(id){
        if(confirm('ต้องการยกเลิก ?')){
          var url = './cancel.php?id=' + id;
          $.ajax({
            url: url,
            context: document.body
          }).done(function(res) {
              if(res == 'success'){
                var target = '#task_item'+id;
                $(target).remove();
                if($('#task_list'+id).html() == ''){
                  $('#tls'+id).remove();
                }
                alert('ยกเลิกรายการเรียบร้อย');
              }
          });
        }
      }
      function update(id){
        if(confirm('ต้องการเสิร์ฟ ?')){
          var url = './serve.php?id=' + id;
          $.ajax({
            url: url,
            context: document.body
          }).done(function(res) {
              if(res == 'success'){
                var target = '#task_item'+id;
                $(target).remove();
                if($('#task_list'+id).html() == ''){
                  $('#tls'+id).remove();
                }
              }
          });
        }
      }
      setInterval(()=>{
        window.location = 'http://'+window.location.hostname+'/kitchen.php';
      },5000);
      setInterval(()=>{
        $('#nowtime').html(Date());
      },1000);
    </script>
  </body>
</html>