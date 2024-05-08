<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>
<?php include 'include/steve_connection.php'; ?>


<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

<?php
    $charger_id = " ";
    $id_tag = " ";
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
    $query5 = mysqli_query($connect,"SELECT idtag FROM fca_users WHERE `password`='*free' or `password`='*test'");
        $newcount=0;
        while($row5 = mysqli_fetch_array($query5))
        {
            if($newcount==0)
            {
                $row_id_tag = $row5[0];
                $id_tag .= "'".$row_id_tag."'";
            }
            else
            {
                $row_id_tag = $row5[0];
                $id_tag .= " , '".$row_id_tag."'";
            }
            $newcount++;
        }

?>  


	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 style="color: #3d56d8;"> Earnings </h4><br>
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
                                     <!--<div class="col-sm-1">
                                        <a class="btn btn-primary" href="javascript:void(0)" style="background-color: #3d56d8; color: white;" onclick="report()">Report</a>
                                    </div>-->
                                    <!--<div class="col-sm-2">
                                        <?php $fromdateexcel=date("Y-m-d H:i:s", strtotime($_POST['fromdate'])); ?>
                                        <?php $todateexcel=date("Y-m-d H:i:s", strtotime($_POST['todate'])); ?>
                                        <input type="hidden" id="fromdateexcel" value="<?php echo $fromdateexcel; ?>">
                                        <input type="hidden" id="todateexcel" value="<?php echo $todateexcel; ?>">-->

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
            $querystring="SELECT count(transaction_pk),sum(`total_cost`) FROM `wallet_track` WHERE  transaction_pk IN(SELECT transaction_pk FROM `GetHistory` WHERE start_timestamp between '$fromdate 00:00:00' and '$todate 23:59:59' and charge_box_id IN($charger_id)and `id_tag` NOT IN($id_tag))";
               $query = mysqli_query($con,$querystring);
			   // $query = mysqli_query($connect,"select count(transaction_id), sum(total_unit), sum(total_cost) from fca_view_transaction where start_time between '$fromdate 00:00:00' and '$todate 23:59:59' and con_id IN (select con_id from fca_connectors where charger_id in ($charger_id) )");
                if(mysqli_num_rows($query)>0)
                {
                    while($row = mysqli_fetch_array($query))
                    {
                        $transaction_count = $row[0];
                        //$unit_count = number_format($row[1],3);
                        $cost_count = number_format($row[1],2);
                    }
                }
                else
                {
                    $transaction_count = $unit_count = $cost_count = 0;
                }
 $querystring1="SELECT count(transaction_pk),sum(`total_cost`) FROM `wallet_track` WHERE  transaction_pk IN(SELECT transaction_pk FROM `GetHistory` WHERE `charge_box_id` IN($charger_id) and `id_tag` NOT IN($id_tag))";
               $query1 = mysqli_query($con,$querystring1);
                //$query1 = mysqli_query($connect,"select count(transaction_id), sum(total_unit), sum(total_cost) from fca_view_transaction where con_id IN (select con_id from fca_connectors where charger_id in ($charger_id) )");
                if(mysqli_num_rows($query1)>0)
                {
                    while($row1 = mysqli_fetch_array($query1))
                    {
                        $transaction_count = $row1[0];
                        //$unit_count = number_format($row1[1],3);
                        $overall_cost_count = number_format($row1[1],2);
                    }
                }
                else
                {
                    $transaction_count = $unit_count = $overall_cost_count = 0;
                }
            
        ?>

                    <!-- <div id="divid"></div> -->     

                    <div class='row clearfix progress-box'>
                        <div class='col-lg-6 col-md-6 col-sm-12 mb-30'>
                            <div class='card-box' id='id1'>
                                <h4 class='pt-20 h5' style='text-align: center;'> Overall Earnings </h4>
                                <h5 class='pt-20 h5' style='text-align: center;'> <b> <?php echo "Rs. ".$overall_cost_count; ?> </b> </h5>
                            </div>
                        </div>
                        <div class='col-lg-6 col-md-6 col-sm-12 mb-30'>
                            <div class='card-box' id='id1'>       

                                <h4 class='pt-20 h5' style='text-align: center;'> Earnings from ( <?php echo date('d-m-Y', strtotime($fromdate)). " to ".date('d-m-Y', strtotime($todate)); ?>) </h4>
                                <h5 class='pt-20 h5' style='text-align: center;'> <b> <?php echo "Rs. ".$cost_count; ?> </b> </h5>
                            </div>
                        </div>
                    </div><br>     
 <!--
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Transaction ID </th>
                                        <th> Connector ID </th>
                                        <th> Reservation ID </th>
                                        <th> Total Unit </th>
                                        <th> Base Fare </th>
                                        <th> Unit Fare </th>
                                        <th> Time Fare </th>
                                        <th> Reservation Fare </th>
                                        <th> GST Fare </th>
                                        <th> Total Cost </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $querystring="select * from fca_view_transaction where status=1 and start_time between '$fromdate 00:00:00' and '$todate 23:59:59' and con_id IN (select con_id from fca_connectors where charger_id in ($charger_id) ) order by transaction_id desc";
                                        $_SESSION["query"]=$querystring;
                                        $query1 = mysqli_query($connect,"select * from fca_view_transaction where start_time between '$fromdate 00:00:00' and '$todate 23:59:59' and con_id IN (select con_id from fca_connectors where charger_id in ($charger_id) ) order by transaction_id desc");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;

                                            $transaction_id = $row['transaction_id'];
                                            $reservation_id = $row['reservation_id'];
                                            $con_id = $row['con_id'];
                                            $total_unit = $row['total_unit'];
                                            $base_fare = $row['base_fare'];
                                            $unit_fare = $row['unit_fare'];
                                            $time_fare = $row['time_fare'];
                                            $reservation_fare = $row['reservation_fare'];
                                            $gst_fare = $row['gst_fare'];
                                            $total_cost = $row['total_cost'];
                                                                                        
                                            ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $transaction_id; ?></td>
                                                <td> <?php echo $con_id; ?></td>
                                                <td> <?php echo $reservation_id; ?></td>
                                                <td> <?php echo $total_unit; ?></td>
                                                <td> <?php echo $base_fare; ?></td>
                                                <td> <?php echo $unit_fare; ?></td>
                                                <td> <?php echo $time_fare; ?></td>
                                                <td> <?php echo $reservation_fare; ?></td>
                                                <td> <?php echo $gst_fare; ?></td>
                                                <td> <?php echo $total_cost; ?></td>
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
        window.location.href="earning_excel.php?fromdate="+fromdate+"&todate="+todate;
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