<?php
// if(!isset($_SESSION['id'])){
// 	session_start();
// 	if(!isset($_SESSION['id'])){
// 		header("Location:login");
// 	}
// 	if($_SESSION['lock']){
// 		header("Location:lock");
// 	}
// }

?>
<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Home Automation</title>
		<meta name="description" content="" />
		<meta name="Author" content="Dorin Grigoras [www.stepofweb.com]" />

		<!-- mobile settings -->
		<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />

		<!-- WEB FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&amp;subset=latin,latin-ext,cyrillic,cyrillic-ext" rel="stylesheet" type="text/css" />

		<!-- CORE CSS -->
		<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<!-- THEME CSS -->
		<link href="assets/css/essentials.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/layout.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/color_scheme/green.css" rel="stylesheet" type="text/css" id="color_scheme" />
		<style type="text/css">
		#title:focus{
			border: 1px solid blue;
		}
		</style>
	</head>
	<!--
		.boxed = boxed version
	-->
	<body>


		<!-- WRAPPER -->
		<div id="wrapper" class="clearfix">

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
					<img src="assets/images/Home-AUTOMATION1.png" alt="admin panel" height="50" width="50" />
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
									<a href="lock?prev=dashboard"><i class="fa fa-lock"></i> Lock Screen</a>
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
					<h1>New Post</h1>
					<ol class="breadcrumb">
						<li><a href="#">Pages</a></li>
						<li class="active">New post</li>
					</ol>
				</header>
				<!-- /page title -->


				<div id="content" class="padding-20">

					<div class="panel panel-default">
						<div class="panel-body" style="background-color:inherit;">
						<div class="row">
							<div class="col-md-10">
								<h3>Add New Post</h3>
							</div>
						</div>
						<form action="postSubmit?public_token=123" method="post">
							<div class="row">
								<div class="col-md-10">
									<div class="row">
										<input type="text" id="title" name="title" class="form-control" placeholder="Enter title here" style="font-size:22px;color:black;" required="required">
									</div>
									<div class="row" style="background-color:#fff;">
										<textarea class="summernote html-edit form-control" data-height="600" data-lang="en-US"></textarea>
										<textarea name="body" id="body" style="display:none;"></textarea>
									</div>
								</div>
								<div class="col-md-2">
									
									<!-- Collapsible -->
									<div id="panel-misc-portlet-r1" class="panel panel-default">

										<div class="panel-heading">

											<span class="elipsis"><!-- panel title -->
												<strong>Publish</strong>
											</span>

											<!-- right options -->
											<ul class="options pull-right list-inline">
												<li><a href="#" class="opt panel_colapse" data-toggle="tooltip" title="Colapse" data-placement="bottom"></a></li>
											</ul>
											<!-- /right options -->

										</div>

										<!-- panel content -->
										<div class="panel-body">

											<h5>CATEGORIES</h5>
											<label for="master_cat">Master category</label>
											
											<div class="fancy-form fancy-form-select">
												<select class="form-control select2" name="master_cat" required="required">
													<option value="inner">School news</option>
													<option value="outer">General news</option>
												</select>

												<!--
													.fancy-arrow
													.fancy-arrow-double
												-->
												<i class="fancy-arrow"></i>
											</div>
											<br/>
											<label for="sub_cat">Sub category</label>
											
											<div class="fancy-form fancy-form-select">
												<select class="form-control select2" name="sub_cat" required="required">
													<option value="sport">Sport news</option>
													<option value="fashion">Fashion news</option>
												</select>

												<!--
													.fancy-arrow
													.fancy-arrow-double
												-->
												<i class="fancy-arrow"></i>
											</div>

										</div>
										<!-- /panel content -->
										
										<!-- panel footer -->
										<div class="panel-footer" style="background-color:#f5f5f5;">
											<div class="row">
												<div class="col-md-6">
													<button class="btn btn-danger btn-sm">TRASH</button>
												</div>
												<div class="col-md-6">
													<button class="btn btn-blue btn-sm" type="submit" onclick="$('#body').val($('.html-edit').code());">PUBLISH</button>
												</div>
											
											</div>
										</div>
										<!-- /panel footer -->

									</div>
									<!-- /Collapsible -->
									
							
								</div>
							</div>
							<br/>
                            <button class="btn" >alert</button>
						</form>
                            
						</div>
					</div>

				</div>
			</section>
			<!-- /MIDDLE -->

		</div>



	
		<!-- JAVASCRIPT FILES -->
		<script type="text/javascript">var plugin_path = 'assets/plugins/';</script>
		<script type="text/javascript" src="assets/plugins/jquery/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="assets/js/app.js"></script>


			
	</body>
</html>