<?php
include "include/dbconnect.php";
include "include/steve_connection.php";

$result = "";

$result = "<style>
			  #tbl2 th
			  {
			  	background-color:#e63814;
			  	color:white;
			  	font-size: 14px;
			  	text-transform: uppercase;
			  	text-align: center;
			  	font-weight: bold;
			  }
			  #tbl2 td
			  {
			  	color: c42216;
			  	font-size: 14px;
			  	font-weight: bold;
			  	text-align: center;
			  }
			  #id1
			  {
			  	box-shadow: 2px 2px 10px #888888;
			  	overflow-y: scroll;
			  	height : 250px; 
			  }
			  ::-webkit-scrollbar
			  {
			    width: 5px;
			  }

			  #id2
			  {
			  	box-shadow: 2px 2px 10px #888888;
			  	overflow-y: scroll;
			  	height : 500px;
			  }
			</style>";

$query = mysqli_query($connect, "select station_id from fca_stations");
$count = 0;
$station_id = "";
$id_tag = " ";
while ($row = mysqli_fetch_array($query)) {
    if ($count == 0) {
        $row_station_id = $row[0];
        $station_id .= "'" . $row_station_id . "'";
    } else {
        $row_station_id = $row[0];
        $station_id .= " , '" . $row_station_id . "'";
    }
    $count++;
}
$query5 = mysqli_query(
    $connect,
    "SELECT idtag FROM fca_users WHERE `password`='*free' or `password`='*test'"
);
$newcount = 0;
while ($row5 = mysqli_fetch_array($query5)) {
    if ($newcount == 0) {
        $row_id_tag = $row5[0];
        $id_tag .= "'" . $row_id_tag . "'";
    } else {
        $row_id_tag = $row5[0];
        $id_tag .= " , '" . $row_id_tag . "'";
    }
    $newcount++;
}
$url =
    "http://13.233.175.29/steve_aws/internal_call.php?key=tuckermotors&cmd=getAvailability&ChargeBoxID=1";
$output = file_get_contents($url);
$obj = json_decode($output);
if ($obj->status == "true") {
    $Chargers = [];
    $Chargers = explode(",", $obj->walletbit);
}
array_splice($Chargers, 0, 0, ["random_string"]); // can be more items
$a = [];

$query = mysqli_query(
    $connect,
    "select charger_id from fca_connectors where 1"
);
$count = 0;
$con_id = "";
while ($row = mysqli_fetch_array($query)) {
    if ($count == 0) {
        $row_con_id = $row[0];
        $con_id .= "'" . $row_con_id . "'";
    } else {
        $row_con_id = $row[0];
        $con_id .= " , '" . $row_con_id . "'";
    }
    $count++;
    $chargerId = $row["charger_id"];
    if (array_search($chargerId, $Chargers, true) != "") {
        $status = "1";
        array_push($a, $chargerId);
    }
}

$query1 = mysqli_query(
    $connect,
    "select count(charger_id) from fca_charger where station_id IN ($station_id)"
);
$fetch1 = mysqli_fetch_array($query1);
$total_chargepoints = $fetch1[0];
$live_chargepoints = count(array_unique($a));
$inactive_chargepoints = $total_chargepoints - $live_chargepoints;

$dc_con_query = mysqli_query(
    $connect,
    "select count(con_id) from fca_connectors where con_type IN ('CHAdeMo', 'CCS2', 'GBT') and charger_id IN (select charger_id from fca_charger where station_id IN ($station_id))"
);
$dc_con_fetch = mysqli_fetch_array($dc_con_query);
$dc_connectors = $dc_con_fetch[0];

$ac_con_query = mysqli_query(
    $connect,
    "select count(con_id) from fca_connectors where con_type IN ('ACTYPE2', 'IEC60309','SOCKET15') and charger_id IN (select charger_id from fca_charger where station_id IN ($station_id))"
);
$ac_con_fetch = mysqli_fetch_array($ac_con_query);
$ac_connectors = $ac_con_fetch[0];

$querystring1 = "SELECT count(transaction_pk),sum(`total_cost`) FROM `wallet_track` WHERE  transaction_pk IN(SELECT transaction_pk FROM `GetHistory` WHERE charge_box_id IN($con_id) and `id_tag` NOT IN($id_tag))";
$query1 = mysqli_query($con, $querystring1);
if (mysqli_num_rows($query1) > 0) {
    while ($row1 = mysqli_fetch_array($query1)) {
        $charging_sessions = $row1[0];
        $revenue = number_format($row1[1], 2);
    }
} else {
    $charging_sessions = $revenue = 0;
}
$querystring1 = "SELECT count(transaction_pk) FROM `GetHistory` WHERE  charge_box_id IN ($con_id) and`stop_value` IS NULL ORDER BY `start_timestamp` DESC";
$charging_session_query2 = mysqli_query($con, $querystring1);
while ($charging_session_row2 = mysqli_fetch_array($charging_session_query2)) {
    $active_charging_sessions = $charging_session_row2[0];
}
$querystring2 = "SELECT transaction_pk,connector_pk,start_value FROM `GetHistory` WHERE  charge_box_id IN ($con_id) and`stop_value` IS NULL ORDER BY `start_timestamp` DESC";
$charging_session_query3 = mysqli_query($con, $querystring2);
while ($charging_session_row3 = mysqli_fetch_array($charging_session_query3)) {
    $transaction_pk = $charging_session_row3[0];
    $connector_pk = $charging_session_row3[1];
    $query3 = "SELECT * FROM `GetLiveUnit` WHERE `connector_pk`=$connector_pk and `transaction_pk`=$transaction_pk and `measurand`='Energy.Active.Import.Register' ORDER BY `value_timestamp`  DESC LIMIT 1";
    $result3 = mysqli_query($con, $query3);
    if ($row3 = mysqli_fetch_array($result3)) {
        $unit_now = $row3["value"] - $row3["start_value"];
        if ($unit_now < 0) {
            $unit_now = 0;
        }
        $active_kwh += $unit_now / 1000;
    }
}

$user_query1 = mysqli_query($connect, "select count(idtag) from fca_users");
while ($user_row1 = mysqli_fetch_array($user_query1)) {
    $total_users = $user_row1[0];
}
$active_users = $total_users - 10;

$fault_query1 = mysqli_query(
    $connect,
    "select count(distinct(`con_id`)) from fca_errors_log where error_status = '0'"
);
while ($fault_row1 = mysqli_fetch_array($fault_query1)) {
    $fault = $fault_row1[0];
}

$result .= "
		<div class='container-fluid'>

		<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        
            <h2 style='color:#c42216;padding-top :50px; padding-bottom:20px;'> Dashboard </h2>
			<div class='row clearfix progress-box'>
				
				<div class='col-lg-4 col-md-6 col-sm-12 mb-30'>
					<div class='card-box pd-30' id='id1' style='background-color:#c42216;' >
						<div class='row'>
							<div class='col-sm-12'>
							
								<h5 class='pt-20 h5' style='text-align: center; color: #fff;'> <b> Charging Points </b> </h5><br>
								<table class='table' id='tbl2'>
									<thead>
									  <tr>
										<th style='background-color: #050505;'> Total </th>
										<th style='background-color: green;'> Live </th>
										<th style='background-color: #e63814;'> Inactive </th>
									  </tr>
									</thead>
									<tbody>
									  <tr>
									  	<td style='background-color: lightgray;'> $total_chargepoints </td>
									  	<td style='background-color: lightgray;'> $live_chargepoints </td>
									  	<td style='background-color: lightgray;'> $inactive_chargepoints </td>
									  </tr>
									</tbody>
							  	</table>
							</div>
						</div>
					</div>
				</div>

				<div class='col-lg-4 col-md-6 col-sm-12 mb-30' '>
					<div class='card-box pd-30' id='id1'style='background-color:#5555e8;'>	
				
						<h5 class='pt-20 total'  style='text-align: center; color: #fff;'> <b> Total Connectors </b> </h5><br>	
					
						<div class='row'>
							<div class='col-sm-4'>
								<img src='images/cpicon1.svg' style='width:100px;'>
							</div>
							<div class='col-sm-8'><br>
								<h6 style='color: #fff;'>  AC Connectors &nbsp; &nbsp; - &nbsp; &nbsp; $ac_connectors </h6><br>
								<h6 style='color: #fff;'> DC Connectors &nbsp; &nbsp; - &nbsp; &nbsp; $dc_connectors </h6>
							</div>
						</div>
					</div>
				</div>

				<div class='col-lg-4 col-md-6 col-sm-12 mb-30'>
					<div class='card-box pd-30' id='id1'style='background-color:green;>		
						<div class='row'>
							<div class='col-sm-12'>
								<h5 class='pt-20 h5' style='text-align: center;color: #fff;'> <b> Live Charging Sessions </b> </h5>
								<h2 class='pt-10' style='text-align: center;color: #fff;'> $active_charging_sessions </h2>
								<h5 class='pt-10 h5' style='text-align: center;color: #fff;'> Total </h5>
								<p style='text-align: center;color: #fff;'> $active_kwh Wh Energy Delivered </p>
							</div>
						</div>
					</div>
				</div>

			</div>


        	<h2 style='color:#c42216;padding-top :50px; padding-bottom:20px;'> Overall Statistics </h2>
			<div class='card-box pd-30' style='width:70%; text-align:center;  justify-content: space-between;'> 
                <div class='row'>
                   
                    <div class='col-lg-4 col-md-6 col-sm-10 '>
                        <h3 class='pt-20 h3' style='text-align: center;'> Revenue </h3><br>
                        <h4 style='text-align: center;'> &#8377; $revenue </h4>
	                </div>

            		<!-- <div class='col-lg-4 col-md-6 col-sm-12'>
                        <h5 class='pt-20 h3' style='text-align: center;'> Energy Used (kWh) </h5><br>
                        <h4 style='text-align: center;'> $kwh </h4>
	                </div> -->

            		<div class='col-lg-4 col-md-6 col-sm-10'>	
                        <h3 class='pt-20 h3' style='text-align: center;'> Charging Sessions </h3><br>
                        <h4 style='text-align: center;'> $charging_sessions </h4>
            		</div>

            		<div class='col-lg-4 col-md-6 col-sm-10'>                
                        <h3 class='pt-20 h3' style='text-align: center;'> Total Users </h3><br>
                        <h4 style='text-align: center;'> $total_users </h4>
            		</div>

					<!--<div class='col-lg-3 col-md-6 col-sm-12'>                   
                        <h5 class='pt-20 h5' style='text-align: center;'> New Users </h5><br>
                        <h4 style='text-align: center;'> $active_users </h4>
                    </div> -->

            		<!--	<div class='col-lg-3 col-md-6 col-sm-12'>                   
                        <h5 class='pt-20 h5' style='text-align: center;'> Faults </h5><br>
                        <h4 style='text-align: center;'> $fault </h4>
                    </div>-->
        		</div>
        	</div><br>


			<div class='container'>

        <div class='dashboard-card upcoming'>
		<i class='fa-solid fa-chart-user' style='color: #fff;'></i>
            <h2 class='title'> Revenue</h2>
            <span class='value'>₹ $revenue</span>
            
        </div>
        <div class='dashboard-card recording'>
            <i class='fas fa-tape '></i>
			<h2  class='title'> Charging Sessions</h2> 
            <span class='title sub'> $charging_sessions </span>
        </div>
        <div class='dashboard-card zoom'>
            <i class='fas fa-search'></i>
            <h2 class='title'>Total Users </h2>
            <span class='title sub'> $total_users </span>
        </div>

    </div>

        	<h2 style='color:#c42216;padding-top :50px; padding-bottom:20px;'> Live Charger Status </h2>
			<div class='row'>";

$con_query = mysqli_query(
    $connect,
    "select * from fca_connectors where charger_id IN (select charger_id from fca_charger where station_id IN ($station_id)) "
);
if (mysqli_num_rows($con_query) > 0) {
    while ($con_row = mysqli_fetch_array($con_query)) {
        $charger_id = $con_row["charger_id"];
        $con_id = $con_row["con_no"];
        $con_qr = $con_row["con_qr_code"];
        if (array_search($charger_id, $Chargers, true) != "") {
            $status_notification = "UnAvailable";
            $query1 = "SELECT `status` FROM `connector_status` WHERE `connector_pk`=(SELECT `connector_pk` FROM `connector` WHERE `charge_box_id`='$charger_id' and `connector_id`=$con_id) ORDER BY `status_timestamp` DESC LIMIT 1";
            $con_query1 = mysqli_query($con, $query1);
            while ($con_row1 = mysqli_fetch_array($con_query1)) {
                $status_notification = $con_row1[0];
            }


            $result .= "
							<div class='col-lg-6 col-md-6 col-sm-12'>        
								<div class='card-box pd-30'>
									<div class='row'>
										<div class='col-sm-2'>
											<img src='images/charger.svg' style='width:60px; height: 60px;'>
										</div>
										<div class='col-sm-6'>
											<h5 class='h5'> $charger_id </h5>
		    	                    		<h6> Connector id : $con_id </h6>
		    	                    		<h6> Connector qr : $con_qr </h6>
										</div>
										<div class='col-sm-4'>
											<h5 class='pt-20 h5'> $status_notification &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;     	      
												<a href = 'connectorstatus.php?con_id=$con_id'> <i class='fas fa-long-arrow-alt-right' style='font-size:20px'></i> </a>
											</h5>
										</div>
									</div>
			                	</div><br>
							</div>";
        }
    }
} else {
    $result .= "
						<div class='col-lg-12 col-md-12 col-sm-12'>        
							<div class='card-box pd-30'>
								<div class='row'>
									<div class='col-sm-2'>
										<img src='images/charger.svg' style='width:60px; height: 60px;'>
									</div>
									<div class='col-sm-10'>
										<h5 class='pt-20 h5'> There is no live charging </h5>
									</div>
								</div>
		                	</div><br>
						</div>";
}

$result .= "</div>


			</div>";

echo $result;

?>
