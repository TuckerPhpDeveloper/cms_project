<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Tucker CMS - Login Page </title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="images/tucker.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/tucker.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/tucker.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>

	<style type="text/css">
		body
		{
			background-image: url('images/assets/bg.jpg');
			background-repeat: no-repeat;	
			background-size: 100% 100%;
		}
		input
		{
			width: 100%;
			border: none;
			border-bottom: 2px solid;
		}
	</style>

</head>
<body class="login-page">


<?php
	include("include/dbconnect.php");

	session_start();

	$error=$_GET['error'];
	
	if(isset($_SESSION["tucker_cms"]))
	{
		header("location:dashboard.php");
	}

	if(isset($_REQUEST["submit"]))
	{
		$uname1 = $_POST['username'];
		$pass1 = base64_encode($_POST['password']);
	
		$objResult = mysqli_query($connect,"SELECT * from tbl_adminprofile where `varUserName`='$uname1' and `varPassword`='$pass1' and `varName`='Admin'");
		if (mysqli_num_rows($objResult) > 0) 
		{
			$objUserdetails = mysqli_fetch_array($objResult);
			$intUserId 		= $objUserdetails['intAdminId'];
			$strUserName 	= $objUserdetails['varUserName'];
			$strName 		= $objUserdetails['varName'];

			//$_SESSION["Session_UserId"]= $intUserId;
			$_SESSION["tucker_cms"]= $strUserName;
			$_SESSION["cmp_name"]=$strName ;
			$_SESSION["popup"]= '1';
			header("Location:dashboard");	
			exit;
		}
		else
		{
			header("Location:index.php?error=1");
		}
	}

?>

<script type="text/javascript">
	function myfunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>

	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="card-box" style="border-radius: 25px;">

				<div class="row align-items-center">
					<div class="col-lg-1"></div>
					<div class="col-lg-5">
						<br><br>
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
						  <ol class="carousel-indicators">
						    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
						  </ol>
						  <div class="carousel-inner">
						    <div class="carousel-item active">
						      <img src="images/assets/slide4.png" alt="First slide" style="width: 100%; height: 100%;">
						    </div>
						    <div class="carousel-item">
						      <img src="images/assets/slide5.png" alt="Second slide" style="width: 100%; height: 100%;">
						    </div>
						    <div class="carousel-item">
						      <img src="images/assets/slide6.png" alt="Third slide" style="width: 100%; height: 100%;">
						    </div>
						  </div>
						  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						    <span class="carousel-control-next-icon" aria-hidden="true"></span>
						    <span class="sr-only">Next</span>
						  </a>
						</div>
						<br><br>
						<!-- <img src="images/login1.gif" alt=""> -->
					</div>	
					<div class="col-lg-6">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center"> <img src="images/logo5.png"> </h2>
								<!-- <h2 class="text-center"> Sign in </h2> -->
							</div>
							<form method="post" action="index.php">
								<?php 
					    		  if($error!='')
					    		  {
					    		    ?><span class="mt5 mb20" style="color:red;">Invalid username and password.</span><?php
					    		    $error='';
					    		  }
					    		?>
								<div class="input-group custom">
									<input type="text" class="form-control form-control-lg" placeholder="Username" name="username">
									<!-- <div class="input-group-append custom">
										<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
									</div> -->
								</div>
								<!-- <div>
									<input type="password" placeholder="Password" name="password" id="password"><br><br>
										<span class="input-group-text" onclick="myfunction()"></span>

								</div> -->
								
								<div class="input-group custom">
									<input type="password" class="form-control form-control-lg" placeholder="Password" name="password" id="password">
									<div class="input-group-append custom">
										<span class="input-group-text" onclick="myfunction()"><i class="fa fa-fw fa-eye-slash field-icon toggle-password"></i></span>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
								            <input class="btn btn-block" type="submit" name="submit" id="submit" value="Submit" style="background-color: #3d56d8; color: white;">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>									
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>