<?php
	include('config.php');

	//querry to display all the saved course codes
	$courses_available = false;
	$all_courses = "SELECT Course_Code FROM courses ";
	$query_all = mysqli_query($con, $all_courses);

	

	//TODO: update the add course condition to avoid adding duplicate entry to database 

	$added = false;
	$deleted = false;
	$updated = false;
	$errormessage="";

	//if condition to handle addition of courses
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (!empty($_POST["course"]) && !empty($_POST["level"]) && !empty($_POST["description"]) && !empty($_POST["course_title"])) {
		$CourseCod = filter_var($_POST["course"], FILTER_SANITIZE_STRING);
		$CourseCod1 = strtoupper($CourseCod);
		$CourseCode = preg_replace('/\s+/', '', $CourseCod1);
		$Level = filter_var($_POST["level"], FILTER_SANITIZE_NUMBER_INT);
		$Description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
		$course_title = filter_var($_POST["course_title"], FILTER_SANITIZE_STRING);

		$select = "SELECT * FROM courses WHERE Course_Code = '$CourseCode' AND Level= '$Level' ";
		$dquery = mysqli_query($con,$select);

		//checks to see if course doesnt exist
		if (mysqli_num_rows($dquery) <= 0) {
			$add = "INSERT INTO courses (Course_Code, Level, Course_Description, Course_Title) VALUES ('$CourseCode', '$Level', '$Description', '$course_title')";
			$query = mysqli_query($con, $add);
				if ($query) {
				$added = true;
				$adderror_message = "";
			}
				else {
				echo "not successful";
				$added = false;
				$adderror_message = "";
			}
			
		}


		//DISPLAYS MESSAGE IN RED IF COURSE ALREADY EXISTS
		else {
			$adderror_message = "Course already Exists.. Try Updating the course instead";
		}

	}

	//if condition to handle the delete submittion
	if (!empty($_POST["del_course"]) && !empty($_POST["del_level"])) {
		$DelCourse = filter_var($_POST["del_course"], FILTER_SANITIZE_STRING);
		$DelLevel = filter_var($_POST["del_level"], FILTER_SANITIZE_NUMBER_INT);


		$select = "SELECT * FROM courses WHERE Course_Code = '$DelCourse' AND Level= '$DelLevel' ";
		$dquery = mysqli_query($con,$select);


		if($dquery) {
			if (mysqli_num_rows($dquery) > 0) {
			$row = mysqli_fetch_assoc ($dquery);
			$id = $row["id"];
			$delete = "DELETE FROM courses WHERE id = '$id' ";

			$dquerry = mysqli_query($con, $delete);
			if ($dquerry) {
					$deleted = true;
				}

			else {
				
				$deleted = false;
				$errormessage = "Unable to delete";
				}

			}
			else {
							
					$deleted = false;
					$errormessage = "Unable to delete";
				}

		}

	else {
							
			$deleted = false;
			$errormessage = "Unable to delete";
		}

	}

	//if condition to handle the update of courses
	if (!empty($_POST["update_course"]) && !empty($_POST["update_level"]) && !empty($_POST["updated_course"]) && !empty($_POST["updated_level"]) && !empty($_POST["updated_description"])) { 

		//old course entry
		$update_course = filter_var($_POST["update_course"], FILTER_SANITIZE_STRING);
		$update_level = filter_var($_POST["update_level"], FILTER_SANITIZE_NUMBER_INT);

		//new course entry
		$updated_course = filter_var($_POST["updated_course"], FILTER_SANITIZE_STRING);
		$updated_level = filter_var($_POST["updated_level"], FILTER_SANITIZE_NUMBER_INT);
		$updated_description = filter_var($_POST["updated_description"], FILTER_SANITIZE_STRING);
		$updated_course_title = filter_var($_POST["updated_description"], FILTER_SANITIZE_STRING);

		$Update = "UPDATE courses SET Course_Code='$updated_course', Level='$updated_level', Course_Description='$updated_description', Course_Title='$updated_course_title' WHERE Course_Code='$update_course' AND Level='$update_level'";

		$querry = mysqli_query($con, $Update);
		if ($querry) {
			$updated = true;
		}

		else {
			echo "not successful";
			$updated = false;
	}


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
							<li>Admin Handle</li>
						</ul>
						<h1 class="futminna">Manage Courses</h1>

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
							<h4>Add Courses</h4>
							<p style="color: green;"><?php if ($added == true) { echo "Successfully added new course";?></p>
							<?php } elseif(!empty($adderror_message)) { ?><p style="color: red"><?php echo $adderror_message;  }?></p>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<input class="input" type="text" name="course" placeholder="Course Code" required="true">
								<input class="input" type="text" name="course_title" placeholder="Course Title" required="true">
								<select class="input" type="text" name="level" >
									<option value="" class="input">--Please choose level--</option>
									<option value="100">100</option>
									<option value="200">200</option>
									<option value="300">300</option>
									<option value="400">400</option>
									<option value="500">500</option>
								</select>
								<textarea class="input" name="description" placeholder="Enter course description" required="true"></textarea>
								<button class="main-button icon-button pull-right">Add Course</button>
							</form>
						</div>
					</div>
					<!-- /contact form -->

					<!-- contact information -->
					<div class="col-md-5 col-md-offset-1">
						<div class="contact-form">
						<h4>Delete Course</h4>
						<p style="color: green;"><?php if($deleted == true) echo "Successfully DELETED"; 
						elseif(!empty($errormessage)) echo $errormessage; ?></p>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<select class="input" type="text" name="del_course">
									<option value="" class="input">--Please choose A Course--</option>
									<?php if (mysqli_num_rows($query_all) > 0) {
										while ($row = mysqli_fetch_assoc($query_all)) {
										 ?>
									<option value="<?php echo ($row["Course_Code"]); ?>"><?php echo ($row["Course_Code"]); ?></option><?php }
								}?>
								</select>
								<select class="input" type="text" name="del_level" >
									<option value="" class="input">--Please choose level--</option>
									<option value="100">100</option>
									<option value="200">200</option>
									<option value="300">300</option>
									<option value="400">400</option>
									<option value="500">500</option>
								</select>
								<button class="main-button icon-button pull-right">Delete Course</button>
						</form>
						<br>

						<h4>Update Course</h4>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<select class="input" type="text" name="update_course">
									<option value="" class="input">--Please choose A Course--</option>
									<?php 
									$all_courses = "SELECT Course_Code FROM courses ";
									$query_all = mysqli_query($con, $all_courses);

									if (mysqli_num_rows($query_all) > 0) {
										while ($row = mysqli_fetch_assoc($query_all)) {
										 ?>
									<option value="<?php echo ($row["Course_Code"]); ?>"><?php echo ($row["Course_Code"]); ?></option><?php }
								}?>
								</select>
								<select class="input" type="text" name="update_level" >
									<option value="" class="input">--Please choose level--</option>
									<option value="100">100</option>
									<option value="200">200</option>
									<option value="300">300</option>
									<option value="400">400</option>
									<option value="500">500</option>
								</select>
								<input class="input" type="text" name="updated_course" placeholder="New Course Code" required="true">
								<input class="input" type="text" name="updated_course_title" placeholder="New Course Code" required="true">
								<select class="input" type="text" name="updated_level" >
									<option value="" class="input">--Please choose new Level--</option>
									<option value="100">100</option>
									<option value="200">200</option>
									<option value="300">300</option>
									<option value="400">400</option>
									<option value="500">500</option>
								</select>
								<textarea class="input" name="updated_description" placeholder="Enter new course description"></textarea>
								<button class="main-button icon-button pull-right">Update Course</button>
						</form>
					</div>

					</div>
					<!-- contact information -->

				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

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
							<li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
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
