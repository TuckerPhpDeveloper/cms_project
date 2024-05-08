<?php $db= new mysqli('localhost','root','','1next2'); 
extract($_POST);
$user_id=$db->real_escape_string($id);
$status=$db->real_escape_string($status);
$sql=$db->query("UPDATE user SET status='$status' WHERE id='$id'");
echo $sql;
//echo 1;
?>
