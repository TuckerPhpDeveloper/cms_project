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
                            <h4 style="color: #3d56d8;"> Wallet track </h4><br>
                        </div>
                    </div><br>               
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th><a class="btn btn-primary" href="javascript:void(0)" style="background-color: #3d56d8; color: white;" onclick="report()">Report</a></th>
                                        <th style="text-align: right;" colspan="11"> <a href="addwalamount" style="color: white;"> <button type="button" name="add" class="btn btn-info"> Add Wallet Amount </button> </a></th>
                                    </tr>
                                    <tr>
                                    <th> Order Id </th>
                                    <th> Customer Name </th>
                                    <th> Customer Mobile </th>
                                    <th> Customer ID </th>
                                    <th> Amount </th>
                                    <th> Status </th>
                                    <th> Timeofupdate </th>
        	                        <th> Actions </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									$querystring1 = "SELECT * FROM `fca_wallet_track` WHERE `server_status`=0";
									$query1 = mysqli_query($connect, $querystring1);

									if (mysqli_num_rows($query1) > 0) {
									while ($row1 = mysqli_fetch_array($query1)) {
										$order_id = $row1["order_id"];
										$idtag = $row1["idtag"];
										$amount = $row1["amount"];
										$status = $row1["status"];
										$server_status = $row1["server_status"];
										$timeofupdate = $row1["timeofupdate"];

										$start_time = date(
											"Y-m-d H:i:s",
											strtotime($timeofupdate . "+330 minutes")
										);

										$query4 = mysqli_query(
											$connect,
											"select name,mobile from fca_users where idtag = '$idtag'"
										);
										$fetch2 = mysqli_fetch_array($query4);
										$name = $fetch2["name"];
										$mobile = $fetch2["mobile"];

										 $buttontext = "Update";
										$buttonlink = "updatewtrack.php?order_id=$order_id";
										    $s_no++;
                                            ?>
                                            <tr>
                                                <td> <?php echo $order_id; ?></td>
                                                <td> <?php echo $name; ?></td>
                                                <td> <?php echo $mobile; ?></td>
                                                <td> <?php echo $idtag; ?></td>
                                                <td> <?php echo $amount; ?></td>
                                                <td> <?php echo $status; ?></td>
                                                <td> <?php echo $timeofupdate; ?></td>
                                                <td> 
                                                     <a class="btn btn-primary" href=<?php echo $buttonlink; ?> style="background-color: <?php echo $cms_color; ?>; color: white;"><?php echo $buttontext; ?></a>	&nbsp; &nbsp;
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
        window.location.href="waltrack_excel.php?";
    }
</script>
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