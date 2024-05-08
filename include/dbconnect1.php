<?php

	error_reporting(0);

	date_default_timezone_set("Asia/Kolkata"); 
				 
	ini_set('max_execution_time', 450);
	set_time_limit(300);

	$host_name =  "103.83.81.25";
	$host_user =  "bigtot_cms_user";
	$host_pass =  "yvT8KJESGT@o";
	$host_db   = "bigtot_cms"; 
		
	$connect=mysqli_connect($host_name,$host_user,$host_pass,$host_db) or die("Could Not Connect to Data Base".mysqli_error());
	
	// if($connect)
	// {
	// 	echo "Success";
	// }
	// else
	// {
	// 	echo "Error";
	// }

	$root_dir="https://".$_SERVER['HTTP_HOST']."/";
	define('ROOT_DIR',$root_dir);	

?>