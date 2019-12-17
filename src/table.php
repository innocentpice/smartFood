<?php
    session_start();
    require('./config.php');
    $sql = "SELECT  `id` ,  `status` FROM  `table`";
  	$sth = $database->prepare($sql);
  	$sth->execute();
  	$tables = $sth->fetchAll();
  	
  	$sql = "SELECT tableNum, id FROM receipt WHERE username = '".$_SESSION['account']['username']."' AND status = 0";
  	$sth = $database->prepare($sql);
  	$sth->execute();
  	$table = $sth->fetch();
  	if(isset($table[0])){
  	  $_SESSION['rOder'] = $table['id'];
  	  $msgDebt = true;
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
    <?php // require('./navbar.php');?>
    <div class="container" style="padding-top:3em;">
        <section class="hero">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h1 class="title">Smart Restaurant</h1>
                    <h2 class="subtitle">เลือกโต๊ะอาหารของท่าน</h2>
                </div>
            </div>
        </section>
        <?php if(empty($msgDebt)){?>
        <div class="columns">
            <?php foreach($tables as $table){?>
            <div class="column has-text-centered">
                <button class="table_item button is-info is-outlined is-large" <?php if($table['status'] == 1){echo 'disabled';}?>><?=$table['id']?></button>
            </div>
            <?php }?>
        </div>
        <?php }else{?>
        <div class="columns">
          <div class="column has-text-centered">
            <h2>ท่านมีบิลที่ยังค้างชำระ กรุณาชำระเงิน</h2>
          </div>
          <script>
            window.tableNumber = '<?=$table[0]?>';
            window.msgDebt = 1;
          </script>
        </div>
        <?php }?>
        <div class="columns">
            <div class="column is-half is-offset-one-quarter has-text-centered" style="padding:2em;">
              <button id="select_btn" class="button is-success is-medium" disabled>ยืนยัน</button>
            </div>
        </div>
    </div>
    
    <div id="guest_user" class="modal<?php if(empty($_SESSION['account'])){echo ' is-active';}?>">
      <div class="modal-background"></div>
      <div class="modal-content container">
        <div class="field is-horizontal">
          <div class="field-label is-normal">
            <label class="label" style="color:#fff">โปรดระบุชื่อ</label>
          </div>
          <div class="field-body">
            <div class="field is-grouped">
              <p class="control is-expanded has-icons-left">
                <input id="guestname" class="input" type="text" placeholder="Name">
                <span class="icon is-small is-left">
                  <i class="fa fa-user"></i>
                </span>
              </p>
               <p class="control">
                <button id="guestname_btn" class="button is-info">
                  ยืนยัน
                </button>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        if(window.msgDebt == 1){
          $('#select_btn').removeAttr('disabled');
        }
        $('#guestname_btn').click((e)=>{
            console.log($('#guestname').val());
            if($('#guestname').val() == ''){
                alert('กรุณากรอกชื่อของท่าน');
                return false;
            }
            
            var url = './guest_login.php?name=' + $('#guestname').val();
            $.ajax({
              url: url,
              context: document.body
            }).done(function(res) {
                if(res != 'error'){
                    $('#nav_username').html(res);
                    $('#guest_user').removeClass('is-active');
                }
            });
        });
    
        $('.table_item').click((e)=>{
            window.tableNumber = e.target.innerHTML;
            console.log(window.tableNumber);
            $('.table_item').addClass('is-outlined is-info');
            $('.table_item').removeClass('is-primary');
            $('#select_btn').removeAttr('disabled');
            $(e.target).removeClass('is-outlined is-info');
            $(e.target).addClass('is-primary');
        });
        
        $('#select_btn').click((e)=>{
          if(window.msgDebt == 1 || confirm('ท่านต้องการเลือกโต๊ะ '+window.tableNumber+' หรือไม่ ?')){
            var url = './select_table.php?table=' + window.tableNumber;
            $.ajax({
              url: url,
              context: document.body
            }).done(function(res) {
                if(res == 'success'){
                    if(window.msgDebt != 1){
                      alert('ท่านเลือกโต๊ะเรียบร้อย');
                    }
                    window.location = 'http://'+window.location.hostname+'/menu.php';
                }
            });
          }
        });
    </script>
  </body>
</html>
l>
