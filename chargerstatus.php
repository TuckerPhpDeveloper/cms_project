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
                            <h4 style="color: #3d56d8;"> Charger Status </h4><br>
                        </div>
                    </div><br>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
										<th> Status </th>
                                        <th> Error Code </th>
                                        <th> Error Info </th>
										<th> Vendor Id </th>
                                        <th> Vendor Error Code </th>
										<th> Status Timestamp </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
										$Charger_id= $_REQUEST['charger_id'];
										$Con_id= $_REQUEST['con_id'];

                                        $s_no=0;
                                        $query1 = mysqli_query($con,"SELECT * FROM `connector_status` WHERE `connector_pk`=(SELECT `connector_pk` FROM `connector` WHERE `charge_box_id`='$Charger_id' and `connector_id`=$Con_id)  ORDER BY `connector_status`.`status_timestamp` DESC LIMIT 10");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $status = $row['status'];
                                            $error_code = $row['error_code'];
                                            $error_info = $row['error_info'];
                                            $vendor_id = $row['vendor_id'];
											$vendor_error_code = $row['vendor_error_code'];
                                            $status_timestamp = $row['status_timestamp'];
                      
                                            ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $status; ?></td>
                                                <td> <?php echo $error_code; ?></td>
                                                <td> <?php echo $error_info; ?></td>
                                                <td> <?php echo $vendor_id; ?></td>
                                                <td> <?php echo $vendor_error_code; ?></td>
                                                <td> <?php echo $status_timestamp; ?></td>
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