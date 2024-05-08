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
                            <h4 style="color: #3d56d8;"> CPO List </h4><br>
                        </div>
                    </div><br>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th><a class="btn btn-primary" href="javascript:void(0)" style="background-color: #3d56d8; color: white;" onclick="report()">Report</a></th>
                                        <th style="text-align: right;" colspan="11"><a href="addcpo" style="color: white;"> <button type="button" name="add" class="btn btn-info">  Add CPO </button> </a></th>
                                    </tr>
                                    
                                    <tr>
                                        <th> S.No </th>
                                        <th> CPO Name </th>
                                        <th> Total Stations </th>
                                        <th> Total Chargers </th>
                                        <th> Total Connectors </th>
                                        <!--<th> Live Connectors </th>-->
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        if(isset($_REQUEST['cms_id']))
                                        {
                                            $cms_id = $_REQUEST['cms_id'];
                                            $query1 = mysqli_query($connect,"select cpo_id, cpo_name from fca_cpo where cms_id = '$cms_id'");
                                            while($row = mysqli_fetch_array($query1))
                                            {
                                                $s_no++;
                                                $cpo_id = $row['cpo_id'];
                                                $cpo_name = $row['cpo_name'];
                                                                                            
                                                $query2 = mysqli_query($connect, "select count(con_id) from fca_connectors where charger_id IN (select charger_id from fca_charger where station_id IN (select station_id from fca_stations where cpo_id = '$cpo_id'))");
                                                $row2 = mysqli_fetch_array($query2);
                                                $total_connectors = $row2[0];
                                                
                                                $query3 = mysqli_query($connect, "select count(station_id) from fca_stations where cpo_id = '$cpo_id'");
                                                $fetch3 = mysqli_fetch_array($query3);
                                                $total_stations = $fetch3[0];

                                                $query4 = mysqli_query($connect, "select count(charger_id) from fca_charger where station_id in (select station_id from fca_stations where cpo_id = '$cpo_id')");
                                                $fetch4 = mysqli_fetch_array($query4);
                                                $total_chargers = $fetch4[0];

                                                $query5 = mysqli_query($connect, "select count(con_id) from fca_connector_status where charger_id IN (select charger_id from fca_charger where station_id IN (select station_id from fca_stations where cpo_id = '$cpo_id')) and meter_status = 1");
                                                $row5 = mysqli_fetch_array($query5);
                                                $live_connectors = $row5[0];
                                                

                                                ?>
                                                <tr id="<?php echo $row['cpo_id'] ?>">
                                                    <td> <?php echo $s_no; ?></td>
                                                    <td> <?php echo $cpo_name; ?></td>
                                                    <td> <?php echo $total_stations; ?></td>
                                                    <td> <?php echo $total_chargers; ?></td>
                                                    <td> <?php echo $total_connectors; ?></td>
                                                    <!--<td> <?php echo $live_connectors; ?></td>-->
                                                    <td> 
                                                        <!--<a href="editcpo.php?id=<?php echo $cpo_id; ?>"> <i class="dw dw-edit2"></i> </a> &nbsp; &nbsp; -->
                                                        <a href="#" id="<?php echo $row["cpo_id"]; ?>" class="view_data"> <i class="dw dw-eye"></i> </a> &nbsp; &nbsp;
                                                        <!-- <a class="remove" style="cursor: pointer;"> <i class="dw dw-trash" style="color: red;"></i> </a> -->
                                                    </td>
                                                </tr>
                                                <?php
                                            }                                            
                                        }
                                        else
                                        {
                                            $query1 = mysqli_query($connect,"select cpo_id, cpo_name from fca_cpo");
                                            while($row = mysqli_fetch_array($query1))
                                            {
                                                $s_no++;
                                                $cpo_id = $row['cpo_id'];
                                                $cpo_name = $row['cpo_name'];
                                                                                            
                                                $query2 = mysqli_query($connect, "select count(con_id) from fca_connectors where charger_id IN (select charger_id from fca_charger where station_id IN (select station_id from fca_stations where cpo_id = '$cpo_id'))");
                                                $row2 = mysqli_fetch_array($query2);
                                                $total_connectors = $row2[0];
                                                
                                                $query3 = mysqli_query($connect, "select count(station_id) from fca_stations where cpo_id = '$cpo_id'");
                                                $fetch3 = mysqli_fetch_array($query3);
                                                $total_stations = $fetch3[0];

                                                $query4 = mysqli_query($connect, "select count(charger_id) from fca_charger where station_id in (select station_id from fca_stations where cpo_id = '$cpo_id')");
                                                $fetch4 = mysqli_fetch_array($query4);
                                                $total_chargers = $fetch4[0];

                                                $query5 = mysqli_query($connect, "select count(con_id) from fca_connector_status where charger_id IN (select charger_id from fca_charger where station_id IN (select station_id from fca_stations where cpo_id = '$cpo_id')) and meter_status = 1");
                                                $row5 = mysqli_fetch_array($query5);
                                                $live_connectors = $row5[0];
                                                

                                                ?>
                                                <tr id="<?php echo $cpo_id ?>">
                                                    <td> <?php echo $s_no; ?></td>
                                                    <td> <?php echo $cpo_name; ?>
                                                    <td> <?php echo $total_stations; ?></td>
                                                    <td> <?php echo $total_chargers; ?></td>
                                                    <td> <?php echo $total_connectors; ?></td>
                                                    <!--<td> <?php echo $live_connectors; ?></td>-->
                                                    <td> 
                                                        <!-- <a href="editcpo.php?id=<?php echo $cpo_id; ?>"> <i class="dw dw-edit2"></i> </a> &nbsp; &nbsp; -->
                                                        <a href="#" id="<?php echo $row["cpo_id"]; ?>" class="view_data"> <i class="dw dw-eye"></i> </a> &nbsp; &nbsp;
                                                        <!-- <a class="remove" style="cursor: pointer;"> <i class="dw dw-trash" style="color: red;"></i> </a> -->
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }

                                    ?>
                                </tbody>
                            </table>
                            

                            <div id="dataModal" class="modal fade">  
                                <div class="modal-dialog">  
                                    <div class="modal-content">  
                                        <div class="modal-header">    
                                            <h5 class="modal-title"> CPO Details</h5>  
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>  
                                        <div class="modal-body" id="cpo_details"></div>  
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
                                       var cpo_id = $(this).attr("id");  
                                       $.ajax({  
                                            url:"cpomodal.php",  
                                            method:"post",  
                                            data:{cpo_id : cpo_id},  
                                            success:function(data)
                                            {  
                                                $('#cpo_details').html(data);  
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


    <script type="text/javascript">
        $(".remove").click(function()
        {
            var id = $(this).parents("tr").attr("id");
            if(confirm('Are you sure to Delete this network ?'))
            {
                $.ajax({
                    url: 'cpodelete.php',
                    type: 'GET',
                    data: {id: id},
                    error: function()
                    {
                        alert('Something is wrong');
                    },
                    success: function(data)
                    {
                        $("#"+id).remove();
                        alert("CPO removed successfully");  
                    }
                });
            }
        });
    </script>
<script>
    function report()
    {
        window.location.href="cpo_excel.php?";
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