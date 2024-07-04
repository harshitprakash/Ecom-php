<?php

session_start();

$con = mysqli_connect("localhost", "root", "", "ecom");

define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/php-project/');
define('SITE_PATH','http://localhost/php-project/');

define('PRODUCT_IMAGE_SERVER_PATH',SERVER_PATH.'media/product/');
define('PRODUCT_IMAGE_SITE_PATH',SITE_PATH.'media/product/');


define('HOME_BANNER_IMAGE_SERVER_PATH',SERVER_PATH.'media/Banner/');
define('HOME_BANNER_IMAGE_SITE_PATH',SITE_PATH.'media/Banner/');



?>
