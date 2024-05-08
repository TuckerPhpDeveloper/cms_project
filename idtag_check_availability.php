<?php
	
	require_once("include/dbconnect.php");

	if(!empty($_POST["idtag"]))
	{
	  	$query = mysqli_query($connect,"SELECT * FROM fca_users WHERE idtag = '" .$_POST["idtag"]. "'");
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