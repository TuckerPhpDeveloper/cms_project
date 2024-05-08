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
        header('Content-Disposition: attachment; filename="Transaction Report.xls"');
        
        
        include "include/dbconnect.php";
        
        session_start();
        $tbl=$tbl."<style>th,td{border:1px solid black;} </style>";
        

        $from = $_GET['fromdate'];
        $to =   $_GET['todate'];

        $from1 = strtotime($_GET['fromdate']);
        $to1 =   strtotime($_GET['todate']);
                                            
        $fromdate = date("d-m-Y", strtotime($_GET['fromdate']));
        $todate = date("d-m-Y", strtotime($_GET['todate']));
        $nextdate = $fromdate;



        $tbl.="<table>
                  <thead>
                    <tr><th colspan='4' align='center'> Transaction Report</th></tr>
                    <tr><th colspan='4' align='center'> [ $fromdate to $todate ]</th></tr>
                    <tr>
                    <th> S.No </th>
                                        <th> Transaction ID </th>
                                        <th> Connector ID </th>
                                        <th> Customer Name </th>
                                        <th> Start Time </th>
                                        <th> Stop Time </th>
                                        <th> Total Unit </th>
                                        <th> Total Cost </th>
                                        <th> Status </th>
                                        <th> Stop Reason </th>
            
                    </tr>
                  </thead>
                  <tbody>";
          
                  
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,$_SESSION['query']);
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;

                                            $transaction_id = $row['transaction_id'];
                                            $con_id = $row['con_id'];
                                            // $start_time = $row['start_time'];
                                            // $stop_time = $row['stop_time'];
                                            $start_time_utc = $row['start_time'];
                                            $start_time = date('Y-m-d H:i:s', strtotime($start_time_utc.'+330 minutes'));
                                            $stop_time_utc = $row['stop_time'];
                                            $stop_time = date('Y-m-d H:i:s', strtotime($stop_time_utc.'+330 minutes'));
                                            $total_unit = $row['total_unit'];
                                            $total_cost = $row['total_cost'];
                                            $statusdb = $row['status'];
                                            $idtag = $row['idtag'];
                                            $stop_reason = $row['stop_reason'];
                                            
                                            $query2 = mysqli_query($connect, "select * from fca_users where idtag='$idtag'");
                                            while($row2 = mysqli_fetch_array($query2))
                                            {
                                                $user_name = $row2['name'];
                                            }
                                            if($statusdb == '1')
                                            {
                                                $status = "Completed";
                                            }
                                            else
                                            {
                                                $status = "Failure";
                                            }

                                            
                                           $tbl.=" <tr>
                                                <td>  $s_no </td>
                                                <td> $transaction_id </td>
                                                <td> $con_id </td>
                                                <td>  $user_name </td>
                                                <td> $start_time </td>
                                                <td> $stop_time </td>
                                                <td>  $total_unit </td>
                                                <td>  $total_cost </td>
                                                <td>  $status </td>
                                                <td>  $stop_reason </td>
                                            </tr>";
                                            
                                         }
                                    

        $tbl.="</tbody>
        </table>";

      echo $tbl;

?>