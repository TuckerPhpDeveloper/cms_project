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
                                        <th> Pay ID </th>
                                        <th> Amount </th>
                                        <th> Credit / Debit </th>
                                        <th> Transaction Time </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_no = 0;
                                    $query1 = mysqli_query(
                                        $connect,
                                        "select * from fca_wallet_transaction where idtag='$idtag' and `credit/debit`!=2 order by sno desc "
                                    );
                                    while (
                                        $row1 = mysqli_fetch_array($query1)
                                    ) {

                                        $s_no++;
                                        $amount = $row1["amount"];
                                        $credit_debit_status =
                                            $row1["credit/debit"];
                                        if ($credit_debit_status == "1") {
                                            $payid = $row1["pay_id"];
                                            $credit_debit =
                                                " <span style='color: green;'> Credit </span> <img src='images/credit.png' style='width:20px; height: 20px;'>";
                                        } elseif ($credit_debit_status == "0") {
                                             $payid =
                                                $row1["pay_id"];
                                            $credit_debit =
                                                " <span style='color: red;'> Debit </span> <img src='images/debit.png' style='width:20px; height: 20px;'>";
                                        }
                                        $timeofupdate = $row1["timeofupdate"];
                                        ?>
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $payid; ?></td>
                                                <td> <?php echo $amount; ?></td>
                                                <td> <?php echo $credit_debit; ?></td>
                                                <td> <?php echo $timeofupdate; ?></td>
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