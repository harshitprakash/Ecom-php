<?php
require('admin/connection.inc.php');
require('function.php');
require('admin/function.inc.php');
require('user_auth.php');

auth();

$cat_res=mysqli_query($con,"SELECT * from categories where status=1 order by categories asc");
$cat_arr=array();
while($row=mysqli_fetch_assoc($cat_res)){
   $cat_arr[]=$row;
}
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $sql = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = $id";
    $result = mysqli_query($con, $sql);
    $res= mysqli_fetch_assoc($result);
}

?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Asbab - eCommerce HTML5 Templatee</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    

    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Owl Carousel min css -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/my_css.css">


    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>


    
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>

<body>
<header id="htc__header" class="htc__header__area header--one">
            <!-- Start Mainmenu Area -->
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href="index.html"><img src="images/logo/4.png" alt="logo images"></a>
                                </div>
                            </div>
                            <div class="col-md-7 col-lg-8 col-sm-5 col-xs-3">
                                <nav class="main__menu__nav hidden-xs hidden-sm">
                                    <ul class="main__menu">
                                        <li class="drop"><a href="index.php">Home</a></li>
                                        <li class="drop"><a href="#">Category</a>
                                            <ul class="dropdown">
                                             <?php foreach($cat_arr as $cat){ ?>
                                                <li><a href="categories.php?id=<?php echo $cat['id']?>"><?php echo $cat['categories']?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <li><a href="contact-us.php">contact</a></li>
                                        <li class="drop"><a href="my_order.php">my orders</a></li>                                       

                                    </ul>
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm">
                                    <nav id="mobile_dropdown">
                                        <ul>
                                            <li class="drop"><a href="index.html">Home</a></li>
                                            <li class="drop"><a href="#">Category</a>
                                                <ul class="dropdown">
                                                    <?php foreach($cat_arr as $cat){ ?>
                                                        <li><a href="categories.php?id=<?php echo $cat['id']?>"><?php echo $cat['categories']?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <li><a href="contact.php">contact</a></li>
                                            <li class="drop"><a href="my_order.php">my orders</a></li>                                       

                                        </ul>
                                    </nav>
                                </div>  
                            </div>
                            <div class="col-md-3 col-lg-2 col-sm-4 col-xs-4">
                                <div class="header__right">
                                    
                                    
                                    <?php if(!empty($admin_login)){?>
                                            <div class="header__account">
                                                <a href="login.php">Profile</a>
                                            </div>
                                            <div class="header__account">
                                                <a href="admin/logout.php">logout</a>
                                            </div>
                                    <?php }
                                    else{?>
                                    <div class="header__account">
                                        <a href="login.php">Login/Register</a>
                                    </div>
                                    <?php }?>
                                    <div class="htc__shopping__cart">
                                        <?php if(isset($_SESSION['id'])){?>
                                        <a href="cart.php"><i class="icon-handbag icons"></i></a>
                                        <a href="#"><span class="htc__qua"><?php echo $res['cart_count'];?></span></a>
                                   <?php }else{?>
                                        <a href="cart.php"><i class="icon-handbag icons"></i></a>
                                        <a href="#"><span class="htc__qua">0</span></a>
                                    <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>