
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
if(isset($_POST["cpo_name"]))
{
    sleep(5);

    $cpo_name = $_POST['cpo_name'];
    $station_name = $_POST['station_name'];
    $mobile = $_POST['mobile'];
    $address_1 = $_POST['address_1'];
    $address_2 = $_POST['address_2'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $region = $_POST['region'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $checkbox1=$_POST['amenities'];  
    $chk="";  
    foreach($checkbox1 as $chk1)  
    {  
      $chk .= $chk1."|";  
    }

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


    $query = mysqli_query($connect,"select * from `fca_stations` order by sno desc limit 1");
    if(mysqli_num_rows($query)>0)
    {
        while($row=mysqli_fetch_array($query))
        {
            $station_id_db = $row['station_id'];
            //$iparr = split ("\_", $station_id_db);
            $iparr = preg_split("/[_,]+/", $station_id_db);
            $station_id_val = $iparr[1]+1; 
            $station_id = $iparr[0]."_".$station_id_val;
        }   
    }
    else
    {
        $station_id_db = "station_";
        //$iparr = split ("\_", $station_id_db); 
        $iparr = preg_split("/[_,]+/", $station_id_db);
        $station_id = $iparr[0]."_1";
    }


        // INSERT INTO `fca_stations`(`sno`, `station_id`, `cpo_id`, `station_name`, `station_latitude`, `station_longitude`, `station_address_1`, `station_address_2`, `station_pincode`, `station_city`, `station_state`, `station_country`, `station_region`, `created_time`, `timeofupdate`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],[value-15])


        $insert_query = mysqli_query($connect,"INSERT INTO `fca_stations`(`station_id`, `cpo_id`, `station_name`, `amenities`, `station_latitude`, `station_longitude`, `station_address_1`, `station_address_2`, `station_pincode`, `station_city`, `station_state`, `station_country`, `station_region`, `created_time`,`station_mobile`,`station_password`,`invoice_address`,`invoice_gstno`) VALUES ('$station_id', '$cpo_name', '$station_name', '$chk', '$latitude', '$longitude', '$address_1', '$address_2', '$pincode', '$city', '$state', '$country', '$region', now(),'$mobile','YWRtaW4=','','')");

            // INSERT INTO `chargepoints_mani`(`chargepoint_name`, `manufacturing_date`, `integration_date`, `network_type`, `access_type`, `status`, `operator`, `network_protocol`, `ws_url`, `network_password`, `plugin_charge`, `local_auth_list`, `qr_code_id`, `evse_type`, `evse_id`, `reservation_time`, `max_power`, `supply_type`, `max_current`, `network`, `tarrif`, `tags`, `cms`, `created_time`) VALUES ('$cp_name','$manufacturing_date','$integration_date','$network_type','$access_type','$status','$operator','$network_protocol','$ws_url','$network_password','$plugincharge','$local_auth_list','$qr_code_id','$evse_type','$evse_id','$reservation_time','$max_power','$supply_type','$max_current','$network','$tarriff','$tags','chargengo',now())");
        
        if($insert_query)
        {
            // $message = '<div class="alert alert-success">
            //                 Station Registration Completed Successfully. Please wait for few secs to add the connectors for this Station.
            //             </div>';
                        ?>
                        <script type="text/javascript">
                            setTimeout(function ()
                            {
                               window.location.href= 'addconnector.php';
                            }, 2000);

                            alert("Station Registration Completed. Next add Connectors");
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
                <h2 style="text-align: center; color: #e41e1b;"> <b> Station Registration </b> </h2> <br><br>

                <?php echo $message; ?>
                <form method="post" id="register_form">
                    <!-- <ul class="nav nav-tabs">
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
                    </ul> -->

                    
                    <div class="tab-content">

                        <div class="tab-pane active" id="general_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> General Information </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> CPO : <span class="text-danger">(*)</span> </label>
                                                <select name="cpo_name" id="cpo_name" class="form-control" data-live-search="true">
                                                    <option value=""> Select CPO </option>
                                                    <?php
                                                        $result = mysqli_query($connect, "SELECT * FROM fca_cpo");
                                                        while($row = mysqli_fetch_array($result))
                                                        {
                                                            ?><option value="<?php echo $row['cpo_id']; ?>"><?php echo $row["cpo_name"];?></option><?php
                                                        }
                                                    ?>
                                                </select>
                                                <span id="error_cpo_name" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label> Station Name : <span class="text-danger">(*)</span> </label>
                                                <input type="text" name="station_name" id="station_name" class="form-control"/>
                                                <!-- <span id="user-availability-status"></span>    
                                                <p><img src="images/loader1.gif" id="loaderIcon" style="display:none" /></p> -->
                                                <span id="error_station_name" class="text-danger"></span>
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
                                                <label> Mobile : <span class="text-danger">(*)</span> </label><br>
                                                <input type="text" name="mobile" id="mobile" class="form-control" />
                                                <span id="error_mobile" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label> Address Line 1 : <span class="text-danger">(*)</span> </label><br>
                                                <input type="text" name="address_1" id="address_1" class="form-control" />
                                                <span id="error_address_1" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label> Address Line 2 : </label><br>
                                                <input type="text" name="address_2" id="address_2" class="form-control" />
                                                <span id="error_address_2" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label> Pincode :  <span class="text-danger">(*)</span> </label><br>
                                                <input type="text" name="pincode" id="pincode" class="form-control" />
                                                <span id="error_pincode" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label> City :  <span class="text-danger">(*)</span> </label>
                                                <input type="text" name="city" id="city" class="form-control" />
                                                <span id="error_city" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label for="state">State <span class="text-danger">(*)</span></label><br>
                                                <select id="state" name="state" data-live-search="true" class="form-control">
                                                    <option value="">Select State</option>
                                                    <?php
                                                        $result = mysqli_query($connect,"SELECT distinct(statefullname) FROM fca_cities");
                                                        while($row = mysqli_fetch_array($result))
                                                        {
                                                            ?><option value="<?php echo $row['statefullname'];?>"><?php echo $row["statefullname"];?></option><?php
                                                        }
                                                    ?>
                                                </select>
                                                <span id="error_state" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label for="country">Country</label>
                                                <select class="form-control" id="country" name="country"></select>
                                            </div><br>
                                            
                                            <div class="form-group">
                                                <label> Region </label>
                                                <select class="form-control" id="region" name="region"></select>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> Amenities </label><br>
                                                <input type="checkbox" id="amenities" name="amenities[]" value="Lodging"> Lodging
                                                <input type="checkbox" id="amenities" name="amenities[]" value="Dining"> Dining
                                                <input type="checkbox" id="amenities" name="amenities[]" value="Restroom"> Restroom 
                                                <input type="checkbox" id="amenities" name="amenities[]" value="Restaurant"> Restaurant
                                                <input type="checkbox" id="amenities" name="amenities[]" value="Parking"> Parking
                                            </div><br><br>

                                            <div class="form-group">
                                                <label> Latitude <span class="text-danger"> (*) </span>  </label>
                                                <!-- <input id="map-search" class="controls" type="hidden" placeholder="Search Box" size="104"> -->
                                                <input type="text" class="form-control" id="latitude" name="latitude">
                                                <span id="error_latitude" class="text-danger"></span>
                                            </div><br>


                                            <div class="form-group">
                                                <label> Longitude <span class="text-danger"> (*) </span>  </label>
                                                <input type="text" class="form-control" id="longitude" name="longitude">
                                                <span id="error_longitude" class="text-danger"></span>
                                                <!-- <input type="hidden" class="reg-input-city" placeholder="City"> -->
                                            </div><br>
                                            
                                            <p> If you don't know exact latitude & longitude, please <a onclick="initialize()" style="color: #e41e1b; cursor: pointer;"> click here </a> for map view </p>
                                            <div class="form-group">
                                                <div id="map_canvas" style="width: auto; height: 400px;"></div>
                                            </div><br>

                                            <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
                                            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAV8AiebjdcoS-Ratewz-HDkFt7XCq3zOM&libraries=places&callback=initMap"></script>

                                        </div>
                                    </div><br>
                                    <div align="center">
                                        <button type="button" name="btn_general_details" id="btn_general_details" style="background-color: #e41e1b; color: white;" class="btn"> Submit </button>
                                    </div><br/>
                                </div>
                            </div>
                        </div>


<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<style type="text/css">
  /*#regiration_form fieldset:not(:first-of-type) {
    display: none;
  }*/

/*  #latitude, #longitude
  {
    width: 100%;
    height: 2.714rem;
  }*/
  #maplocation
  {
    width: 30%;
    height: 2.714rem;
  }
  </style>


  <script type="text/javascript">

    function initialize()
    {
        // Creating map object
        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 12,
            center: new google.maps.LatLng(9.911647, 78.092797),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        // creates a draggable marker to the given coords
        var vMarker = new google.maps.Marker({
            position: new google.maps.LatLng(9.911647, 78.092797),
            draggable: true
        });
        // adds a listener to the marker
        // gets the coords when drag event ends
        // then updates the input with the new coords
        google.maps.event.addListener(vMarker, 'dragend', function (evt) {
            $("#latitude").val(evt.latLng.lat().toFixed(6));
            $("#longitude").val(evt.latLng.lng().toFixed(6));
            map.panTo(evt.latLng);
        });
        // centers the map on markers coords
        map.setCenter(vMarker.position);
        // adds the marker on the map
        vMarker.setMap(map);
    }
</script>



                    </div>
                </form>
              


            <script>
               


            $(document).ready(function()
            {

                $('#btn_general_details').click(function()
                {
                    var error_cpo_name = '';
                    var error_mobile = '';
                    var error_station_name = '';
                    var error_address_1 = '';
                    var error_pincode = '';
                    var error_city = '';
                    var error_state = '';
                    var error_latitude = '';
                    var error_longitude = '';

                    // var mobile_validation = /^\d{10}$/;
                    // var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              
                    if($.trim($('#cpo_name').val()).length == 0)
                    {
                        error_cpo_name = 'CPO Name is required';
                        $('#error_cpo_name').text(error_cpo_name);
                        $('#cpo_name').addClass('has-error');
                    }
                    else
                    {
                        error_cpo_name = '';
                        $('#error_cpo_name').text(error_cpo_name);
                        $('#cpo_name').removeClass('has-error');
                    }
                    if($.trim($('#mobile').val()).length == 0)
                    {
                        error_mobile = 'mobile number is required';
                        $('#error_mobile').text(error_mobile);
                        $('#mobile').addClass('has-error');
                    }
                    else
                    {
                       error_station_name = '';
                       $('#error_station_name').text(error_station_name);
                       $('#station_name').removeClass('has-error');
                    }
                    if($.trim($('#station_name').val()).length == 0)
                    {
                        error_station_name = 'Station Name is required';
                        $('#error_station_name').text(error_station_name);
                        $('#station_name').addClass('has-error');
                    }
                    else
                    {
                       error_station_name = '';
                       $('#error_station_name').text(error_station_name);
                       $('#station_name').removeClass('has-error');
                    }
                      
                    if($.trim($('#address_1').val()).length == 0)
                    {
                        error_address_1 = 'Address is required';
                        $('#error_address_1').text(error_address_1);
                        $('#address_1').addClass('has-error');
                    }
                    else
                    {
                       error_address_1 = '';
                       $('#error_address_1').text(error_address_1);
                       $('#address_1').removeClass('has-error');
                    }

                    if($.trim($('#pincode').val()).length == 0)
                    {
                       error_pincode = 'Pincode is required';
                       $('#error_pincode').text(error_pincode);
                       $('#pincode').addClass('has-error');
                    }
                    else
                    {
                       error_pincode = '';
                       $('#error_pincode').text(error_pincode);
                       $('#pincode').removeClass('has-error');
                    }

                    if($.trim($('#city').val()).length == 0)
                    {
                       error_city = 'City is required';
                       $('#error_city').text(error_city);
                       $('#city').addClass('has-error');
                    }
                    else
                    {
                       error_city = '';
                       $('#error_city').text(error_city);
                       $('#city').removeClass('has-error');
                    }

                    if($.trim($('#state').val()).length == 0)
                    {
                       error_state = 'State is required';
                       $('#error_state').text(error_state);
                       $('#state').addClass('has-error');
                    }
                    else
                    {
                       error_state = '';
                       $('#error_state').text(error_state);
                       $('#state').removeClass('has-error');
                    }
                    
                    if($.trim($('#latitude').val()).length == 0)
                    {
                       error_latitude = 'Latitude is required';
                       $('#error_latitude').text(error_latitude);
                       $('#latitude').addClass('has-error');
                    }
                    else
                    {
                       error_latitude = '';
                       $('#error_latitude').text(error_latitude);
                       $('#latitude').removeClass('has-error');
                    }
                    
                    if($.trim($('#longitude').val()).length == 0)
                    {
                       error_longitude = 'Longitude is required';
                       $('#error_longitude').text(error_longitude);
                       $('#longitude').addClass('has-error');
                    }
                    else
                    {
                       error_longitude = '';
                       $('#error_longitude').text(error_longitude);
                       $('#longitude').removeClass('has-error');
                    }
                    
                    if(error_mobile!=''||error_cpo_name !='' || error_station_name !='' || error_address_1 !='' || error_pincode !='' || error_city !='' || error_state !='' || error_latitude!='' || error_longitude!= '')
                    {
                       return false;
                    }
                    else
                    {
                        // $('#btn_preview_details').attr("disabled", "disabled");
                        $(document).css('cursor', 'prgress');
                        $("#register_form").submit();
                    }
                });
             
            
            
                // $('#btn_preview_details').click(function()
                // {               
                //     $('#btn_preview_details').attr("disabled", "disabled");
                //     $(document).css('cursor', 'prgress');
                //     $("#register_form").submit();
                // });


                
                $('#state').on('change', function()
                {
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
                            state_id: state_id
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