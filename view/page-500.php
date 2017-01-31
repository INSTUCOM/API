<?php
if(!isset($_SESSION['id'])){
	session_start();
	if(!isset($_SESSION['id'])){
		header("Location:login");
	}
	if($_SESSION['lock']){
		header("Location:lock");
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


		<!-- WRAPPER -->
		<div id="wrapper">

			<!-- 
				ASIDE 
				Keep it outside of #wrapper (responsive purpose)
			-->
			<aside id="aside">
				<!--
					Always open:
					<li class="active alays-open">

					LABELS:
						<span class="label label-danger pull-right">1</span>
						<span class="label label-default pull-right">1</span>
						<span class="label label-warning pull-right">1</span>
						<span class="label label-success pull-right">1</span>
						<span class="label label-info pull-right">1</span>
				-->
				<nav id="sideNav"><!-- MAIN MENU -->
					<ul class="nav nav-list">
						<li>
							<a href="controls">
								<i class="main-icon fa fa-gears"></i> <span>Controls</span>
							</a>
						</li>
						<li>
							<a href="add-device">
								<i class="main-icon fa fa-book"></i> <span>Add Device</span>
							</a>
						</li>
					</ul>
				</nav>

				<span id="asidebg"><!-- aside fixed background --></span>
			</aside>
			<!-- /ASIDE -->


			<!-- HEADER -->
			<header id="header">

				<!-- Mobile Button -->
				<button id="mobileMenuBtn"></button>

				<!-- Logo -->
				<span class="logo pull-left">
					<!--  <img src="assets/images/logo_light.png" alt="admin panel" height="35" />  -->
					<div style="color:white;font-size:15px;font-weight:bold;">HOME AUTOMATION</div>
				</span>

				<form method="get" action="page-search.html" class="search pull-left hidden-xs">
					<input type="text" class="form-control" name="k" placeholder="Search for something..." />
				</form>

				<nav>

					<!-- OPTIONS LIST -->
					<ul class="nav pull-right">

						<!-- USER OPTIONS -->
						<li class="dropdown pull-left">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
								<img class="user-avatar" alt="" src="assets/images/noavatar.jpg" height="34" /> 
								<span class="user-name">
									<span class="hidden-xs">
										<?php echo $_SESSION['last_name'];  ?> <i class="fa fa-angle-down"></i>
									</span>
								</span>
							</a>
							<ul class="dropdown-menu hold-on-click">
								<li><!-- settings -->
									<a href="page-user-profile.html"><i class="fa fa-cogs"></i> Settings</a>
								</li>

								<li class="divider"></li>

								<li><!-- lockscreen -->
									<a href="lock?prev=500"><i class="fa fa-lock"></i> Lock Screen</a>
								</li>
								<li><!-- logout -->
									<a href="logoutController"><i class="fa fa-power-off"></i> Log Out</a>
								</li>
							</ul>
						</li>
						<!-- /USER OPTIONS -->

					</ul>
					<!-- /OPTIONS LIST -->

				</nav>

			</header>
			<!-- /HEADER -->


			<!-- 
				MIDDLE 
			-->
			<section id="middle">


				<!-- page title -->
				<header id="page-header">
					<h1>Error 500</h1>
				</header>
				<!-- /page title -->


				<div id="content" class="padding-20">

					<div class="panel panel-default">
						<div class="panel-body">

							<p class="lead">
								<span class="e404">500</span>
								<strong>Oops!</strong> Something went wrong.<br />
								We are fixing it! Please come back in a while.
							</p>

						</div>
					</div>

				</div>
			</section>
			<!-- /MIDDLE -->

		</div>



	
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="<?php echo __SERVER_ROOT;    ?>assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo __SERVER_ROOT;    ?>assets/js/app.js"></script>

	</body>
</html>