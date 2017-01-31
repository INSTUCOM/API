<?php
if(!isset($_SESSION['id'])){
	session_start();
	if(!isset($_SESSION['id'])){
		header("Location:login");
	}
	if(isset($_GET['prev'])){
		$last_page = $_GET['prev'];
		$_SESSION['last_page'] = $last_page;
		$_SESSION['lock'] = true;
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
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<!-- THEME CSS -->
		<link href="<?php echo __SERVER_ROOT;    ?>assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo __SERVER_ROOT;    ?>assets/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo __SERVER_ROOT;    ?>assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />

	</head>
	<!--
		.boxed = boxed version
	-->
	<body>


		<div class="lockscreen">
			<div class="inner">

				<form method="post" action="unlockController">

					<div class="lock-container clearfix margin-top-10">
					<?php
					if(isset($_GET['text'])){
						$text = $_GET['text'];
						if($text == "incorrect"){
						print <<<HERE
						<div class="alert alert-danger noborder text-center weight-400 nomargin noradius">
						Incorrect Password!
					</div>
HERE;
						}
					}
					?>

						<!-- avatar - remove if not needed . Recommended: 120x120px -->
						<!--<img class="avatar" src="assets/images/demo/thumb/9.jpg" width="120" alt="avatar" /> -->

						<span class="pull-right note"><i class="fa fa-lock"></i> Locked</span>
						<h1><?php echo $_SESSION['last_name']." ".$_SESSION['first_name'];  ?></h1>
						<a href="mailto:<?php echo $_SESSION['email']; ?>"><?php echo $_SESSION['email']; ?></a>

						<div class="input-group margin-top-10 margin-bottom6">
							<input class="form-control" type="password" placeholder="Password" name="password" />
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit"><i class="fa fa-sign-in"></i></button>
							</div>
						</div>

						<p class="note nomargin">
							Not <?php echo $_SESSION['last_name']." ".$_SESSION['first_name'];  ?>? <a href="logoutController">Click Here</a>
						</p>

					</div>

					<p class="clearfix size-12 margin-top3">
						Deewai inc &copy; 2016
					</p>

				</form>

			</div>
		</div>


		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="<?php echo __SERVER_ROOT;    ?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo __SERVER_ROOT;    ?>assets/js/app.js"></script>
	</body>
</html>