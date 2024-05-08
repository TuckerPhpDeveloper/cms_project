<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>


<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 style="color: #3d56d8;"> Charging Zones </h4><br>
						</div>
					</div><br>
					

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th style="text-align: right;" colspan="11"> <button type="button" name="add" class="btn btn-info"> <a href="addzones.php" style="color: white;"> Add Zones </a> </button></th>
                                    </tr>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Zone Name </th>
                                        <th> Address </th>
                                        <th> City & State </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,"select * from charging_zones");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;

                                            $zone_name = $row['zone_name'];
                                            $zone_desc = $row['zone_desc'];
                                            $latitude = $row['latitude'];
                                            $longitude = $row['longitude'];
                                            $address = $row['address'];
                                            $pincode = $row['pincode'];
                                            $city = $row['city'];
                                            $state = $row['state'];
                                            $country = $row['country'];
                                            $region = $row['region'];

                                            ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $zone_name; ?>
                                                <td> <?php echo $address; ?></td>
                                                <td> <?php echo $city.", ".$state; ?></td>
                                                <td> <a href="#"><i class="dw dw-edit2"></i></a> &nbsp; &nbsp; <a href="#"><i class="dw dw-eye"></i></a> &nbsp; &nbsp; <a href="#"><i class="dw dw-trash" style="color: red;"></i></a> </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>

				</div>
				<!-- Bordered table End -->			

				</div>
				
			</div>
		</div>
	</div>


	<!-- js -->

	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>

	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>


    <!-- buttons for Export datatable -->
    <script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="src/plugins/datatables/js/vfs_fonts.js"></script>
    <!-- Datatable Setting js -->
    <script src="vendors/scripts/datatable-setting.js"></script>

</body>
</html>