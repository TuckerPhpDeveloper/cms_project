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
                            <h4 style="color: #3d56d8;"> CMS List </h4><br>
                        </div>
                    </div><br>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th><a class="btn btn-primary" href="javascript:void(0)" style="background-color: #3d56d8; color: white;" onclick="report()">Report</a></th>
                                        <th style="text-align: right;" colspan="11"><a href="addcms" style="color: white;"> <button type="button" name="add" class="btn btn-info">  Add CMS </button> </a></th>
                                    </tr>
                                    
                                    <tr>
                                        <th> S.No </th>
                                        <th> CMS Name </th>
                                        <th> Total CPO </th>
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
                                        $query1 = mysqli_query($connect,"select cms_id, name from fca_cms_login");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $cms_id = $row['cms_id'];
                                            $cms_name = $row['name'];

                                            $query2 = mysqli_query($connect, "select count(cpo_id) from fca_cpo where cms_id = '$cms_id' ");
                                            $fetch2 = mysqli_fetch_array($query2);
                                            $total_cpo = $fetch2[0];

                                            $query3 = mysqli_query($connect, "select count(station_id) from fca_stations where cpo_id IN (select cpo_id from fca_cpo where cms_id = '$cms_id') ");
                                            $fetch3 = mysqli_fetch_array($query3);
                                            $total_stations = $fetch3[0];

                                            $query4 = mysqli_query($connect, "select count(charger_id) from fca_charger where station_id in (select station_id from fca_stations where cpo_id IN (select cpo_id from fca_cpo where cms_id = '$cms_id'))");
                                            $fetch4 = mysqli_fetch_array($query4);
                                            $total_chargers = $fetch4[0];

                                            $query5 = mysqli_query($connect, "select count(con_id) from fca_connectors where charger_id IN (select charger_id from fca_charger where station_id IN (select station_id from fca_stations where cpo_id IN (select cpo_id from fca_cpo where cms_id = '$cms_id' ))) ");
                                            $fetch5 = mysqli_fetch_array($query5);
                                            $total_connectors = $fetch5[0];

                                            $query6 = mysqli_query($connect, "select count(con_id) from fca_connector_status where charger_id IN (select charger_id from fca_charger where station_id IN (select station_id from fca_stations where cpo_id IN (select cpo_id from fca_cpo where cms_id = '$cms_id'))) and meter_status = 1");
                                            $fetch6 = mysqli_fetch_array($query6);
                                            $live_connectors = $fetch6[0];

                                            ?>
                                            <tr id="<?php echo $cms_id ?>">
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $cms_name; ?></td>
                                                <td> <?php echo $total_cpo; ?></td>
                                                <td> <?php echo $total_stations; ?></td>
                                                <td> <?php echo $total_chargers; ?></td>
                                                <td> <?php echo $total_connectors; ?></td>
                                                <!--<td> <?php echo $live_connectors; ?></td>-->
                                                <td> 
                                                     <!--<a href="editcms.php?id=<?php echo $cms_id; ?>"> <i class="dw dw-edit2"></i> </a> &nbsp; &nbsp;-->
                                                    <a href="#" id="<?php echo $row["cms_id"]; ?>" class="view_data"> <i class="dw dw-eye"></i> </a> &nbsp; &nbsp;
                                                    <a href="cpo.php?cms_id=<?php echo $cms_id; ?>"> <i class="dw dw-login"></i> </a> &nbsp; &nbsp;
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
                                            <h5 class="modal-title"> CMS Details</h5>  
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>  
                                        <div class="modal-body" id="cms_details"></div>  
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
                                       var cms_id = $(this).attr("id");  
                                       $.ajax({  
                                            url:"cmsmodal.php",  
                                            method:"post",  
                                            data:{cms_id : cms_id},  
                                            success:function(data)
                                            {  
                                                $('#cms_details').html(data);  
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
                    url: 'cmsdelete.php',
                    type: 'GET',
                    data: {id: id},
                    error: function()
                    {
                        alert('Something is wrong');
                    },
                    success: function(data)
                    {
                        $("#"+id).remove();
                        alert("CMS removed successfully");  
                    }
                });
            }
        });
    </script>
<script>
    function report()
    {
        window.location.href="cms_excel.php?";
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