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
                            <h4 style="color: #e41e1b;"> Charging Networks </h4><br>
                        </div>
                    </div><br>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th style="text-align: right;" colspan="11"><a href="addnetwork.php" style="color: white;"> <button type="button" name="add" class="btn btn-info">  Add Network </button> </a></th>
                                    </tr>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Network Name </th>
                                        <th> Company Name </th>
                                        <th> Address </th>
                                        <th> City & State </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,"select * from client_registration where cms='chargengo'");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $network_id = $row['network_id'];
                                            $network_name = $row['client_name'];
                                            $company_name = $row['company_name'];
                                            $address = $row['address'];
                                            $city = $row['city'];
                                            $state = $row['state'];

                                            ?>
                                            <tr id="<?php echo $row['network_id'] ?>">
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $network_name; ?>
                                                <td> <?php echo $company_name; ?></td>
                                                <td> <?php echo $address; ?></td>
                                                <td> <?php echo $city.", ".$state; ?></td>
                                                <td> 
                                                    <a href="editnetwork.php?id=<?php echo $network_id;?>"> <i class="dw dw-edit2"></i> </a> &nbsp; &nbsp;
                                                    <a href="#" id="<?php echo $row["network_id"]; ?>" class="view_data"> <i class="dw dw-eye"></i> </a> &nbsp; &nbsp;
                                                    <!-- <a class="remove" style="cursor: pointer;"> --><i class="dw dw-trash" style="color: red;"></i><!-- </a> -->
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
                                            <h5 class="modal-title"> Network Details</h5>  
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>  
                                        <div class="modal-body" id="network_details"></div>  
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
                                       var network_id = $(this).attr("id");  
                                       $.ajax({  
                                            url:"modal.php",  
                                            method:"post",  
                                            data:{network_id : network_id},  
                                            success:function(data)
                                            {  
                                                $('#network_details').html(data);  
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
                    url: 'networkdelete.php',
                    type: 'GET',
                    data: {id: id},
                    error: function()
                    {
                        alert('Something is wrong');
                    },
                    success: function(data)
                    {
                        $("#"+id).remove();
                        alert("Network removed successfully");  
                    }
                });
            }
        });
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