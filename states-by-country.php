<?php
require_once "include/dbconnect.php";
$state_id = $_POST["city_id"];
$result = mysqli_query($connect,"SELECT * FROM cities where `cityfullname` = '$state_id'");
?>
<?php
while($row = mysqli_fetch_array($result)) {
?>
<option value="<?php echo $row["statefullname"];?>"><?php echo $row["statefullname"];?></option>
<?php
}
?>