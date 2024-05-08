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
        header('Content-Disposition: attachment; filename="Fault Report.xls"');
        
        
        include "include/dbconnect.php";
        
        session_start();
        $tbl=$tbl."<style>th,td{border:1px solid black;} </style>";
        

        $from = $_GET['fromdate'];
        $to =   $_GET['todate'];


        $fromdate = date("d-m-Y", strtotime($_GET['fromdate']));
        $todate = date("d-m-Y", strtotime($_GET['todate']));
        $nextdate = $fromdate;



        $tbl.="<table>
                  <thead>
                    <tr><th colspan='4' align='center'> Fault Report</th></tr>
                    <tr><th colspan='4' align='center'> [ $fromdate to $todate ]</th></tr>
                    <tr>
                   <th> S.No </th>
                                        <th> Connector ID </th>
                                        <th> Fault Code </th>
                                        <th> Fault Name </th>
                                        <th> Fault Description </th>
                                        <th> Occured Time </th>
                                        <th> Solved Time </th>
                                        <th> Status </th>
            
                    </tr>
                  </thead>
                  <tbody>";
          
                  
                                         $s_no=0;
$query1 = mysqli_query($connect,$_SESSION['query']);
if(mysqli_num_rows($query1)>0)
                                        {
                                            while($row = mysqli_fetch_array($query1))
                                            {
                                                $con_id = $row['con_id'];

                                                $query2 = mysqli_query($connect, "select * from fca_errors_log where occured_time between '$fromdate 00:00:00' and '$todate 23:59:59' and con_id = '$con_id' order by sno desc limit 1");
                                                while($row2 = mysqli_fetch_array($query2))
                                                {
                                                    $s_no++;
                                                    $error_code = $row2['error_code'];
                                                    $error_name = $row2['error_name'];
                                                    $error_desc = $row2['error_desc'];
                                                    $occured_time_utc = $row2['solved_time'];
                                                        $occured_time = date('Y-m-d H:i:s', strtotime($occured_time_utc.'+330 minutes'));
                                                    $error_status = $row2['error_status'];

                                                    if($error_status == '0')
                                                    {
                                                        $status =  "Not Solved";
                                                        $solved_time = '';
                                                    }
                                                    else if($error_status == '1')
                                                    {
                                                        $status =  "Solved";
                                                        $solved_time_utc = $row2['solved_time'];
                                                        $solved_time = date('Y-m-d H:i:s', strtotime($solved_time_utc.'+330 minutes'));
                                                    }
                                                   
                                            
                                           $tbl.=" <tr>
                                                <td> $s_no </td>
                                                <td> $con_id </td>
                                                <td> $error_code </td>
                                                <td> $error_name </td>
                                                <td> $error_desc </td>
                                                <td> $occured_time </td>
                                                <td> $solved_time </td>
                                                <td> $status </td>
                                            </tr>";
                                            
                                         }
                                            }
                                        }
                                    

        $tbl.="</tbody>
        </table>";

      echo $tbl;

?>