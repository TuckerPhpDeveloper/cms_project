
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
if(isset($_POST["email"]))
{
    sleep(5);
    $client_name = $_POST['client_name'];
    $company_name = $_POST['company_name'];
    $mobile = $_POST['mobile'];
    $landline = $_POST['landline'];
    $email = $_POST['email'];
    $aadhaar = $_POST['aadhaar'];
    $gst = $_POST['gst'];
    $pan = $_POST['pan'];

    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $region = $_POST['region'];

    $bank_name = $_POST['bank_name'];
    $branch_name = $_POST['branch_name'];
    $account_number = $_POST['account_number'];
    $account_name = $_POST['account_name'];
    $ifsc_code = $_POST['ifsc_code'];

    $query = mysqli_query($connect,"select * from `client_registration` order by id desc limit 1");
    if(mysqli_num_rows($query)>0)
    {
        while($row=mysqli_fetch_array($query))
        {
            $client_id_db = $row['network_id'];
            $iparr = split ("\_", $client_id_db);
            $client_id_val = $iparr[1]+1; 
            $client_id = $iparr[0]."_".$client_id_val;
        }   
    }
    else
    {
        $client_id_db = "network_";
        $iparr = split ("\_", $client_id_db); 
        $client_id = $iparr[0]."_1";
    }

    //$client_id = $client_id_db."1";


    $check_query = mysqli_query($connect,"select * from client_registration where client_name='$client_name'");
    if(mysqli_num_rows($check_query)>0)
    {
        while($row = mysqli_fetch_array($check_query))
        {
            $client_name_db = $row['client_name'];
        }
    }
    else
    {
        $client_name_db = '';
    }

    if($client_name_db != $client_name)
    {
        $insert_query = mysqli_query($connect,"INSERT INTO `client_registration`(`network_id`, `client_name`, `company_name`, `company_mobile`, `company_landline`, `company_mail`, `aadhaar`, `gst`, `pan`, `address`, `pincode`, `city`, `state`, `country`, `region`, `bank_name`, `branch_name`, `account_number`, `account_name`, `ifsc_code`, `cms`, `created_time`) VALUES ('$client_id','$client_name','$company_name','$mobile','$landline','$email','$aadhaar','$gst','$pan','$address','$pincode','$city','$state','$country','$region','$bank_name','$branch_name','$account_number','$account_name','$ifsc_code','chargengo',now())");
        
        if($insert_query)
        {
            // $message = '<div class="alert alert-success">
            //                 Network Registration Completed Successfully
            //             </div>';
                        ?>
                        <!-- <script type="text/javascript">
                            setTimeout(function ()
                            {
                               window.location.href= 'addchargepoint.php';
                            }, 10000);
                        </script> -->

                        <script type="text/javascript">
                            setTimeout(function ()
                            {
                               window.location.href= 'addchargepoint.php';
                            }, 2000);
                                
                            alert("Network Registration Completed. Next add Charging Points");
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
        // $message = '<div class="alert alert-primary">
        //                 Already Inserted this Network    
        //             </div>';
                    ?>
                    <script type="text/javascript">
                        setTimeout(function ()
                        {
                           window.location.href= 'chargingnetworks.php';
                        }, 2000);
                        alert("Already this Network is Registered. Check Charging Networks Section");
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
                <h2 style="text-align: center; color: #e41e1b;"> <b> Network Registration </b> </h2> <br><br>

                <?php echo $message; ?>
                <form method="post" id="register_form">
                    <ul class="nav nav-tabs">
                        <div class="row" style="width: 100%;">
                            <div class="col-sm-3">
                                <li class="nav-item">
                                    <a class="nav-link active_tab1" id="list_client_details" style="border:1px solid #ccc; padding: 20px; text-align: center;">Network Details</a>
                                </li>
                            </div>
                            <div class="col-sm-3">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_address_details" style="border:1px solid #ccc; padding: 20px; text-align: center;">Address Details</a>
                                </li>
                            </div>
                            <div class="col-sm-3">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_bank_details" style="border:1px solid #ccc; padding: 20px; text-align: center;">Bank Details</a>
                                </li>
                            </div>
                            <div class="col-sm-3">
                                <li class="nav-item">
                                    <a class="nav-link inactive_tab1" id="list_preview_details" style="border:1px solid #ccc; padding: 20px; text-align: center;"> Preview </a>
                                </li>
                            </div>
                        </div>
                    </ul>

                    
                    <div class="tab-content" style="margin-top:16px;">

                        <div class="tab-pane active" id="client_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Network Details</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label> Network Name : <span class="text-danger">(You can't edit Network Name in future)</span> </label>
                                        <input type="text" name="client_name" id="client_name" class="form-control" onBlur="checkAvailability()"/>
                                        <span id="user-availability-status"></span>    
                                        <p><img src="images/loader1.gif" id="loaderIcon" style="display:none" /></p>
                                        <span id="error_client_name" class="text-danger"></span>
                                    </div><br>
                                    <div class="form-group">
                                        <label> Company Name : <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="company_name" id="company_name" class="form-control" />
                                        <span id="error_company_name" class="text-danger"></span>
                                    </div><br>
                                    <div class="form-group">
                                        <label> Mobile Number :  <span class="text-danger">(*)</span> </label>
                                        <input type="number" name="mobile" id="mobile" class="form-control" />
                                        <span id="error_mobile" class="text-danger"></span>
                                    </div><br>
                                    <div class="form-group">
                                        <label> Landline Number : </label>
                                        <input type="number" name="landline" id="landline" class="form-control" />
                                        <!-- <span id="error_password" class="text-danger"></span> -->
                                    </div><br>
                                    <div class="form-group">
                                        <label> Email ID :  <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="email" id="email" class="form-control" />
                                        <span id="error_email" class="text-danger"></span>
                                    </div><br>
                                    <div class="form-group">
                                        <label> Aadhaar Number :  <span class="text-danger">(*)</span> </label>
                                        <input type="number" name="aadhaar" id="aadhaar" class="form-control" />
                                        <span id="error_aadhaar" class="text-danger"></span>
                                    </div><br>
                                    <div class="form-group">
                                        <label> GST Number :  <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="gst" id="gst" class="form-control" />
                                        <span id="error_gst" class="text-danger"></span>
                                    </div><br>
                                    <div class="form-group">
                                        <label> PAN Number :  <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="pan" id="pan" class="form-control" />
                                        <span id="error_pan" class="text-danger"></span>
                                    </div><br>
                                    <div align="center">
                                        <button type="button" name="btn_client_details" id="btn_client_details" style="background-color: #3d56d8; color: white;" class="btn">Next</button>
                                    </div><br/>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="address_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Address Details</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label> Company Address : <span class="text-danger">(*)</span> </label>
                                        <textarea name="address" id="address" class="form-control"></textarea>
                                        <span id="error_address" class="text-danger"></span>
                                    </div><br>
                                    
                                    <div class="form-group">
                                        <label> Pincode :  <span class="text-danger">(*)</span> </label>
                                        <input type="number" name="pincode" id="pincode" class="form-control" />
                                        <span id="error_pincode" class="text-danger"></span>
                                    </div><br>

                                    <!-- <div class="form-group">
                                        <label>Select Category</label>
                                        <select name="city" id="city" class="form-control input-lg" data-live-search="true" title="Select Category">

                                        </select>
                                    </div> -->
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

                                    <div align="center">
                                        <button type="button" name="previous_btn_address_details" id="previous_btn_address_details" class="btn btn-danger">Previous</button>
                                        <button type="button" name="btn_address_details" id="btn_address_details" style="background-color: #3d56d8; color: white;" class="btn">Next</button>
                                    </div><br/>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="bank_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Bank Details </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label> Bank Name <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control" />
                                        <span id="error_bank_name" class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label> Branch Name <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="branch_name" id="branch_name" class="form-control" />
                                        <span id="error_branch_name" class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label> Account Number <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="account_number" id="account_number" class="form-control" />
                                        <span id="error_account_number" class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label> Account Name <span class="text-danger">(*)</span> </label>
                                        <input type="text" name="account_name" id="account_name" class="form-control" />
                                        <span id="error_account_name" class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label> IFSC Code <span class="text-danger">(*)</span></label>
                                        <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
                                        <span id="error_ifsc_code" class="text-danger"></span>
                                    </div><br>

                                    <div align="center">
                                        <button type="button" name="previous_btn_bank_details" id="previous_btn_bank_details" class="btn btn-danger">Previous</button>
                                        <button type="button" name="btn_bank_details" id="btn_bank_details" style="background-color: #3d56d8; color: white;" class="btn" onclick="preview()"> Next </button>
                                    </div><br>
                                </div>
                            </div>
                        </div>

<script type="text/javascript">
    function preview()
    {
        var client_name = document.getElementById("client_name").value;
        var client_name_value = document.getElementById("client_name_value");
        client_name_value.innerText = client_name;

        var company_name = document.getElementById("company_name").value;
        var company_name_value = document.getElementById("company_name_value");
        company_name_value.innerText = company_name;

        var mobile = document.getElementById("mobile").value;
        var mobile_value = document.getElementById("mobile_value");
        mobile_value.innerText = mobile;

        var landline = document.getElementById("landline").value;
        var landline_value = document.getElementById("landline_value");
        landline_value.innerText = landline;

        var email = document.getElementById("email").value;
        var email_value = document.getElementById("email_value");
        email_value.innerText = email;

        var aadhaar = document.getElementById("aadhaar").value;
        var aadhaar_value = document.getElementById("aadhaar_value");
        aadhaar_value.innerText = aadhaar;

        var gst = document.getElementById("gst").value;
        var gst_value = document.getElementById("gst_value");
        gst_value.innerText = gst;

        var pan = document.getElementById("pan").value;
        var pan_value = document.getElementById("pan_value");
        pan_value.innerText = pan;

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

        var bank_name = document.getElementById("bank_name").value;
        var bank_name_value = document.getElementById("bank_name_value");
        bank_name_value.innerText = bank_name;

        var branch_name = document.getElementById("branch_name").value;
        var branch_name_value = document.getElementById("branch_name_value");
        branch_name_value.innerText = branch_name;

        var account_number = document.getElementById("account_number").value;
        var account_number_value = document.getElementById("account_number_value");
        account_number_value.innerText = account_number;

        var account_name = document.getElementById("account_name").value;
        var account_name_value = document.getElementById("account_name_value");
        account_name_value.innerText = account_name;

        var ifsc_code = document.getElementById("ifsc_code").value;
        var ifsc_code_value = document.getElementById("ifsc_code_value");
        ifsc_code_value.innerText = ifsc_code;
        
    }
</script>

                        <div class="tab-pane fade" id="preview_details">
                            <div class="panel panel-default">
                                <div class="panel-heading"> Network Registration Preview </div>
                                <div class="panel-body"><br>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6">
                                            <table border="1" class="table table-bordered">
                                                <tr>
                                                    <th> Client Name </th>
                                                    <td> <span id="client_name_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Company Name </th>
                                                    <td> <span id="company_name_value"></span>  </td>
                                                </tr>
                                                <tr>
                                                    <th> Mobile Number </th>
                                                    <td> <span id="mobile_value"></span>  </td>
                                                </tr>
                                                <tr>
                                                    <th> Landline Number </th>
                                                    <td> <span id="landline_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Email ID </th>
                                                    <td> <span id="email_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Aadhaar Number </th>
                                                    <td> <span id="aadhaar_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> GST Number </th>
                                                    <td> <span id="gst_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Pan Card Number </th>
                                                    <td> <span id="pan_value"></span> </td>
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
                                                    <th>Bank Name </th>
                                                    <td> <span id="bank_name_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Branch Name </th>
                                                    <td> <span id="branch_name_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Account Number </th>
                                                    <td> <span id="account_number_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> Account Name </th>
                                                    <td> <span id="account_name_value"></span> </td>
                                                </tr>
                                                <tr>
                                                    <th> IFSC Code </th>
                                                    <td> <span id="ifsc_code_value"></span> </td>
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
                var client_name_check_status = 0;

                function checkAvailability()
                {
                    $("#loaderIcon").show();    
                    jQuery.ajax({
                        url: "check_availability.php",
                        data:'username='+$("#client_name").val(),
                        type: "POST",
                        success:function(data)
                        {
                            //$("#user-availability-status").html(data);
                            $("#loaderIcon").hide();
                            if(data=='available')
                            {
                                //alert("Available");
                                client_name_check_status = 1;
                                error_client_name = '';
                                $('#error_client_name').text(error_client_name);
                                $('#client_name').removeClass('has-error');
                            }
                            else if(data=='taken')
                            {
                                //alert("Already taken this Network Name");
                                client_name_check_status = 2;
                                error_client_name = 'Network Name is already taken';
                                $('#error_client_name').text(error_client_name);
                                $('#client_name').addClass('has-error');
                            }
                        },
                        error:function (){}
                    });
                }


            $(document).ready(function()
            {
                
                $('#city').selectpicker();
                
                $('#btn_client_details').click(function()
                {
                    var error_client_name = '';
                    var error_company_name = '';
                    var error_mobile = '';
                    var error_email = '';
                    var error_aadhaar = '';
                    var error_gst = '';
                    var error_pan = '';

                    var mobile_validation = /^\d{10}$/;
                    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                    var aadhaar_validation = /^\d{12}$/;
                    var gst_validation = /^([0-9]){2}([A-Za-z]){5}([0-9]){4}([A-Za-z]){1}([0-9A-Za-z]{1})([Z-Zz-z]){1}([0-9A-Z]){1}?$/;
                    var pan_validation = /[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
              

                    if($.trim($('#client_name').val()).length == 0)
                    {
                        error_client_name = 'Network Name is required';
                        $('#error_client_name').text(error_client_name);
                        $('#client_name').addClass('has-error');
                    }
                    else if(client_name_check_status==2)
                    {
                        error_client_name = 'Network Name is already taken';
                        $('#error_client_name').text(error_client_name);
                        $('#client_name').addClass('has-error');
                    }
                    else
                    {
                        error_client_name = '';
                        $('#error_client_name').text(error_client_name);
                        $('#client_name').removeClass('has-error');
                    }

                    if($.trim($('#company_name').val()).length == 0)
                    {
                        error_company_name = 'Company Name is required';
                        $('#error_company_name').text(error_company_name);
                        $('#company_name').addClass('has-error');
                    }
                    else
                    {
                       error_company_name = '';
                       $('#error_company_name').text(error_company_name);
                       $('#company_name').removeClass('has-error');
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
                      
                    if($.trim($('#aadhaar').val()).length == 0)
                    {
                        error_aadhaar = 'Aadhaar Number is required';
                        $('#error_aadhaar').text(error_aadhaar);
                        $('#aadhaar').addClass('has-error');
                    }
                    else
                    {
                        if(!aadhaar_validation.test($('#aadhaar').val()))
                        {
                            error_aadhaar = 'Invalid Aadhaar Number';
                            $('#error_aadhaar').text(error_aadhaar);
                            $('#aadhaar').addClass('has-error');
                        }
                        else
                        {
                            error_aadhaar = '';
                            $('#error_aadhaar').text(error_aadhaar);
                            $('#aadhaar').removeClass('has-error');
                        }
                    }

                    if($.trim($('#gst').val()).length == 0)
                    {
                       error_gst = 'GST Number is required';
                       $('#error_gst').text(error_gst);
                       $('#gst').addClass('has-error');
                    }
                    else
                    {
                        if(!gst_validation.test($('#gst').val()))
                        {
                            error_gst = 'Invalid GST Number';
                            $('#error_gst').text(error_gst);
                            $('#gst').addClass('has-error');
                        }
                        else
                        {
                            error_gst = '';
                            $('#error_gst').text(error_gst);
                            $('#gst').removeClass('has-error');
                        }
                    }

                    if($.trim($('#pan').val()).length == 0)
                    {
                       error_pan = 'PAN Number is required';
                       $('#error_pan').text(error_pan);
                       $('#pan').addClass('has-error');
                    }
                    else
                    {
                        if(!pan_validation.test($('#pan').val()))
                        {
                            error_pan = 'Invalid PAN Number';
                            $('#error_pan').text(error_pan);
                            $('#pan').addClass('has-error');
                        }
                        else
                        {
                            error_pan = '';
                            $('#error_pan').text(error_pan);
                            $('#pan').removeClass('has-error');
                        }
                    }

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

                    
                    if(error_client_name!='' || error_company_name!='' || error_mobile!='' || error_email!='' || error_aadhaar!='' || error_gst!='' || error_pan!='' || client_name_check_status == 2)
                    {
                       return false;
                    }
                    else
                    {
                        $('#list_client_details').removeClass('active active_tab1');
                        $('#list_client_details').removeAttr('href data-toggle');
                        $('#client_details').removeClass('active');
                        $('#list_client_details').addClass('inactive_tab1');
                        $('#list_address_details').removeClass('inactive_tab1');
                        $('#list_address_details').addClass('active_tab1 active');
                        $('#list_address_details').attr('href', '#address_details');
                        $('#list_address_details').attr('data-toggle', 'tab');
                        $('#address_details').addClass('active in');
                    }
                });
             
                $('#previous_btn_address_details').click(function()
                {
                    $('#list_address_details').removeClass('active active_tab1');
                    $('#list_address_details').removeAttr('href data-toggle');
                    $('#address_details').removeClass('active in');
                    $('#list_address_details').addClass('inactive_tab1');
                    $('#list_client_details').removeClass('inactive_tab1');
                    $('#list_client_details').addClass('active_tab1 active');
                    $('#list_client_details').attr('href', '#client_details');
                    $('#list_client_details').attr('data-toggle', 'tab');
                    $('#client_details').addClass('active in');
                });
             

                $('#btn_address_details').click(function()
                {
                    var error_address = '';
                    var error_pincode = '';
                    var error_city = '';
                    var error_state = '';
                    var error_country = '';
              
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

                    if($.trim($('#country').val()).length == 0)
                    {
                       error_country = 'Country is required';
                       $('#error_country').text(error_country);
                       $('#country').addClass('has-error');
                    }
                    else
                    {
                       error_country = '';
                       $('#error_country').text(error_city);
                       $('#country').removeClass('has-error');
                    }

                    if(error_address!='' || error_pincode!='' || error_city!='' || error_state!='' || error_country!='')
                    {
                       return false;
                    }
                    else
                    {
                       $('#list_address_details').removeClass('active active_tab1');
                       $('#list_address_details').removeAttr('href data-toggle');
                       $('#address_details').removeClass('active');
                       $('#list_address_details').addClass('inactive_tab1');
                       $('#list_bank_details').removeClass('inactive_tab1');
                       $('#list_bank_details').addClass('active_tab1 active');
                       $('#list_bank_details').attr('href', '#bank_details');
                       $('#list_bank_details').attr('data-toggle', 'tab');
                       $('#bank_details').addClass('active in');
                    }
                });
             
                $('#previous_btn_bank_details').click(function()
                {
                    $('#list_bank_details').removeClass('active active_tab1');
                    $('#list_bank_details').removeAttr('href data-toggle');
                    $('#bank_details').removeClass('active in');
                    $('#list_bank_details').addClass('inactive_tab1');
                    $('#list_address_details').removeClass('inactive_tab1');
                    $('#list_address_details').addClass('active_tab1 active');
                    $('#list_address_details').attr('href', '#address_details');
                    $('#list_address_details').attr('data-toggle', 'tab');
                    $('#address_details').addClass('active in');
                });
             
                $('#btn_bank_details').click(function()
                {
                    var error_bank_name = '';
                    var error_branch_name = '';
                    var error_account_name = '';
                    var error_account_number = '';
                    var error_ifsc_code = '';

                    var mobile_validation = /^\d{10}$/;

                    if($.trim($('#bank_name').val()).length == 0)
                    {
                       error_bank_name = 'Bank Name is required';
                       $('#error_bank_name').text(error_bank_name);
                       $('#bank_name').addClass('has-error');
                    }
                    else
                    {
                       error_bank_name = '';
                       $('#error_bank_name').text(error_bank_name);
                       $('#bank_name').removeClass('has-error');
                    }
                      
                    if($.trim($('#branch_name').val()).length == 0)
                    {
                       error_branch_name = 'Bracnch Name is required';
                       $('#error_branch_name').text(error_branch_name);
                       $('#branch_name').addClass('has-error');
                    }
                    else
                    {
                       error_branch_name = '';
                       $('#error_branch_name').text(error_branch_name);
                       $('#branch_name').removeClass('has-error');
                    }
                      
                    if($.trim($('#account_number').val()).length == 0)
                    {
                       error_account_number = 'Account Number is required';
                       $('#error_account_number').text(error_account_number);
                       $('#account_number').addClass('has-error');
                    }
                    else
                    {
                       error_account_number = '';
                       $('#error_account_number').text(error_account_number);
                       $('#account_number').removeClass('has-error');
                    }
                      
                    if($.trim($('#account_name').val()).length == 0)
                    {
                       error_account_name = 'Account Name is required';
                       $('#error_account_name').text(error_account_name);
                       $('#account_name').addClass('has-error');
                    }
                    else
                    {
                       error_account_name = '';
                       $('#error_account_name').text(error_account_name);
                       $('#account_name').removeClass('has-error');
                    }
                      
                    if($.trim($('#ifsc_code').val()).length == 0)
                    {
                       error_ifsc_code = 'IFSC Code is required';
                       $('#error_ifsc_code').text(error_ifsc_code);
                       $('#ifsc_code').addClass('has-error');
                    }
                    else
                    {
                       error_ifsc_code = '';
                       $('#error_ifsc_code').text(error_ifsc_code);
                       $('#ifsc_code').removeClass('has-error');
                    }
                      
                    if(error_bank_name!='' || error_branch_name!='' || error_account_number!='' || error_account_name!='' || error_ifsc_code!='')
                    {
                       return false;
                    }
                    else
                    {
                        $('#list_bank_details').removeClass('active active_tab1');
                        $('#list_bank_details').removeAttr('href data-toggle');
                        $('#bank_details').removeClass('active');
                        $('#list_bank_details').addClass('inactive_tab1');
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
                    $('#list_bank_details').removeClass('inactive_tab1');
                    $('#list_bank_details').addClass('active_tab1 active');
                    $('#list_bank_details').attr('href', '#bank_details');
                    $('#list_bank_details').attr('data-toggle', 'tab');
                    $('#bank_details').addClass('active in');
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