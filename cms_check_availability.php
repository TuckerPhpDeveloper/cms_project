<?php
	
	require_once("include/dbconnect.php");

	if(!empty($_POST["cms_id"]))
	{
	  	$query = mysqli_query($connect,"SELECT * FROM fca_cms_login WHERE cms_id = '" .$_POST["cms_id"]. "'");
  		$count = mysqli_num_rows($query);
  		if($count>0)
  		{
		    echo "taken";
  		}
  		else
  		{
      		echo "available";
  		}
	}
?>