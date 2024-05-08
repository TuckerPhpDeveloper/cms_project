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
							<h4 style="color: #1faa89;"> Location </h4><br>
							<form action="" method="POST">

                                <div class="row">
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control" id="city" name="city">
                                            <option value=""> Country </option>
                                            <?php
                                                $result = mysqli_query($connect,"SELECT distinct(countryfullname) FROM cities");
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    ?><option value="<?php echo $row['countryfullname'];?>"><?php echo $row["countryfullname"];?></option><?php

                                                    ?><!-- <option value="<?php echo $row['countryfullname'];?>" <?php if($_POST['city'] == $row['countryfullname']) echo 'selected="selected" '; ?>><?php echo $row["countryfullname"];?></option> --><?php
                                                }
                                            ?>
                                        </select>
                                        <span id="error_city" class="text-danger"></span>
                                    </div>
                                  </div>
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control" id="state" name="state"></select>
                                        <span id="error_state" class="text-danger"></span>
                                    </div><br>
                                  </div>
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control" id="country" name="country"></select>
                                        <span id="error_country" class="text-danger"></span>
                                    </div><br>
                                  </div>
									<!-- <div class="col-sm-2">
                                        <div class="form-group">
                                            <select name='country' class="form-control" id="country" required>
                                                <option value='india'> India </option>
                                                <option value=''> Pakistan </option>
                                                <option value=''> Netherland </option>
                                                <option value=''> New Zealand </option>
                                            </select>
                                        </div>
									</div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <select name='region' class="form-control" id="region" required>
                                                <option value='North'> North </option>
                                                <option value='East'> East </option>
                                                <option value='West'> West </option>
                                                <option value='South'> South </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <select name='region' class="form-control" id="region" required>
                                                <option value='North'> Tamilnadu </option>
                                                <option value='East'> Kerala </option>
                                                <option value='West'> Gujarat </option>
                                                <option value='South'> Maharashtra </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <select name='region' class="form-control" id="region" required>
                                                <option value='North'> Virudhunagar </option>
                                                <option value='East'> Madurai </option>
                                                <option value='West'> Mumbai </option>
                                                <option value='South'> Surat </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <select name='region' class="form-control" id="region" required>
                                                <option value='North'> 626131 </option>
                                                <option value='East'> 625003 </option>
                                                <option value='West'> 626001 </option>
                                                <option value='South'> 625016 </option>
                                            </select>
                                        </div>
                                    </div> -->
									<!-- <div class="col-sm-4">
										<div class="form-group">
											<input class="form-control datetimepicker" type="text" name="todate" id="todate" placeholder="Select To Date & Time" autocomplete="off" required>
										</div>
									</div> -->
									<div class="col-sm-3">
										<input type="submit" name="report" value="Submit" class="btn" style="background-color: #1faa89; color: white;">
										<!-- <a class="btn btn-primary" href="javascript:void(0)" onclick="report()">Get Report</a> -->
									</div>
									<div class="col-sm-2">
                                        <?php $region = $_POST['region']; ?>
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
							$region = $_REQUEST['country'];
                        }
                        else if(isset($_GET['region']))
                        {
                            $region = $_GET['country'];
                        }
							
                        if($region!='')
                        {
                            ?>
								<div class="row">
                                    <div class="col-sm-12">
                                        
                                        <div class="pd-20 card-box mb-30"> 
                                        <h4 style="text-align: center; color: #1faa89;"> Chargepoint Details </h4><br>
                                        <table class="data-table table stripe hover nowrap">
                                            <thead>
                                                <tr>
                                                    <th> S.No </th>
                                                    <th> Network Name </th>
                                                    <th> Station Name </th>
                                                    <th> Charge Point ID </th>
                                                    <th> No of Connectors </th>
                                                    <th> Status </th>
                                                    <th> Action </th>
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
							<?php
						}
                        else
                        {
                            ?>
                               <div class="row">
                                    <div class="col-sm-12">
                                        
                                        <div class="pd-20 card-box mb-30"> 
                                        <h4 style="text-align: center; color: #1faa89;"> Chargepoint Details </h4><br>
                                        <table class="data-table table stripe hover nowrap">
                                            <thead>
                                                <tr>
                                                    <th> S.No </th>
                                                    <th> Network Name </th>
                                                    <th> Station Name </th>
                                                    <th> Charge Point ID </th>
                                                    <th> No of Connectors </th>
                                                    <th> Status </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $s_no=0;
                                                    $query1=mysqli_query($connect,"select * from client_registration");
                                                    while($row1=mysqli_fetch_array($query1))
                                                    {
                                                        $client_name = $row1['client_name'];

                                                        $query2=mysqli_query($connect,"select * from station_table where client_name='$client_name'");
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
                            <?php
                        }
					?>
				</div>
				
			</div>
		</div>
	</div>









            <script>
                


            $(document).ready(function()
            {
                $('#city').on('change', function()
                {
                    var city_id = this.value;
                    $.ajax({
                        url: "filter1_country_state.php",
                        type: "POST",
                        data:
                        {
                            city_id: city_id
                        },
                        cache: false,
                        success: function(result)
                        {
                            $("#state").html(result);
                        }
                    });
                });
               
                $('#state').on('click', function()
                {
                    var state_id = this.value;
                    $.ajax({
                        url: "filter2_state_city.php",
                        type: "POST",
                        data:
                        {
                            state_id: state_id
                        },
                        cache: false,
                        success: function(result)
                        {
                            $("#country").html(result);
                        }
                    });
                });

            });
            </script>


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