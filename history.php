<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>
<?php include 'include/steve_connection.php'; ?>


<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

<?php
    $charger_id = " ";
    if(isset($_POST['report']))
    {
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $charger = $_POST['charger'];
    }
    else
    {
        $fromdate = date("Y-m-d");
        $todate = date("Y-m-d");
        $charger = "all";
    }

    if($charger == 'all')
    {
                        $query = mysqli_query($connect,"select charger_id from fca_charger where 1");

       //$query = mysqli_query($connect,"select charger_id from fca_charger where station_id in (select station_id from fca_stations where cpo_id in (select cpo_id from fca_cpo where cms_id = '$cms_referred') )");
        $count=0;
        while($row = mysqli_fetch_array($query))
        {
            if($count==0)
            {
                $row_charger_id = $row[0];
                $charger_id .= "'".$row_charger_id."'";
            }
            else
            {
                $row_charger_id = $row[0];
                $charger_id .= " , '".$row_charger_id."'";
            }
            $count++;
        }
    }
    else
    {
        $charger_id.= "'".$charger."'";
    }
?>  


	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 style="color: <?php echo $cms_color?>;"> History </h4><br>
                            <form method="POST" id="myform">

                                <div class="row">
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="date" name="fromdate" id="fromdate" value="<?php echo $fromdate ?>" class="form-control" max="<?php echo date("Y-m-d"); ?>">
                                     </div>
                                  </div>
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="date" name="todate" id="todate" value="<?php echo $todate; ?>" class="form-control" max="<?php echo date("Y-m-d"); ?>">
                                    </div>
                                  </div>
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="charger" id="charger" class="form-control" data-live-search="true" required>
                                            <option value="all"> Select All </option>
                                            <?php
                                                $result = mysqli_query($connect, "SELECT `charger_id` FROM fca_charger where station_id IN (select station_id from fca_stations) ORDER BY `fca_charger`.`charger_id` ASC");
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $charger_id_db = $row['charger_id'];
                                                    ?><option value="<?php echo $charger_id_db; ?>"  <?php if($charger_id_db == $charger) echo 'selected="selected"'?>> <?php echo $charger_id_db; ?></option><?php

                                                }
                                            ?>
                                        </select>
                                    </div>
                                  </div>
                                    <div class="col-sm-2">
                                        <input type="submit" name="report" value="Submit" class="btn" style="background-color: <?php echo $cms_color?>; color: white;">
                                         <!--<a class="btn btn-primary" href="javascript:void(0)" onclick="report()">Get Report</a> -->
                                    </div>
                                     <div class="col-sm-1">
                                        <a class="btn" href="javascript:void(0)" style="background-color: <?php echo $cms_color?>;color: white;" onclick="report()">Report</a>
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
					</div>


        <style>
            #id1
            {
                box-shadow: 2px 2px 10px #888888;
                overflow-y: scroll;
                height : 150px; 
            }
            ::-webkit-scrollbar
            {
                width: 5px;
            }
        </style>                            
        <?php
            
                $query = mysqli_query($connect,"select count(transaction_id), sum(total_unit), sum(total_cost) from fca_view_transaction where start_time between '$fromdate 00:00:00' and '$todate 23:59:59' and con_id IN (select con_id from fca_connectors where charger_id in ($charger_id) )");
                if(mysqli_num_rows($query)>0)
                {
                    while($row = mysqli_fetch_array($query))
                    {
                        $transaction_count = $row[0];
                        $unit_count = number_format($row[1],3);
                        $cost_count = number_format($row[2],2);
                    }
                }
                else
                {
                    $transaction_count = $unit_count = $cost_count = 0;
                }
            
        ?>

                    <!-- <div id="divid"></div> -->     

                    <!-- <div class='row clearfix progress-box'>
                        <div class='col-lg-4 col-md-6 col-sm-12 mb-30'>
                            <div class='card-box' id='id1'>
                                <h4 class='pt-20 h5' style='text-align: center;'> Transactions </h4>
                                <h5 class='pt-20 h5' style='text-align: center;'> <b> <?php echo $transaction_count; ?> </b> </h5>
                            </div>
                        </div>
                        <div class='col-lg-4 col-md-6 col-sm-12 mb-30'>
                            <div class='card-box' id='id1'>       
                                <h4 class='pt-20 h5' style='text-align: center;'> Total Earnings </h4>
                                <h5 class='pt-20 h5' style='text-align: center;'> <b> <?php echo "Rs. ".$cost_count; ?> </b> </h5>
                            </div>
                        </div>
                        <div class='col-lg-4 col-md-6 col-sm-12 mb-30'>
                            <div class='card-box' id='id1'>    
                                <h4 class='pt-20 h5' style='text-align: center;'> Total Energy (kWh) </h4>
                                <h5 class='pt-20 h5' style='text-align: center;'> <b> <?php echo $unit_count; ?> </b> </h5>
                            </div>
                        </div>
                    </div><br> -->     


                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Transaction ID </th>
                                        <th> Connector ID </th>
                                        <th> Customer Name </th>
                                        <th> Start Time </th>
                                        <th> Stop Time </th>
                                        <th> Total Unit </th>
                                        <th> Total Cost </th>
                                        <th> Status </th>
                                        <th> Stop Reason </th>
                                        <th> INVOICE </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $querystring="select * from GetCMSHistory where start_timestamp between '$fromdate 00:00:00' and '$todate 23:59:59' and charge_box_id IN ($charger_id) order by transaction_pk desc";
										$_SESSION["query"]=$querystring;
										$_SESSION['fromdate']=$fromdate;
		                                $_SESSION['todate']=$todate;
                                        $query1 = mysqli_query($con,$querystring);
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                             $transaction_id = $row['transaction_pk'];
                                            $con_id = $row['connector_id'];
                                            $charger_id=$row['charge_box_id'];
                                            $start_time_utc = $row['start_timestamp'];
                                            $start_time = date('Y-m-d H:i:s', strtotime($start_time_utc.'+330 minutes'));
                                            $stop_time_utc = $row['stop_timestamp'];
                                            $stop_time = date('Y-m-d H:i:s', strtotime($stop_time_utc.'+330 minutes'));
                                            $total_unit = $row['total_unit'];//number_format((($row['stop_value']-$row['start_value'])/1000),2);
                                            $total_cost = $row['total_cost'];
                                            $statusdb = '1';
                                            $idtag = $row['id_tag'];
                                            $stop_reason = $row['stop_reason'];
                                            $query3 = mysqli_query($connect, "select `con_qr_code` from fca_view_wlabel_map where charger_id='$charger_id' and con_no=$con_id");
                                            while($row3 = mysqli_fetch_array($query3))
                                            {
                                                $con_qr = $row3['con_qr_code'];
                                            }
                                            $query2 = mysqli_query($connect, "select name,mobile,vehicle,password from fca_users where idtag='$idtag' OR dc_idtag='$idtag'");
                                            while($row2 = mysqli_fetch_array($query2))
                                            {
                                                $user_name = $row2['name'];
                                                $user_mobile = $row2['mobile'];
                                                $user_vehicle = $row2['vehicle'];
                                                $user_pass = $row2['password'];
                                                if($user_pass=="*free"||$user_pass=="*test")
                                                {
                                                   $total_cost = "0.00";
                                                }
                                            }


                                            if($statusdb == '1')
                                            {
                                                $status = "<span class='badge-success' style='padding: 5px;'> Completed </span>";
                                            }
                                            else
                                            {
                                                $status = "<span class='badge-danger' style='padding: 5px;'>Failure</span>";
                                            }

                                            ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $transaction_id; ?></td>
                                                <td> <?php echo $con_qr; ?></td>
                                                <td> <?php echo $user_name; ?></td>
                                                <td> <?php echo $start_time; ?></td>
                                                <td> <?php echo $stop_time; ?></td>
                                                <td> <?php echo $total_unit; ?></td>
                                                <td> <?php echo $total_cost; ?></td>
                                                <td> <?php echo $status; ?></td>
                                                <td> <?php echo $stop_reason; ?></td>
                                                <td style="text-align: center;"> <a href="http://cms.tuckerio.bigtot.in/flutter/FlutterInvoice/show.php?transid=<?php echo $transaction_id; ?>"><h5><i class="dw dw-login"></i></h5> </td>
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



<script type="text/javascript">
$(document).ready(function()
{

    // $('#myform').on('submit', function(event){
    //     event.preventDefault();
    //     if($('#fromdate').val() == '')
    //     {
    //         alert("Enter From Date");
    //     }
    //     else if($('#todate').val() == '')
    //     {
    //         alert("Enter To Date");
    //     }
    //     else
    //     {
    //         //var form_data = $(this).serialize();
    //         var fromdate = $('#fromdate').val();
    //         var todate = $('#todate').val();

    //         $.ajax({
    //             url:"api/transaction1.php",
    //             method:"POST",
    //             data:{fromdate:fromdate, todate:todate},
    //             success:function(data)
    //             {
    //                 //alert("Data Fetched using PHP API");
    //                 $('#divid').html(data);
    //             }
    //         });
    //     }
    // });

});
</script>
<script>
    function report()
    {
        fromdate=document.getElementById('fromdateexcel').value;
        todate=document.getElementById('todateexcel').value;
        // $("#div_refresh").load("inverterload.php?fromdate="+fromdate+"&todate="+todate);
        window.location.href="history_excel.php?fromdate="+fromdate+"&todate="+todate;
    }
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