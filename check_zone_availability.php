<?php
require_once("include/dbconnect.php");


if(!empty($_POST["username"])) {
  $query = mysqli_query($connect,"SELECT * FROM charging_zones WHERE zone_name='" . $_POST["username"] . "'");
  $count = mysqli_num_rows($query);
  if($count>0) {
      echo "taken";
  }else{
      echo "available";
  }
}
?>