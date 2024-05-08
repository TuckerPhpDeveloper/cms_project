<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include "include/dbconnect.php"; ?>
<?php
$idtag = $_REQUEST["idtag"];
$query = mysqli_query(
    $connect,
    "select name, wallet_amount from fca_users where idtag = '$idtag'"
);
$fetch = mysqli_fetch_array($query);
$name = $fetch[0];
$wallet = $fetch[1];
?>

<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                
                <div class="pd-20 card-box mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h4 style="color: #3d56d8;"> Transaction List - <?php echo $name; ?> </h4><br>
                            <p> Wallet Amont : Rs. <?php echo $wallet; ?> </p>
                            <form action="users_transaction.php?idtag=<?php echo $idtag; ?>" method="post">
                                <label> Enter Final Wallet Amount : Rs. </label>
                                <input type="number" step=0.01 name="wallet_amount" required>
                                <input type="submit" name="submit" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-sm-12">
                            <table class="data-table table stripe hover nowrap">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
										<th> Connector Name </th>
                                        <th> Charger id </th>
                                        <th> Station id </th>
										<th> cpo id </th>
                                        <th> cms id </th>
										<th> Connector Type </th>
										<th> Connector Rating </th>
                                        <th> Status </th>
                                        <th> Unit Fare </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_no = 0;
                                    $query1 = mysqli_query(
                                        $connect,
                                        "SELECT * FROM `fca_view_qr_scan` WHERE `charger_id`=(SELECT `charger_id` FROM `fca_group_charge` WHERE `id_tag`='$idtag')"
                                    );
                                    while ($row = mysqli_fetch_array($query1)) {

                                        $s_no++;
                                        $con_qr_code = $row["con_qr_code"];
                                        $charger_id = $row["charger_id"];
                                        $con_id = $row["con_no"];
                                        $station_id = $row["station_name"];
                                        $cpo_id = $row["cpo_id"];
                                        $cms_id = $row["cms_id"];
                                        $con_type = $row["con_type"];
                                        $power_capacity =
                                            $row["power_capacity"];
                                        $unit_fare = $row["unit_fare"];
                                        if (
                                            array_search(
                                                $charger_id,
                                                $Chargers,
                                                true
                                            ) != ""
                                        ) {
                                            $query2 = "SELECT `status` FROM `connector_status` WHERE `connector_pk`=(SELECT `connector_pk` FROM `connector` WHERE `charge_box_id`='$charger_id' and `connector_id`=$con_id) ORDER BY `status_timestamp` DESC LIMIT 1";
                                            $con_query1 = mysqli_query(
                                                $con,
                                                $query2
                                            );
                                            if (
                                                $con_row1 = mysqli_fetch_array(
                                                    $con_query1
                                                )
                                            ) {
                                                $status_notification =
                                                    $con_row1[0];
                                            } else {
                                                $status_notification =
                                                    "Unavailable";
                                            }
                                        } else {
                                            $status_notification =
                                                "Unavailable";
                                        }
                                        ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $con_qr_code; ?></td>
                                                <td> <?php echo $charger_id; ?></td>
                                                <td> <?php echo $station_id; ?></td>
                                                <td> <?php echo $cpo_id; ?></td>
                                                <td> <?php echo $cms_id; ?></td>
                                                <td> <?php echo $con_type; ?></td>
                                                <td> <?php echo $power_capacity; ?></td>
                                                <td> <?php echo $status_notification; ?></td>
                                                <td> <?php echo $unit_fare; ?></td>
                                                <td>  
                                                     <a href="editconnector.php?con_id=<?php echo $charger_id; ?>"> <i class="dw dw-edit2"></i> </a> &nbsp; &nbsp;
                                                     <!--<a href="#" id="<?php echo $row[
                                                         "chargepoint_name"
                                                     ]; ?>" class="view_data"> <i class="dw dw-eye"></i> </a> &nbsp; &nbsp;-->
                                                    <!-- <a class="remove" style="cursor: pointer;"> <i class="dw dw-trash" style="color: red;"></i> </a> -->
                                                 </td> 
                                               
                                            </tr>
                                            <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <?php if (isset($_POST["wallet_amount"])) {
                                $wallet_amount = $_POST["wallet_amount"];
                                $wallet_diff = abs($wallet_amount - $wallet);
                                if ($wallet > $wallet_amount) {
                                    $credit_debit_ins = 0;
                                } else {
                                    $credit_debit_ins = 1;
                                }
                                $ins_wallet_query = mysqli_query(
                                    $connect,
                                    "INSERT INTO `fca_wallet_transaction`(`idtag`, `pay_id`, `amount`, `credit/debit`) VALUES ('$idtag','server','$wallet_diff','$credit_debit_ins')"
                                );
                                $upd_wallet_query = mysqli_query(
                                    $connect,
                                    "UPDATE `fca_users` SET `wallet_amount`='$wallet_amount' WHERE `idtag` = '$idtag'"
                                );
                                if ($ins_wallet_query) { ?>
                                        <script type="text/javascript">
                                            setTimeout(function ()
                                            {
                                               window.location.href= 'users.php';
                                            }, 2000);

                                            alert("Your Wallet has been updated.");
                                        </script>
                                        <?php }
                            } ?>
                        </div>
                    </div>

                </div>
                <!-- Bordered table End -->         

                </div>
                
            </div>
        </div>
    </div>


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