
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
if(isset($_POST["zone_name"]))
{
    sleep(5);
    $zone_name = $_POST['zone_name'];
    $zone_desc = $_POST['zone_desc'];

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $region = $_POST['region'];
    
    $image = $_FILES['image']['tmp_name']; 
    $img = addslashes(file_get_contents($image)); 

    $check_query = mysqli_query($connect,"select * from charging_zones where zone_name='$zone_name'");
    if(mysqli_num_rows($check_query)>0)
    {
        while($row = mysqli_fetch_array($check_query))
        {
            $zone_name_db = $row['zone_name'];
        }
    }
    else
    {
        $zone_name_db = '';
    }

    if($zone_name_db != $zone_name)
    {
        $message = "INSERT INTO `charging_zones`(`zone_name`, `zone_desc`, `latitude`, `longitude`, `address`, `pincode`, `city`, `state`, `country`, `region`, `zone_image`) VALUES ('$zone_name',$zone_desc,'$latitude','$longitude','$address','$pincode','$city','$state','$country','$region','$img');";

        $insert_query = mysqli_query($connect,"INSERT INTO `charging_zones`(`zone_name`, `zone_desc`, `latitude`, `longitude`, `address`, `pincode`, `city`, `state`, `country`, `region`, `zone_image`) VALUES ('$zone_name','$zone_desc','$latitude','$longitude','$address','$pincode','$city','$state','$country','$region','$img');");
        
        if($insert_query)
        {
            $message = '<div class="alert alert-success">
                            Zone Registration Completed Successfully
                        </div>';
                        ?>
                        <script type="text/javascript">
                            setTimeout(function ()
                            {
                               window.location.href= 'chargingzones.php';
                            }, 10000);
                        </script>

                        <?php
        }
        else
        {
            $message = '<div class="alert alert-danger">
                            There is an error in Registration
                        </div>';
        }
    }
    else
    {       
        $message = '<div class="alert alert-primary">
                        Already Inserted this Zone Name    
                    </div>';
                    ?>
                    <script type="text/javascript">
                        setTimeout(function ()
                        {
                           window.location.href= 'addzones.php';
                        }, 10000);
                    </script>
                    <?php
    }
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
                <h2 style="text-align: center; color: #3d56d8;"> <b> Add Zones </b> </h2> <br><br>

                <?php echo $message; ?>
                <form method="post" id="register_form">
                    <ul class="nav nav-tabs">
                        <div class="row" style="width: 100%;">
                            <div class="col-sm-4">
                                <li class="nav-item">
                                    <a class="nav-link active_tab1" id="list_general_details" style="border:1px solid #ccc; padding: 20px; text-align: center;">General Details</a>
                                </li>
                            </div>
                            <div class="col-sm-4">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_address_details" style="border:1px solid #ccc; padding: 20px; text-align: center;">Location Details</a>
                                </li>
                            </div>
                            <div class="col-sm-4">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_preview_details" style="border:1px solid #ccc; padding: 20px; text-align: center;"> Preview </a>
                                </li>
                            </div>
                        </div>
                    </ul>

                    
                    <div class="tab-content" style="margin-top:16px;">

                        <div class="tab-pane active" id="general_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> General Details</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label> Zone Name : <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="zone_name" id="zone_name" class="form-control" onBlur="checkAvailability()"/>
                                        <span id="user-availability-status"></span>    
                                        <p><img src="images/loader1.gif" id="loaderIcon" style="display:none" /></p>
                                        <span id="error_zone_name" class="text-danger"></span>
                                    </div><br>
                                    <div class="form-group">
                                        <label> Short Description : <span class="text-danger">(*)</span> </label>
                                        <textarea name="zone_desc" id="zone_desc" class="form-control"></textarea>
                                        <span id="error_zone_desc" class="text-danger"></span>
                                    </div><br>
                                    <div align="center">
                                        <button type="button" name="btn_general_details" id="btn_general_details" style="background-color: #3d56d8; color: white;" class="btn">Next</button>
                                    </div><br/>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="address_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Location Details</div>
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label> Latitude : <span class="text-danger">(*)</span> </label>
                                        <input type="number" name="latitude" id="latitude" class="form-control">
                                        <span id="error_latitude" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Longitude : <span class="text-danger">(*)</span> </label>
                                        <input type="number" name="longitude" id="longitude" class="form-control">
                                        <span id="error_longitude" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Address : <span class="text-danger">(*)</span> </label>
                                        <textarea name="address" id="address" class="form-control"></textarea>
                                        <span id="error_address" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Pincode :  <span class="text-danger">(*)</span> </label>
                                        <input type="number" name="pincode" id="pincode" class="form-control" />
                                        <span id="error_pincode" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="city">City <span class="text-danger">(*)</span> </label><br>
                                        <select id="city" name="city" data-live-search="true">
                                            <option value="">Select City</option>
                                            <?php
                                                $result = mysqli_query($connect,"SELECT * FROM cities1");
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    ?><option value="<?php echo $row['cityfullname'];?>"><?php echo $row["cityfullname"];?></option><?php
                                                }
                                            ?>
                                        </select>
                                        <span id="error_city" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select class="form-control" id="state" name="state"></select>
                                        <span id="error_state" class="text-danger"></span>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control" id="country" name="country"></select>
                                        <span id="error_country" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Region </label>
                                        <select class="form-control" id="region" name="region"></select>
                                    </div><br>

                                    <div class="form-group">
                                        <label> Select Image : </label>
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div><br>
                                    
                                    <div align="center">
                                        <button type="button" name="previous_btn_address_details" id="previous_btn_address_details" class="btn btn-danger">Previous</button>
                                        <button type="button" name="btn_address_details" id="btn_address_details" style="background-color: #3d56d8; color: white;" class="btn" onclick="preview()">Next</button>
                                    </div><br/>
                                </div>
                            </div>
                        </div>

                       

<script type="text/javascript">
    function preview()
    {
        var zone_name = document.getElementById("zone_name").value;
        var zone_name_value = document.getElementById("zone_name_value");
        zone_name_value.innerText = zone_name;

        var zone_desc = document.getElementById("zone_desc").value;
        var zone_desc_value = document.getElementById("zone_desc_value");
        zone_desc_value.innerText = zone_desc;

        var latitude = document.getElementById("latitude").value;
        var latitude_value = document.getElementById("latitude_value");
        latitude_value.innerText = latitude;

        var longitude = document.getElementById("longitude").value;
        var longitude_value = document.getElementById("longitude_value");
        longitude_value.innerText = longitude;
        
        var address = document.getElementById("address").value;
        var address_value = document.getElementById("address_value");
        address_value.innerText = address;

        var pincode = document.getElementById("pincode").value;
        var pincode_value = document.getElementById("pincode_value");
        pincode_value.innerText = pincode;

        var city = document.getElementById("city").value;
        var city_value = document.getElementById("city_value");
        city_value.innerText = city;

        var state = document.getElementById("state").value;
        var state_value = document.getElementById("state_value");
        state_value.innerText = state;

        var country = document.getElementById("country").value;
        var country_value = document.getElementById("country_value");
        country_value.innerText = country;

        var region = document.getElementById("region").value;
        var region_value = document.getElementById("region_value");
        region_value.innerText = region;
        
        
    }
</script>

                        <div class="tab-pane fade" id="preview_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Zone Preview </div>
                                <div class="panel-body"><br>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6">
                                            <table border="1" class="table table-bordered">
                                                <tr>
                                                    <th> Zone Name </th>
                                                    <td> <span id="zone_name_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Zone Description </th>
                                                    <td> <span id="zone_desc_value"></span></td>
                                                </tr>
                                                <tr>
                                                    <th> Latitude </th>
                                                    <td> <span id="latitude_value"></span></td>
                                                </tr>
                                                <tr>
                                                    <th> Longitude </th>
                                                    <td> <span id="longitude_value"></span></td>
                                                </tr>
                                                <tr>
                                                    <th> Address </th>
                                                    <td> <span id="address_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th>Pin Code</th>
                                                    <td> <span id="pincode_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> City </th>
                                                    <td> <span id="city_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td> <span id="state_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th>Country</th>
                                                    <td> <span id="country_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Region </th>
                                                    <td> <span id="region_value"></span> </td>
                                                </tr>
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
                var zone_name_check_status = 0;

                function checkAvailability()
                {
                    $("#loaderIcon").show();    
                    jQuery.ajax({
                        url: "check_zone_availability.php",
                        data:'username='+$("#zone_name").val(),
                        type: "POST",
                        success:function(data)
                        {
                            //$("#user-availability-status").html(data);
                            $("#loaderIcon").hide();
                            if(data=='available')
                            {
                                //alert("Available");
                                zone_name_check_status = 1;
                                error_zone_name = '';
                                $('#error_zone_name').text(error_zone_name);
                                $('#zone_name').removeClass('has-error');
                            }
                            else if(data=='taken')
                            {
                                //alert("Already taken this Network Name");
                                zone_name_check_status = 2;
                                error_zone_name = 'Zone Name is already taken';
                                $('#error_zone_name').text(error_zone_name);
                                $('#zone_name').addClass('has-error');
                            }
                        },
                        error:function (){}
                    });
                }


            $(document).ready(function()
            {
                
                $('#city').selectpicker();
                
                $('#btn_general_details').click(function()
                {
                    var error_zone_name = '';
                    var error_zone_desc = '';

              
                    if($.trim($('#zone_name').val()).length == 0)
                    {
                        error_zone_name = 'Zone Name is required';
                        $('#error_zone_name').text(error_zone_name);
                        $('#zone_name').addClass('has-error');
                    }
                    else if(zone_name_check_status==2)
                    {
                        error_zone_name = 'Zone Name is already taken';
                        $('#error_zone_name').text(error_zone_name);
                        $('#zone_name').addClass('has-error');
                    }
                    else
                    {
                        error_zone_name = '';
                        $('#error_zone_name').text(error_zone_name);
                        $('#zone_name').removeClass('has-error');
                    }

                    if($.trim($('#zone_desc').val()).length == 0)
                    {
                        error_zone_desc = 'Zone Description is required';
                        $('#error_zone_desc').text(error_zone_desc);
                        $('#zone_desc').addClass('has-error');
                    }
                    else
                    {
                       error_zone_desc = '';
                       $('#error_zone_desc').text(error_zone_desc);
                       $('#zone_desc').removeClass('has-error');
                    }

                    
                    // if(error_client_name!='' || error_company_name!='' || error_mobile!='' || error_email!='' || error_aadhaar!='' || error_gst!='' || error_pan!='' || client_name_check_status == 2)
                    // {
                    //    return false;
                    // }
                    // else
                    // {
                        $('#list_general_details').removeClass('active active_tab1');
                        $('#list_general_details').removeAttr('href data-toggle');
                        $('#general_details').removeClass('active');
                        $('#list_general_details').addClass('inactive_tab1');
                        $('#list_address_details').removeClass('inactive_tab1');
                        $('#list_address_details').addClass('active_tab1 active');
                        $('#list_address_details').attr('href', '#address_details');
                        $('#list_address_details').attr('data-toggle', 'tab');
                        $('#address_details').addClass('active in');
                    //}
                });
             
                $('#previous_btn_address_details').click(function()
                {
                    $('#list_address_details').removeClass('active active_tab1');
                    $('#list_address_details').removeAttr('href data-toggle');
                    $('#address_details').removeClass('active in');
                    $('#list_address_details').addClass('inactive_tab1');
                    $('#list_general_details').removeClass('inactive_tab1');
                    $('#list_general_details').addClass('active_tab1 active');
                    $('#list_general_details').attr('href', '#general_details');
                    $('#list_general_details').attr('data-toggle', 'tab');
                    $('#general_details').addClass('active in');
                });
             

                $('#btn_address_details').click(function()
                {
                    var error_latitude = '';
                    var error_longitude = '';
                    var error_address = '';
                    var error_pincode = '';
                    var error_city = '';
                    var error_state = '';
                    var error_country = '';
              
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
              
                    if($.trim($('#address').val()).length == 0)
                    {
                        error_address = 'Address is required';
                        $('#error_address').text(error_address);
                        $('#address').addClass('has-error');
                    }
                    else
                    {
                        error_address = '';
                        $('#error_address').text(error_address);
                        $('#address').removeClass('has-error');
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

                    // if(error_address!='' || error_pincode!='' || error_city!='')
                    // {
                    //    return false;
                    // }
                    // else
                    // {
                       $('#list_address_details').removeClass('active active_tab1');
                       $('#list_address_details').removeAttr('href data-toggle');
                       $('#address_details').removeClass('active');
                       $('#list_address_details').addClass('inactive_tab1');
                       $('#list_preview_details').removeClass('inactive_tab1');
                       $('#list_preview_details').addClass('active_tab1 active');
                       $('#list_preview_details').attr('href', '#preview_details');
                       $('#list_preview_details').attr('data-toggle', 'tab');
                       $('#preview_details').addClass('active in');
                    //}
                });
             
             
                $('#previous_btn_preview_details').click(function()
                {
                    $('#list_preview_details').removeClass('active active_tab1');
                    $('#list_preview_details').removeAttr('href data-toggle');
                    $('#preview_details').removeClass('active in');
                    $('#list_preview_details').addClass('inactive_tab1');
                    $('#list_address_details').removeClass('inactive_tab1');
                    $('#list_address_details').addClass('active_tab1 active');
                    $('#list_address_details').attr('href', '#address_details');
                    $('#list_address_details').attr('data-toggle', 'tab');
                    $('#address_details').addClass('active in');
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