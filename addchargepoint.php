
<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

<style>
  .active_tab1
  {
   background-color: #fff;
   color:#333;
   font-weight: 600;
  }
  .inactive_tab1
  {
   background-color: #f5f5f5;
   color: #333;
   cursor: not-allowed;
  }
  .has-error
  {
   border-color:#cc0000;
   background-color:#ffff99;
  }
</style>

<?php

$message = '';
if(isset($_POST["cp_name"]))
{
    sleep(5);

    $cp_name = $_POST['cp_name'];
    //$charging_zones = $_POST['charging_zones'];
    $manufacturing_date = $_POST['manufacturing_date'];
    $integration_date = $_POST['integration_date'];
    $network_type = $_POST['network_type'];
    $access_type = $_POST['access_type'];
    $status = $_POST['status'];

    $operator = $_POST['operator'];
    $network_protocol = $_POST['network_protocol'];
    $ws_url = $_POST['ws_url'];
    $network_password = $_POST['network_password'];
    $plugincharge = $_POST['plugincharge'];
    $local_auth_list = $_POST['local_auth_list'];

    $qr_code_id = $_POST['qr_code_id'];
    $evse_type = $_POST['evse_type'];
    $evse_id = $_POST['evse_id'];
    $reservation_time = $_POST['reservation_time'];
    $max_power = $_POST['max_power'];

    $supply_type = $_POST['supply_type'];
    $max_current = $_POST['max_current'];

    $network = $_POST['network'];
    $tarriff = $_POST['tarriff'];
    $tags = $_POST['tags'];


    // $query = mysqli_query($connect,"select * from `client_registration` order by id desc limit 1");
    // if(mysqli_num_rows($query)>0)
    // {
    //     while($row=mysqli_fetch_array($query))
    //     {
    //         $client_id_db = $row['network_id'];
    //         $iparr = split ("\_", $client_id_db);
    //         $client_id_val = $iparr[1]+1; 
    //         $client_id = $iparr[0]."_".$client_id_val;
    //     }   
    // }
    // else
    // {
    //     $client_id_db = "network_";
    //     $iparr = split ("\_", $client_id_db); 
    //     $client_id = $iparr[0]."_1";
    // }

    //$client_id = $client_id_db."1";


    // $check_query = mysqli_query($connect,"select * from client_registration where client_name='$client_name'");
    // while($row = mysqli_fetch_array($check_query))
    // {
    //     $client_name_db = $row['client_name'];
    // }
    // if($client_name_db != $client_name)
    // {
        $insert_query = mysqli_query($connect,"INSERT INTO `chargepoints_mani`(`chargepoint_name`, `manufacturing_date`, `integration_date`, `network_type`, `access_type`, `status`, `operator`, `network_protocol`, `ws_url`, `network_password`, `plugin_charge`, `local_auth_list`, `qr_code_id`, `evse_type`, `evse_id`, `reservation_time`, `max_power`, `supply_type`, `max_current`, `network`, `tarrif`, `tags`, `cms`, `created_time`) VALUES ('$cp_name','$manufacturing_date','$integration_date','$network_type','$access_type','$status','$operator','$network_protocol','$ws_url','$network_password','$plugincharge','$local_auth_list','$qr_code_id','$evse_type','$evse_id','$reservation_time','$max_power','$supply_type','$max_current','$network','$tarriff','$tags','chargengo',now())");
        
        if($insert_query)
        {
            $message = '<div class="alert alert-success">
                            Charge Point Registration Completed Successfully. Please wait for few secs to add the connectors for this Chargepoint.
                        </div>';
                        ?>
                        <script type="text/javascript">
                            setTimeout(function ()
                            {
                               window.location.href= 'addconnector.php';
                            }, 2000);
                        </script>

                        <?php
        }
        else
        {
            $message = '<div class="alert alert-danger">
                            There is an error in Registration
                        </div>';
        }
    // }
    // else
    // {       
    //     $message = '<div class="alert alert-primary">
    //                     Already Inserted this Network    
    //                 </div>';
                    ?>
                    <!-- <script type="text/javascript">
                        setTimeout(function ()
                        {
                           window.location.href= 'addstation.php';
                        }, 10000);
                    </script> -->
                    <?php
    //}
}
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

<div class="main-container">
    <div class="row">
        <div class="col-sm-12">
            <div class="pd-20 card-box mb-30"> 
                <h2 style="text-align: center; color: #e41e1b;"> <b> Charge Point Registration </b> </h2> <br><br>

                <?php echo $message; ?>
                <form method="post" id="register_form">
                    <ul class="nav nav-tabs">
                        <div class="row" style="width: 100%;">
                            <div class="col-sm-2">
                                <li class="nav-item">
                                    <a class="nav-link active_tab1" id="list_general_details" style="border:1px solid #ccc; padding: 20px; text-align: center;"> General </a>
                                </li>
                            </div>
                            <div class="col-sm-2">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_ocpp_details" style="border:1px solid #ccc; padding: 20px; text-align: center;"> OCPP </a>
                                </li>
                            </div>
                            <div class="col-sm-2">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_evse_details" style="border:1px solid #ccc; padding: 20px; text-align: center;"> EVSE </a>
                                </li>
                            </div>
                            <div class="col-sm-2">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_hardware_details" style="border:1px solid #ccc; padding: 20px; text-align: center;"> Hardware Management </a>
                                </li>
                            </div>
                            <div class="col-sm-2">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_operator_details" style="border:1px solid #ccc; padding: 20px; text-align: center;"> Operator Details </a>
                                </li>
                            </div>
                            <div class="col-sm-2">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_preview_details" style="border:1px solid #ccc; padding: 20px; text-align: center;"> Preview </a>
                                </li>
                            </div>
                        </div>
                    </ul>

                    
                    <div class="tab-content" style="margin-top:16px;">

                        <div class="tab-pane active" id="general_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> General Information </div>
                                <div class="panel-body">
                                    
                                    <div class="form-group">
                                        <label> Charge Point Name : <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="cp_name" id="cp_name" class="form-control"/>
                                        <!-- <span id="user-availability-status"></span>    
                                        <p><img src="images/loader1.gif" id="loaderIcon" style="display:none" /></p> -->
                                        <span id="error_cp_name" class="text-danger"></span>
                                    </div><br>

                                    <!-- <div class="form-group">
                                        <label> Charging Zones : <span class="text-danger">(*)</span> </label><br>
                                        <select name="charging_zones" id="charging_zones" data-live-search="true">
                                            <option value=""> Select Zone </option>
                                            <?php
                                                // $result = mysqli_query($connect,"SELECT * FROM charging_zones");
                                                // while($row = mysqli_fetch_array($result))
                                                // {
                                                //     ?><option value="<?php //echo $row['zone_name'];?>"><?php //echo $row["zone_name"];?></option><?php
                                                // }
                                            ?>
                                        </select>
                                        <span id="error_charging_zones" class="text-danger"></span>
                                    </div><br> -->

                                    <div class="form-group">
                                        <label> Manufacturing Date : <span class="text-danger">(*)</span> </label><br>
                                        <input type="date" name="manufacturing_date" id="manufacturing_date" />
                                        <span id="error_manufacturing_date" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label> Integration Date :  <span class="text-danger">(*)</span> </label><br>
                                        <input type="date" name="integration_date" id="integration_date" />
                                        <span id="error_integration_date" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label> Network Type : <span class="text-danger">(*)</span> </label>
                                        <select name="network_type" id="network_type" class="form-control">
                                            <option value=""> Select Network Type </option>
                                            <option value="Ethernet"> Ethernet </option>
                                            <option value="Wi-Fi"> Wi-Fi</option>
                                            <option value="GSM/GPRS"> GSM/GPRS </option>
                                            <option value="Bluetooth"> Bluetooth </option>
                                            <option value="All"> ALL </option>
                                        </select>
                                        <span id="error_network_type" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label> Access Type : <span class="text-danger">(*)</span> </label>
                                        <select name="access_type" id="access_type" class="form-control">
                                            <option value=""> Select Access Type </option>
                                            <option value="Private"> Private </option>
                                            <option value="Public"> Public </option>
                                        </select>
                                        <span id="error_access_type" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label> Status : <span class="text-danger">(*)</span> </label>
                                        <select name="status" id="status" class="form-control">
                                            <option value=""> Select Status </option>
                                            <option value="Active"> Active </option>
                                            <option value="Disabled"> Disabled </option>
                                            <option value="Demo"> Demo </option>
                                            <option value="Out of Order"> Out of Order </option>
                                        </select>
                                        <span id="error_status" class="text-danger"></span>
                                    </div><br>

                                    <div align="center">
                                        <button type="button" name="btn_general_details" id="btn_general_details" style="background-color: #3d56d8; color: white;" class="btn"> Next </button>
                                    </div><br/>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="ocpp_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> OCPP Details </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <input type="checkbox" name="operator" id="operator">
                                        <label> Managed by Operator </label>
                                        <span id="error_operator" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Network Protocol :  <span class="text-danger">(*)</span> </label>
                                        <select name="network_protocol" id="network_protocol" class="form-control">
                                            <option value=""> Select Network Protocol </option>
                                            <option value="OCPP 1.6"> OCPP 1.6 </option>
                                            <option value="OCPP 2.0"> OCPP 2.0 </option>
                                        </select>
                                        <span id="error_network_protocol" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label> Charge Point WS URL <span class="text-danger">(*)</span> </label>
                                        <input type="text" id="ws_url" name="ws_url" class="form-control">
                                        <span id="error_ws_url" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Network Password </label>
                                        <input type="text" id="network_password" name="network_password"class="form-control">
                                        <span id="error_network_password" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <input type="checkbox" name="plugincharge" id="plugincharge">
                                        <label> Plugin charge without authentication </label>
                                        <span id="error_plugincharge" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <input type="checkbox" id="local_auth_list" name="local_auth_list">
                                        <label> Local Auth List </label>
                                        <span id="error_local_auth_list" class="text-danger"></span>
                                    </div><br>

                                    <div align="center">
                                        <button type="button" name="previous_btn_ocpp_details" id="previous_btn_ocpp_details" class="btn btn-danger"> Previous </button>
                                        <button type="button" name="btn_ocpp_details" id="btn_ocpp_details" style="background-color: #3d56d8; color: white;" class="btn"> Next </button>
                                    </div><br/>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="evse_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> EVSE Details </div>
                                <div class="panel-body">
                                    
                                    <div class="form-group">
                                        <label> QR Code ID : <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="qr_code_id" id="qr_code_id" class="form-control"/>
                                        <span id="error_qr_code_id" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> EVSE Type : <span class="text-danger">(*)</span> </label>
                                        <select name="evse_type" id="evse_type" class="form-control">
                                            <option value=""> Select </option>
                                            <option value="ac"> AC </option>
                                            <option value="dc"> DC </option>
                                            <option value="acdc"> AC + DC </option>
                                        </select>
                                        <span id="error_evse_type" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label> EVSE ID : <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="evse_id" id="evse_id" class="form-control" />
                                        <span id="error_evse_id" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <input type="checkbox" name="reservation_time" id="reservation_time"/>
                                        <label> Reservation Time </label>
                                        <span id="error_reservation_time" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label> Max Power <span class="text-danger">(*)</span></label>
                                        <input type="number" name="max_power" id="max_power" class="form-control">
                                        <span id="error_max_power" class="text-danger"></span>
                                    </div><br>

                                    <div align="center">
                                        <button type="button" name="previous_btn_evse_details" id="previous_btn_evse_details" class="btn btn-danger"> Previous </button>
                                        <button type="button" name="btn_evse_details" id="btn_evse_details" style="background-color: #3d56d8; color: white;" class="btn"> Next </button>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="hardware_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Hardware Management Details </div>
                                <div class="panel-body">
                                    
                                    <div class="form-group">
                                        <label> Supply Type : <span class="text-danger">(*)</span> </label>
                                        <select id="supply_type" name="supply_type" class="form-control"> 
                                            <option value=""> Select </option>
                                            <option value="single"> Single Phase </option>
                                            <option value="three"> Three Phase </option>
                                        </select>
                                        <span id="error_supply_type" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Input Max Current Limit : <span class="text-danger">(*)</span> </label>
                                        <input type="number" name="max_current" id="max_current" class="form-control">
                                        <span id="error_max_current" class="text-danger"></span>
                                    </div><br>


                                    <!-- <div class="clearfix">
                                        <button type="button" name="add" class="btn btn-success btn-sm add"> Add Connector </button> <br><br>
                                    </div>

                                    <div class="table-repsonsive">
                                        <span id="error"></span>
                                        <table class="table table-bordered" id="item_table">
                                            <thead>
                                                <tr>
                                                    <th> Connector Type </th>
                                                    <th> Format </th>
                                                    <th> Power Capacity (KW) </th>
                                                    <th> Charging Current (A) </th>
                                                    <th> Connector Protection </th>
                                                    <th> Remove </th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div align="center">
                                            <input type="submit" name="submit" class="btn btn-info" value="Insert" id="btn_details" />
                                        </div>
                                    </div> -->


                                    <div align="center">
                                        <button type="button" name="previous_btn_hardware_details" id="previous_btn_hardware_details" class="btn btn-danger"> Previous </button>
                                        <button type="button" name="btn_hardware_details" id="btn_hardware_details" style="background-color: #3d56d8; color: white;" class="btn"> Next </button>
                                    </div><br>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="operator_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Operator Details </div>
                                <div class="panel-body">
                                    
                                    <div class="form-group">
                                        <label> Network : <span class="text-danger">(*)</span> </label>
                                        <select name="network" id="network" class="form-control" data-live-search="true">
                                            <option value=""> Select Network </option>
                                            <?php
                                                $result = mysqli_query($connect, "SELECT * FROM client_registration where cms='chargengo'");
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    ?><option value="<?php echo $row['client_name'];?>"><?php echo $row["client_name"];?></option><?php
                                                }
                                            ?>
                                        </select>
                                        <span id="error_network" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Tarriff : <span class="text-danger">(*)</span> </label>
                                        <select name="tarriff" id="tarriff" class="form-control">
                                            <option value="0"> Select </option>
                                        </select>
                                        <span id="error_tarriff" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label> Tags : <span class="text-danger">(*)</span> </label>
                                        <select name="tags" id="tags" class="form-control">
                                            <option value="0"> Select </option>
                                        </select>
                                        <span id="error_tags" class="text-danger"></span>
                                    </div><br>

                                    <div align="center">
                                        <button type="button" name="previous_btn_operator_details" id="previous_btn_operator_details" class="btn btn-danger"> Previous </button>
                                        <button type="button" name="btn_operator_details" id="btn_operator_details" style="background-color: #3d56d8; color: white;" class="btn" onclick="preview()"> Next </button>
                                    </div><br>
                                </div>
                            </div>
                        </div>


<script type="text/javascript">
    function preview()
    {
        var cp_name = document.getElementById("cp_name").value;
        var cp_name_value = document.getElementById("cp_name_value");
        cp_name_value.innerText = cp_name;

        // var charging_zones = document.getElementById("charging_zones").value;
        // var charging_zones_value = document.getElementById("charging_zones_value");
        // charging_zones_value.innerText = charging_zones;

        var manufacturing_date = document.getElementById("manufacturing_date").value;
        var manufacturing_date_value = document.getElementById("manufacturing_date_value");
        manufacturing_date_value.innerText = manufacturing_date;

        var integration_date = document.getElementById("integration_date").value;
        var integration_date_value = document.getElementById("integration_date_value");
        integration_date_value.innerText = integration_date;        

        var network_type = document.getElementById("network_type").value;
        var network_type_value = document.getElementById("network_type_value");
        network_type_value.innerText = network_type;

        var access_type = document.getElementById("access_type").value;
        var access_type_value = document.getElementById("access_type_value");
        access_type_value.innerText = access_type;
        
        var status = document.getElementById("status").value;
        var status_value = document.getElementById("status_value");
        status_value.innerText = status;

        var operator = document.querySelector('#operator');
        if(operator.checked == true)
        {
            var operator_value = document.getElementById("operator_value");
            operator_value.innerText = " Enabled ";
        }
        else
        {
            var operator_value = document.getElementById("operator_value");
            operator_value.innerText = " Disabled ";
        }

        var network_protocol = document.getElementById("network_protocol").value;
        var network_protocol_value = document.getElementById("network_protocol_value");
        network_protocol_value.innerText = network_protocol;
        
        var ws_url = document.getElementById("ws_url").value;
        var ws_url_value = document.getElementById("ws_url_value");
        ws_url_value.innerText = ws_url;

        var network_password = document.getElementById("network_password").value;
        var network_password_value = document.getElementById("network_password_value");
        network_password_value.innerText = network_password;

        var plugincharge = document.querySelector('#plugincharge');
        if(plugincharge.checked == true)
        {
            var plugincharge_value = document.getElementById("plugincharge_value");
            plugincharge_value.innerText = " Enabled ";
        }
        else
        {
            var plugincharge_value = document.getElementById("plugincharge_value");
            plugincharge_value.innerText = " Disabled ";
        }


        var local_auth_list = document.querySelector('#local_auth_list');
        if(local_auth_list.checked == true)
        {
            var local_auth_list_value = document.getElementById("local_auth_list_value");
            local_auth_list_value.innerText = " Enabled ";
        }
        else
        {
            var local_auth_list_value = document.getElementById("local_auth_list_value");
            local_auth_list_value.innerText = " Disabled ";
        }

        var qr_code_id = document.getElementById("qr_code_id").value;
        var qr_code_id_value = document.getElementById("qr_code_id_value");
        qr_code_id_value.innerText = qr_code_id;

        var evse_type = document.getElementById("evse_type").value;
        var evse_type_value = document.getElementById("evse_type_value");
        evse_type_value.innerText = evse_type;

        var evse_id = document.getElementById("evse_id").value;
        var evse_id_value = document.getElementById("evse_id_value");
        evse_id_value.innerText = evse_id;

        var reservation_time = document.querySelector('#reservation_time');
        if(reservation_time.checked == true)
        {
            var reservation_time_value = document.getElementById("reservation_time_value");
            reservation_time_value.innerText = " Enabled ";
        }
        else
        {
            var reservation_time_value = document.getElementById("reservation_time_value");
            reservation_time_value.innerText = " Disabled ";
        }

        var max_power = document.getElementById("max_power").value;
        var max_power_value = document.getElementById("max_power_value");
        max_power_value.innerText = max_power;


        var supply_type = document.getElementById("supply_type").value;
        var supply_type_value = document.getElementById("supply_type_value");
        supply_type_value.innerText = supply_type;      

        var max_current = document.getElementById("max_current").value;
        var max_current_value = document.getElementById("max_current_value");
        max_current_value.innerText = max_current;  

        var network = document.getElementById("network").value;
        var network_value = document.getElementById("network_value");
        network_value.innerText = network; 

        var tarriff = document.getElementById("tarriff").value;
        var tarriff_value = document.getElementById("tarriff_value");
        tarriff_value.innerText = tarriff; 

        var tags = document.getElementById("tags").value;
        var tags_value = document.getElementById("tags_value");
        tags_value.innerText = tags; 

    }
</script>

                        <div class="tab-pane fade" id="preview_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Chargepoint Preview </div>
                                <div class="panel-body"><br>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6">
                                            <table border="1" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="6" style="vertical-align: middle; text-align: center;"> General Details </th>
                                                        <th> Charge Point Name </th>
                                                        <td> <span id="cp_name_value"></span> </td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <th> Charging Zones </th>
                                                        <td> <span id="charging_zones_value"></span> </td>
                                                    </tr> -->
                                                    <tr>
                                                        <th> Manufacturing Date </th>
                                                        <td> <span id="manufacturing_date_value"></span> </td>
                                                    </tr>
                                                    <tr>
                                                        <th> Integration Date </th>
                                                        <td> <span id="integration_date_value"></span> </td>
                                                    </tr>
                                                    <tr>
                                                        <th> Network Type </th>
                                                        <td> <span id="network_type_value"></span> </td>
                                                    </tr>
                                                    <tr>
                                                        <th> Access Type </th>
                                                        <td> <span id="access_type_value"></span> </td>
                                                    </tr>
                                                    <tr>
                                                        <th> Status </th>
                                                        <td> <span id="status_value"></span> </td>
                                                    </tr>

                                                    <tr>
                                                        <th rowspan="6" style="text-align: center; vertical-align: middle;"> OCPP Details </th>
                                                        <th> Operator </th>
                                                        <td> <span id="operator_value"></span> </td>
                                                    </tr>
                                                    <tr>
                                                        <th> Network Protocol </th>
                                                        <td> <span id="network_protocol_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>WS URl</th>
                                                        <td><span id="ws_url_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th> Network Password </th>
                                                        <td> <span id="network_password_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th> Plugin Charge </th>
                                                        <td><span id="plugincharge_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th> Local Auth List </th>
                                                        <td> <span id="local_auth_list_value"></span></td>
                                                    </tr>


                                                    <tr>
                                                        <th rowspan="5" style="text-align: center; vertical-align: middle;"> EVSE Details </th>
                                                        <th> QR Code ID </th>
                                                        <td> <span id="qr_code_id_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th> EVSE Type </th>
                                                        <td><span id="evse_type_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th> EVSE ID </th>
                                                        <td><span id="evse_id_value"> </span></td>
                                                    </tr>
                                                    <tr>
                                                        <th> Reservation Time </th>
                                                        <td><span id="reservation_time_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Max Power</th>
                                                        <td><span id="max_power_value"></span></td>
                                                    </tr>


                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;"> Hardware Management Details </th>
                                                        <th> Supply Type </th>
                                                        <td><span id="supply_type_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Max Current </th>
                                                        <td><span id="max_current_value"></span></td>
                                                    </tr>


                                                    <tr>
                                                        <th rowspan="3" style="text-align: center; vertical-align: middle;"> Operator Details </th>
                                                        <th> Network </th>
                                                        <td><span id="network_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th> Tarriff </th>
                                                        <td><span id="tarriff_value"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <th> Tags </th>
                                                        <td> <span id="tags_value"></span></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="col-sm-3"></div>
                                    </div><br>

                                    <div align="center">
                                        <button type="button" name="previous_btn_preview_details" id="previous_btn_preview_details" class="btn btn-danger">Previous</button>
                                        <button type="button" name="btn_preview_details" id="btn_preview_details" class="btn btn-success">Register</button>
                                    </div><br>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
              


            <script>
                //var cp_name_check_status = 0;

                // function checkAvailability()
                // {
                //     $("#loaderIcon").show();    
                //     jQuery.ajax({
                //         url: "check_availability.php",
                //         data:'username='+$("#cp_name").val(),
                //         type: "POST",
                //         success:function(data)
                //         {
                //             //$("#user-availability-status").html(data);
                //             $("#loaderIcon").hide();
                //             if(data=='available')
                //             {
                //                 //alert("Available");
                //                 cp_name_check_status = 1;
                //                 error_cp_name = '';
                //                 $('#error_cp_name').text(error_cp_name);
                //                 $('#cp_name').removeClass('has-error');
                //             }
                //             else if(data=='taken')
                //             {
                //                 //alert("Already taken this Network Name");
                //                 cp_name_check_status = 2;
                //                 error_cp_name = 'Network Name is already taken';
                //                 $('#error_cp_name').text(error_cp_name);
                //                 $('#cp_name').addClass('has-error');
                //             }
                //         },
                //         error:function (){}
                //     });
                // }


            $(document).ready(function()
            {
                
                $('#charging_zones').selectpicker();
                // $('#network_type').selectpicker();
                // $('#access_type').selectpicker();

                var count = 0;
                $(document).on('click', '.add', function()
                {
                    count++;
                    var html = '';
                    html += '<tr>';
                      
                    // html += '<td><select name="charging_power_type[]" class="form-control charging_power_type"><option value="">Select Category</option><option value="ac"> AC </option><option value="dc"> DC </option></select></td>';
                      
                    html += '<td><select name="item_category[]" class="form-control item_category" data-sub_category_id="'+count+'"><option value="">Select Category</option><?php //echo fill_select_box($connect, "0"); ?></select></td>';
                      
                    html += '<td><select name="item_sub_category[]" class="form-control item_sub_category" id="item_sub_category'+count+'"><option value="">Select Sub Category</option></select></td>';
                      
                    html += '<td><select name="phase_type[]" class="form-control phase_type"><option value="single"> Single Phase </option><option value="three"> Three Phase </option></select></td>';

                    html += '<td><input type="text" name="charging_current[]" class="form-control charging_current" /></td>';
                    html += '<td><input type="text" name="power_capacity[]" class="form-control power_capacity" /></td>';

                    html += '<td><select name="connector_protection[]" class="form-control connector_protection"><option value="none"> None </option> <option value="Temperature Sensor"> Temperature Sensor </option> <option value="Liquid Cooling"> Liquid Cooling </option></select></td>';

                    html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span> Remove </button></td>';
                      $('tbody').append(html);
                });

                $(document).on('click', '.remove', function()
                {
                    $(this).closest('tr').remove();
                });

                $(document).on('change', '.item_category', function()
                {
                    var category_id = $(this).val();
                    var sub_category_id = $(this).data('sub_category_id');
                    $.ajax({
                        url:"fill_sub_category.php",
                        method:"POST",
                        data:{category_id:category_id},
                        success:function(data)
                        {
                            var html = '<option value="">Select Sub Category</option>';
                            html += data;
                            $('#item_sub_category'+sub_category_id).html(html);
                        }
                    })
                });


                $('#insert_form').on('submit', function(event)
                {
                    event.preventDefault();
                    var error = '';

                    $('.charging_current').each(function()
                    {
                        var count = 1;
                        if($(this).val() == '')
                        {
                            error += '<p>Enter Charging Current at '+count+' Row</p>';
                            return false;
                        }
                        count = count + 1;
                    });

                    $('.power_capacity').each(function()
                    {
                        var count = 1;
                        if($(this).val() == '')
                        {
                            error += '<p>Enter Power Capacity at '+count+' row</p>';
                            return false;
                        }
                        count = count + 1;
                    });

                      
                    $('.connector_protection').each(function()
                    {
                        var count = 1;
                        if($(this).val() == '')
                        {
                            error += '<p>Enter Connector Protection '+count+' Row</p> ';
                            return false;
                        }
                        count = count + 1;
                    });

                    var form_data = $(this).serialize();

                    var networkname = document.getElementById("networkname").value;
                    var stationname = document.getElementById("stationname").value;
                    var ocpp = document.getElementById("ocpp").value;
                    var firmware = document.getElementById("firmware").value;
                    var model_number = document.getElementById("model_number").value;
                    var manufacturing_date = document.getElementById("manufacturing_date").value;
                    var user_authentication = document.getElementById("user_authentication").value;
                    var energy_meter_type = document.getElementById("energy_meter_type").value;

                    if(error == '' && networkname!='' && stationname!='' && ocpp!='' && firmware!='' && model_number!='' && manufacturing_date!='' && user_authentication!='' && energy_meter_type!='')
                    {
                        $.ajax({
                            url:"insert.php",
                            method:"POST",
                            data:form_data,
                            success:function(data)
                            {
                                // if(data == 'ok')
                                // {
                                //   $('#item_table').find('tr:gt(0)').remove();
                                $('#btn_details').attr("disabled", "disabled");
                                $('#error').html('<div class="alert alert-success"> Connector Details Saved</div>');
                                //}
                            }
                        });
                    }
                    else
                    {
                        if(error!='')
                        {
                            $('#error').html('<div class="alert alert-danger">'+error+'</div>');
                        }
                        else
                        {
                            $('#error').html('<div class="alert alert-danger">Please fill all Fields</div>');
                        }
                    }

                });                



                $('#btn_general_details').click(function()
                {
                    var error_cp_name = '';
                    //var error_charging_zones = '';
                    var error_manufacturing_date = '';
                    var error_integration_date = '';
                    var error_network_type = '';
                    var error_access_type = '';
                    var error_status = '';

                    var mobile_validation = /^\d{10}$/;
                    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              
                    if($.trim($('#cp_name').val()).length == 0)
                    {
                        error_cp_name = 'Charge Point Name is required';
                        $('#error_cp_name').text(error_cp_name);
                        $('#cp_name').addClass('has-error');
                    }
                    // else if(cp_name_check_status==2)
                    // {
                    //     error_cp = 'Charge Point Name is already taken. Please Enter another one';
                    //     $('#error_cp_name').text(error_cp_name);
                    //     $('#cp_name').addClass('has-error');
                    // }
                    else
                    {
                        error_cp_name = '';
                        $('#error_cp_name').text(error_cp_name);
                        $('#cp_name').removeClass('has-error');
                    }

                    // if($.trim($('#charging_zones').val()).length == 0)
                    // {
                    //     error_charging_zones = 'Charging Zone is required';
                    //     $('#error_charging_zones').text(error_charging_zones);
                    //     $('#charging_zones').addClass('has-error');
                    // }
                    // else
                    // {
                    //    error_charging_zones = '';
                    //    $('#error_charging_zones').text(error_charging_zones);
                    //    $('#charging_zones').removeClass('has-error');
                    // }                    

                    if($.trim($('#manufacturing_date').val()).length == 0)
                    {
                        error_manufacturing_date = 'Manufacturing Date is required';
                        $('#error_manufacturing_date').text(error_manufacturing_date);
                        $('#manufacturing_date').addClass('has-error');
                    }
                    else
                    {
                       error_manufacturing_date = '';
                       $('#error_manufacturing_date').text(error_manufacturing_date);
                       $('#manufacturing_date').removeClass('has-error');
                    }
                      
                    if($.trim($('#integration_date').val()).length == 0)
                    {
                        error_integration_date = 'Integration Date is required';
                        $('#error_integration_date').text(error_integration_date);
                        $('#integration_date').addClass('has-error');
                    }
                    else
                    {
                       error_integration_date = '';
                       $('#error_integration_date').text(error_integration_date);
                       $('#integration_date').removeClass('has-error');
                    }

                    if($.trim($('#network_type').val()).length == 0)
                    {
                       error_network_type = 'Network Type is required';
                       $('#error_network_type').text(error_network_type);
                       $('#network_type').addClass('has-error');
                    }
                    else
                    {
                       error_network_type = '';
                       $('#error_network_type').text(error_network_type);
                       $('#network_type').removeClass('has-error');
                    }

                    if($.trim($('#access_type').val()).length == 0)
                    {
                       error_access_type = 'Access Type is required';
                       $('#error_access_type').text(error_access_type);
                       $('#access_type').addClass('has-error');
                    }
                    else
                    {
                       error_access_type = '';
                       $('#error_access_type').text(error_access_type);
                       $('#access_type').removeClass('has-error');
                    }

                    if($.trim($('#status').val()).length == 0)
                    {
                       error_status = 'Status is required';
                       $('#error_status').text(error_status);
                       $('#status').addClass('has-error');
                    }
                    else
                    {
                       error_status = '';
                       $('#error_status').text(error_status);
                       $('#status').removeClass('has-error');
                    }

                    // if($.trim($('#mobile').val()).length == 0)
                    // {
                    //    error_mobile = 'Mobile Number is required';
                    //    $('#error_mobile').text(error_mobile);
                    //    $('#mobile').addClass('has-error');
                    // }
                    // else
                    // {
                    //     if(!mobile_validation.test($('#mobile').val()))
                    //     {
                    //         error_mobile = 'Invalid Mobile Number';
                    //         $('#error_mobile').text(error_mobile);
                    //         $('#mobile').addClass('has-error');
                    //     }
                    //     else
                    //     {
                    //         error_mobile = '';
                    //         $('#error_mobile').text(error_mobile);
                    //         $('#mobile').removeClass('has-error');
                    //     }
                    // }

                    // if($.trim($('#email').val()).length == 0)
                    // {
                    //     error_email = 'Email ID is required';
                    //     $('#error_email').text(error_email);
                    //     $('#email').addClass('has-error');
                    // }
                    // else
                    // {
                    //     if(!filter.test($('#email').val()))
                    //     {
                    //         error_email = 'Invalid Email';
                    //         $('#error_email').text(error_email);
                    //         $('#email').addClass('has-error');
                    //     }
                    //     else
                    //     {
                    //         error_email = '';
                    //         $('#error_email').text(error_email);
                    //         $('#email').removeClass('has-error');
                    //     }
                    // }

                    // if($.trim($('#password').val()).length == 0)
                    // {
                    //  error_password = 'Password is required';
                    //  $('#error_password').text(error_password);
                    //  $('#password').addClass('has-error');
                    // }
                    // else
                    // {
                    //  error_password = '';
                    //  $('#error_password').text(error_password);
                    //  $('#password').removeClass('has-error');
                    // }

                    
                    if(error_cp_name !='' || error_manufacturing_date !='' || error_integration_date !='' || error_network_type !='' || error_access_type !='' || error_status !='')
                    {
                       return false;
                    }
                    else
                    {
                        $('#list_general_details').removeClass('active active_tab1');
                        $('#list_general_details').removeAttr('href data-toggle');
                        $('#general_details').removeClass('active');
                        $('#list_general_details').addClass('inactive_tab1');
                        $('#list_ocpp_details').removeClass('inactive_tab1');
                        $('#list_ocpp_details').addClass('active_tab1 active');
                        $('#list_ocpp_details').attr('href', '#ocpp_details');
                        $('#list_ocpp_details').attr('data-toggle', 'tab');
                        $('#ocpp_details').addClass('active in');
                    }
                });
             
                $('#previous_btn_ocpp_details').click(function()
                {
                    $('#list_ocpp_details').removeClass('active active_tab1');
                    $('#list_ocpp_details').removeAttr('href data-toggle');
                    $('#ocpp_details').removeClass('active in');
                    $('#list_ocpp_details').addClass('inactive_tab1');
                    $('#list_general_details').removeClass('inactive_tab1');
                    $('#list_general_details').addClass('active_tab1 active');
                    $('#list_general_details').attr('href', '#general_details');
                    $('#list_general_details').attr('data-toggle', 'tab');
                    $('#general_details').addClass('active in');
                });
             

                $('#btn_ocpp_details').click(function()
                {
                    var error_operator = '';
                    var error_network_protocol = '';
                    var error_ws_url = '';
              
                    if($.trim($('#operator').val()).length == 0)
                    {
                        error_operator = 'Operator is required';
                        $('#error_operator').text(error_operator);
                        $('#operator').addClass('has-error');
                    }
                    else
                    {
                        error_operator = '';
                        $('#error_operator').text(error_operator);
                        $('#operator').removeClass('has-error');
                    }
              
                    if($.trim($('#network_protocol').val()).length == 0)
                    {
                       error_network_protocol = 'Network Protocol is required';
                       $('#error_network_protocol').text(error_network_protocol);
                       $('#network_protocol').addClass('has-error');
                    }
                    else
                    {
                       error_network_protocol = '';
                       $('#error_network_protocol').text(error_network_protocol);
                       $('#network_protocol').removeClass('has-error');
                    }
                      
                    if($.trim($('#ws_url').val()).length == 0)
                    {
                       error_ws_url = 'WS URL is required';
                       $('#error_ws_url').text(error_ws_url);
                       $('#ws_url').addClass('has-error');
                    }
                    else
                    {
                       error_ws_url = '';
                       $('#error_ws_url').text(error_ws_url);
                       $('#ws_url').removeClass('has-error');
                    }

                    if(error_network_protocol !='' || error_ws_url !='')
                    {
                       return false;
                    }
                    else
                    {
                       $('#list_ocpp_details').removeClass('active active_tab1');
                       $('#list_ocpp_details').removeAttr('href data-toggle');
                       $('#ocpp_details').removeClass('active');
                       $('#list_ocpp_details').addClass('inactive_tab1');
                       $('#list_evse_details').removeClass('inactive_tab1');
                       $('#list_evse_details').addClass('active_tab1 active');
                       $('#list_evse_details').attr('href', '#evse_details');
                       $('#list_evse_details').attr('data-toggle', 'tab');
                       $('#evse_details').addClass('active in');
                    }
                });
             
                $('#previous_btn_evse_details').click(function()
                {
                    $('#list_evse_details').removeClass('active active_tab1');
                    $('#list_evse_details').removeAttr('href data-toggle');
                    $('#evse_details').removeClass('active in');
                    $('#list_evse_details').addClass('inactive_tab1');
                    $('#list_ocpp_details').removeClass('inactive_tab1');
                    $('#list_ocpp_details').addClass('active_tab1 active');
                    $('#list_ocpp_details').attr('href', '#ocpp_details');
                    $('#list_ocpp_details').attr('data-toggle', 'tab');
                    $('#ocpp_details').addClass('active in');
                });
             
                $('#btn_evse_details').click(function()
                {
                    var error_qr_code_id = '';
                    var error_evse_type = '';
                    var error_evse_id = '';
                    var error_max_power = '';

                    if($.trim($('#qr_code_id').val()).length == 0)
                    {
                       error_qr_code_id = 'QR Code ID is required';
                       $('#error_qr_code_id').text(error_qr_code_id);
                       $('#qr_code_id').addClass('has-error');
                    }
                    else
                    {
                       error_qr_code_id = '';
                       $('#error_qr_code_id').text(error_qr_code_id);
                       $('#qr_code_id').removeClass('has-error');
                    }
                      
                    if($.trim($('#evse_type').val()).length == 0)
                    {
                       error_evse_type = 'EVSE Type is required';
                       $('#error_evse_type').text(error_evse_type);
                       $('#evse_type').addClass('has-error');
                    }
                    else
                    {
                       error_evse_type = '';
                       $('#error_evse_type').text(error_evse_type);
                       $('#evse_type').removeClass('has-error');
                    }
                      
                    if($.trim($('#evse_id').val()).length == 0)
                    {
                       error_evse_id = 'EVSE ID is required';
                       $('#error_evse_id').text(error_evse_id);
                       $('#evse_id').addClass('has-error');
                    }
                    else
                    {
                       error_evse_id = '';
                       $('#error_evse_id').text(error_evse_id);
                       $('#evse_id').removeClass('has-error');
                    }
                      
                    if($.trim($('#max_power').val()).length == 0)
                    {
                       error_max_power = 'Max Power is required';
                       $('#error_max_power').text(error_max_power);
                       $('#max_power').addClass('has-error');
                    }
                    else
                    {
                       error_max_power = '';
                       $('#error_max_power').text(error_max_power);
                       $('#max_power').removeClass('has-error');
                    }
                      
                      
                    if(error_qr_code_id!='' || error_evse_type!='' || error_evse_id!='' || error_max_power!='')
                    {
                        return false;
                    }
                    else
                    {
                        $('#list_evse_details').removeClass('active active_tab1');
                        $('#list_evse_details').removeAttr('href data-toggle');
                        $('#evse_details').removeClass('active');
                        $('#list_evse_details').addClass('inactive_tab1');
                        $('#list_hardware_details').removeClass('inactive_tab1');
                        $('#list_hardware_details').addClass('active_tab1 active');
                        $('#list_hardware_details').attr('href', '#hardware_details');
                        $('#list_hardware_details').attr('data-toggle', 'tab');
                        $('#hardware_details').addClass('active in');
                    }

                });


             
                $('#previous_btn_hardware_details').click(function()
                {
                    $('#list_hardware_details').removeClass('active active_tab1');
                    $('#list_hardware_details').removeAttr('href data-toggle');
                    $('#hardware_details').removeClass('active in');
                    $('#list_hardware_details').addClass('inactive_tab1');
                    $('#list_evse_details').removeClass('inactive_tab1');
                    $('#list_evse_details').addClass('active_tab1 active');
                    $('#list_evse_details').attr('href', '#evse_details');
                    $('#list_evse_details').attr('data-toggle', 'tab');
                    $('#evse_details').addClass('active in');
                });
             
                $('#btn_hardware_details').click(function()
                {
                    var error_supply_type = '';
                    var error_max_current = '';

                    if($.trim($('#supply_type').val()).length == 0)
                    {
                       error_supply_type = 'Supply Type is required';
                       $('#error_supply_type').text(error_supply_type);
                       $('#supply_type').addClass('has-error');
                    }
                    else
                    {
                       error_supply_type = '';
                       $('#error_supply_type').text(error_supply_type);
                       $('#supply_type').removeClass('has-error');
                    }
                      
                    if($.trim($('#max_current').val()).length == 0)
                    {
                       error_max_current = 'Max Current is required';
                       $('#error_max_current').text(error_max_current);
                       $('#max_current').addClass('has-error');
                    }
                    else
                    {
                       error_max_current = '';
                       $('#error_max_current').text(error_max_current);
                       $('#max_current').removeClass('has-error');
                    }
                      
                    if(error_supply_type!='' || error_max_current!='')
                    {
                        return false;
                    }
                    else
                    {
                        $('#list_hardware_details').removeClass('active active_tab1');
                        $('#list_hardware_details').removeAttr('href data-toggle');
                        $('#hardware_details').removeClass('active');
                        $('#list_hardware_details').addClass('inactive_tab1');
                        $('#list_operator_details').removeClass('inactive_tab1');
                        $('#list_operator_details').addClass('active_tab1 active');
                        $('#list_operator_details').attr('href', '#operator_details');
                        $('#list_operator_details').attr('data-toggle', 'tab');
                        $('#operator_details').addClass('active in');

                    }
                });



                $('#previous_btn_operator_details').click(function()
                {
                    $('#list_operator_details').removeClass('active active_tab1');
                    $('#list_operator_details').removeAttr('href data-toggle');
                    $('#operator_details').removeClass('active in');
                    $('#list_operator_details').addClass('inactive_tab1');
                    $('#list_hardware_details').removeClass('inactive_tab1');
                    $('#list_hardware_details').addClass('active_tab1 active');
                    $('#list_hardware_details').attr('href', '#hardware_details');
                    $('#list_hardware_details').attr('data-toggle', 'tab');
                    $('#hardware_details').addClass('active in');
                });
             
                $('#btn_operator_details').click(function()
                {
                    var error_network = '';
                    var error_tarriff = '';
                    var error_tags = '';

                    if($.trim($('#network').val()).length == 0)
                    {
                       error_network = 'Network is required';
                       $('#error_network').text(error_network);
                       $('#network').addClass('has-error');
                    }
                    else
                    {
                       error_network = '';
                       $('#error_network').text(error_network);
                       $('#network').removeClass('has-error');
                    }
                      
                    if($.trim($('#tarriff').val()).length == 0)
                    {
                       error_tarriff = 'Tarriff is required';
                       $('#error_tarriff').text(error_tarrif);
                       $('#tarriff').addClass('has-error');
                    }
                    else
                    {
                       error_tarrif = '';
                       $('#error_tarriff').text(error_tarrif);
                       $('#tarriff').removeClass('has-error');
                    }
                      
                    if($.trim($('#tags').val()).length == 0)
                    {
                       error_tags = 'Tags is required';
                       $('#error_tags').text(error_tags);
                       $('#tags').addClass('has-error');
                    }
                    else
                    {
                       error_tags = '';
                       $('#error_tags').text(error_tags);
                       $('#tags').removeClass('has-error');
                    }
                      
                    if(error_network!='' || error_tarrif!='' || error_tags!='')
                    {
                        return false;
                    }
                    else
                    {
                        $('#list_operator_details').removeClass('active active_tab1');
                        $('#list_operator_details').removeAttr('href data-toggle');
                        $('#operator_details').removeClass('active');
                        $('#list_operator_details').addClass('inactive_tab1');
                        $('#list_preview_details').removeClass('inactive_tab1');
                        $('#list_preview_details').addClass('active_tab1 active');
                        $('#list_preview_details').attr('href', '#preview_details');
                        $('#list_preview_details').attr('data-toggle', 'tab');
                        $('#preview_details').addClass('active in');

                       // $('#btn_bank_details').attr("disabled", "disabled");
                       // $(document).css('cursor', 'prgress');
                       // $("#register_form").submit();

                    }

                });


                $('#previous_btn_preview_details').click(function()
                {
                    $('#list_preview_details').removeClass('active active_tab1');
                    $('#list_preview_details').removeAttr('href data-toggle');
                    $('#preview_details').removeClass('active in');
                    $('#list_preview_details').addClass('inactive_tab1');
                    $('#list_operator_details').removeClass('inactive_tab1');
                    $('#list_operator_details').addClass('active_tab1 active');
                    $('#list_operator_details').attr('href', '#operator_details');
                    $('#list_operator_details').attr('data-toggle', 'tab');
                    $('#operator_details').addClass('active in');
                });

                $('#btn_preview_details').click(function()
                {               
                    $('#btn_preview_details').attr("disabled", "disabled");
                    $(document).css('cursor', 'prgress');
                    $("#register_form").submit();
                });


                $('#city').on('change', function()
                {
                    var city_id = this.value;
                    $.ajax({
                        url: "states-by-country.php",
                        type: "POST",
                        data:
                        {
                            city_id: city_id
                        },
                        cache: false,
                        success: function(result)
                        {
                            $("#state").html(result);
                            //$('#country-dropdown').html('<option value="">Select State First</option>'); 
                        }
                    });
                
               
                    var state_id = this.value;
                    $.ajax({
                        url: "countries-by-state.php",
                        type: "POST",
                        data:
                        {
                            state_id: state_id
                        },
                        cache: false,
                        success: function(result)
                        {
                            $("#country").html(result);
                        }
                    });
               


                    $.ajax({
                        url: "region-by-city.php",
                        type: "POST",
                        data:
                        {
                            city_id: city_id
                        },
                        cache: false,
                        success: function(result)
                        {
                            $("#region").html(result);
                        }
                    });
                });

            });
            </script>


            </div>
        </div>
    </div>       
</div>


<!-- js -->
<script src="vendors/scripts/core.js"></script>
<script src="vendors/scripts/script.min.js"></script>
<script src="vendors/scripts/process.js"></script>
<script src="vendors/scripts/layout-settings.js"></script>

</body>
</html>