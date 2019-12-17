<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
<body>
<?php
    session_start();
    session_unset();
?>
    <script>
        window.location = 'http://'+window.location.hostname+'/';
    </script>
</body>
</html>



