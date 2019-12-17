<?php
  session_start();
  require('./config.php');
  if(isset($_POST['username'])){
    $sql = "SELECT * FROM member WHERE username = :username AND password = :password";
    $param = array(
          ':username' => $_POST['username'],
          ':password' => $_POST['password']
    );
  	$sth = $database->prepare($sql);
  	$sth->execute($param);
  	$account = $sth->fetch();
  	if(isset($account['id'])){
  	  $_SESSION['account'] = $account;
  	  $_SESSION['account']['discount'] = 5;
  	}else{
  	  $msgPassError = 'error';
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
    <div class="container" style="padding-top:3em;">
        <section class="hero">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h1 class="title">Smart Restaurant</h1>
                    <h2 class="subtitle">ร้านอาหารอัจฉริยะ</h2>
                </div>
            </div>
        </section>
        <form method="post">
          <div class="columns">
              <div class="column is-half is-offset-one-quarter">
                  <div class="field">
                    <label class="label">Username</label>
                    <p class="control">
                      <input class="input is-medium" type="text" placeholder="Username" name="username">
                    </p>
                  </div>
                  <div class="field">
                    <label class="label">Password</label>
                    <p class="control">
                      <input class="input is-medium" type="password" placeholder="Password" name="password">
                    </p>
                  </div>
                  <div class="field is-grouped columns">
                    <p class="column">
                      <button type="submit" class="button is-primary is-outlined is-medium is-fullwidth">Login</button>
                    </p>
                    <p class="column">
                      <a href="./" class="button is-info is-outlined is-medium is-fullwidth">Cancel</a>
                    </p>
                  </div>
                  <a href="./register.php" class="button is-primary is-medium is-fullwidth">สมัครสมาชิก</a>
              </div>
          </div>
        </form>
    </div>
    <?php if($msgPassError == 'error'){?>
      <script>
        alert('Password Invalid');
      </script>
    <?php }?>
    <?php if(isset($_SESSION['account'])){?>
      <script>
        window.location = 'http://'+window.location.hostname+'/table.php';
      </script>
    <?php }?>
  </body>
</html>
