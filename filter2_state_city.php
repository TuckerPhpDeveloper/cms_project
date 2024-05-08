<?php
	require_once "include/dbconnect.php";
	$country_id = $_POST["state_id"];
	$result = mysqli_query($connect,"SELECT distinct(cityfullname) FROM cities where `statefullname` = '$country_id'");
	while($row = mysqli_fetch_array($result))
	{
		?><option value="<?php echo $row["cityfullname"];?>"><?php echo $row["cityfullname"];?></option><?php
	}
?>