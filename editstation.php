<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>

<?php

    $station_id = $_REQUEST['station_id'];
    
   $query1 = mysqli_query($connect, "select * from fca_stations where station_id  ='$station_id' ");
    $fetch1 = mysqli_fetch_array($query1);
    $station_name = $fetch1['station_name'];
    $station_address_1 = $fetch1['station_address_1'];
    $station_address_2 = $fetch1['station_address_2'];
    $station_pincode = $fetch1['station_pincode'];
    $station_city = $fetch1['station_city'];
    $station_state = $fetch1['station_state'];
    $station_latitude = $fetch1['station_latitude'];
    $station_longitude = $fetch1['station_longitude'];
	    $station_amenities = $fetch1['amenities'];
	    $station_mobile = $fetch1['station_mobile'];

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
        $name = $_POST['station_name'];
        $address_1 = $_POST['station_address_1'];
        $address_2 = $_POST['station_address_2'];
        $pincode = $_POST['station_pincode'];
        $city = $_POST['station_city'];
        $state = $_POST['station_state'];
        $latitude = $_POST['station_latitude'];
        $longitude = $_POST['station_longitude'];
        $amenities = $_POST['station_amenities'];
        $mobile = $_POST['station_mobile'];
        $update_query1 = mysqli_query($connect, "UPDATE `fca_stations` SET `station_name`='$name',`amenities`='$amenities',`station_latitude`='$latitude',`station_longitude`='$longitude',`station_address_1`='$address_1',`station_address_2`='$address_2',`station_pincode`='$pincode',`station_city`='$city',`station_state`='$state',`station_mobile`='$mobile' WHERE `station_id`='$station_id'");

        if($update_query1)
        {
            ?>
            <script type="text/javascript">
                setTimeout(function ()
                {
                   window.location.href= 'dashboard.php';
                }, 2000);
                alert("Station Details are updated");
            </script>
            <?php
        }
        else
        {
            ?>
            <script type="text/javascript">
                setTimeout(function ()
                {
                   window.location.href= 'editstation.php?station_id=<?php echo $station_id; ?>';
                }, 2000);
                alert("Invalid information. Please Check the fields value");
            </script>
            <?php
        }
    }
?>
                <div class="pd-20 card-box mb-30">
                  
                    <div class="clearfix">
                        <h5 style="color: #3d56d8;"> Station id - <span style="font-size: 18px;"><?php echo $station_id; ?></span> </h5><br>
                    </div>
                    <div class="wizard-content">
                    
                            <section>
                                <form method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station Name </label>
                                            <input type="text" id="station_name" name="station_name" value="<?php echo $station_name; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station Address 1 </label>
                                            <input type="text" id="station_address_1" name="station_address_1" value="<?php echo $station_address_1; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station Address 2 </label>
                                            <input type="text" id="station_address_2" name="station_address_2" value="<?php echo $station_address_2; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station Pincode </label>
                                            <input type="text" id="station_pincode" name="station_pincode" value="<?php echo $station_pincode; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station City </label>
                                            <input type="text" id="station_city" name="station_city" value="<?php echo $station_city; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station State </label>
                                            <input type="text" id="station_state" name="station_state" value="<?php echo $station_state; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station Latitude </label>
                                            <input type="text" id="station_latitude" name="station_latitude" value="<?php echo $station_latitude; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station Longitude </label>
                                            <input type="text" id="station_longitude" name="station_longitude" value="<?php echo $station_longitude; ?>" class="form-control">
                                        </div>
                                    </div>
									 <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Amenities </label>
                                            <input type="text" id="station_amenities" name="station_amenities" value="<?php echo $station_amenities; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Station Mobile </label>
                                            <input type="text" id="station_mobile" name="station_mobile" value="<?php echo $station_mobile; ?>" class="form-control">
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