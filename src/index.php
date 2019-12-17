<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>SmartRestaurant</title>
      <!--Import Google Icon Font-->
      <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!-- Compiled and minified CSS -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
      <style>
        body {
          background-image: url('/public/img/bg03.jpg');
          background-size: auto;
          background-repeat: no-repeat;
        }
      </style>
    </head>

    <body>
      <nav>
        <div class="nav-wrapper">
          <a href="#" class="brand-logo center">Smart Restaurant</a>
        </div>
      </nav>
      <div class="row" style="padding-top:3em;">
        <div class="col s12 m6">
          <div class="row">
            <div class="col s10 offset-s1">
              <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                  <span class="card-title center-align">
                    สำหรับลูกค้าทั่วไป
                  </span>
                  <p class="center-align">
                    ลูกค้าทั่วไปจะไม่ได้รับสิทธิในการให้ส่วนลดค่าอาหาร
                  </p>
                </div>
                <div class="card-action center-align">
                  <a href="./table.php" class="waves-effect waves-teal btn-flat btn white-text" style="margin-top:1em;">
                    เลือกรายการอาหาร
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col s12 m6">
          <div class="row">
            <div class="col s10 offset-s1">
              <div class="card blue-grey darken-1">
                <div class="card-content white-text">
                  <span class="card-title center-align">
                    สำหรับลูกค้าที่เป็นสมาชิก
                  </span>
                  <p class="center-align">
                    ลูกค้าที่เป็นสมาชิกจะได้รับสิทธิในการรับส่วนลดค่าอาหาร
                  </p>
                </div>
                <div class="card-action row">
                  <div class="col s12 m6 center-align" style="margin-top:1em;">
                    <a href="./register.php" class="waves-effect waves-light btn">
                      สมัครสมาชิก
                    </a>
                  </div>
                  <div class="col s12 m6 center-align" style="margin-top:1em;">
                    <a href="./login.php" class="waves-effect waves-teal btn-flat btn white-text">
                      เข้าสู่ระบบ
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <!-- Compiled and minified JavaScript -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    </body>
  </html>