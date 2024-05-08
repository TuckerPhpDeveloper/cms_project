<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>


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
                                    <!-- <tr>
                                        <th style="text-align: right;" colspan="11"><a href="addcms.php" style="color: white;"> <button type="button" name="add" class="btn btn-info">  Add CMS </button> </a></th>
                                    </tr> -->
                                    <tr>
                                        <th> S.No </th>
                                        <th> Idtag </th>
                                        <th> Parent Idtag </th>
                                        <th> Name </th>
                                        <th> Mobile </th>
                                        <th> Email </th>
                                        <th> City </th>
                                        <th> Wallet Amount </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $s_no=0;
                                        $query1 = mysqli_query($connect,"select * from fca_users");
                                        while($row1 = mysqli_fetch_array($query1))
                                        {
                                            $s_no++;
                                            $idtag = $row1['idtag'];
                                            $parent_idtag = $row1['parent_idtag'];
                                            $name = $row1['name'];
                                            $mobile = $row1['mobile'];
                                            $email = $row1['email'];
                                            $wallet = $row1['wallet_amount'];
                                            $status = $row1['status'];

                                            $query2 = mysqli_query($connect, "select city from fca_user_details where idtag = '$idtag' ");
                                            $fetch2 = mysqli_fetch_array($query2);
                                            $city = $fetch2[0];

                                            ?>
                                            <!-- <tr id="<?php // echo $row['cms_id'] ?>"> -->
                                            <tr>
                                                <td> <?php echo $s_no; ?></td>
                                                <td> <?php echo $idtag; ?></td>
                                                <td> <?php echo $parent_idtag; ?></td>
                                                <td> <?php echo $name; ?></td>
                                                <td> <?php echo $mobile; ?></td>
                                                <td> <?php echo $email; ?></td>
                                                <td> <?php echo $city; ?></td>
                                                <td> <?php echo "Rs. ".$wallet; ?></td>
                                                <td>           </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                        </tbody>
                                    </table>



    <link rel="stylesheet" href="https://write.corbpie.com/wp-content/litespeed/localres/aHR0cHM6Ly9jZG5qcy5jbG91ZGZsYXJlLmNvbS8=ajax/libs/bootswatch/4.5.0/flatly/bootstrap.min.css"/>
    <script src="https://write.corbpie.com/wp-content/litespeed/localres/aHR0cHM6Ly9jZG5qcy5jbG91ZGZsYXJlLmNvbS8=ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: "status.php",
                data: {"id": <?php echo $machine_id;?>},
                success: function (data) {
                    console.log(data)
                }
            });
        });
    </script>

<?php
if (isset($_POST['form_submit'])) {//Form was submitted
    (isset($_POST['machine_state'])) ? $status = 1 : $status = 0;
    //Update DB
    $db = new PDO('mysql:host=localhost;dbname=testing;charset=utf8mb4', 'root', '');
    $update = $db->prepare("UPDATE `info` SET `status` = ? WHERE `id` = ? LIMIT 1;");
    $update->execute([$status, $machine_id]);
} else {//Page was loaded
    $status = $_SESSION['status'];
}
if ($status) {//status = 1 (on)
    $status_str = "on";
    $checked_status = "checked";
} else {
    $status_str = "off";
    $checked_status = "";
}
?>



                                                  <form method="post">

                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                   name='machine_state' <?php echo $checked_status; ?>>
                            <label class="custom-control-label" for="customSwitch1"></label>
                        </div>
                        <input type="hidden" name="form_submit" value="">

                <input type="submit" class="btn btn-info btn-sm" name="submit" value="Update"/>
            </form>

        </td>
                                            </tr>
                                            
                                </tbody>
                            </table>


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