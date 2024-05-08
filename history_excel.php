<?php

        header('Pragma: public');
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");   
        header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: pre-check=0, post-check=0, max-age=0');
        header("Pragma: no-cache");
        header("Expires: 0");
        header('Content-Transfer-Encoding: none');
        header('Content-Type: application/vnd.ms-excel;');
        header("Content-type: application/x-msexcel");
        header('Content-Disposition: attachment; filename="History Report.xls"');
        
        
        include "include/dbconnect.php";
        include 'include/steve_connection.php';
        session_start();
        $tbl=$tbl."<style>th,td{border:1px solid black;} </style>";
        

        //$from = $_GET['fromdate'];
        //$to =   $_GET['todate'];
	    $from=$_SESSION['fromdate'];
		$to=$_SESSION['todate'];

        $from1 = strtotime($_GET['fromdate']);
        $to1 =   strtotime($_GET['todate']);
                                            
        $diff = ($to1 - $from1)/60/60/24;

        $fromdate = date("d-m-Y", strtotime($_GET['fromdate']));
        $todate = date("d-m-Y", strtotime($_GET['todate']));
        $nextdate = $fromdate;

$sum_total_cost=0;

        $tbl.="<table>
                  <thead>
                    <tr><th colspan='11' align='center'> History Report</th></tr>
                    <tr><th colspan='11' align='center'> [ $fromdate to $todate ]</th></tr>
                    <tr>
                    <th> S.No </th>
                                        <th> Transaction ID </th>
                                        <th> Connector ID </th>
                                        <th> Customer Name </th>
                                        <th> Start Time </th>
                                        <th> Stop Time </th>
                                        <th> Stop Reason </th>
                                        <th> Unit Fare </th>
                                        <th> Total Unit </th>
                                        <th> Total Unit(Loss) </th>
                                        <th> Total Cost </th>
                    </tr>
                  </thead>
                  <tbody>";
          
                  
                                        $s_no=0;
                                        $query1 = mysqli_query($con,$_SESSION['query']);
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $transaction_id = $row['transaction_pk'];
                                            $con_id = $row['connector_id'];
                                            $charger_id=$row['charge_box_id'];
                                            $start_time_utc = $row['start_timestamp'];
                                            $start_time = date('Y-m-d H:i:s', strtotime($start_time_utc.'+330 minutes'));
                                            $stop_time_utc = $row['stop_timestamp'];
                                            $stop_time = date('Y-m-d H:i:s', strtotime($stop_time_utc.'+330 minutes'));
                                            $total_unit = ($row['stop_value']-$row['start_value'])/1000;
                                            $total_unit_con = $row['total_unit'];
                                            $total_cost = $row['total_cost'];
                                            $unit_fare = $row['unit_fare'];
                                            $base_fare = $row['base_fare'];
                                            $gst_fare = $row['gst_fare'];
                                            $statusdb = '1';//$row['status'];
                                            $idtag = $row['id_tag'];
                                            $stop_reason = $row['stop_reason'];
                                            /*$transaction_id = $row['transaction_id'];
                                            $con_id = $row['con_id'];
                                            $start_time_utc = $row['start_time'];
                                            $start_time = date('Y-m-d H:i:s', strtotime($start_time_utc.'+330 minutes'));
                                            $stop_time_utc = $row['stop_time'];
                                            $stop_time = date('Y-m-d H:i:s', strtotime($stop_time_utc.'+330 minutes'));
                                            $total_unit = $row['total_unit'];
                                            $total_cost = $row['total_cost'];
                                            $statusdb = $row['status'];
                                            $idtag = $row['idtag'];
                                            $stop_reason = $row['stop_reason'];*/
                                            $query3 = mysqli_query($connect, "select * from fca_view_wlabel_map where charger_id='$charger_id' and con_no=$con_id");
                                            while($row3 = mysqli_fetch_array($query3))
                                            {
                                                $con_qr = $row3['con_qr_code'];
                                            }
                                            $query2 = mysqli_query($connect, "select * from fca_users where idtag='$idtag' OR dc_idtag='$idtag'");
                                            while($row2 = mysqli_fetch_array($query2))
                                            {
                                                $user_name = $row2['name'];
                                                $user_pass = $row2['password'];
                                                if($user_pass=="*free"||$user_pass=="*test")
                                                {
                                                   $total_cost = "0.00";
                                                }
                                            }
                                            if($statusdb == '1')
                                            {
                                                $status = "Completed";
                                            }
                                            else
                                            {
                                                $status = "Failure";
                                            }
$sum_total_cost+=$total_cost;
$sum_total_unit+=$total_unit;
$sum_total_unit_con+=$total_unit_con;

                                            
                                           $tbl.=" <tr>
                                                <td>  $s_no </td>
                                                <td> $transaction_id </td>
                                                <td> $con_qr </td>
                                                <td>  $user_name </td>
                                                <td> $start_time </td>
                                                <td> $stop_time </td>
                                                <td>  $stop_reason </td>
                                                <td>  $unit_fare </td>
                                                <td>  $total_unit </td>
                                                <td>  $total_unit_con </td>
                                                <td>  $total_cost </td>
                                            </tr>";
                                            
                                         }
                                    

        $tbl.="
        <tr>
        <th colspan='8' align='center'></th>
		<th colspan='1' align='right' > $sum_total_unit </th>
		<th colspan='1' align='right' > $sum_total_unit_con </th>
		<th colspan='1' align='right' > $sum_total_cost </th>
		</tr>
		</tr>
        </tbody>
        </table>";

      echo $tbl;

?>