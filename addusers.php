
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
if(isset($_POST["name"]))
{
    sleep(5);

 $type = $_POST['network_type'];
  $cms = $_POST['cms_id'];
    $idtag = $_POST['idtag'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address_1 = $_POST['address_1'];
    $address_2 = $_POST['address_2'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $expiry_date = date('Y-m-d H:i:s', strtotime('+1 years'));

    // $query = mysqli_query($connect,"select * from `fca_stations` order by sno desc limit 1");
    // if(mysqli_num_rows($query)>0)
    // {
    //     while($row=mysqli_fetch_array($query))
    //     {
    //         $station_id_db = $row['station_id'];
    //         //$iparr = split ("\_", $station_id_db);
    //         $iparr = preg_split("/[_,]+/", $station_id_db);
    //         $station_id_val = $iparr[1]+1; 
    //         $station_id = $iparr[0]."_".$station_id_val;
    //     }   
    // }
    // else
    // {
    //     $station_id_db = "station_";
    //     //$iparr = split ("\_", $station_id_db); 
    //     $iparr = preg_split("/[_,]+/", $station_id_db);
    //     $station_id = $iparr[0]."_1";
    // }


echo $query="INSERT INTO `fca_users`(`idtag`,`dc_idtag`,`parent_idtag`, `name`, `mobile`, `email`, `password`,`OTP`,`vehicle`,`expiry_date`,`wallet_amount`,`m_status`, `status`,`cms_id`,`timeofupdate`) VALUES ('$idtag',NULL,'','$name','$mobile','$email','$type','','','$expiry_date','0.00','0','1','$cms',now())";
echo $query1="INSERT INTO `fca_users_details`(`idtag`, `address_1`, `address_2`, `pincode`, `city`, `state`, `country`) VALUES ('$idtag','$address_1','$address_2','$pincode','$city','$state','$country')";
        $insert_query = mysqli_query($connect,$query);
        $insert_query1 = mysqli_query($connect,$query1);

            // INSERT INTO `chargepoints_mani`(`chargepoint_name`, `manufacturing_date`, `integration_date`, `network_type`, `access_type`, `status`, `operator`, `network_protocol`, `ws_url`, `network_password`, `plugin_charge`, `local_auth_list`, `qr_code_id`, `evse_type`, `evse_id`, `reservation_time`, `max_power`, `supply_type`, `max_current`, `network`, `tarrif`, `tags`, `cms`, `created_time`) VALUES ('$cp_name','$manufacturing_date','$integration_date','$network_type','$access_type','$status','$operator','$network_protocol','$ws_url','$network_password','$plugincharge','$local_auth_list','$qr_code_id','$evse_type','$evse_id','$reservation_time','$max_power','$supply_type','$max_current','$network','$tarriff','$tags','chargengo',now())");
        
        if($insert_query && $insert_query1)
        {
            // $message = '<div class="alert alert-success">
            //                 Station Registration Completed Successfully. Please wait for few secs to add the connectors for this Station.
            //             </div>';
                        ?>
                        <script type="text/javascript">
                            setTimeout(function ()
                            {
                               window.location.href= 'users.php';
                            }, 2000);

                            alert("RFID Registration Completed.");
                        </script>

                        <?php
        }
        else
        {
            $message = '<div class="alert alert-danger">
                            There is an error in RFID Registration
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
                <h2 style="text-align: center; color: #3d56d8;"> <b> RFID Registration </b> </h2> <br><br>

                <?php echo $message; ?>
                <form method="post" id="register_form">
                    
                    <div class="tab-content">

                        <div class="tab-pane active" id="general_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> RFID Details </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> IDTAG : <span class="text-danger"> (*) </span> </label>
                                                <input type="text" name="idtag" id="idtag" class="form-control" onBlur="checkAvailability()" />
                                                <span id="idtag-availability-status"></span>    
                                                <p><img src="images/loader1.gif" id="loaderIcon" style="display:none" /></p>
                                                <span id="error_idtag" class="text-danger"></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label> CMS : <span class="text-danger">(*)</span> </label>
                                                <select name="cms_id" id="cms_id" class="form-control" data-live-search="true">
                                                    <option value=""> Select CMS </option>
                                                    <?php
                                                        $result = mysqli_query($connect, "SELECT * FROM `fca_cms_login`");
                                                        while($row = mysqli_fetch_array($result))
                                                        {
                                                            ?><option value="<?php echo $row['cms_id']; ?>"><?php echo $row["cms_id"];?></option><?php
                                                        }
                                                    ?>
                                                </select>
                                                <span id="error_cpo_name" class="text-danger"></span>
                                            </div><br>
                                        <div class="form-group">
                                            <label> User Type : <span class="text-danger">(*)</span> </label>
                                            <select name="network_type" id="network_type" class="form-control">
                                                <option> Select Type </option>
                                                <option value="*free"> Free card </option>
                                                <option value="*test"> Test card </option>
                                                <option value="*gift"> Gift card </option>
                                                <option value="*own"> Owner card </option>
                                                <option value=""> Normal </option>
                                            </select>
                                           <span id="error_cpo_name" class="text-danger"></span>
                                        </div><br>
                                            <div class="form-group">
                                                <label> Name : <span class="text-danger">(*)</span> </label>
                                                <input type="text" name="name" id="name" class="form-control">
                                                <span id="error_name" class="text-danger"></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label> Mobile Number :  <span class="text-danger">(*)</span> </label>
                                                <input type="number" name="mobile" id="mobile" class="form-control" />
                                                <span id="error_mobile" class="text-danger"></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label> Email ID :  <span class="text-danger">(*)</span> </label>
                                                <input type="email" name="email" id="email" class="form-control" />
                                                <span id="error_email" class="text-danger"></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label> Pincode :  <span class="text-danger">(*)</span> </label><br>
                                                <input type="text" name="pincode" id="pincode" class="form-control" />
                                                <span id="error_pincode" class="text-danger"></span>
                                            </div><br>

                                        </div>

                                        <div class="col-sm-6">
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
                                            
                                        </div>
                                    </div><br>
                                    <div align="center">
                                        <button type="button" name="btn_general_details" id="btn_general_details" style="background-color: #3d56d8; color: white;" class="btn"> Submit </button>
                                    </div><br/>
                                </div>
                            </div>
                        </div>


<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>




                    </div>
                </form>
              


            <script>
               
            var idtag_check_status = 0;

            function checkAvailability()
            {
                $("#loaderIcon").show();    
                jQuery.ajax({
                    url: "idtag_check_availability.php",
                    data:'idtag='+$("#idtag").val(),
                    type: "POST",
                    success:function(data)
                    {
                        //$("#user-availability-status").html(data);
                        $("#loaderIcon").hide();
                        if(data=='available')
                        {
                            //alert("Available");
                            idtag_check_status = 1;
                            error_idtag = '';
                            $('#error_idtag').text(error_idtag);
                            $('#idtag').removeClass('has-error');
                        }
                        else if(data=='taken')
                        {
                            //alert("Already taken this Network Name");
                            idtag_check_status = 2;
                            error_idtag = 'IDTAG is already taken';
                            $('#error_idtag').text(error_idtag);
                            $('#idtag').addClass('has-error');
                        }
                    },
                    error:function (){}
                });
            }

            $(document).ready(function()
            {
                $('#btn_general_details').click(function()
                {
                    var error_name = '';
                    var error_mobile = '';
                    var error_email = '';
                    var error_idtag = '';
                    var error_address_1 = '';
                    var error_pincode = '';
                    var error_city = '';
                    var error_state = '';

                    var mobile_validation = /^\d{10}$/;
                    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              
                    if($.trim($('#name').val()).length == 0)
                    {
                        error_name = 'Name is required';
                        $('#error_name').text(error_name);
                        $('#name').addClass('has-error');
                    }
                    else
                    {
                        error_name = '';
                        $('#error_name').text(error_name);
                        $('#name').removeClass('has-error');
                    }

                    if($.trim($('#mobile').val()).length == 0)
                    {
                       error_mobile = 'Mobile Number is required';
                       $('#error_mobile').text(error_mobile);
                       $('#mobile').addClass('has-error');
                    }
                    else
                    {
                        if(!mobile_validation.test($('#mobile').val()))
                        {
                            error_mobile = 'Invalid Mobile Number';
                            $('#error_mobile').text(error_mobile);
                            $('#mobile').addClass('has-error');
                        }
                        else
                        {
                            error_mobile = '';
                            $('#error_mobile').text(error_mobile);
                            $('#mobile').removeClass('has-error');
                        }
                    }

                    if($.trim($('#email').val()).length == 0)
                    {
                        error_email = 'Email ID is required';
                        $('#error_email').text(error_email);
                        $('#email').addClass('has-error');
                    }
                    else
                    {
                        if(!filter.test($('#email').val()))
                        {
                            error_email = 'Invalid Email';
                            $('#error_email').text(error_email);
                            $('#email').addClass('has-error');
                        }
                        else
                        {
                            error_email = '';
                            $('#error_email').text(error_email);
                            $('#email').removeClass('has-error');
                        }
                    }



                    if($.trim($('#idtag').val()).length == 0)
                    {
                        error_idtag = 'IDTAG is required';
                        $('#error_idtag').text(error_idtag);
                        $('#idtag').addClass('has-error');
                    }
                    else if(idtag_check_status==2)
                    {
                        error_idtag = 'IDTAG is already taken';
                        $('#error_idtag').text(error_idtag);
                        $('#idtag').addClass('has-error');
                    }
                    else
                    {
                        error_idtag = '';
                        $('#error_idtag').text(error_idtag);
                        $('#idtag').removeClass('has-error');
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
                    
                    if(error_name !='' || error_mobile !='' || error_email !='' || error_idtag !='' || error_address_1 !='' || error_pincode !='' || error_city!='' || error_state!='' || idtag_check_status == '2')
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