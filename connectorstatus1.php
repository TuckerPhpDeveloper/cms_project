<?php

	$con_id = $_REQUEST['con_id'];
?>


	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">


	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="images/loading.gif" alt=""></div>
		</div>
	</div>

	<script type="text/javascript">
		let timeout;
		con_id = <?php echo $con_id; ?>;
		myFunction();

		function myFunction()
		{
		  	timeout = setTimeout(alertFunc, 10000);
		}

		function alertFunc()
		{
		    window.location.href='connectorstatus.php?con_id='+con_id;
		}
	</script>
