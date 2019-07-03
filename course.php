<?php
	include('config.php');


	//to querry all course entry
	$all_courses = "SELECT Course_Code FROM courses ";
	$query_all = mysqli_query($con, $all_courses);
	$errormessage="";
	$description = false;


	//condition to handle view course submission
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (!empty($_POST["course"])) {
		$CourseCode = filter_var($_POST["course"], FILTER_SANITIZE_STRING);
		$select = "SELECT * FROM courses WHERE Course_Code = '$CourseCode' ";
		$dquery = mysqli_query($con,$select);

		if (mysqli_num_rows($dquery) > 0) {
			$description = true;
			$row2 = mysqli_fetch_assoc ($dquery);
		}

		else $errormessage = "Could not Find Course";


	}

}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Futminna Course Description</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>
		<link rel="apple-touch-icon" sizes="57x57" href="/img/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/img/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/img/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/img/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/img/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/img/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/img/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/img/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="/img/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/img/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
		<link rel="manifest" href="/img/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/img/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>

		<!-- Header -->
		<header id="header">
			<div class="container">

				<div class="navbar-header">
					<!-- Logo -->
					<div class="navbar-brand">
						<a class="logo" href="index.php">
							<img src="./img/logo.png" alt="logo">
						</a>
						<a class="logo blue-text" href="index.php">
								Computer Engineering
						</a>
					</div>
					<!-- /Logo -->

					<!-- Mobile toggle -->
					<button class="navbar-toggle">
						<span></span>
					</button>
					<!-- /Mobile toggle -->
				</div>

				<!-- Navigation -->
				<nav id="nav">
					<ul class="main-menu nav navbar-nav navbar-right">
						<li><a href="index.php">Home</a></li>
						<li><a href="course.php">View Course</a></li>
					</ul>
				</nav>
				<!-- /Navigation -->

			</div>
		</header>
		<!-- /Header -->

		<!-- Hero-area -->
		<div class="hero-area section">

			<!-- Backgound Image -->
			<div class="bg-image bg-parallax overlay" style="background-image:url(./img/page-background.jpg)"></div>
			<!-- /Backgound Image -->

			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 text-center">
						<ul class="hero-area-tree">
							<li><a href="index.html">Home</a></li>
							<li>Course Description</li>
						</ul>
						<h1 class="futminna">Discover Your Courses</h1>

					</div>
				</div>
			</div>

		</div>
		<!-- /Hero-area -->

		<!-- Contact -->
		<div id="contact" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<!-- contact form -->
					<div class="col-md-6">
						<div class="contact-form">
							<h4>Select the course Code</h4>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<select class="input" type="text" name="course">
									<option value="" class="input">--Please choose A Course--</option>
									<?php if (mysqli_num_rows($query_all) > 0) {
										while ($row = mysqli_fetch_assoc($query_all)) {
										 ?>
									<option value="<?php echo ($row["Course_Code"]); ?>"><?php echo ($row["Course_Code"]); ?></option><?php }
								}?>
								</select>
								<button class="main-button icon-button">View Description</button>
							</form>
						</div>
					</div>
					<!-- /contact form -->

					<!-- contact information -->
					<div class="col-md-5 col-md-offset-1">
						<h4>COURSE DESCRIPTION</h4><?php if ($description == false) {
							?><p style="color: black; font-weight: bold;">No Course Selected Yet!!<p><?php ;
						} else { ?>
						<p style="color: black; font-weight: bold;"><?php echo ("Course Code: ".$row2["Course_Code"]); ?></p>
						<p style="color: black; font-weight: bold;" ><?php echo ("Course Title: <p>".$row2["Course_Title"]. "</p>"); ?></p>
						<p style="color: black; font-weight: bold;" ><?php echo ("Course Description: <p>".$row2["Course_Description"]. "</p>"); ?></p>
					<?php }?>
						
						
						
						<!-- /course description here -->

					</div>
					<!-- contact information -->

				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

		</div>
		<!-- /Contact -->

		<!-- Footer -->
		<footer id="footer" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<!-- footer logo -->
					<div class="col-md-6">
						<div class="footer-logo">
							<a class="logo" href="index.html">
								<img src="./img/logo.png" alt="logo">
							</a>
							<a class="logo blue-text" href="index.html">
								Computer Engineering
							</a>
						</div>
					</div>
					<!-- footer logo -->

					<!-- footer nav -->
					<div class="col-md-6">
						<ul class="footer-nav">
						<li><a href="index.php">Home</a></li>
						<li><a href="course.php">View Course</a></li>
						</ul>
					</div>
					<!-- /footer nav -->

				</div>
				<!-- /row -->

				<!-- row -->
				<div id="bottom-footer" class="row">

					<!-- social -->
					<div class="col-md-4 col-md-push-8">
						<ul class="footer-social">
							<li><a href="https://www.facebook.com/wisdom.praise.3" class="facebook"><i class="fa fa-facebook"></i></a></li>
							<li><a href="https://www.twitter.com/@wisdompraise" class="twitter"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="https://www.github.com/wizzywit" class="github"><i class="fa fa-github"></i></a></li>
						</ul>
					</div>
					<!-- /social -->

					<!-- copyright -->
					<div class="col-md-8 col-md-pull-4">
						<div class="footer-copyright">
							<span>&copy; Copyright 2019. All Rights Reserved. | This website was made by CPE2K19 LEVEL GRP 4 <i class="fa fa-heart-o" aria-hidden="true"></i></span>
						</div>
					</div>
					<!-- /copyright -->

				</div>
				<!-- row -->

			</div>
			<!-- /container -->

		</footer>
		<!-- /Footer -->

		<!-- preloader -->
		<div id='preloader'><div class='preloader'></div></div>
		<!-- /preloader -->


		<!-- jQuery Plugins -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
		<script type="text/javascript" src="js/google-map.js"></script>
		<script type="text/javascript" src="js/main.js"></script>

	</body>
</html>
