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
        header('Content-Disposition: attachment; filename="User Report.xls"');
        
        
        include "include/dbconnect.php";
        
        session_start();
        $tbl=$tbl."<style>th,td{border:1px solid black;} </style>";


        $tbl.="<table>
                  <thead>
                    <tr><th colspan='4' align='center'> User Report</th></tr>
                    <tr>
                                        <th> S.No </th>
                                        <th> Idtag </th>
                                        <th> Name </th>
                                        <th> Mobile </th>
                                        <th> CMS </th>
                                        <th> Account type </th>
                                        <th> Wallet Amount </th>
                                        <th> Amount Credit </th>
                                        <th> Amount Debit </th>
                                        <th> Calculated Wallet Amount </th>
                                        <th> Wallet Tally Status </th>
                    </tr>
                  </thead>
                  <tbody>";
          
                  
                                    
                                        $sr = 1;
                                        $query = "SELECT * FROM fca_users WHERE status=1";
                                        $result = mysqli_query($connect,$query);
                                        if (mysqli_num_rows($result)>0)
                                        {
                                            while ($row = mysqli_fetch_array($result))
                                            {
                                                $query1 = mysqli_query($connect, "select city from fca_user_details where idtag = '".$row['idtag']."' ");
                                                $row1 = mysqli_fetch_array($query1);
                                                $city = $row1['city'];
                                                $query2 = mysqli_query($connect, "SELECT SUM(`amount`) FROM `fca_wallet_transaction` WHERE `idtag`='".$row['idtag']."' AND `credit/debit`=1");
                                                $row2 = mysqli_fetch_array($query2);
                                                $credit = round($row2[0],2);
                                                $query3 = mysqli_query($connect, "SELECT SUM(`amount`) FROM `fca_wallet_transaction` WHERE `idtag`='".$row['idtag']."' AND `credit/debit`=0");
                                                $row3 = mysqli_fetch_array($query3);
                                                $debit = round($row3[0],2);
                                                $buttonActive = (($row['status'] == 1)?'block':'none');
                                                $buttonInActive = (($row['status'] == 0)?'block':'none');
                                                $wallet_amount=round($row['wallet_amount'],2);
                                                $calculated_wallet=round($credit-$debit,2);
                                                $wallet_status="tally";
                                                if($calculated_wallet!=$wallet_amount)
                                                {
                                                       $wallet_status="not tally";
                                                }
                                                 $idtag=$row['idtag'];
                                                 $name=$row['name'];
                                                 $mobile=$row['mobile'];
                                                 $cms=$row['cms_id'];
                                                 $password=$row['password'];
                                            $pending=round($calculated_wallet-$wallet_amount,2);
                                                $tbl.=" <tr>
                                                <td>  $sr </td>
                                                <td> $idtag </td>
                                                <td>  $name </td>
                                                <td> $mobile </td>
                                                <td>  $cms </td>
                                              <td> $password</td>
                                                  <td> $wallet_amount</td>
                                                    <td> $credit</td>
                                                    <td> $debit</td>
                                                    <td> $calculated_wallet</td>
                                                    <td> $wallet_status,$pending </td>
                                            </tr>";
                                                $sr++;
                                            }
                                        }
                                    
        $tbl.="</tbody>
        </table>";

      echo $tbl;

?>