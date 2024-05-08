
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

    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $designation = $_POST['designation'];

    $cms_id = $_POST['cms_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];


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



        $insert_query = mysqli_query($connect,"INSERT INTO `fca_cms_login`(`cms_id`, `username`, `password`, `name`, `mobile`, `email`, `designation`, `logo`, `permission`) VALUES ('$cms_id','$username','$password','$name','$mobile','$email','$designation','','')");

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
                               window.location.href= 'cms.php';
                            }, 2000);

                            alert("CMS Registration Completed.");
                        </script>

                        <?php
        }
        else
        {
            $message = '<div class="alert alert-danger">
                            There is an error in CMS Registration
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
                <h2 style="text-align: center; color: #3d56d8;"> <b> CMS Registration </b> </h2> <br><br>

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
                                <div class="panel-heading"> CMS Details </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label> CMS Name : <span class="text-danger">(*)</span> </label>
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
                                                <label> Designation : </label>
                                                <input type="text" name="designation" id="designation" class="form-control" />
                                            </div><br>

                                        </div>

                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label> CMS ID : <span class="text-danger"> (*) </span> </label>
                                                <input type="text" name="cms_id" id="cms_id" class="form-control" onBlur="checkAvailability()" />
                                                <span id="cms-id-availability-status"></span>    
                                                <p><img src="images/loader1.gif" id="loaderIcon" style="display:none" /></p>
                                                <span id="error_cms_id" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label> Username <span class="text-danger"> (*) </span>  </label>
                                                <input type="text" class="form-control" id="username" name="username">
                                                <span id="error_username" class="text-danger"></span>
                                            </div><br>

                                            <div class="form-group">
                                                <label> Password <span class="text-danger"> (*) </span>  </label>
                                                <input type="password" class="form-control" id="password" name="password">
                                                <span id="error_password" class="text-danger"></span>
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
               
            var cms_id_check_status = 0;

            function checkAvailability()
            {
                $("#loaderIcon").show();    
                jQuery.ajax({
                    url: "cms_check_availability.php",
                    data:'cms_id='+$("#cms_id").val(),
                    type: "POST",
                    success:function(data)
                    {
                        //$("#user-availability-status").html(data);
                        $("#loaderIcon").hide();
                        if(data=='available')
                        {
                            //alert("Available");
                            cms_id_check_status = 1;
                            error_cms_id = '';
                            $('#error_cms_id').text(error_cms_id);
                            $('#cms_id').removeClass('has-error');
                        }
                        else if(data=='taken')
                        {
                            //alert("Already taken this Network Name");
                            cms_id_check_status = 2;
                            error_cms_id = 'CMS ID is already taken';
                            $('#error_cms_id').text(error_cms_id);
                            $('#cms_id').addClass('has-error');
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
                    var error_description = '';
                    var error_cms_id = '';
                    var error_username = '';
                    var error_password = '';

                    var mobile_validation = /^\d{10}$/;
                    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              
                    if($.trim($('#name').val()).length == 0)
                    {
                        error_name = 'CMS Name is required';
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



                    if($.trim($('#cms_id').val()).length == 0)
                    {
                        error_cms_id = 'CMS ID is required';
                        $('#error_cms_id').text(error_cms_id);
                        $('#cms_id').addClass('has-error');
                    }
                    else if(cms_id_check_status==2)
                    {
                        error_cms_id = 'CMS ID is already taken';
                        $('#error_cms_id').text(error_cms_id);
                        $('#cms_id').addClass('has-error');
                    }
                    else
                    {
                        error_cms_id = '';
                        $('#error_cms_id').text(error_cms_id);
                        $('#cms_id').removeClass('has-error');
                    }


                    if($.trim($('#username').val()).length == 0)
                    {
                        error_username = 'Username is required';
                        $('#error_username').text(error_username);
                        $('#username').addClass('has-error');
                    }
                    else
                    {
                       error_username = '';
                       $('#error_username').text(error_username);
                       $('#username').removeClass('has-error');
                    }
                      
                    if($.trim($('#password').val()).length == 0)
                    {
                        error_password = 'Password is required';
                        $('#error_password').text(error_password);
                        $('#password').addClass('has-error');
                    }
                    else
                    {
                       error_password = '';
                       $('#error_password').text(error_password);
                       $('#password').removeClass('has-error');
                    }
                    
                    if(error_name !='' || error_mobile !='' || error_email !='' || error_description !='' || error_cms_id !='' || error_username !='' || error_password!='' || cms_id_check_status == '2')
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