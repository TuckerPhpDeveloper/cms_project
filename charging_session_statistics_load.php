<?php
include "include/dbconnect.php";
include "include/steve_connection.php";

$result = "";

$result .= "
		<div class='container-fluid'>
			<div class='row'>
                <div class='col-sm-12'>
                    <div class='pd-20 card-box mb-30'> 
                        <h4 style='text-align: center; color: #c42216; padding-top:20px'> Live Charging Sessions </h4><br><br>
                    	<table class='data-table table stripe hover'>
                        	<thead>
                            	<tr>
                                	<th> Charger ID </th>
                                    <th> Connector QR </th>
                                    <th> Transaction ID </th>
                                    <th> Customer Name </th>
                                    <th> Start Time </th>
                                    <th> Duration </th>
                                    <th> Connector Status </th>
	                                <th> Consumed Units (kWh) </th>
    	                            <th> Amount (Rs) </th>
        	                        <th> Status </th>
        	                        <th> Actions </th> 
            	                </tr>
                	        </thead>
                        	<tbody>";
$url =
    "http://13.233.175.29/steve_aws/internal_call.php?key=tuckermotors&cmd=getAvailability&ChargeBoxID=1";
$output = file_get_contents($url);
$obj = json_decode($output);
if ($obj->status == "true") {
    $Chargers = [];
    $Chargers = explode(",", $obj->walletbit);
}
array_splice($Chargers, 0, 0, ["random_string"]);
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
}
$querystring1 = "SELECT * FROM `GetHistory` WHERE  charge_box_id IN ($con_id) and`stop_value` IS NULL ORDER BY `start_timestamp` DESC";

$query1 = mysqli_query($con, $querystring1);

if (mysqli_num_rows($query1) > 0) {
    while ($row1 = mysqli_fetch_array($query1)) {
        $station_name = $row1["station_name"];
        $charger_id = $row1["charge_box_id"];
        $transaction_id = $row1["transaction_pk"];
        $con_no = $row1["connector_pk"];
        $connector_id = $row1["connector_id"];
        $idtag = $row1["id_tag"];
        $start_time_utc = $row1["start_timestamp"];
        if (array_search($charger_id, $Chargers, true) != "") {
            $querystring2 = "SELECT `status` FROM `connector_status` WHERE `connector_pk`=$con_no ORDER BY `status_timestamp` DESC LIMIT 1";
            $query2 = mysqli_query($con, $querystring2);
            if ($con_row1 = mysqli_fetch_array($query2)) {
                $status_notification = $con_row1[0];
            } else {
                $status_notification = "Offline";
            }
        } else {
            $status_notification = "Offline";
        }
        $unit = 0;
        $unit_fare = 0;
        $base_fare = 0;
        $gst_fare = 0;
        $query3 = "SELECT * FROM `GetLiveUnit` WHERE `connector_pk`=$con_no and `transaction_pk`=$transaction_id and `measurand`='Energy.Active.Import.Register' ORDER BY `value_timestamp`  DESC LIMIT 1";
        $result3 = mysqli_query($con, $query3);
        if ($row3 = mysqli_fetch_array($result3)) {
            $unit_now = $row3["value"] - $row3["start_value"];
            if ($unit_now < 0) {
                $unit_now = 0;
            }
            $unit = $unit_now / 1000;
        }
        $query2 = "SELECT * FROM `fca_view_station` WHERE `charger_id`='$charger_id'";
        $result2 = mysqli_query($connect, $query2);
        if ($row2 = mysqli_fetch_array($result2)) {
            $charger_qr_code = $row2["charger_qr_code"];
            $unit_fare = $row2["unit_fare"];
            $base_fare = $row2["base_fare"];
            $gst_fare = $row2["gst_fare"];
            $razorpay_fare = $row2["razorpay_fare"];
            $conversion_loss = $row2["conversion_loss"];
        }
        $start_time = date(
            "Y-m-d H:i:s",
            strtotime($start_time_utc . "+330 minutes")
        );

        $query4 = mysqli_query(
            $connect,
            "select name from fca_users where idtag = '$idtag' || dc_idtag = '$idtag'"
        );
        $fetch2 = mysqli_fetch_array($query4);
        $name = $fetch2["name"];
        $unit = $unit + ($unit * $conversion_loss) /100;
        $unit_cost = $unit_fare * $unit;
        if($unit_cost<1)$base_fare=0;
        $fin_cost = $unit_cost + $base_fare;
        $est_cost = $fin_cost + ($fin_cost * $gst_fare) / 100;
        $est_cost = $est_cost + ($est_cost * $razorpay_fare) / 100;
        $est_cost = number_format($est_cost, 2);

        $time2 = date("Y-m-d H:i:s");
        $diff = abs(strtotime($start_time) - strtotime($time2));
        $tmins = $diff / 60;
        $hours = floor($tmins / 60);
        $min = $tmins % 60;
         $buttontext = "Stop";
        $buttonlink = "http://cms.tuckerio.bigtot.in/steve_aws/cms_manual_stop.php?Transid=$transaction_id";
                                            

        $result .= "
                                        <tr>
                                            <td> $charger_id </td>
                                            <td> $charger_qr_code-$connector_id </td>
                                            <td> $transaction_id </td>
                                            <td> $name </td>
                                            <td> $start_time </td>
                                            <td> $hours Hrs : $min Mins </td>
                                            <td> $status_notification </td>
                                            <td> $unit </td>
                                            <td> $est_cost </td>
                                            <td>
  <span class='badge' style='padding: 10px 10px; font-size: 18px; background-color: #28a745; color: #fff; border-radius: 5px; cursor: pointer; display: inline-block;'>Charging</span>
</td>

<td> 
  <a class='btn badge' href='$buttonlink' style='padding: 10px 20px; font-size: 18px; background-color: red; color: white; border-radius: 5px; cursor: pointer; text-decoration: none;'>Stop</a>
</td>

                                        </tr>";
    }
} else {
    $result .= "
                                    <tr>
                                        <td colspan = '9' style='text-align: center;'> There is no live charging </td>
                                    </tr>";
}

$result .= "
                               
                            </tbody>
                        </table>
                    </div>
                </div>
			</div>
		</div>";

echo $result;

?>
