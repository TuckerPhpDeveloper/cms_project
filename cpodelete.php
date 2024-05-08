<?php


require('include/dbconnect.php');


if(isset($_GET['id']))
{
     $sql = "DELETE FROM fca_cpo WHERE cpo_id='".$_GET['id']."' ";
     $connect->query($sql);
	 echo 'Deleted successfully.';
}


?>