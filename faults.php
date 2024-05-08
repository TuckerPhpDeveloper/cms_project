<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>


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
        $query = mysqli_query($connect,"select charger_id from fca_charger");
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
        $charger_id = "'".$charger."'";
    }
?>  


	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 style="color: #3d56d8;"> Faults </h4><br>
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
                                                $result = mysqli_query($connect, "SELECT * FROM fca_charger");
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
                                        <input type="submit" name="report" value="Submit" class="btn" style="background-color: #3d56d8; color: white;">
                                        <!-- <a class="btn btn-primary" href="javascript:void(0)" onclick="report()">Get Report</a> -->
                                    </div>
                                    <div class="col-sm-1">
                                        <a class="btn btn-primary" href="javascript:void(0)" style="background-color: #3d56d8; color: white;" onclick="report()">Report</a>
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
 


                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Connector ID </th>
                                        <th> Fault Code </th>
                                        <th> Fault Name </th>
                                        <th> Fault Description </th>
                                        <th> Occured Time </th>
                                        <th> Solved Time </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,"select con_id from fca_connectors where charger_id in ($charger_id)");
                                        if(mysqli_num_rows($query1)>0)
                                        {
                                            while($row = mysqli_fetch_array($query1))
                                            {
                                                $con_id = $row['con_id'];

                                                $query2 = mysqli_query($connect, "select * from fca_errors_log where occured_time between '$fromdate 00:00:00' and '$todate 23:59:59' and con_id = '$con_id' order by sno desc limit 1");
                                                while($row2 = mysqli_fetch_array($query2))
                                                {
                                                    $s_no++;
                                                    $error_code = $row2['error_code'];
                                                    $error_name = $row2['error_name'];
                                                    $error_desc = $row2['error_desc'];
                                                    $occured_time_utc = $row2['occured_time'];
                                                    $occured_time = date('Y-m-d H:i:s', strtotime($occured_time_utc.'+330 minutes'));
                                                    $error_status = $row2['error_status'];

                                                    if($error_status == '0')
                                                    {
                                                        $status =  "<span class='badge-danger' style='padding: 5px;'> Not Solved </span> ";
                                                        $solved_time = '';
                                                    }
                                                    else if($error_status == '1')
                                                    {
                                                        $status =  "<span class='badge-success' style='padding: 5px;'> Solved </span> ";
                                                        $solved_time_utc = $row2['solved_time'];
                                                        $solved_time = date('Y-m-d H:i:s', strtotime($solved_time_utc.'+330 minutes'));
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $s_no; ?></td>
                                                        <td><?php echo $con_id; ?></td>
                                                        <td><?php echo $error_code; ?></td>
                                                        <td><?php echo $error_name; ?></td>
                                                        <td><?php echo $error_desc; ?></td>
                                                        <td><?php echo $occured_time; ?></td>
                                                        <td><?php echo $solved_time; ?></td>
                                                        <td><?php echo $status; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <tr>
                                                <td colspan="8" style="text-align: center;"> No Faults occured </td>
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
        window.location.href="faults_excel.php?fromdate="+fromdate+"&todate="+todate;
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