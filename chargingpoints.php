<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>


<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h4 style="color: #e41e1b;"> Charging Points </h4><br>
                        </div>
                    </div><br>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th style="text-align: right;" colspan="11"> <a href="addchargepoint.php" style="color: white;"> <button type="button" name="add" class="btn btn-info"> Add Charging Point </button> </a></th>
                                    </tr>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Chargepoint Name </th>
                                        <th> Access Type </th>
                                        <th> QR Code </th>
                                        <th> EVSE Type </th>
                                        <th> Max Power </th>
                                        <th> Network </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,"select * from chargepoints_mani where cms='chargengo'");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;

                                            $chargepoint_name = $row['chargepoint_name'];
                                            $access_type = $row['access_type'];
                                            $qr_code_id = $row['qr_code_id'];
                                            $evse_type = $row['evse_type'];
                                            $max_power = $row['max_power'];
                                            $network = $row['network'];

                                            ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $chargepoint_name; ?></td>
                                                <td> <?php echo $access_type; ?></td>
                                                <td> <?php echo $qr_code_id; ?></td>
                                                <td> <?php echo $evse_type; ?></td>
                                                <td> <?php echo $max_power; ?></td>
                                                <td> <?php echo $network; ?></td>
                                                <td> 
                                                    <!-- <a href="editchargepoint.php?id=<?php echo $chargepoint_name;?>"> <i class="dw dw-edit2"></i> </a> --> &nbsp; &nbsp;
                                                    <!-- <a href="#" id="<?php echo $row["chargepoint_name"]; ?>" class="view_data"> <i class="dw dw-eye"></i> </a> --> &nbsp; &nbsp;
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

                            <script>    
                                $(document).ready(function()
                                {  
                                    $('.view_data').click(function()
                                    {  
                                       var chargepoint_name = $(this).attr("id");  
                                       $.ajax({  
                                            url:"chargepointmodal.php",  
                                            method:"post",  
                                            data:{chargepoint_name : chargepoint_name},  
                                            success:function(data)
                                            {  
                                                $('#chargepoint_details').html(data);  
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