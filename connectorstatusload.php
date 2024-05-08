<?php 
    include 'include/dbconnect.php';

    $result="";
    $con_id = 281;
    $query2 = mysqli_query($connect, "select status_notification, meter_status from fca_connector_status where con_id = '$con_id'");
    $fetch2 = mysqli_fetch_array($query2);
    $con_status = $fetch2[0];
    $meter_status = $fetch2[1];


    












$result.="
<td> $con_status </td>
                                                <td>";
                                                    
                                                        if($meter_status == '0')
                                                        {
                                                            $result.="
                                                                <button id='$con_id' class='btn btn-success btn-sm start'> Start </button>
                                                                <button id='$con_id' class='btn btn-danger btn-sm stop' disabled> Stop </button>";
                                                        }
                                                        else if($meter_status == '1')
                                                        {
                                                            $result.="
                                                                <button id='$con_id' class='btn btn-success btn-sm start' disabled> Start </button>
                                                                <button id='$con_id' class='btn btn-danger btn-sm stop'> Stop </button>
                                                                <button id='$con_id' class='btn btn-info btn-sm profile'> Profile </button>";
                                                        }
                                                        $result.="

                                                </td>

<div id='dataModal' class='modal fade'>  
                                    <div class='modal-dialog'>  
                                        <div class='modal-content'>  
                                            <div class='modal-header'>    
                                                <h5 class='modal-title'> Send Start command to connector : <?php echo $con_id; ?> </h5>  
                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>  
                                            <div class='modal-body' id='start_details'></div>  
                                        </div>  
                                    </div>  
                                </div>  

                                <div id='dataModal2' class='modal fade'>  
                                    <div class='modal-dialog'>  
                                        <div class='modal-content'>  
                                            <div class='modal-header'>    
                                                <h5 class='modal-title'> Send Stop command to connector : <?php echo $con_id; ?> </h5>  
                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>  
                                            <div class='modal-body' id='stop_details'></div>  
                                        </div>  
                                    </div>  
                                </div> 

                                <div id='dataModal3' class='modal fade'>  
                                    <div class='modal-dialog'>  
                                        <div class='modal-content'>  
                                            <div class='modal-header'>    
                                                <h5 class='modal-title'> Set Charging Profile : <?php echo $con_id; ?> </h5>  
                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            </div>  
                                            <div class='modal-body' id='profile_details'></div>  
                                        </div>  
                                    </div>  
                                </div> 

                            <script>    
                                $(document).ready(function()
                                {  
                                    $('.start').click(function()
                                    {  
                                       var con_id = $(this).attr('id');  
                                       $.ajax({  
                                            url:'startmodal.php',  
                                            method:'post',  
                                            data:{con_id : con_id},  
                                            success:function(data)
                                            {  
                                                $('#start_details').html(data);  
                                                $('#dataModal').modal('show');  
                                            }  
                                       });  
                                    });  
                                });  
                            </script>


                            <script>    
                                $(document).ready(function()
                                {  
                                    $('.stop').click(function()
                                    {  
                                       var con_id = $(this).attr('id');  
                                       $.ajax({  
                                            url:'stopmodal.php',  
                                            method:'post',  
                                            data:{con_id : con_id},  
                                            success:function(data)
                                            {  
                                                $('#stop_details').html(data);  
                                                $('#dataModal2').modal('show');  
                                            }  
                                       });  
                                    });  
                                });  
                            </script>

                            <script>    
                                $(document).ready(function()
                                {  
                                    $('.profile').click(function()
                                    {  
                                       var con_id = $(this).attr('id');  
                                       var voltage = <?php echo $voltage; ?>;
                                       var current = <?php echo $current; ?>;

                                       $.ajax({  
                                            url:'profilemodal.php',  
                                            method:'post',  
                                            data:{con_id : con_id, voltage:voltage, current:current},  
                                            success:function(data)
                                            {  
                                                $('#profile_details').html(data);  
                                                $('#dataModal3').modal('show');  
                                            }  
                                       });  
                                    });  
                                });  
                            </script>


                                                ";

echo $result;
                                                ?>