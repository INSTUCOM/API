<?php
if(!isset($_SESSION['id'])){
	session_start();
	if(isset($_SESSION['id'])){
		header("Location:dashboard");
	}
}

?>
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Home Automation</title>
		<meta name="description" content="" />
		<meta name="Author" content="Deewai Inc." />

		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />

		<!-- WEB FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

		<!-- CORE CSS -->
		<link href="<?php echo __SERVER_ROOT;    ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<!-- THEME CSS -->
		<link href="<?php echo __SERVER_ROOT;    ?>assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo __SERVER_ROOT;    ?>assets/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo __SERVER_ROOT;    ?>assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />

	</head>
	<!--
		.boxed = boxed version
	-->
	<body>


		<div class="padding-15">

			<div class="login-box">

				<!-- login form -->
				<form action="signinController" method="post" class="sky-form boxed">
					<header><i class="fa fa-users"></i> Sign In</header>
					<?php
					if(isset($_GET['text'])){
						$text = $_GET['text'];
						if($text == "incorrect"){
						print <<<HERE
						<div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
						Invalid Email or Password!
					</div>
HERE;
						}
						else if($text == "inactive"){
							print <<<HERE
							<div class="alert alert-warning noborder text-center weight-400 nomargin noradius">
						Account Inactive!
					</div>
HERE;
						}
						else if($text == "empty"){
							print <<<HERE
							<div class="alert alert-warning noborder text-center weight-400 nomargin noradius">
						Please fill all fields!
					</div>
HERE;
						}
						else if($text == "registered"){
							print <<<HERE
							<div class="alert alert-success noborder text-center weight-400 nomargin noradius">
						You have successfully registered. Please login!
					</div>
HERE;
						}
						else{
							print <<<HERE
						<div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
						An Error occured!
					</div>
HERE;
						}
					}
					?>

					<!--
					<div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
						Invalid Email or Password!
					</div>

					<div class="alert alert-warning noborder text-center weight-400 nomargin noradius">
						Account Inactive!
					</div>

					<div class="alert alert-default noborder text-center weight-400 nomargin noradius">
						<strong>Too many failures!</strong> <br />
						Please wait: <span class="inlineCountdown" data-seconds="180"></span>
					</div>
					-->

					<fieldset>	
					
						<section>
							<label class="label">E-mail</label>
							<label class="input">
								<i class="icon-append fa fa-envelope"></i>
								<input type="email" name="email">
								<span class="tooltip tooltip-top-right">Email Address</span>
							</label>
						</section>
						
						<section>
							<label class="label">Password</label>
							<label class="input">
								<i class="icon-append fa fa-lock"></i>
								<input type="password" name="password">
								<b class="tooltip tooltip-top-right">Type your Password</b>
							</label>
							<label class="checkbox"><input type="checkbox" name="checkbox-inline" checked><i></i>Keep me logged in</label>
						</section>

					</fieldset>

					<footer>
						<button type="submit" class="btn btn-primary pull-right">Sign In</button>
						<div class="forgot-password pull-left">
							<a href="password">Forgot password?</a> <br />
							<a href="register"><b>Need to Register?</b></a>
						</div>
					</footer>
				</form>
				<!-- /login form -->

				

			</div>

		</div>

		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="<?php echo __SERVER_ROOT;    ?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo __SERVER_ROOT;    ?>assets/js/app.js"></script>
	</body>
</html>