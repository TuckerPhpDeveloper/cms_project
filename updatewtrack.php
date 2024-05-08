<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include "include/dbconnect.php"; ?>
<?php
$order_id = $_REQUEST["order_id"];
$s_query = mysqli_query(
    $connect,
    "SELECT `idtag`, `amount`, `status` FROM `fca_wallet_track` WHERE `order_id`= '$order_id'"
);
$fetch = mysqli_fetch_array($s_query);
$s_idtag = $fetch[0];
$s_amount = $fetch[1];
$s_status = $fetch[2];
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
                
<?php if (isset($_POST["submit"])) {
    $idtag = $_POST["idtag"];
    $amount = $_POST["amount"];
    $status = $_POST["status"];
    $payid = $_POST["payid"];
    if ($status == "1") {
        $querystring1 =
            "SELECT * FROM `fca_wallet_transaction` WHERE `pay_id`='$payid'";
        $query1 = mysqli_query($connect, $querystring1);
        if (mysqli_num_rows($query1) <= 0) {
                $query1 = "SELECT `fca_function_wallet_update`('$s_amount', '1', '$s_idtag', '$payid')";
                $result1 = mysqli_query($connect, $query1);
        }
        $query = "UPDATE `fca_wallet_track` SET `status`='paid',`server_status`='1' WHERE `order_id`='$order_id'";
    } elseif ($status == "2") {
        $query = "UPDATE `fca_wallet_track` SET `status`='attempted',`server_status`='1' WHERE `order_id`='$order_id'";
    }
    $result = mysqli_query($connect, $query);
    if ($result) { ?>
            <script type="text/javascript">
                setTimeout(function ()
                {
                   window.location.href= 'wallettrack.php';
                }, 2000);
                alert("Wallet Details are updated");
            </script>
            <?php } else { ?>
            <script type="text/javascript">
                setTimeout(function ()
                {
                   window.location.href= 'updatewtrack.php?order_id=<?php echo $order_id; ?>';
                }, 2000);
                alert("Invalid information. Please Check the fields value");
            </script>
            <?php }
} ?>
                <div class="pd-20 card-box mb-30">
                  
                    <div class="clearfix">
                        <h5 style="color: #3d56d8;"> Order id - <span style="font-size: 18px;"><?php echo $order_id; ?></span> </h5><br>
                    </div>
                    <div class="wizard-content">
                    
                            <section>
                                <form method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> idtag </label>
                                            <input type="text" id="idtag" name="idtag" value="<?php echo $s_idtag; ?>" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> amount </label>
                                            <input type="text" id="amount" name="amount" value="<?php echo $s_amount; ?>" class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> payid </label>
                                            <input type="text" id="payid" name="payid" value="" class="form-control">
                                        </div>
                                    </div>
                                     <div class="form-group">
                                            <label> Status : <span class="text-danger">(*)</span> </label>
                                            <select name="status" id="status" class="form-control">
                                                <option> Select Status </option>
                                                <option value="1"> Paid </option>
                                                <option value="2"> Failed </option>
                                            </select>
                                        </div><br>
                              
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