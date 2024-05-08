
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
if(isset($_POST["mobile"]))
{
    sleep(5);

 $type = $_POST['network_type'];
    $idtag = $_POST['idtag'];
    $mobile = $_POST['mobile'];
    $payid = $_POST['payid'];
    $amount = $_POST['amount'];
   

if($type=="1")
{
     $query = "SELECT `fca_function_wallet_update_tax`('$amount', '1', '$idtag', '$payid')";
$result = mysqli_query($connect, $query);
}else
{
    $query = "SELECT `fca_function_wallet_update`('$amount', '1', '$idtag', '$payid')";
$result = mysqli_query($connect, $query);
}



        if($result)
        {
                        ?>
                        <script type="text/javascript">
                            setTimeout(function ()
                            {
                               window.location.href= 'users.php';
                            }, 2000);

                            alert("Add Wallet Completed.");
                        </script>

                        <?php
        }
        else
        {
            $message = '<div class="alert alert-danger">
                            There is an error in Add Wallet
                        </div>';
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
                <h2 style="text-align: center; color: #3d56d8;"> <b> Add To Wallet </b> </h2> <br><br>

                <?php echo $message; ?>
                <form method="post" id="register_form">
                    
                    <div class="tab-content">

                        <div class="tab-pane active" id="general_details">
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
                                            <label> User Type : <span class="text-danger">(*)</span> </label>
                                            <select name="network_type" id="network_type" class="form-control">
                                                <option> Select Type </option>
                                                <option value="1"> With TAX </option>
                                                <option value="2"> Without TAX </option>
                                            </select>
                                           <span id="error_cpo_name" class="text-danger"></span>
                                        </div><br>
                                            <div class="form-group">
                                                <label> Mobile Number :  <span class="text-danger">(*)</span> </label>
                                                <input type="number" name="mobile" id="mobile" class="form-control" />
                                                <span id="error_mobile" class="text-danger"></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label> Pay ID :  <span class="text-danger">(*)</span> </label>
                                                <input type="payid" name="payid" id="payid" class="form-control" />
                                                <span id="error_email" class="text-danger"></span>
                                            </div><br>
                                            <div class="form-group">
                                                <label> Amount :  <span class="text-danger">(*)</span> </label><br>
                                                <input type="text" name="amount" id="amount" class="form-control" />
                                                <span id="error_pincode" class="text-danger"></span>
                                            </div><br>

                                        </div>
                                         </div>
                                    <div>
                                        <button type="button" name="btn_general_details" id="btn_general_details" style="background-color: #3d56d8; color: white;" class="btn"> Submit </button>
                                    </div><br/>
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
                             //alert("Already taken this Network Name");
                            idtag_check_status = 2;
                            error_idtag = 'IDTAG is NOT Avail';
                            $('#error_idtag').text(error_idtag);
                            $('#idtag').addClass('has-error');
                        }
                        else if(data=='taken')
                        {
                            //alert("Available");
                            idtag_check_status = 1;
                            error_idtag = '';
                            $('#error_idtag').text(error_idtag);
                            $('#idtag').removeClass('has-error');
                           
                        }
                    },
                    error:function (){}
                });
            }

            $(document).ready(function()
            {
                $('#btn_general_details').click(function()
                {
                    var error_mobile = '';
                    var error_email = '';
                    var error_idtag = '';
                    var error_pincode = '';

                    var mobile_validation = /^\d{10}$/;
                    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              
             

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

                    if($.trim($('#payid').val()).length == 0)
                    {
                        error_email = 'Email ID is required';
                        $('#error_email').text(error_email);
                        $('#payid').addClass('has-error');
                    }
                    else
                    {
                       
                            error_email = '';
                            $('#error_email').text(error_email);
                            $('#payid').removeClass('has-error');
                        
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

                    if($.trim($('#amount').val()).length == 0)
                    {
                       error_pincode = 'Pincode is required';
                       $('#error_pincode').text(error_pincode);
                       $('#amount').addClass('has-error');
                    }
                    else
                    {
                       error_pincode = '';
                       $('#error_pincode').text(error_pincode);
                       $('#amount').removeClass('has-error');
                    }

                  
                    if(error_mobile !='' || error_email !='' || error_idtag !='' || error_pincode !='' || idtag_check_status == '2')
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