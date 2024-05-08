<?php  
    
    include 'include/dbconnect.php';

    if(isset($_POST["station_id"]))  
    {  
        $output = '';  
          
        $query = mysqli_query($connect, "SELECT * FROM `fca_stations` WHERE `station_id`= '".$_POST["station_id"]."'" );  
        $fetch = mysqli_fetch_array($query);
        $station_name = $fetch['station_name'];
        $station_mobile = $fetch['station_mobile'];
        $station_address_1 = $fetch['station_address_1'];
        $station_address_2 = $fetch['station_address_2'];
        $station_pincode = $fetch['station_pincode'];
        $station_city = $fetch['station_city'];
        $station_state = $fetch['station_state'];
		$station_latitude = $fetch['station_latitude'];
        $station_longitude = $fetch['station_longitude'];
        $amenities = $fetch['amenities'];

        
        $output .= '<div class="table-responsive">  
                        <table class="table table-bordered">
                          <tr>  
                               <th> Name </th>  
                               <td> '.$station_name.' </td>  
                          </tr>  
                          <tr>  
                               <th> Mobile Number </th>  
                               <td> '.$station_mobile.' </td>  
                          </tr>  
                          <tr>
                              <th> Address Line 1 </th>
                              <td> '.$station_address_1.' </td>
                          </tr>
                          <tr>
                              <th> Address Line 2 </th>
                              <td> '.$station_address_2.' </td>
                          </tr>
                          <tr>
                              <th> Pincode </th>
                              <td> '.$station_pincode.' </td>
                          </tr>
                          <tr>
                              <th> City </th>
                              <td> '.$station_city.', '.$station_state.' </td>
                          </tr>
                          <tr>
                              <th> Lattiude of Location </th>
                              <td> '.$station_latitude.' </td>
                          </tr>
                          <tr>
                              <th> Longitude of Location </th>
                              <td> '.$station_longitude.' </td>
                          </tr>
                          <tr>
                              <th> Amenities </th>
                              <td> '.$amenities.' </td>
                          </tr>
                        </table>
                    </div>';  
        
        echo $output;  
    
    }


?>