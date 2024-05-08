
<?php

	$connect = new PDO("mysql:host=103.83.81.25; dbname=bigtot_cms;", "bigtot_cms_user", "yvT8KJESGT@o");
	
	function fill_select_box($connect, $category_id)
	{
		$query = "SELECT * FROM connector_table WHERE typecode = '".$category_id."'";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

		$output = '';
		foreach($result as $row)
 		{
			$output .= '<option value="'.$row["category_id"].'">'.$row["connector_name"].'</option>';
 		}
 		return $output;
	}

echo fill_select_box($connect, $_POST["category_id"]);

?>
