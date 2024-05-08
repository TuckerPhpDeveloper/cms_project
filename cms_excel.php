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
        header('Content-Disposition: attachment; filename="CMS Report.xls"');
        
        
        include "include/dbconnect.php";
        
        session_start();
        $tbl=$tbl."<style>th,td{border:1px solid black;} </style>";


        $tbl.="<table>
                  <thead>
                    <tr><th colspan='4' align='center'> CMS Report</th></tr>
                    <tr>
                                        <th> S.No </th>
                                        <th> CMS Name </th>
                                        <th> Total CPO </th>
                                        <th> Total Stations </th>
                                        <th> Total Chargers </th>
                                        <th> Total Connectors </th>
                                        <th> Live Connectors </th>            
                    </tr>
                  </thead>
                  <tbody>";
          
                  $s_no=0;
                                        $query1 = mysqli_query($connect,"select cms_id, name from fca_cms_login");
                                        while($row = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $cms_id = $row['cms_id'];
                                            $cms_name = $row['name'];

                                            $query2 = mysqli_query($connect, "select count(cpo_id) from fca_cpo where cms_id = '$cms_id' ");
                                            $fetch2 = mysqli_fetch_array($query2);
                                            $total_cpo = $fetch2[0];

                                            $query3 = mysqli_query($connect, "select count(station_id) from fca_stations where cpo_id IN (select cpo_id from fca_cpo where cms_id = '$cms_id') ");
                                            $fetch3 = mysqli_fetch_array($query3);
                                            $total_stations = $fetch3[0];

                                            $query4 = mysqli_query($connect, "select count(charger_id) from fca_charger where station_id in (select station_id from fca_stations where cpo_id IN (select cpo_id from fca_cpo where cms_id = '$cms_id'))");
                                            $fetch4 = mysqli_fetch_array($query4);
                                            $total_chargers = $fetch4[0];

                                            $query5 = mysqli_query($connect, "select count(con_id) from fca_connectors where charger_id IN (select charger_id from fca_charger where station_id IN (select station_id from fca_stations where cpo_id IN (select cpo_id from fca_cpo where cms_id = '$cms_id' ))) ");
                                            $fetch5 = mysqli_fetch_array($query5);
                                            $total_connectors = $fetch5[0];

                                            $query6 = mysqli_query($connect, "select count(con_id) from fca_connector_status where charger_id IN (select charger_id from fca_charger where station_id IN (select station_id from fca_stations where cpo_id IN (select cpo_id from fca_cpo where cms_id = '$cms_id'))) and meter_status = 1");
                                            $fetch6 = mysqli_fetch_array($query6);
                                            $live_connectors = $fetch6[0];

                                            $tbl.=" <tr>
                                                <td>  $s_no </td>
                                                <td> $cms_name </td>
                                                <td> $total_cpo </td>
                                                <td>  $total_stations </td>
                                                <td> $total_chargers </td>
                                                <td> $total_connectors</td>
                                                <td>  $live_connectors </td>
                                            </tr>";
                                                $sr++; 
										}
                                    
        $tbl.="</tbody>
        </table>";

      echo $tbl;

?>