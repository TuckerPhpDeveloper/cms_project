<?php

        // header('Pragma: public');
        // header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");   
        // header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
        // header('Cache-Control: no-store, no-cache, must-revalidate');
        // header('Cache-Control: pre-check=0, post-check=0, max-age=0');
        // header("Pragma: no-cache");
        // header("Expires: 0");
        // header('Content-Transfer-Encoding: none');
        // header('Content-Type: application/vnd.ms-excel;');
        // header("Content-type: application/x-msexcel");
        // header('Content-Disposition: attachment; filename="Station Report.xls"');
        
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Report.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

        include "include/dbconnect.php";
        
        session_start();
        $tbl=$tbl."<style>th,td{border:1px solid black;} </style>";


        $tbl.="<table>
                  <thead>
                    <tr><th colspan='4' align='center'>Wallet Track Report</th></tr>
                    <tr>
                                    <th> S.No </th>
                                        <th> Order ID </th>
                                        <th> idTag </th>
                                        <th> Amount </th>
                                        <th> Status </th>
                                        <th> Time </th>       
                    </tr>
                  </thead>
                  <tbody>";
          
                 $s_no=0;
                                        $query1 = mysqli_query($connect,"SELECT * FROM `fca_wallet_track` WHERE `server_status`=0");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $order_id = $row['order_id'];
                                            $idtag = $row['idtag'];
                                            $amount = $row['amount'];
											$status = $row['status'];
                                            $timeofupdate = $row['timeofupdate'];
                                            $tbl.=" <tr>
                                                <td>  $s_no </td>
                                                <td> $order_id </td>
                                                <td> $idtag </td>
                                                <td>  $amount </td>
                                                <td> $status </td>
                                                <td> $timeofupdate</td>
                                            </tr>";
                                                $sr++; 
										}
                                    
        $tbl.="</tbody>
        </table>";

      echo $tbl;

?>