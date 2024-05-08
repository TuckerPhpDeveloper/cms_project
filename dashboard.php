<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script>
	   	$(document).ready(function()
	   	{
	       	setInterval(function()
	       	{
		        $("#div_refresh").load("dashboardload.php");
	       	}, 1000); 
	   	});
	</script>

	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="row clearfix progress-box">
				<div class="table-responsive" id="div_refresh"></div>
			</div>
		</div>
	</div>

	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script src="vendors/scripts/dashboard.js"></script>


	<script src="src/plugins/jQuery-Knob-master/jquery.knob.min.js"></script>
	<script src="vendors/scripts/dashboard2.js"></script>

</body>
</html>