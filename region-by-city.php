<?php

	require_once "include/dbconnect.php";
	$state_id = $_POST["state_id"];
	$result = mysqli_query($connect,"SELECT distinct(region) FROM fca_cities where `statefullname` = '$state_id'");
	while($row = mysqli_fetch_array($result))
	{
		?><option value="<?php echo $row["region"];?>"><?php echo $row["region"];?></option><?php
	}
	
?>