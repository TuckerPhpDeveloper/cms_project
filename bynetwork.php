<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>


<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 style="color: #1faa89;"> Network </h4><br>
							<form action="" method="POST">
								<div class="row">
									
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select name='network' class="form-control" id="network" required>
                                               <option value=""> Select Network Name </option>
                                                <?php 
                                                    $query1=mysqli_query($connect,"select client_name from client_registration order by id desc");
                                                    while($row1=mysqli_fetch_array($query1))
                                                    {
                                                        $client_name = $row1[0];
                                                        ?>
                                                        <option value="<?php echo $row1['client_name'];?>" <?php if($_POST['network'] == $row1['client_name']) echo 'selected="selected" '; ?>><?php echo $row1['client_name'];?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    
									<!-- <div class="col-sm-4">
										<div class="form-group">
											<input class="form-control datetimepicker" type="text" name="todate" id="todate" placeholder="Select To Date & Time" autocomplete="off" required>
										</div>
									</div> -->
									<div class="col-sm-3">
										<input type="submit" name="report" value="Submit" class="btn" style="background-color: #1faa89; color: white;">
										<!-- <a class="btn btn-primary" href="javascript:void(0)" onclick="report()">Get Report</a> -->
									</div>
									<div class="col-sm-3">
                                        <?php $network = $_POST['network']; ?>
										<?php $fromdateexcel=date("Y-m-d H:i:s", strtotime($_POST['fromdate'])); ?>
										<?php $todateexcel=date("Y-m-d H:i:s", strtotime($_POST['todate'])); ?>
										<input type="hidden" id="fromdateexcel" value="<?php echo $fromdateexcel; ?>">
										<input type="hidden" id="todateexcel" value="<?php echo $todateexcel; ?>">
										<!-- <a class="btn btn-danger" href="javascript:void(0)" onclick="excel()">Get Excel</a> -->
										<!-- <a class="btn btn-danger dropdown-toggle" href="#" role="button">Get Excel</a> -->
									</div>
								</div>
							</form>
						</div>
					</div>
					
				</div>
				<!-- Bordered table End -->			

				<?php
						if(isset($_REQUEST['report']))
						{
							$region = $_REQUEST['network'];
                        }
                        else if(isset($_GET['network']))
                        {
                            $region = $_GET['network'];
                        }
							
                        if($region!='')
                        {
                            ?>
								<div class="row">
                                    <div class="col-sm-12">
                                        
                                        <div class="pd-20 card-box mb-30"> 
                                        <h4 style="text-align: center; color: #1faa89;"> Station Details </h4><br>
                                        <table class="data-table table stripe hover nowrap">
                                            <thead>
                                                <tr>
                                                    <th> S.No </th>
                                                    <th> Station Name </th>
                                                    <th> Charge Point ID </th>
                                                    <th> No of Connectors </th>
                                                    <th> Location </th>
                                                    <th> Status </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $s_no = 0;
                                                    $query1=mysqli_query($connect,"select * from station_table where client_name='$region'");
                                                    while($row1=mysqli_fetch_array($query1))
                                                    {
                                                        $station_name = $row1['station_name'];
                                                        $city = $row1['city'];
                                                        $state = $row1['state'];
                                                        $statusdb = $row1['status'];

                                                        if($statusdb == '1')
                                                        {
                                                            $status = "<img src='images/green.png' style='width: 40px; height: 40px;'>";
                                                        }
                                                        else
                                                        {
                                                            $status = "<img src='images/red.png' style='width: 40px; height: 40px;'>";   
                                                        }
                                                        
                                                        $query2=mysqli_query($connect,"select * from chargepoints where station_name='$station_name'");
                                                        while($row2=mysqli_fetch_array($query2))
                                                        {
                                                            $chargepointsid = $row2['chargepointsid'];

                                                            $query3 = mysqli_query($connect,"select count(id) from connectorid_details where chargepointsid='$chargepointsid'");
                                                            while($row3=mysqli_fetch_array($query3))
                                                            {
                                                                $no_of_connectors = $row3[0];
                                                                $s_no++;
                                                                ?>
                                                                <tr>
                                                                    <td> <?php echo $s_no; ?></td>
                                                                    <td> <?php echo $station_name; ?></td>
                                                                    <td> <?php echo $chargepointsid; ?></td>
                                                                    <td> <?php echo $no_of_connectors; ?></td>
                                                                    <td> <?php echo $city.", ".$state; ?></td>
                                                                    <td> <?php echo $status; ?></td>
                                                                    <td> <!-- <a class="dropdown-item" href="station_update.php?serial_no=<?php echo $serial_no; ?>"><i class="dw dw-edit2"></i> </a> -->
                                                                        <a class="dropdown-item" href=""><i class="dw dw-eye"></i> </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
								</div>
							<?php
						}
                        else
                        {
                            ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        
                                        <div class="pd-20 card-box mb-30"> 
                                        <h4 style="text-align: center; color: #1faa89;"> Station Details </h4><br>
                                        <table class="data-table table stripe hover nowrap">
                                            <thead>
                                                <tr>
                                                    <th> S.No </th>
                                                    <th> Station Name </th>
                                                    <th> Charge Point ID </th>
                                                    <th> No of Connectors </th>
                                                    <th> Location </th>
                                                    <th> Status </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $s_no = 0;
                                                    $query1=mysqli_query($connect,"select * from station_table");
                                                    while($row1=mysqli_fetch_array($query1))
                                                    {
                                                        $station_name = $row1['station_name'];
                                                        $city = $row1['city'];
                                                        $state = $row1['state'];
                                                        $statusdb = $row1['status'];

                                                        if($statusdb == '1')
                                                        {
                                                            $status = "<img src='images/green.png' style='width: 40px; height: 40px;'>";
                                                        }
                                                        else
                                                        {
                                                            $status = "<img src='images/red.png' style='width: 40px; height: 40px;'>";   
                                                        }
                                                        
                                                        $query2=mysqli_query($connect,"select * from chargepoints where station_name='$station_name'");
                                                        while($row2=mysqli_fetch_array($query2))
                                                        {
                                                            $chargepointsid = $row2['chargepointsid'];
                                                            $query3 = mysqli_query($connect,"select count(id) from connectorid_details where chargepointsid='$chargepointsid'");
                                                            while($row3=mysqli_fetch_array($query3))
                                                            {
                                                                $no_of_connectors = $row3[0];
                                                                $s_no++;
                                                                ?>
                                                                <tr>
                                                                    <td> <?php echo $s_no; ?></td>
                                                                    <td> <?php echo $station_name; ?></td>
                                                                    <td> <?php echo $chargepointsid; ?></td>
                                                                    <td> <?php echo $no_of_connectors; ?></td>
                                                                    <td> <?php echo $city.", ".$state; ?></td>
                                                                    <td> <?php echo $status; ?></td>
                                                                    <td> <!-- <a class="dropdown-item" href="station_update.php?serial_no=<?php echo $serial_no; ?>"><i class="dw dw-edit2"></i> </a> -->
                                                                        <a class="dropdown-item" href="chargepoint.php?cid=<?php echo $chargepointsid; ?>"><i class="dw dw-eye"></i> </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
					?>
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