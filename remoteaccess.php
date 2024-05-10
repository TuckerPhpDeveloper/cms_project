<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include "include/dbconnect.php"; ?>
<?php include "include/steve_connection.php"; ?>
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">               
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h4 style="color: #c42216;padding-top:20px"> Remote Control </h4><br>
                        </div>
                    </div><br>               
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
										<th> Connector QR </th>
                                        <th> Charger id </th>
                                        <th> Connector </th>
                                        <th> Status </th>
                                        <th> Unit Fare </th>
                                         <th> Actions </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $url ="http://13.233.175.29/steve_aws/internal_call.php?key=tuckermotors&cmd=getAvailability&ChargeBoxID=1";
                                    $output = file_get_contents($url);
                                    $obj = json_decode($output);
                                    if ($obj->status == "true") {
                                        $Chargers = [];
                                        $Chargers = explode(",",$obj->walletbit);
                                    }
                                    array_splice($Chargers, 0, 0, ["random_string",]);
                                    // can be more items
                                    $s_no = 0;
                                    $query1 = mysqli_query($connect,"SELECT * FROM `fca_view_qr_scan` WHERE 1");
                                    while ($row = mysqli_fetch_array($query1)) {
                                        $con_qr_code = $row["con_qr_code"];
                                        $charger_id = $row["charger_id"];
                                        $con_id = $row["con_no"];
                                        $con_out = $row["con_id"];
                                        $station_id = $row["station_id"];
                                        $cpo_id = $row["cpo_id"];
                                        $cms_id = $row["cms_id"];
                                        $con_type = $row["con_type"];
                                        $power_capacity = $row["power_capacity"];
                                        $unit_fare = $row["unit_fare"];
                                        $buttoncolor = "grey";
                                        $buttontext = "not avail";
                                        $buttonlink = "";
                                        $buttoncolor1 = "grey";
                                        $buttontext1 = "not avail";
                                        $buttonlink1 = "";
                                        if (array_search($charger_id,$Chargers,true) != "") {
                                            $querystring2 = "SELECT `status` FROM `connector_status` WHERE `connector_pk`=(SELECT `connector_pk` FROM `connector` WHERE `charge_box_id`='$charger_id' and `connector_id`=$con_id) ORDER BY `status_timestamp` DESC LIMIT 1";
                                            $query2 = mysqli_query($con,$querystring2);
                                            if ($con_row1 = mysqli_fetch_array($query2)) {
                                                $status_notification =$con_row1[0];
                                                $buttoncolor1 = "black";
                                                $buttontext1 = "Reset";
                                                $buttonlink1 = "http://tucker.bigtot.in/internal_call.php?key=tuckermotors&cmd=Reset&ChargeBoxID=$charger_id";
                                            } else {
                                                $status_notification ="Unavailable";
                                                $buttoncolor1 = "grey";
                                                $buttontext1 = "not avail";
                                                $buttonlink1 = "";
                                            }
                                            /*$buttoncolor = "green";
                                            $buttontext = "Access Control";
                                            $buttonlink ="https://cms.bigtot.in/connectorstatus_$con_out";*/
                                            $querystring3 = "SELECT * FROM `GetHistory` WHERE  `charge_box_id`='$charger_id' and `connector_id`=$con_id and`stop_value` IS NULL ORDER BY `start_timestamp` DESC";
                                            $query3 = mysqli_query($con,$querystring3);
                                            if (mysqli_num_rows($query3) > 0) {
                                                $buttoncolor = "red";
                                                $buttontext = "Stop";
                                                $buttonlink = "http://tucker.bigtot.in/internal_call.php?key=tuckermotors&cmd=RemoteStopTransaction&ChargeBoxID=$charger_id&ConnectorID=$con_id&idTag=a4505f70b1";
                                            } else {
                                                $buttoncolor = "green";
                                                $buttontext = "Start";
                                            $buttonlink = "http://tucker.bigtot.in/internal_call.php?key=tuckermotors&cmd=RemoteStartTransaction&ChargeBoxID=$charger_id&ConnectorID=$con_id&idTag=a4505f70b1";
                                            }
                                        } else {
                                            $status_notification ="Unavailable";
                                            $buttoncolor = "grey";
                                            $buttontext = "not avail";
                                            $buttonlink = "";
                                        } 
										if (($buttontext != "not avail")&&($buttontext1 != "not avail")) {                                         
										    $s_no++;
                                            ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $con_qr_code; ?></td>
                                                <td> <?php echo $charger_id; ?></td>
                                                <td> <?php echo $con_id; ?></td>
                                                <td> <?php echo $status_notification; ?></td>
                                                <td> <?php echo $unit_fare; ?></td>
                                                <td> 
                                                     <a class="btn btn-primary" href=<?php echo $buttonlink; ?> style="background-color: <?php echo $buttoncolor; ?>; color: white;"><?php echo $buttontext; ?></a>	&nbsp; &nbsp;
                                                     <a class="btn btn-primary" href=<?php echo $buttonlink1; ?> style="background-color: <?php echo $buttoncolor1; ?>; color: white;"><?php echo $buttontext1; ?></a>	&nbsp; &nbsp;
                                                 </td> 
                                               
                                            </tr>
                                            <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>                              
                            <div id="dataModal" class="modal fade">  
                                <div class="modal-dialog">  
                                    <div class="modal-content">  
                                        <div class="modal-header">    
                                            <h5 class="modal-title"> Charge Point Details</h5>  
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>  
                                        <div class="modal-body" id="chargepoint_details"></div>  
                                        <div class="modal-footer">  
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>  
                                    </div>  
                                </div>  
                            </div>  
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
        window.location.href="charger_excel.php?";
    }
</script>    <!-- js -->
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