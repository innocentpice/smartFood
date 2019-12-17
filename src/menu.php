<?php
  session_start();
  require('./config.php');
  
  if(empty($_SESSION['account'])){
    return false;
    echo 'plz Login';
    exit();
  }
  
  // Food Menu
  if($_GET['category'] == 'sweet'){ 
    $sql = "SELECT * FROM food WHERE category = 'sweet'";
  } else if($_GET['category'] == 'drink'){ 
    $sql = "SELECT * FROM food WHERE category = 'drink'";
  } else {
    $sql = "SELECT * FROM food WHERE category = 'maincourse'";
  }
	$sth = $database->prepare($sql);
	$sth->execute();
	$foodMenu = $sth->fetchAll();
	
	// Receipt Order
	$sql = "SELECT *  FROM  `receipt` WHERE username = '".$_SESSION['account']['username']."' AND status = 0 AND tableNum = '".$_SESSION['tableNum']."'";
	$sth = $database->prepare($sql);
	$sth->execute();
	$rOder = $sth->fetch();
	
	if(empty($rOder[0])){
	  $sql = "INSERT INTO `smartrj`.`receipt` (`id`, `username`, `tableNum`, `sumary`, `status`, `STTIME`, `discount`) VALUES (NULL, '".$_SESSION['account']['username']."', '".$_SESSION['tableNum']."', '0', '0', CURRENT_TIMESTAMP, '".$_SESSION['account']['discount']."')";
  	$sth = $database->prepare($sql);
  	$sth->execute();
  	$sth->fetch();
  	$sql = "SELECT *  FROM  `receipt` WHERE username = '".$_SESSION['account']['username']."' AND status = 0 AND tableNum = '".$_SESSION['tableNum']."'";
  	$sth = $database->prepare($sql);
  	$sth->execute();
  	$rOder = $sth->fetch();
  	$_SESSION['rOder'] = $rOder['id'];
	}
	
	// Choose Menu
  $sql = "SELECT order_recript.*, food.title FROM order_recript INNER JOIN food ON order_recript.foodID = food.id WHERE username =  '".$_SESSION['account']['username']."' AND STATUS = 0 AND r_id = '".$rOder['id']."'";
	$sth = $database->prepare($sql);
	$sth->execute();
	$chooseMenu = $sth->fetchAll();
	
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
    <div class="container is-fluid">
        <div class="columns">
          <div class="column is-one-quarter" style="padding-top:2em;">
            <nav class="panel">
              <p class="panel-heading">
                รายการอาหารที่สั่ง
              </p>
              
              <div id="taskmenu_list">
                <?php $i=0;foreach($chooseMenu as $CList){$i++;?>
                <p id="chooseList<?=$CList['id']?>" class="panel-block">
                  <span style="padding-right:1em">
                    <?=$i?>. <?=$CList['title']?> ( <?=$CList['foodNum']?> )
                  </span>
                  <button onClick="delChoose(<?=$CList['id']?>);" class="button is-danger is-small">
                    ยกเลิก
                  </button>
                </p>
                <?php }?>
              </div>
              
              <div class="panel-block">
                <a href="./order.php?confirmMenu=true" onClick="return confirm('ยืนยัน ?');" class="button is-info is-outlined is-fullwidth">
                  ยืนยันการสั่งอาหาร
                </a>
              </div>
            </nav>
          </div>
          <div class="column" style="padding-top:2em;">
            <h1 class="title has-text-centered">Smart Restaurant</h1>
            <h2 class="subtitle has-text-centered">รายการเมนูอาหาร</h2>
            <div class="columns">
              <div class="column is-10 is-offset-1">
                <?php $a=0;foreach($foodMenu as $food){$a++;
                  if($a==1){ echo '<div class="columns">'; }
                ?>
                  <div class="column is-one-third">
                      <div class="card">
                        <div class="card-image">
                          <figure class="image is-4by3">
                            <img src="./public/img<?=$food['img']?>" alt="Image">
                          </figure>
                        </div>
                        <div class="card-content">
                          <div class="media">
                            <div class="media-conten">
                              <p class="title is-4">
                                <?=$food['title']?>
                              </p>
                              <p class="subtitle is-6">
                                <?=$food['category']?>
                              </p>
                            </div>
                          </div>
                          <div class="content">
                            <small>ราคา:&nbsp;
                              <stong><?=$food['price']?></stong>
                              &nbsp;บาท
                            </small>
                            <div class="field has-addons" style="margin-top:1em;">
                              <p class="control">
                                <input id="food<?=$food['id']?>" class="input" type="number" placeholder="จำนวน" value="1">
                              </p>
                              <p class="control">
                                <button onclick="addChoose(<?=$food['id']?>,<?=$food['price']?>);" class="button is-info">
                                  เพิ่มรายการอาหาร
                                </button>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                <?php 
                  if($a==3){ echo '</div>';$a=0;}
                }
                $a=NULL;
                ?>
              </div>
            </div>
          </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      function addChoose(id,price){
        var foodNum = Number($('#food'+id).val());
        var url = './add_choose.php?fid=' + id + '&fnum=' + foodNum + '&fprice=' + price;
          $.ajax({
            url: url,
            context: document.body
          }).done(function(res) {
            window.location = 'http://'+window.location.hostname+'/menu.php?category=<?=$_GET['category']?>';
          });
        console.log(id,foodNum,price);
      }
      function delChoose(id){
        if(confirm('ต้องการลบ ?') == 1){
          var url = './del_choose.php?id=' + id;
          $.ajax({
            url: url,
            context: document.body
          }).done(function(res) {
            if(res == 'success'){
              var target = '#chooseList'+id;
              $(target).remove();
            }
          });
        }
      }
    </script>
  </body>
</html>