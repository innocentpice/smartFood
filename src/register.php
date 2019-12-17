<?php
require('./config.php');
if(isset($_POST['username']) && isset($_POST['password'])){
  $sql = "INSERT INTO member (id, name, tel, email, address, username, password) VALUES (NULL, :name, :tel, :email, :address, :username, :password)";
  $param = array(
    ':name' => $_POST['name'],
    ':tel' => $_POST['tel'],
    ':email' => $_POST['email'],
    ':address' => $_POST['address'],
    ':username' => $_POST['username'],
    ':password' => $_POST['password']
  );
  $sth = $database->prepare($sql);
  $sth->execute($param);
  $result = $sth->fetch();
  if($sth->errorCode() == 'HY000'){
    $sql = "SELECT * FROM member WHERE username = :username AND password = :password";
    $param = array(
          ':username' => $_POST['username'],
          ':password' => $_POST['password']
    );
  	$sth = $database->prepare($sql);
  	$sth->execute($param);
  	$account = $sth->fetch();
  	if(isset($account['id'])){
  	  session_start();
  	  $_SESSION['account'] = $account;
  	  $_SESSION['account']['discount'] = 5;
  	}
  }
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
    <div class="container" style="padding-top:0em;">
        <section class="hero">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h1 class="title">Smart Restaurant</h1>
                    <h2 class="subtitle">สมัครสมาชิก</h2>
                </div>
            </div>
        </section>
        <form method="post" id="register">
        <div class="field is-horizontal">
          <div class="field-label is-medium">
            <label class="label">Name - Surname</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <input required class="input is-medium" type="text" placeholder="Name - Surname" name="name">
              </div>
            </div>
          </div>
        </div>
        
        <div class="field is-horizontal">
          <div class="field-label is-medium">
            <label class="label">Tel</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <input required class="input is-medium" type="number" placeholder="Tel" name="tel">
              </div>
            </div>
          </div>
        </div>
        
        <div class="field is-horizontal">
          <div class="field-label is-medium">
            <label class="label">E-mail</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <input required class="input is-medium" type="tesx" placeholder="E-mail" name="email">
              </div>
            </div>
          </div>
        </div>
        
        <div class="field is-horizontal">
          <div class="field-label is-medium">
            <label class="label">Address</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <textarea class="textarea is-medium" placeholder="Address" name="address"></textarea>
              </div>
            </div>
          </div>
        </div>
        
        <div class="field is-horizontal">
          <div class="field-label is-medium">
            <label class="label">Username</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <input required class="input is-medium" type="text" placeholder="Username" name="username">
              </div>
            </div>
          </div>
        </div>
        
        <div class="field is-horizontal">
          <div class="field-label is-medium">
            <label class="label">Password</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <input required class="input is-medium" type="password" placeholder="Password" name="password">
              </div>
            </div>
          </div>
        </div>
        
        <div class="field is-horizontal">
          <div class="field-label is-medium">
            <label class="label">Confirm</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <input required class="input is-medium" type="password" placeholder="Confirm Password" name="confirm">
              </div>
            </div>
          </div>
        </div>
        
        <div class="column is-half is-offset-one-quarter">
          <button type="submit" class="button is-primary is-medium is-fullwidth">สมัครสมาชิก</butto>
        </div>
        </form>
        <?php if(isset($_SESSION['account'])){?>
          <script>
            alert('สมัครสมาชิกเรียบร้อย');
            window.location = 'http://'+window.location.hostname+'/login.php';
          </script>
        <?php }?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
      $(document).ready(()=>{
        $('#register').submit((e)=>{
          var password = $('input[name="password"]').val();
          var confirm = $('input[name="confirm"]').val();
          if(password != confirm){
            alert('กรุณากรอก Password ให้ตรงกัน');
            $('input[name="password"]').focus();
            e.preventDefault();
          }
        });
      });
    </script>
  </body>
</html>
