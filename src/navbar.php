<?php
  @session_start();
  if(empty($_SESSION['account'])){
    return false;
    echo 'plz Login';
    exit();
  }
  require('./config.php');
  $sql = "SELECT COUNT(id) FROM order_recript WHERE status >= 1 AND username = '".$_SESSION['account']['username']."' AND r_id = '".$_SESSION['rOder']."'";
	$sth = $database->prepare($sql);
	$sth->execute();
	$Listnum = $sth->fetch();
?>
<?php /*
<nav class="nav has-shadow">
    <div class="container">
        <div class="nav-left nav-menu">
          <a class="nav-item">
            <a class="nav-item is-tab is-hidden-mobile">Smart Reataurant</a>
          </a>
          <a href="./menu.php" class="nav-item is-tab is-hidden-mobile">อาหาร</a>
          <a href="./menu.php?category=sweet" class="nav-item is-tab is-hidden-mobile">ของหวาน</a>
          <a href="./menu.php?category=drink" class="nav-item is-tab is-hidden-mobile">เครื่องดื่ม</a>
        </div>
        <div class="nav-center nav-menu">
          <a class="nav-item">
            <a href="./order.php" class="nav-item is-tab is-hidden-mobile">
              รายการที่สั่งซื้อ
              <span style="background:yellow;border-radius:20px;width:25px;height:25px;margin-left:3px;display:inline-block"><small id="list_number"><?=$Listnum[0]?></small></span>
            </a>
          </a>
        </div>
        <span class="nav-toggle" for="nav-toggle-state">
          <span></span>
          <span></span>
          <span></span>
        </span>
        <input type="checkbox" id="nav-toggle-state" />
        <div class="nav-right nav-menu">
          <span class="nav-item">
            <span id="nav_username"><?=$_SESSION['account']['name']?></span>
            <?php if(isset($_SESSION['tableNum'])){
              echo '(โต๊ะ '.$_SESSION['tableNum'].')';
            }else{
              echo '(ยังไม่จองโต๊ะ)';
            }?>
          </span>
        </div>
    </div>
</nav>

*/?>

<nav class="nav has-shadow">
  <div class="container">
    <a class="nav-item is-brand is-hidden-mobile">Smart Reataurant</a>
    
    <!-- Using a <label /> here -->
    <label class="nav-toggle" for="nav-toggle-state">
      <span></span>           <!-- ^^^^^^^^^^^^^^^^ -->
      <span></span>
      <span></span>
    </label>
    
    <!-- This checkbox is hidden -->
    <input type="checkbox" id="nav-toggle-state" style="display: none;"/>
    
    <div class="nav-left nav-menu is-hidden-mobile">
      <a href="./menu.php" class="nav-item is-tab">อาหาร</a>
      <a href="./menu.php?category=sweet" class="nav-item is-tab">ของหวาน</a>
      <a href="./menu.php?category=drink" class="nav-item is-tab">เครื่องดื่ม</a>
    </div>
    
    <div class="nav-right nav-menu">
      <a href="./menu.php" class="nav-item is-tab">อาหาร</a>
      <a href="./menu.php?category=sweet" class="nav-item is-tab">ของหวาน</a>
      <a href="./menu.php?category=drink" class="nav-item is-tab">เครื่องดื่ม</a>
    </div>
    <a class="nav-item">
      <a href="./order.php" class="nav-item is-tab">
        รายการที่สั่งซื้อ
        <span style="background:yellow;border-radius:20px;width:25px;height:25px;margin-left:3px;display:inline-block"><small id="list_number"><?=$Listnum[0]?></small></span>
      </a>
    </a>
    <span class="nav-item is-hidden-mobile">
        <span id="nav_username"><?=$_SESSION['account']['name']?></span>
        <?php if(isset($_SESSION['tableNum'])){
          echo '(โต๊ะ '.$_SESSION['tableNum'].')';
        }else{
          echo '(ยังไม่จองโต๊ะ)';
        }?>
    </span>
    
  </div>
</nav>