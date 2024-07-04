<?php
require('admin/connection.inc.php');
require('admin/function.inc.php');

$success = "";
$error = "";

if(isset($_POST['submit'])){
	$username=get_safe_value($con,$_POST['name']);
	$email=get_safe_value($con,$_POST['email']);
	$password=get_safe_value($con,$_POST['password']);
	$c_password=get_safe_value($con,$_POST['confirm_password']);

	
	if(strlen($username)<3 ||strlen($username)>20){
		$error= "user name must be between 3 to 20 characters.";
	}
	elseif(!preg_match('/^[a-zA-Z0-9_]+$/',$username)){
        $error = "Username can only contain letters, numbers, and underscores.";
	}
	elseif(strlen($password)<6){
		$error= "password must be 6 character long.";
	}
	elseif($password !== $c_password){
		$error= "password do not match.";
	}
	else{
        // Check if email already exists
        $stmt = $con->prepare("SELECT * FROM admin_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already taken.";
        } 
		else{
				// Check if username already exists
				$stmt = $con->prepare("SELECT * FROM admin_users WHERE username = ?");
				$stmt->bind_param("s", $username);
				$stmt->execute();
				$stmt->store_result();

				if ($stmt->num_rows > 0)
				{
					$error = "Username already taken.";
				}
				 else{
					// Hash the password
					$hashed_password = password_hash($password, PASSWORD_DEFAULT);

					// Insert the user into the database
					$stmt = $con->prepare("INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)");
					$stmt->bind_param("sss", $username, $email, $hashed_password);
					if ($stmt->execute()) {
						header("Location: login.php?success=Registration%20successful,%20please%20Login");
						exit();
					} else {
						$error = "Error: " . $stmt->error;
					}
            	}
			}
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
						<div class="logo d-flex align-items__center" style="justify-content:center;">
							<a href="index.php"><img src="images/logo/4.png" alt="logo images"></a>
						</div>
					</div>
				<div class="col-md-12">
						<div class="contact-form-wrap mt--60">
							<div class="col-xs-12">
								<?php if($error != ""){?>
							<div class="alert alert-danger" role="alert">
								<h4 class="text-danger">
									<?php echo $error;?>
								</h4>
							</div>
							<?php }?>
								<div class="contact-title">
									<h2 class="title__line--6">Register</h2>
								</div>
							</div>
							<div class="col-xs-12">
								<form id="contact-form" action="#" method="post">
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="text" name="name" placeholder="Enter Name*" style="width:100%" required>
										</div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="email" name="email" placeholder="Enter Email*" style="width:100%" required>
										</div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="password" name="password" placeholder="Enter Password*" style="width:100%"required>
										</div>
									</div>
									<div class="single-contact-form">
										<div class="contact-box name">
											<input type="password" name="confirm_password" placeholder="Enter Confirm Password*" style="width:100%"required>
										</div>
									</div>
									<div class="form-output">
									<p class="form-messege"></p>
									</div>
									<div class="contact-btn">
										<button type="submit" name="submit" class="fv-btn">Register</button>
									</div>
                                    <div style="margin-top:20px">
                                        <h3>Already have an account <a href="login.php" class="text-danger">Login</a></h3>
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