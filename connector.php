<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>

<?php
    $con_id = $_REQUEST['con_id'];

    $query1 = mysqli_query($connect, "select * from fca_charger where charger_id  in (select charger_id from fca_connectors where con_id = '$con_id') ");
    $fetch1 = mysqli_fetch_array($query1);
    $charger_id = $fetch1['charger_id'];
    $charger_qr_code = $fetch1['charger_qr_code'];
    $shared_home_db = $fetch1['shared/home'];
    if($shared_home_db == '1')
    {
        $shared_home = "Home Charger";
    }
    else
    {
        $shared_home = "Shared Charger";
    }
    $cpo_ws_link = $fetch1['cpo_ws_link'];
    $charger_ws_link = $fetch1['charger_ws_link'];
    $server_ip = $fetch1['server_ip'];

    $query2 = mysqli_query($connect, "select * from fca_charger_payment where charger_id  in (select charger_id from fca_connectors where con_id = '$con_id') and enable_bit = 1");
    $fetch2 = mysqli_fetch_array($query2);
    $base_fare = $fetch2['base_fare'];
    $unit_fare = $fetch2['unit_fare'];
    $time_fare = $fetch2['time_fare'];
    $reservation_fare = $fetch2['reservation_fare'];

    $query3 = mysqli_query($connect, "select * from fca_charger_spec where charger_id  in (select charger_id from fca_connectors where con_id = '$con_id') ");
    $fetch3 = mysqli_fetch_array($query3);
    $kw = $fetch3['kw'];
    $phase = $fetch3['phases'];
    $network_type = $fetch3['network_type'];

    $query4 = mysqli_query($connect, "select * from fca_connectors where con_id = '$con_id'");
    $fetch4 = mysqli_fetch_array($query4);
    $con_qr_code = $fetch4['con_qr_code'];
    $con_type = $fetch4['con_type'];
    $con_format = $fetch4['con_format'];
    $charging_current = $fetch4['charging_current'];
    $power_capacity = $fetch4['power_capacity'];

    $query5 = mysqli_query($connect, "select * from fca_connector_status where con_id = '$con_id'");
    $fetch5 = mysqli_fetch_array($query5);
    $status = $fetch5['status_notification'];


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
                        <h4 style="color: #3d56d8;"> Connector Id - <?php echo $con_id; ?> &nbsp; <a href="editconnector.php?con_id=<?php echo $con_id; ?>" style="font-size: 20px;"> <i class="fa fa-pencil"></i> Edit </a></h4><br>
                    </div>
                    <div class="wizard-content">
                    
                        <section>
                            <div class="row">
                                <div class="col-sm-6">
                                    <table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;" colspan="3"> Charger Details </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> Charger ID </td>
                                                <td> <?php echo $charger_id; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Charger QR Code </td>
                                                <td> <?php echo $charger_qr_code; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Shared / Home </td>
                                                <td> <?php echo $shared_home; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Server IP </td>
                                                <td> <?php echo $server_ip; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> CPO WS Link </td>
                                                <td> <?php echo $cpo_ws_link; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Charger WS Link </td>
                                                <td> <?php echo $charger_ws_link; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Base Fare </td>
                                                <td> Rs. <?php echo $base_fare; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Unit Fare </td>
                                                <td> Rs. <?php echo $unit_fare; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Time Fare </td>
                                                <td> Rs. <?php echo $time_fare; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Reservation Fare </td>
                                                <td> Rs. <?php echo $reservation_fare; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> KW </td>
                                                <td> <?php echo $kw; ?> KW </td>
                                            </tr>
                                            <tr>
                                                <td> Phase </td>
                                                <td> <?php echo $phase; ?> Phase </td>
                                            </tr>
                                            <tr>
                                                <td> Network Type </td>
                                                <td> <?php echo $network_type; ?> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table class='table table-bordered'>
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;" colspan="3"> Connector Details </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> Connector ID </td>
                                                <td> <?php echo $con_id; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Connector QR Code </td>
                                                <td> <?php echo $con_qr_code; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Connector Type </td>
                                                <td> <?php echo $con_type; ?></td>
                                            </tr>
                                            <tr>
                                                <td> Format </td>
                                                <td> <?php echo $con_format; ?> </td>
                                            </tr>
                                            <tr>
                                                <td> Charging Current </td>
                                                <td> <?php echo $charging_current; ?> A</td>
                                            </tr>
                                            <tr>
                                                <td> Power Capacity </td>
                                                <td> <?php echo $power_capacity; ?> KW </td>
                                            </tr>
                                            <tr>
                                                <td> Status </td>
                                                <td> <?php echo $status; ?> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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