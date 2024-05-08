<?php include "header.php"; ?>
<?php include "left.php"; ?>
<?php include 'include/dbconnect.php'; ?>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>

	

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				                <div class="pd-20 card-box mb-30">
                    <div class="clearfix mb-20">
                        <div class="pull-left">
                            <h4 style="color: #3d56d8;"> Users List </h4><br>
                        </div>
                    </div><br>
                    

                    <!--<div class="row">-->
                    <!--    <div class="col-sm-12">-->
                    <!--        <table class="data-table table stripe hover nowrap">-->
                    <!--            <thead>-->
                    <!--                <tr>-->
                    <!--                    <th><a class="btn btn-primary" href="javascript:void(0)" style="background-color: #3d56d8; color: white;" onclick="report()">Report</a></th>-->
                    <!--                </tr>-->
                    <!--                <tr>-->
                    <!--                    <th> S.No </th>-->
                    <!--                    <th> Idtag </th>-->
                                        <!--<th> Parent Idtag </th>-->
                    <!--                    <th> Name </th>-->
                    <!--                    <th> Mobile </th>-->
                    <!--                    <th> CMS </th>-->
                    <!--                    <th> Wallet Amount </th>-->
                                        <!--<th> Amount Credit </th>-->
                                        <!--<th> Amount Debit </th>-->
                                        <!--<th> Calculated Wallet Amount </th>-->
                    <!--                    <th> Wallet Tally Status </th>-->
                    <!--                    <th> Status </th>-->
                                        <!--<th> Email </th>-->
                                        <!--<th> City </th>-->
                    <!--                    <th> Transaction </th>-->
                    <!--                </tr>-->
                    <!--            </thead>-->
                <!--            </table>-->
                <!--         </div>-->
                <!--    </div>-->

                </div>
				<script src="http://code.jquery.com/jquery-latest.js"></script>
				<script>
				    $(document).ready(function()
				    {
                        for (let i = 0; i < 20; i++) {
                            const vurl="users.php?id="+$i;
				         $('#div_refresh').load(vurl);
				        }
				    });
				</script>
                <div class="table-responsive" id="div_refresh"></div>
                
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

</body>
</html>