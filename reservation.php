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
							<h4 style="color: #3d56d8;"> Reservation </h4><br>
							<form action="" method="POST">

                                <div class="row">
                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="date" name="fromdate" id="fromdate" value="<?php echo $fromdate ?>" class="form-control">
                                     </div>
                                  </div>
                                  <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="date" name="todate" id="todate" value="<?php echo $todate; ?>" class="form-control">
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
                                
                            <h4 style="text-align: center; color: #3d56d8;"> Reservation Details from <?php echo $fromdate." to ".$todate; ?>  </h4><br>
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> IDTAG </th>
                                        <th> User ID </th>
                                        <th> User Email </th>
                                        <th> Connector ID </th>
                                        <th> Reserved Time </th>
                                        <th> Expiry Date </th>
                                        <th> Duration </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,"select * from reservation_backup where reserved_time between '$fromdate 00:00:00' and '$todate 23:59:59'");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $idtag = $row['idtag'];
                                            $con_id = $row['connector_id'];
                                            $reserved_time = $row['reserved_time'];
                                            $expiry_date = $row['expiry_date'];
                                            $duration = $row['duration(hrs)'];
                                            $statusdb = $row['cancel_bit'];

                                            if($statusdb == '1')
                                            {
                                                $status = "<img src='images/green.png' style='width:30px; height:30px;'>";
                                            }
                                            else
                                            {
                                                $status = "<img src='images/red.png' style='width:30px; height:30px;'>";   
                                            }

                                            $query2 = mysqli_query($connect,"select * from user_details where idtag='$idtag'");
                                            while($row2 = mysqli_fetch_array($query2))
                                            {
                                                $user_id = $row2['user_known_id'];
                                                $user_mail = $row2['user_mail_id'];
                                            }
                                            ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $idtag; ?></td>
                                                <td> <?php echo $user_id; ?></td>
                                                <td> <?php echo $user_mail; ?></td>
                                                <td> <?php echo $con_id; ?></td>
                                                <td> <?php echo $reserved_time; ?></td>
                                                <td> <?php echo $expiry_date; ?></td>
                                                <td> <?php echo $duration; ?></td>
                                                <td> <?php echo $status; ?></td>
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