<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>
<?php include 'include/steve_connection.php'; ?>



<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h4 style="color: #3d56d8;"> Stations List </h4><br>
                        </div>
                    </div><br>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th><a class="btn btn-primary" href="javascript:void(0)" style="background-color: #3d56d8; color: white;" onclick="report()">Report</a></th>
                                        <th style="text-align: right;" colspan="11"> <a href="addstation" style="color: white;"> <button type="button" name="add" class="btn btn-info"> Add Station </button> </a></th>
                                    </tr>
                                    <tr>
                                        <th> S.No </th>
                                        <th> CPO Name </th>
                                        <th> Station Name </th>
                                        <th> Station Id </th>
                                        <th> Total Chargers </th>
                                        <th> Total Connectors </th>
                                        <!--<th> Live Connectors </th>-->
                                         <th> Actions </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,"select * from fca_stations");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $cpo_id = $row['cpo_id'];
                                            $station_id = $row['station_id'];
                                            $station_name = $row['station_name'];

                                            $query2 = mysqli_query($connect, "select cpo_name from fca_cpo where cpo_id = '$cpo_id'");
                                            $row2 = mysqli_fetch_array($query2);
                                            $cpo_name = $row2[0];

                                            $query3 = mysqli_query($connect, "select count(con_id) from fca_connectors where charger_id IN (select charger_id from fca_charger where station_id = '$station_id')");
                                            while($row3 = mysqli_fetch_array($query3))
                                            {
                                                $conn_id = $row3[0];
                                            }

                                            $query4 = mysqli_query($connect, "select count(charger_id) from fca_charger where station_id = '$station_id'");
                                            $fetch4 = mysqli_fetch_array($query4);
                                            $total_chargers = $fetch4[0];

                                            $count=0;
                            $con_id = "";
 $query11 = "SELECT `charger_id`,`con_no` FROM `fca_view_map` WHERE station_id ='$station_id'";
            $result1 = mysqli_query($connect, $query11);
            if(mysqli_num_rows($result1)>0)
			{
            while ($row1 = mysqli_fetch_array($result1)) {
				if($count==0)
                                {
                                    $row_con_id = $row1["charger_id"];
                                    $con_id .= "'".$row_con_id."'";
                                }
                                else
                                {
                                    $row_con_id = $row1["charger_id"];
                                    $con_id .= " , '".$row_con_id."'";
                                }
                                $count++;
            
	   $query5= "SELECT count(transaction_pk) FROM `GetHistory` WHERE  charge_box_id IN ($con_id) and`stop_value` IS NULL ORDER BY `start_timestamp` DESC LIMIT 1";
                                            //$query5 = mysqli_query($connect, "select count(con_id) from fca_connector_status where charger_id IN (select charger_id from fca_charger where station_id ='$station_id' and meter_status = 1)");
                                           $query5 = mysqli_query($con,$query5);
                                            while($row5 = mysqli_fetch_array($query5))
                                            {
                                                $live_connectors = $row5[0];
                                            }
			}
			}
			else
			{
			    $live_connectors =0;
			}
                                        
                                            ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $cpo_name; ?></td>
                                                <td> <?php echo $station_name; ?></td>
                                                <td> <?php echo $station_id; ?></td>
                                                <td> <?php echo $total_chargers; ?></td>
                                                <td> <?php echo $conn_id; ?></td>
                                                <!--<td> <?php echo $live_connectors; ?></td>-->
                                                 <td>  
                                                     <a href="editstation.php?station_id=<?php echo $station_id;?>"> <i class="dw dw-edit2"></i> </a> &nbsp; &nbsp;
                                                     <a href="#" id="<?php echo $station_id; ?>" class="view_data"> <i class="dw dw-eye"></i> </a> &nbsp; &nbsp;
                                                    <!-- <a class="remove" style="cursor: pointer;"> <i class="dw dw-trash" style="color: red;"></i> </a> -->
                                                 </td> 
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                                

                            <div id="dataModal" class="modal fade">  
                                <div class="modal-dialog">  
                                    <div class="modal-content">  
                                        <div class="modal-header">    
                                            <h5 class="modal-title"> Station Details</h5>  
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>  
                                        <div class="modal-body" id="station_details"></div>  
                                        <div class="modal-footer">  
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>  
                                    </div>  
                                </div>  
                            </div>  

                            <script>    
                                $(document).ready(function()
                                {  
                                    $('.view_data').click(function()
                                    {  
                                       var station_id = $(this).attr("id");  
                                       $.ajax({  
                                            url:"stationmodal.php",  
                                            method:"post",  
                                            data:{station_id : station_id},  
                                            success:function(data)
                                            {  
                                                $('#station_details').html(data);  
                                                $('#dataModal').modal("show");  
                                            }  
                                       });  
                                    });  
                                });  
                            </script>



                        </div>
                    </div>

                </div>
                <!-- Bordered table End -->         

                </div>
                
            </div>
        </div>
    </div>

<script>
    function report()
    {
        window.location.href="station_excel.php?";
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