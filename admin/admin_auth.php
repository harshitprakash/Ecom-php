<?php

function auth(){
   global $admin_login;
    if(!empty($_SESSION['login']) && $_SESSION['user_type'] =='admin'){
         //admin
   }
   else{
      header('Location:../login.php');

   }
}
?>