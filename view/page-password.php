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
		<title>Smarty Admin</title>
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

				<!--
				<div class="alert alert-danger noradius">Email not found!</div>
				<div class="alert alert-success noradius">Email sent!</div>
				-->

				<!-- password form -->
				<form action="index.html" method="post" class="sky-form boxed ">
					<header><i class="fa fa-users"></i> Forgot Password</header>
					
					<fieldset>	
					
						<label class="label">E-mail</label>
						<label class="input">
							<i class="icon-append fa fa-envelope"></i>
							<input type="email">
							<span class="tooltip tooltip-top-right">Type your Email</span>
						</label>
						<a href="login">Back to Login</a>

					</fieldset>

					<footer>
						<button type="submit" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-refresh"></i> Reset Passsword</button>
					</footer>
				</form>
				<!-- /password form -->

				<div class="alert alert-default noradius">
					The reset link will be sent to your email address. Click the link and reset your account password.
				</div>


			</div>

		</div>


		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="<?php echo __SERVER_ROOT;    ?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo __SERVER_ROOT;    ?>assets/js/app.js"></script>
	</body>
</html>