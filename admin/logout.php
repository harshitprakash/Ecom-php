<?php
      require('connection.inc.php');
      
       unset($_SESSION['login']);
       unset($_SESSION['email']);
       unset($_SESSION['id']);
            header('location:../index.php');
            die();

?>