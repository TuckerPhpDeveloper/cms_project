<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>
<?php include 'include/steve_connection.php'; ?>

<?php
    $con_id = $_REQUEST['con_id'];

    $query1 = mysqli_query($connect, "select * from fca_view_qr_scan where  con_id = '$con_id' ");
    $fetch1 = mysqli_fetch_array($query1);
    $charger_id = $fetch1['charger_id'];
    $con_no = $fetch1['con_no'];
$querystring3 = "SELECT * FROM `GetHistory` WHERE  `charge_box_id`='$charger_id' and `connector_id`=$con_no and`stop_value` IS NULL ORDER BY `start_timestamp` DESC";
                                            $query3 = mysqli_query($con,$querystring3);
                                            if (mysqli_num_rows($query3) > 0) {
                                              $meter_status='1';
                                                
                                            } else {
                                                $meter_status='0';
                                                
                                            }
                                            

    $query3 = mysqli_query($connect, "select cpo_name from fca_cpo where cpo_id in (select cpo_id from fca_stations where station_id in (select station_id from fca_charger where charger_id = '$charger_id') )");
    $fetch3 = mysqli_fetch_array($query3);
    $cpo_name = $fetch3[0];

    $query4 = mysqli_query($connect, "select station_name from fca_stations where station_id in (select station_id from fca_charger where charger_id = '$charger_id')");
    $fetch4 = mysqli_fetch_array($query4);
    $station_name = $fetch4[0];

    $query5 = mysqli_query($connect, "select gst_fare, base_fare, unit_fare from fca_charger_payment where charger_id = '$charger_id'");
    $fetch5 = mysqli_fetch_array($query5);
    $gst_fare = $fetch5[0];
    $base_fare = $fetch5[1];
    $unit_fare = $fetch5[2];

    $query6 = mysqli_query($connect, "SELECT `ActualVoltage`,`ActualCurrent` FROM `fca_charger_parameters` WHERE `charger_id`=(SELECT `charger_id` FROM `fca_connectors` WHERE `con_id`='$con_id')");
    $fetch6 = mysqli_fetch_array($query6);
    $voltage = $fetch6[0];
    $current = $fetch6[1];

    $status = $_REQUEST['status'];
    $newTime = strtotime('-330 minutes');
    $currentdate = date('Y-m-d H:i:s', $newTime);

    if(isset($_REQUEST['status']))
    {
        $idtag = $_POST['idtag'];
        $unit = $_POST['unit'];
        
        $totalcost = ($unit * $unit_fare) + $base_fare;
        $totalcost = $totalcost + ($totalcost * ($gst_fare/100));
        $amount = $totalcost;


        $transaction_id = $_POST['transaction_id'];


        if($status == '1' && $meter_status == '0')
        {
            echo $buttonlink = "http://tucker.bigtot.in/internal_call.php?key=tuckermotors&cmd=RemoteStartTransaction&ChargeBoxID=$charger_id&ConnectorID=$con_id&idTag=$idtag";
                   $file = file_get_contents($buttonlink);
                   echo "<script>
                            alert('Start Command is on progress' $file); 
                        </script>";                             
        }
        else if($status == '2' && $meter_status == '1')
        {
            $buttonlink = "http://tucker.bigtot.in/internal_call.php?key=tuckermotors&cmd=RemoteStopTransaction&ChargeBoxID=$charger_id&ConnectorID=$con_id&idTag=$idtag";
            $file = file_get_contents($buttonlink);

                 echo "<script> 
                        alert('Stop Command is on progress'$file);
                    </script>";                            
        }
    }
    else
    {
    }

?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/jquery-steps/jquery.steps.css">
<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>


<style type="text/css">
    .main-container
    {
        font-family: 'Poppins';
    }
</style>

    <script src="http://code.jquery.com/jquery-latest.js"></script> 


    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                
                <div class="pd-20 card-box mb-30">
                  
                    <div class="clearfix">
                        <h4 style="color: #e41e1b;"> Connector Id - <?php echo $con_id; ?></h4><br>
                    </div>
                    <div class="wizard-content">
                    
                        <section>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;" colspan="6"> Connector Details </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th> CPO Name </th>
                                                <th> Station Name </th>
                                                <th> Charge Point ID </th>
                                                <th> Connector ID </th>
                                                <th> Remote Commands </th>
                                            </tr>
                                            <tr>
                                                <td> <?php echo $cpo_name; ?> </td>
                                                <td> <?php echo $station_name; ?> </td>
                                                <td> <?php echo $charger_id; ?> </td>
                                                <td> <?php echo $con_id; ?> </td>
                                                <td>
                                                    <?php
                                                        if($meter_status == '0')
                                                        {
                                                            ?> 
                                                                <button id="<?php echo $con_id; ?>" class="btn btn-success btn-sm start"> Start </button>
                                                                <button id="<?php echo $con_id; ?>" class="btn btn-danger btn-sm stop" style="cursor:not-allowed;" disabled> Stop </button>
                                                            <?php
                                                        }
                                                        else if($meter_status == '1')
                                                        {
                                                            ?>
                                                                <button id="<?php echo $con_id; ?>" class="btn btn-success btn-sm start" style="cursor:not-allowed;" disabled> Start </button>
                                                                <button id="<?php echo $con_id; ?>" class="btn btn-danger btn-sm stop"> Stop </button>
                                                            <?php 
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                               
                                <div id="dataModal" class="modal fade">  
                                    <div class="modal-dialog">  
                                        <div class="modal-content">  
                                            <div class="modal-header">    
                                                <h5 class="modal-title"> Send Start command to connector : <?php echo $con_id; ?> </h5>  
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>  
                                            <div class="modal-body" id="start_details"></div>  
                                        </div>  
                                    </div>  
                                </div>  

                                <div id="dataModal2" class="modal fade">  
                                    <div class="modal-dialog">  
                                        <div class="modal-content">  
                                            <div class="modal-header">    
                                                <h5 class="modal-title"> Send Stop command to connector : <?php echo $con_id; ?> </h5>  
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>  
                                            <div class="modal-body" id="stop_details"></div>  
                                        </div>  
                                    </div>  
                                </div> 

                            <script>    
                                $(document).ready(function()
                                {  
                                    $('.start').click(function()
                                    {  
                                       var con_id = $(this).attr("id");  
                                       $.ajax({  
                                            url:"startmodal.php",  
                                            method:"post",  
                                            data:{con_id : con_id},  
                                            success:function(data)
                                            {  
                                                $('#start_details').html(data);  
                                                $('#dataModal').modal("show");  
                                            }  
                                       });  
                                    });  
                                });  
                            </script>


                            <script>    
                                $(document).ready(function()
                                {  
                                    $('.stop').click(function()
                                    {  
                                       var con_id = $(this).attr("id");  
                                       $.ajax({  
                                            url:"stopmodal.php",  
                                            method:"post",  
                                            data:{con_id : con_id},  
                                            success:function(data)
                                            {  
                                                $('#stop_details').html(data);  
                                                $('#dataModal2').modal("show");  
                                            }  
                                       });  
                                    });  
                                });  
                            </script>

                        </section>
                            
                    </div>
                   
                </div>

            </div>
        </div>
    </div>





    <!-- js -->
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>


    <script src="src/plugins/jquery-steps/jquery.steps.js"></script>
    <script src="vendors/scripts/steps-setting.js"></script>

</body>
</html>