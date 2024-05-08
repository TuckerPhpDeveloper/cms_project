<?php
  
  $connect = new PDO("mysql:host=103.83.81.25; dbname=bigtot_cms;", "bigtot_cms_user", "yvT8KJESGT@o");
  $connect1 = mysqli_connect("103.83.81.25","bigtot_cms_user","yvT8KJESGT@o","bigtot_cms") or die("Could Not Connect to Data Base".mysqli_error());


  date_default_timezone_set("Asia/Kolkata"); 
  $today = date("Y-m-d");


    $query = mysqli_query($connect1,"select * from `fca_charger` order by sno desc limit 1");
    if(mysqli_num_rows($query)>0)
    {
        while($row=mysqli_fetch_array($query))
        {
            $charger_id_db = $row['charger_id'];
            $iparr = explode("t", $charger_id_db);
            $charger_id_val = $iparr[1]+1; 
            $charger_id = $iparr[0]."t".$charger_id_val;
        }   
    }
    else
    {
        $charger_id_db = "ChargePoint";
        $iparr = explode("t", $charger_id_db); 
        $charger_id_val = "1";
        $charger_id = $iparr[0]."t".$charger_id_val;
    }

    // if(mysqli_num_rows($query)>0)
    // {
    //     while($row=mysqli_fetch_array($query))
    //     {
    //         $charger_id_db = $row['charger_id'];
    //         $iparr = split ("t", $charger_id_db);
    //         $charger_id_val = $iparr[1]+1; 
    //         $charger_id = $iparr[0].$charger_id_val;
    //     }   
    // }
    // else
    // {
    //     $charger_id_db = "ChargePoint";
    //     $iparr = split ("t", $charger_id_db); 
    //     $charger_id = $iparr[0]."1";
    // }

    // $con_query = mysqli_query($connect1,"select * from `fca_connectors` order by sno desc limit 1");
    // if(mysqli_num_rows($con_query)>0)
    // {
    //     while($row=mysqli_fetch_array($con_query))
    //     {
    //         $con_id_db = $row['con_id'];
    //         $iparr = split ("\_", $con_id_db);
    //         $con_id_val = $iparr[1]+1; 
    //         $con_id = $iparr[0]."_".$con_id_val;
    //     }   
    // }
    // else
    // {
    //     $con_id_db = "con_";
    //     $iparr = split ("\_", $con_id_db); 
    //     $con_id = $iparr[0]."_1";
    // }


    if(isset($_POST["charging_current"]))
    {    
        $station_id = $_POST["station"];
        $charger_qr_code = $_POST["charger_qr_code"];
        $shared_home = $_POST["shared_home"];
        $kw = $_POST["kw"];
        $phase = $_POST["phase"];
        $network_type = $_POST["network_type"];
        $heartbeat_interval = $_POST["heartbeat_interval"];
        $metervalues_interval = $_POST["metervalues_interval"];
        $manufacturing_date = $_POST["manufacturing_date"];
        //$amenities = $_POST["amenities"];
        $checkbox1=$_POST['amenities'];  
$chk="";  
foreach($checkbox1 as $chk1)  
   {  
      $chk .= $chk1."|";  
   }  
        $current = number_format($kw*1000/230,0);

        $base_fare = $_POST["base_fare"];
        $unit_fare = $_POST["unit_fare"];
        $time_fare = $_POST["time_fare"];
        $reservation_fare = $_POST["reservation_fare"];



        $query1 = mysqli_query($connect1,"INSERT INTO `fca_charger`(`station_id`,`charger_id`,`charger_qr_code`, `shared/home`, `server_ip`, `cpo_ws_link`, `charger_ws_link`, `status`,`last_updated_time`) VALUES ('$station_id','$charger_id', '$charger_qr_code', '$shared_home','183.83.184.240:9082','tuckermotors','$charger_id',0,now())");

        $query2 = mysqli_query($connect1, "INSERT INTO `fca_charger_parameters`(`charger_id`,`ActualVoltage`, `ActualCurrent`, `OverVoltage`, `UnderVoltage`, `OverCurrent`, `OverTemperature`, `50Temperature`, `25Temperature`) VALUES ('$charger_id', '230', '$current', '253.8', '207', '16', '17', '65', '68')");

        $query3 = mysqli_query($connect1, "INSERT INTO `fca_charger_payment`(`charger_id`, `gst_fare`, `base_fare`, `unit_fare`, `time_fare`, `reservation_fare`, `enable_bit`) VALUES ('$charger_id', '18', '$base_fare', '$unit_fare', '$time_fare', '$reservation_fare',1)");

        $query4 = mysqli_query($connect1, "INSERT INTO `fca_charger_spec`(`charger_id`, `chargepoint_serial_no`, `heartbeat_interval`, `metervalues_interval`, `manufacturing_date`, `amenities`, `kw`, `phases`, `integration_date`, `network_type`, `timezone_adjust`) VALUES ('$charger_id', '$charger_id', '$heartbeat_interval', '$metervalues_interval', '$manufacturing_date', '$chk', '$kw', '$phase', '$today', '$network_type','19800') ");


        for($count = 0; $count < count($_POST["charging_current"]); $count++)
        {
            $count_value = $count + 1;
            $connector_id = $charger_id_val.$count_value;
            $data = array(':connector_id' => $charger_id_val.$count_value,
                          // ':connector_qr_code' => $_POST["connector_qr_code"][$count],
                          ':connector_type' => $_POST["connector_type"][$count],
                          ':format' => $_POST["format"][$count],
                          // ':power_capacity' => $_POST['power_capacity'][$count],
                          ':charging_current'   => $_POST["charging_current"][$count],
                        ':charging_voltage'   => $_POST["charging_voltage"][$count]);

            $con_ins_query = "INSERT INTO `fca_connectors`(`con_id`,`charger_id`,`con_no`, `con_qr_code`,`con_type`,`con_format`,`charging_current`, `charging_voltage`, `power_capacity`, `max_power`) VALUES (:connector_id, '$charger_id', '$count_value',$charger_qr_code', :connector_type, :format, :charging_current,:charging_voltage, '$kw', '$kw')";
            $statement = $connect->prepare($con_ins_query);
            $statement->execute($data);

            $con_ins_query1 = mysqli_query($connect1, "INSERT INTO `fca_connector_status`(`con_id`, `charger_id`, `reserve_status`, `cancel_reserve`, `meter_value`, `start`, `stop`, `availability`, `change_availability`, `meter_status`, `status_notification`) VALUES ('$connector_id','$charger_id',0,0,0,0,0,1,0,0,'Available')");
            // $statement1 = $connect->prepare($con_ins_query1);
            // $statement1->execute($data);
$con_type_db = $_POST['connector_type'][$count];
            if($con_type_db == 'CHAdeMo')
            {
                $iec60309 = 0;
                $actype2 = 0;
                $chademo = 1;
                $gbt = 0;
                $ccs2 = 0;
                $ft15askt = 0;
            }
            else if($con_type_db == 'CCS2')
            {
                $iec60309 = 0;
                $actype2 = 0;
                $chademo = 0;
                $gbt = 0;
                $ccs2 = 1;
                $ft15askt = 0;
            }
            else if($con_type_db == 'GBT')
            {
                $iec60309 = 0;
                $actype2 = 0;
                $chademo = 0;
                $gbt = 1;
                $ccs2 = 0;
                $ft15askt = 0;
            }
            else if($con_type_db == 'ACTYPE2')
            {
                $iec60309 = 0;
                $actype2 = 1;
                $chademo = 0;
                $gbt = 0;
                $ccs2 = 0;
                $ft15askt = 0;
            }
            else if($con_type_db == 'IEC60309')
            {
                $iec60309 = 1;
                $actype2 = 0;
                $chademo = 0;
                $gbt = 0;
                $ccs2 = 0;
                $ft15askt = 0;
            }
            else if($con_type_db == 'FT15ASKT')
            {
                $iec60309 = 0;
                $actype2 = 0;
                $chademo = 0;
                $gbt = 0;
                $ccs2 = 0;
                $ft15askt = 1;
            }
            else
            {
                $iec60309 = $actype2 = $chademo = $gbt = $ccs2 = $ft15askt = 0;
            }

            $con_ins_query2 = mysqli_query($connect1, "INSERT INTO `fca_connector_types`(`con_id`, `iec60309`, `actype2`, `chademo`, `gbt`, `ccs2`, `ft15askt`, `status`) VALUES ('$connector_id','$iec60309','$actype2','$chademo','$gbt','$ccs2','$ft15askt',1)");
            // $statement2 = $connect->prepare($con_ins_query2);
            // $statement2->execute($data);

            $con_ins_query3 = mysqli_query($connect1, "INSERT INTO `fca_connector_update`(`con_id`, `transaction_id`, `unit`, `power`, `voltage`, `current`,`soc`) VALUES ('$connector_id','0','0','0','0','0','0')");

            
        }

        $query5 = mysqli_query($connect1, "select count(con_id) from `fca_connectors` where charger_id = '$charger_id'");
        $fetch5 = mysqli_fetch_array($query5);
        $no_of_connectors = $fetch5[0];

        $query6 = mysqli_query($connect1, "update `fca_charger_spec` set `no_of_connectors` = '$no_of_connectors' where `charger_id` = '$charger_id'");

        if($query1 && $query2 && $query3 && $query4 && $query5 && $query6)
        {
          echo 'ok';
        }
        else
        {
          echo 'err';
        }
    }
    else
    {
      echo "error";
    }
    
?>