<?php
    require('admin/connection.inc.php');
    require('admin/function.inc.php');
    $msg='';
    $error="";
    $success="";

    if(isset($_POST['submit']))
    {
       $email=get_safe_value($con,$_POST['email']);
       $password=get_safe_value($con,$_POST['password']);

       $sql= "SELECT * from admin_users where email='$email'";
       $req= mysqli_query($con,$sql);
       $count= mysqli_num_rows($req);
       if($count>0)
       {
        $row = mysqli_fetch_assoc($req);
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            
            $user_type=$row['role'];
            $user_id=$row['id'];

            $_SESSION['login']='yes';
            $_SESSION['email']=$email;
            $_SESSION['id']=$user_id;
            $_SESSION['user_type'] = $user_type;
            if($user_type == 'user') {
                header('Location:index.php'); // Redirect to admin dashboard
           } 
           if($user_type == 'admin'){
            // header('Location:admin/categories.php');
            echo '<script>window.location.href = "admin/categories.php";</script>';

            }
        }
        else{
            $error="Please enter correct login details";
        }

       }
       else
       {
            $error="Please enter correct login details";
       }
       
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

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


    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
</head>
<body>
	 <section class="htc__contact__area ptb--100 bg__white">
            <div class="container">
                <div class="row">
					<div class="col-md-12">
						<div class="logo" style="justify-content:center;">
							<a href="index.php"><img src="images/logo/4.png" alt="logo images"></a>
						</div>
					</div>
					<div class="col-md-12">
						<div class="contact-form-wrap mt--60">
							<div class="col-xs-12">
                    <?php
                        if (isset($_GET['success'])) {
                            $success_message = $_GET['success'];
                            echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($success_message) . '</div>';
                        }
                        if (isset($_GET['error'])) {
                            $error_message = $_GET['error'];
                            echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($error_message) . '</div>';
                        }
                        if (!empty($error)){?>
                                <div class="alert alert-danger" role="alert">
                                    <h4 class="text-danger">
                                        <?php echo $error; ?>
                                    </h4>
                                </div>
                                <?php } ?>

								<div class="contact-title">
									<h2 class="title__line--6">Login</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="" method="post">
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="text" name="email" placeholder="Your email*" style="width:100%" required>
										</div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
										<input type="password" name="password" placeholder="Your password*" style="width:100%" required >
										</div>
									</div>
									<div class="form-output" style="margin-top:10px;margin-bottom:-40px;">
										<h3 class="text-danger mt-4"><?php echo $msg?></h3> <br>
									</div>
									<div class="contact-btn">
										<button type="submit" name="submit" class="fv-btn">Login</button>
									</div>
									<div style="margin-top:20px">
                                        <h3>Don't have an account? <a href="register.php" class="text-danger">Register here</a></h3>
                                    </div>
								</form>
								
								
							</div>
						</div> 
                
					</div>
				

					
					
            </div>
        </section>
         

    <!-- jquery latest version -->
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!-- Waypoints.min.js. -->
    <script src="js/waypoints.min.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>
</body>
</html>