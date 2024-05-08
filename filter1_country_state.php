<?php
	require_once "include/dbconnect.php";
	$country_id = $_POST["city_id"];
	$result = mysqli_query($connect,"SELECT distinct(statefullname) FROM cities where `countryfullname` = '$country_id'");
	while($row = mysqli_fetch_array($result))
	{
		?><option value="<?php echo $row["statefullname"];?>"><?php echo $row["statefullname"];?></option><?php
	}
?>