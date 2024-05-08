<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>

<?php
    /*$con_id = $_REQUEST['con_id'];

    $query1 = mysqli_query($connect, "select * from fca_charger where charger_id  in (select charger_id from fca_connectors where con_id = '$con_id') ");
    $fetch1 = mysqli_fetch_array($query1);
    $charger_id = $fetch1['charger_id'];
    $charger_qr_code = $fetch1['charger_qr_code'];
    $shared_home = $fetch1['shared/home'];
    $cpo_ws_link = $fetch1['cpo_ws_link'];
    $charger_ws_link = $fetch1['charger_ws_link'];

    $query2 = mysqli_query($connect, "select * from fca_charger_payment where charger_id in (select charger_id from fca_connectors where con_id = '$con_id') and enable_bit = '1'");
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
    $heartbeat_interval = $fetch3['heartbeat_interval'];
    $metervalues_interval = $fetch3['metervalues_interval'];
    $manufacturing_date = $fetch3['manufacturing_date'];

    $query4 = mysqli_query($connect, "select * from fca_connectors where con_id = '$con_id'");
    $fetch4 = mysqli_fetch_array($query4);
    $con_qr_code = $fetch4['con_qr_code'];
    $con_type = $fetch4['con_type'];
    $con_format = $fetch4['con_format'];
    $charging_current = $fetch4['charging_current'];
    $charging_voltage = $fetch4['charging_voltage'];
    $power_capacity = $fetch4['power_capacity'];

    $query5 = mysqli_query($connect, "select * from fca_connector_status where con_id = '$con_id'");
    $fetch5 = mysqli_fetch_array($query5);
    $status = $fetch5[0];*/
    $charger_id = $_REQUEST['con_id'];
    
   $query1 = mysqli_query($connect, "select * from fca_charger where charger_id  ='$charger_id' ");
    $fetch1 = mysqli_fetch_array($query1);
    $charger_qr_code = $fetch1['charger_qr_code'];
    $shared_home = $fetch1['shared/home'];
    $cpo_ws_link = $fetch1['cpo_ws_link'];
    $charger_ws_link = $fetch1['charger_ws_link'];

    $query2 = mysqli_query($connect, "select * from fca_charger_payment where charger_id ='$charger_id' and enable_bit = '1'");
    $fetch2 = mysqli_fetch_array($query2);
    $base_fare = $fetch2['base_fare'];
    $unit_fare = $fetch2['unit_fare'];
    $time_fare = $fetch2['time_fare'];
    $reservation_fare = $fetch2['reservation_fare'];

    $query3 = mysqli_query($connect, "select * from fca_charger_spec where charger_id='$charger_id'");
    $fetch3 = mysqli_fetch_array($query3);
    $kw = $fetch3['kw'];
    $phase = $fetch3['phases'];
    $network_type = $fetch3['network_type'];
    $heartbeat_interval = $fetch3['heartbeat_interval'];
    $metervalues_interval = $fetch3['metervalues_interval'];
    $manufacturing_date = $fetch3['manufacturing_date'];
    $no_of_connectors = $fetch3['no_of_connectors'];

$inc=0;
    $query4 = mysqli_query($connect, "select * from fca_connectors where charger_id='$charger_id'");
     while ( $fetch4 = mysqli_fetch_array($query4)) {
    $con_qr_code = $fetch4['con_qr_code'];
	if($inc!=0)$con_id.=','.$con_qr_code;
	else $con_id.=$con_qr_code;
    $con_type[] = $fetch4['con_type'];
    $con_format[] = $fetch4['con_format'];
    $charging_current[] = $fetch4['charging_current'];
    $charging_voltage[] = $fetch4['charging_voltage'];
    $power_capacity[] = $fetch4['power_capacity'];
    			 $inc++;

     }

    $query5 = mysqli_query($connect, "select * from fca_connector_status where charger_id='$charger_id'");
     while ($fetch5 = mysqli_fetch_array($query5)) {
    $status[] = $fetch5[0];
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
                
<?php
    if(isset($_POST['submit']))
    {
        $station = $_POST['station'];
        $shared_home_update = $_POST['shared_home'];
        $network_type_update = $_POST['network_type'];
        $heartbeat_interval_update = $_POST['heartbeat_interval'];
        $metervalues_interval_update = $_POST['metervalues_interval'];

        $base_fare_update = $_POST['base_fare'];
        $unit_fare_update = $_POST['unit_fare'];
        $time_fare_update = $_POST['time_fare'];
        $reservation_fare_update = $_POST['reservation_fare'];

        $charging_current_update = $_POST['charging_current'];
        $charging_voltage_update = $_POST['charging_voltage'];

        $update_query1 = mysqli_query($connect, "UPDATE `fca_charger` SET `station_id`='$station',`shared/home`='$shared_home_update',`status`=0,`last_updated_time`=now() WHERE charger_id = '$charger_id'");

        $update_query2 = mysqli_query($connect, "UPDATE `fca_charger_spec` SET `heartbeat_interval`='$heartbeat_interval_update',`metervalues_interval`='$metervalues_interval_update',`network_type`='$network_type_update' WHERE charger_id = '$charger_id'");

        $update_query3 = mysqli_query($connect, "UPDATE `fca_charger_payment` SET `enable_bit`=0 WHERE charger_id = '$charger_id'");

        $update_query4 = mysqli_query($connect, "INSERT INTO `fca_charger_payment`(`charger_id`, `gst_fare`, `base_fare`, `unit_fare`, `time_fare`, `reservation_fare`, `enable_bit`) VALUES ('$charger_id', '18', '$base_fare_update', '$unit_fare_update', '$time_fare_update', '$reservation_fare_update', 1) ");

        $update_query5 = mysqli_query($connect, "UPDATE `fca_connectors` SET `charging_current`='$charging_current_update', `charging_voltage`='$charging_voltage_update' WHERE con_id = '$con_id'");

        if($update_query1 && $update_query2 && $update_query3 && $update_query4 && $update_query5)
        {
            ?>
            <script type="text/javascript">
                setTimeout(function ()
                {
                   window.location.href= 'dashboard.php';
                }, 2000);
                alert("Charger & Connector Details are updated");
            </script>
            <?php
        }
        else
        {
            ?>
            <script type="text/javascript">
                setTimeout(function ()
                {
                   window.location.href= 'editconnector.php?con_id=<?php echo $con_id; ?>';
                }, 2000);
                alert("Invalid information. Please Check the fields value");
            </script>
            <?php
        }
    }
?>
                <div class="pd-20 card-box mb-30">
                  
                    <div class="clearfix">
                        <h5 style="color: #3d56d8;"> Charger id - <span style="font-size: 18px;"><?php echo $charger_id; ?></span> </h5><br>
                    </div>
                    <div class="wizard-content">
                    
                            <section>
                                <form method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                       <div class="form-group">
                                                <label> STATION : <span class="text-danger">(*)</span> </label>
                                                <select name="station" id="station" class="form-control" data-live-search="true">
                                                    <option value=""> Select STATION </option>
                                                    <?php
                                                        $result = mysqli_query($connect, "SELECT * FROM fca_stations");
                                                        while($row = mysqli_fetch_array($result))
                                                        {
                                                            ?><option value="<?php echo $row['station_id']; ?>"><?php echo $row["station_name"];?></option><?php
                                                        }
                                                    ?>
                                                </select>
                                                <span id="error_cpo_name" class="text-danger"></span>
                                            </div><br>
                                        <div class="form-group">
                                            <label> Shared / Home </label>
                                            <select name="shared_home" id="shared_home" class="form-control">
                                                <option> Select Charger Type </option>
                                                <option value="2" <?php if($shared_home == '2') echo 'selected="selected"' ?> > Shared Charger </option>
                                                <option value="1" <?php if($shared_home == '1') echo 'selected="selected"' ?> > Home Charger </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Network Type </label>
                                            <select name="network_type" id="network_type" class="form-control">
                                                <option> Select Network Type </option>
                                                <option value="EWGG" <?php if($network_type == 'EWGG') echo 'selected="selected"' ?> > Ethernet + Wi-Fi + GPS/GPRS </option>
                                                <option value="EW" <?php if($network_type == 'EW') echo 'selected="selected"' ?> > Ethernet + Wi-Fi </option>
                                                <option value="EGG" <?php if($network_type == 'EGG') echo 'selected="selected"' ?> > Ethernet + GPS/GPRS </option>
                                                <option value="WGG" <?php if($network_type == 'WGG') echo 'selected="selected"' ?> > Wi-Fi + GPS/GPRS </option>
                                                <option value="GG" <?php if($network_type == 'GG') echo 'selected="selected"' ?> > GPS/GPRS </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Heartbeat Interval (Hrs) 1-5 </label>
                                            <input type="number" id="heartbeat_interval" name="heartbeat_interval" value="<?php echo $heartbeat_interval; ?>" class="form-control" max="5" min="1">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Meter Values Interval (Secs) 30-600 </label>
                                            <input type="number" id="metervalues_interval" name="metervalues_interval" value="<?php echo $metervalues_interval; ?>" class="form-control" max="600" min="30">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Base Fare </label>
                                            <input type="number" id="base_fare" name="base_fare" value="<?php echo $base_fare; ?>" class="form-control" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Unit Fare </label>
                                            <input type="number" id="unit_fare" name="unit_fare" value="<?php echo $unit_fare; ?>" class="form-control" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Time Fare </label>
                                            <input type="number" id="time_fare" name="time_fare" value="<?php echo $time_fare; ?>" class="form-control" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Reservation Fare </label>
                                            <input type="number" id="reservation_fare" name="reservation_fare" value="<?php echo $reservation_fare; ?>" class="form-control" min="0">
                                        </div>
                                    </div>
                                </div><br><br>


                                <h5 style="color: #3d56d8;"> Connector id - <span style="font-size: 18px;"><?php echo $con_id; ?></span>  </h5><br>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label> Connector Type </label>
                                            <?php for($i=0;$i<$no_of_connectors;$i++){ ?>
                                                <input type="text" value="<?php echo $con_type[$i]; ?>" class="form-control" disabled>
                                                 <?php } ?>
                                            

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label> Connector Format </label>
                                            <?php for($i=0;$i<$no_of_connectors;$i++){ ?>
                                                <input type="text" value="<?php echo $con_format[$i]; ?>" class="form-control" disabled>
                                                 <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Charging Current (A) </label>
                                            <?php for($i=0;$i<$no_of_connectors;$i++){ ?>
                                            <input type="text" id="charging_current" name="charging_current" value="<?php echo $charging_current[$i]; ?>" class="form-control">
                                                 <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Charging Voltage (V) </label>
                                             <?php for($i=0;$i<$no_of_connectors;$i++){ ?>
                                            <input type="text" id="charging_voltage" name="charging_voltage" value="<?php echo $charging_voltage[$i]; ?>" class="form-control">
                                                 <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label> Power Capacity (KW) </label>
                                              <?php for($i=0;$i<$no_of_connectors;$i++){ ?>
                                            <input type="text" id="power_capacity" name="power_capacity" value="<?php echo $power_capacity[$i]; ?>" class="form-control" disabled>
                                                 <?php } ?>
                                        </div>
                                    </div>
                                </div><br><br>


                                <div align="center">
                                    <input type="submit" name="submit" class="btn btn-info" value="Update" id="btn_details" />
                                </div>
                                   
                                </form>

                            </section>
                            
                    </div>
                   
                </div>

            </div>
        </div>
    </div>





<script>

$(document).ready(function()
{      
});

</script>




    <!-- js -->
    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>


    <script src="src/plugins/jquery-steps/jquery.steps.js"></script>
    <script src="vendors/scripts/steps-setting.js"></script>

</body>
</html>