<?php


function auth(){
    global $admin_login;
     if(!empty($_SESSION['login']) && $_SESSION['user_type'] =='user'){
        $admin_login=$_SESSION['login'];
     }
}
?>