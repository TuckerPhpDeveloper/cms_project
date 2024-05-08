<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>
<?php
$idtag = $_REQUEST["idtag"];
?>

<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h4 style="color: #3d56d8;"> Users List </h4><br>
                        </div>
                    </div><br>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Idtag </th>
                                        <!--<th> Parent Idtag </th>-->
                                        <th> Name </th>
                                        <th> Mobile </th>
                                        <th> CMS </th>
                                        <th> Wallet Amount </th>
                                        <th> Amount Credit </th>
                                        <th> Amount Debit </th>
                                        <th> Calculated Wallet Amount </th>
                                        <th> Wallet Tally Status </th>
                                        <th> Status </th>
                                        <th> Email </th>
                                        <th> City </th>
                                        <th> Transaction </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sr = 1;
                                        $query = "SELECT * FROM `fca_users` WHERE `mobile`='$idtag' and `m_status`=1";
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
                                                $password=$row['password'];
                                                $buttonActive = (($row['status'] == 1)?'block':'none');
                                                $buttonInActive = (($row['status'] == 0)?'block':'none');
                                                $wallet_amount=round($row['wallet_amount'],2);
                                                $calculated_wallet=round($credit-$debit,2);
                                                $wallet_status="tally";
                                                if($calculated_wallet!=$wallet_amount)
                                                {
                                                       $wallet_status="not tally";
                                                       if($password=='*test' or $password=='*free')
                                                       {
                                                            $wallet_status="tally";
                                                       }
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $sr; ?></td>
                                                    <td><?php echo $row['idtag']; ?></td>
                                                    <!--<td><?php echo $row['parent_idtag']; ?></td>-->
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php echo $row['mobile']; ?></td>
                                                    <td><?php echo $row['cms_id']; ?></td>
                                                    <td><?php echo " Rs. ".$wallet_amount; ?></td>
                                                    <td><?php echo " Rs. ".$credit; ?></td>
                                                    <td><?php echo " Rs. ".$debit; ?></td>
                                                    <td><?php echo " Rs. ".$calculated_wallet; ?></td>
                                                    <td><?php echo $wallet_status.":".round($calculated_wallet-$wallet_amount,2);?></td>
                                                    <td><a href="javaScript:void(0)" title="Active" style="display: <?php echo $buttonActive; ?>" id="activeBtn"<?php echo $row['sno']; ?> onclick="activeInactive(<?php echo $row['sno']; ?>,0);" class="btn btn-success btn-sm"> Active </a>
                                                    <a href="javaScript:void(0)" title="Inactive" style="display:<?php echo $buttonInActive; ?>" id="inactiveBtn"<?php echo $row['sno']; ?> onclick="activeInactive(<?php echo $row['sno']; ?>,1);" class="btn btn-danger btn-sm"> Inactive </a> </td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row1['city']; ?></td>
                                                    <td style="text-align: center;"> <a href="users_transaction_<?php echo $row['idtag']; ?>"><h5><i class="dw dw-login"></i></h5> </td>
                                                </tr>
                                                <?php
                                                $sr++;
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>

                            <script type="text/javascript">
                                //$(document).ready(function()
                                //{
                                    // $.post("script.php",{key:"getAllUsers"},function (response)
                                    // {
                                    //     $("#tableBodyData").html(response);
                                    // })
                                //});

                                function activeInactive(recordId,status)
                                {
                                    var message = ((status == 0?" inactive ":" Active "));
                                    if(confirm("Are you sure to"+ message+ "the user"))
                                    {
                                        $.post("script.php",{key:"activeInactive",status:status,recordId:recordId},function (response)
                                        {
                                            if (response == "success")
                                            {
                                                if (status == 1)
                                                {
                                                    $('#activeBtn'+recordId).show();
                                                    $('#inactiveBtn'+recordId).hide();
                                                }
                                                else if (status == 0)
                                                {
                                                    $('#inactiveBtn'+recordId).show();
                                                    $('#activeBtn'+recordId).hide();
                                                }
                                                window.location.href = 'users.php';
                                                // alert("User is "+ message +"now");
                                            }
                                        });
                                    }
                                }
                            </script>


                        </div>
                    </div>

                </div>
                <!-- Bordered table End -->         

                </div>
                
            </div>
        </div>
    </div>
<script>
    function report()
    {
        window.location.href="users_excel.php?";
    }
</script>

    <!-- js -->

    <script src="vendors/scripts/core.js"></script>
    <script src="vendors/scripts/script.min.js"></script>
    <script src="vendors/scripts/process.js"></script>
    <script src="vendors/scripts/layout-settings.js"></script>

    <script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>


    <!-- buttons for Export datatable -->
    <script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="src/plugins/datatables/js/vfs_fonts.js"></script>
    <!-- Datatable Setting js -->
    <script src="vendors/scripts/datatable-setting.js"></script>

</body>
</html>