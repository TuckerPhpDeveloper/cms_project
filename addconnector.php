<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>


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
                
                <div class="pd-20 card-box mb-30">
                  
                    <div class="clearfix">
                        <h4 style="color: #3d56d8;"> Charger Details : </h4><br>
                    </div>
                    <div class="wizard-content">
                    
                            <section>
                                <form method="POST" id="insert_form">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Select Station </label>
                                            <select name="station" id="station" class="form-control" data-live-search="true">
                                                <option value=""> Select Station </option>
                                                <?php
                                                    $result = mysqli_query($connect, "SELECT * FROM fca_stations");
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        ?><option value="<?php echo $row['station_id']; ?>"><?php echo $row["station_name"];?></option><?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Charger QR Code </label>
                                            <input type="text" id="charger_qr_code" name="charger_qr_code" placeholder="Enter Charger QR Code" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Shared / Home </label>
                                            <select name="shared_home" id="shared_home" class="form-control">
                                                <option> Select Charger Type </option>
                                                <option value="2"> Shared Charger </option>
                                                <option value="1"> Home Charger </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> KW </label>
                                            <input type="text" id="kw" name="kw" placeholder="Enter Charger KW" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Phase </label>
                                            <select name="phase" id="phase" class="form-control">
                                                <option> Select Phase Type </option>
                                                <option value="1"> Single Phase </option>
                                                <option value="3"> Three Phase </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Network Type </label>
                                            <select name="network_type" id="network_type" class="form-control">
                                                <option> Select Network Type </option>
                                                <option value="EWGG"> Ethernet + Wi-Fi + GPS/GPRS </option>
                                                <option value="EW"> Ethernet + Wi-Fi </option>
                                                <option value="EGG"> Ethernet + GPS/GPRS </option>
                                                <option value="WGG"> Wi-Fi + GPS/GPRS </option>
                                                <option value="GG"> GPS/GPRS </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Heartbeat Interval (Hrs) 1-5 </label>
                                            <input type="number" id="heartbeat_interval" name="heartbeat_interval" placeholder="Enter Heartbeat Interval value" class="form-control" max="5" min="1">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Meter Values Interval (Secs) 30-600 </label>
                                            <input type="number" id="metervalues_interval" name="metervalues_interval" placeholder="Enter Meter Values Interval value" class="form-control" max="600" min="30">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Manufacturing Date </label>
                                            <input type="date" id="manufacturing_date" name="manufacturing_date" class="form-control">
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label> Amenities </label><br>
                                            <input type="checkbox" id="amenities" name="amenities[]" value="Lodging"> Lodging
                                            <input type="checkbox" id="amenities" name="amenities[]" value="Dining"> Dining
                                            <input type="checkbox" id="amenities" name="amenities[]" value="Restroom"> Restroom 
                                            <input type="checkbox" id="amenities" name="amenities[]" value="Restaurant"> Restaurant
                                            <input type="checkbox" id="amenities" name="amenities[]" value="Parking"> Parking
                                        </div>
                                    </div> -->
                                </div><br><br>
                                
                                <h4 style="color: #3d56d8;"> Fare Details : </h4><br>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Base Fare </label>
                                            <input type="number" id="base_fare" name="base_fare" placeholder="Enter Base Fare" class="form-control" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Unit Fare </label>
                                            <input type="number" id="unit_fare" name="unit_fare" placeholder="Enter Unit Fare" class="form-control" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Time Fare </label>
                                            <input type="number" id="time_fare" name="time_fare" placeholder="Enter Time Fare" class="form-control" min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> Reservation Fare </label>
                                            <input type="number" id="reservation_fare" name="reservation_fare" placeholder="Enter Reservation Fare" class="form-control" min="0">
                                        </div>
                                    </div>
                                </div><br><br>

                                <div class="clearfix">
                                    <button type="button" name="add" class="btn btn-success btn-sm add"> <h6 style="color: white;"> + Add Connector </h6></button> <br><br>
                                </div>

                                <div class="table-repsonsive">
                                    <span id="error"></span>
                                    <table class="table table-bordered" id="item_table">
                                        <thead>
                                            <tr>
                                                <!-- <th> Connector QR Code </th> -->
                                                <th> Connector Type </th>
                                                <th> Format </th>
                                                <th> Charging Current (A) </th>
                                                <th> Charging Voltage (V) </th>
                                                <!-- <th> Power Capacity (KW) </th> -->
                                                <th> Remove </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div align="center">
                                        <input type="submit" name="submit" class="btn btn-info" value="Insert" id="btn_details" />

                                    </div>
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

    var count = 0;

    $(document).on('click', '.add', function()
    {
        count++;
        var html = '';
        html += '<tr>';
          
        // html += '<td><input type="text" name="connector_qr_code[]" class="form-control connector_qr_code"></td>';  
        html += '<td><?php include "1.php"; ?></td>';

        html += '<td><select name="format[]" class="form-control format"><option value="socket"> Socket </option> <option value="connector"> Connector </option></select></td>';

        html += '<td><input type="number" name="charging_current[]" class="form-control charging_current" min="0" max="500"></td>';
        html += '<td><input type="number" name="charging_voltage[]" class="form-control charging_voltage" min="0"></td>';
        // html += '<td><input type="text" name="charging_current[]" class="form-control charging_current" /></td>';
       // html += '<td><input type="text" name="power_capacity[]" class="form-control power_capacity" /></td>';

        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span> Remove </button></td>';
          $('tbody').append(html);
    });

    $(document).on('click', '.remove', function()
    {
        $(this).closest('tr').remove();
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

        $('.charging_voltage').each(function()
        {
            var count = 1;
            if($(this).val() == '')
            {
                error += '<p>Enter Charging Voltage at '+count+' row</p>';
                return false;
            }
            count = count + 1;
        });

        var form_data = $(this).serialize();

        var station = document.getElementById("station").value;
        var charger_qr_code = document.getElementById("charger_qr_code").value;
        var shared_home = document.getElementById("shared_home").value;
        var kw = document.getElementById("kw").value;
        var phase = document.getElementById("phase").value;


        if(error == '' && station!='' && charger_qr_code!='' && shared_home!='' && kw!='' && phase!='')
        {
            $.ajax({
                url:"insert.php",
                method:"POST",
                data:form_data,
                success:function(data)
                {
                    if(data == 'ok')
                    {
                        //   $('#item_table').find('tr:gt(0)').remove();
                        $('#btn_details').attr("disabled", "disabled");
                        $('#error').html('<div class="alert alert-success"> Connector Details Saved</div>');
                        setTimeout(function ()
                        {
                            window.location.href= 'dashboard.php';
                        }, 1000);
                        
                    }
                    else if(data == 'err') 
                    {
                        $('#error').html('<div class="alert alert-danger"> Query Error </div>');   
                    }
                    else if(data == 'error') 
                    {
                        $('#error').html('<div class="alert alert-danger"> Connector Details are Not Saved</div>');   
                    }
                    else{
						$('#error').html('<div class="alert alert-danger"> Connector Details are Not Saved</div>');   

					}
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
                $('#error').html('<div class="alert alert-danger">Please fill all the fields</div>');
            }
        }

    });
      
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