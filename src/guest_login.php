<?php 
    session_start();
    if(isset($_GET['name'])){
        $account = array(
            'guest' => true,
            'username' => 'Guest['.$_GET['name'].']',
            'name' => 'Guest['.$_GET['name'].']',
            'discount' => 0
        );
        $_SESSION['account'] = $account;
        echo $_SESSION['account']['name'];
    }else{
        echo 'error';
    }