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
        header('Content-Disposition: attachment; filename="Earning Report.xls"');
        
        
        include "include/dbconnect.php";
        
        session_start();
        $tbl=$tbl."<style>th,td{border:1px solid black;} </style>";
        

        $from = $_GET['fromdate'];
        $to =   $_GET['todate'];

        $from1 = strtotime($_GET['fromdate']);
        $to1 =   strtotime($_GET['todate']);
                                            
        $diff = ($to1 - $from1)/60/60/24;

        $fromdate = date("d-m-Y", strtotime($_GET['fromdate']));
        $todate = date("d-m-Y", strtotime($_GET['todate']));
        $nextdate = $fromdate;



        $tbl.="<table>
                  <thead>
                    <tr><th colspan='4' align='center'> Earning Report</th></tr>
                    <tr><th colspan='4' align='center'> [ $fromdate to $todate ]</th></tr>
                    <tr>
                     <th> S.No </th>
                                        <th> Transaction ID </th>
                                        <th> Connector ID </th>
                                        <th> Reservation ID </th>
                                        <th> Base Fare </th>
                                        <th> Unit Fare </th>
                                        <th> Time Fare </th>
                                        <th> Reservation Fare </th>
                                        <th> GST Fare </th>
										<th> Total Unit </th>
                                        <th> Total Cost </th>
            
                    </tr>
                  </thead>
                  <tbody>";
          
                  
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,$_SESSION['query']);
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;

                                             $s_no++;

                                            $transaction_id = $row['transaction_id'];
                                            $reservation_id = $row['reservation_id'];
                                            $con_id = $row['con_id'];
                                            $total_unit = $row['total_unit'];
                                            $base_fare = $row['base_fare'];
                                            $unit_fare = $row['unit_fare'];
                                            $time_fare = $row['time_fare'];
                                            $reservation_fare = $row['reservation_fare'];
                                            $gst_fare = $row['gst_fare'];
                                            $total_cost = $row['total_cost'];
                                            
                                           
                                            
                                           $tbl.=" <tr>
                                                <td> $s_no </td>
                                                <td> $transaction_id </td>
                                                <td> $con_id </td>
                                                <td> $reservation_id </td>
                                                <td> $base_fare </td>
                                                <td> $unit_fare </td>
                                                <td> $time_fare </td>
                                                <td> $reservation_fare </td>
                                                <td> $gst_fare </td>
                                                <td> $total_unit </td>
												<td> $total_cost </td>
                                            </tr>";
                                            
                                         }
                                    

        $tbl.="</tbody>
        </table>";

      echo $tbl;

?>