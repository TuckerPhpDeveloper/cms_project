<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>


<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

<?php
    if(isset($_POST['report']))
    {
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];   
    }
    else
    {
        $fromdate = date("Y-m-d");
        $todate = date("Y-m-d");
    }
?>	

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 style="color: #3d56d8;"> Authorization </h4><br>
							<form action="" method="POST">

                                <div class="row">
                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="date" name="fromdate" id="fromdate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                     </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="date" name="todate" id="todate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
                                    </div>
                                  </div>
									<div class="col-sm-2">
										<input type="submit" name="report" value="Submit" class="btn" style="background-color: #3d56d8; color: white;">
										<!-- <a class="btn btn-primary" href="javascript:void(0)" onclick="report()">Get Report</a> -->
									</div>
									<div class="col-sm-2">
										<?php $fromdateexcel=date("Y-m-d H:i:s", strtotime($_POST['fromdate'])); ?>
										<?php $todateexcel=date("Y-m-d H:i:s", strtotime($_POST['todate'])); ?>
										<input type="hidden" id="fromdateexcel" value="<?php echo $fromdateexcel; ?>">
										<input type="hidden" id="todateexcel" value="<?php echo $todateexcel; ?>">

										<!-- <a class="btn btn-danger" href="javascript:void(0)" onclick="excel()"> Excel </a> -->
										<!-- <a class="btn btn-danger dropdown-toggle" href="#" role="button">Get Excel</a> -->

									</div>
								</div>
							</form>
						</div>
					</div><br><br>
					

                    <div class="row">
                        <div class="col-sm-12">
                                
                            <h4 style="text-align: center; color: #3d56d8;"> Authorization Details from <?php echo $fromdate." to ".$todate; ?>  </h4><br>
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> IDTAG </th>
                                        <th> User ID </th>
                                        <th> Date & Time </th>
                                        <th> Type </th>
                                        <th> Status </th>
                                        <th> EVSE ID </th>
                                        <th> Connector ID </th>
                                        <th> View </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $query1=mysqli_query($connect,"select * from client_registration");
                                        while($row1=mysqli_fetch_array($query1))
                                        {
                                            $client_name = $row1['client_name'];

                                            $query2=mysqli_query($connect,"select * from station_table where client_name='$client_name' and city='$region'");
                                            while($row2=mysqli_fetch_array($query2))
                                            {
                                                $station_name = $row2['station_name'];
                                                $statusdb = $row2['status'];
                                                if($statusdb == '1')
                                                {
                                                    $status = "<img src='images/green.png' style='width: 40px; height: 40px;'>";
                                                }
                                                else
                                                {
                                                    $status = "<img src='images/red.png' style='width: 40px; height: 40px;'>";   
                                                }

                                                $query3=mysqli_query($connect,"select * from chargepoints where station_name='$station_name'");
                                                while($row3=mysqli_fetch_array($query3))
                                                {
                                                    $chargepointsid = $row3['chargepointsid'];
                                                    
                                                    $query4 = mysqli_query($connect,"select count(id) from connectorid_details where chargepointsid='$chargepointsid'");
                                                    while($row4=mysqli_fetch_array($query4))
                                                    {
                                                        $s_no++;
                                                        $no_of_connectors = $row4[0];
                                                        ?>
                                                        <tr>
                                                            <td> <?php echo $s_no; ?></td>
                                                            <td> <?php echo $client_name; ?></td>
                                                            <td> <?php echo $station_name; ?></a></td>
                                                            <td> <?php echo $chargepointsid; ?></td>
                                                            <td> <?php echo $no_of_connectors; ?></td>
                                                            <td> <?php echo $status; ?></td>
                                                            <td> <!-- <a class="dropdown-item" href="station_update.php?serial_no=<?php echo $serial_no; ?>"><i class="dw dw-edit2"></i> </a> -->
                                                                <a class="dropdown-item" href="stationprofiles.php"><i class="dw dw-eye"></i> </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }
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