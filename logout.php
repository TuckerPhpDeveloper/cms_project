<?php

session_start();
	
include "include/dbconnect.php";

$userid= $_SESSION["chargengo_username"];
$username =$_SESSION["Session_Username"];
$cmp_name =$_SESSION["cmp_name"];

if($userid!='')
{
	$userid='';
	$username='';
	$cmp_name="";
}

	unset($_SESSION['chargengo_username']);
    unset($_SESSION['Session_Username']);
	unset($_SESSION["cmp_name"]);
	
	$_SESSION['chargengo_username']='';
	$_SESSION['Session_Username']='';
	$_SESSION["cmp_name"]="";

    unset($_SESSION['db']);
	$_SESSION['db']='';

	$_SESSION["load_meter_check"]="";

	$userid='';
	$username='';
	

	session_unset();
	//$_SESSION['last_visited'] = $_SERVER['HTTP_REFERER'];
	//session_destroy();
	
	
/*	
echo "sessionuserid".$_SESSION['Session_UserId'];
echo "sessionusername".$_SESSION['Session_Username']='';
echo "userid".$userid;
echo "username".$username;
*/

echo "<meta http-equiv='refresh' content='0;url=".$root_dir."index.php'>";
exit;	



?>