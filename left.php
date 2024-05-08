
	<div class="left-side-bar" style="background-color: #c42216;">
		<div>
			<div class="logo" style="background-color: #fff;text-align:center;padding:10px 0px 10px 0px;">
			<img src="images/tuckerlogo.png" alt="logo">
			</div>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<?php
					   $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
					?>
					<li>
						<a href="dashboard" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/dashboard.png"></span><span class="mtext"> Dashboard </span> </a>
					</li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<div class="sidebar-small-cap">Activity</div>
					</li>
					<!-- <li>
						<a href="#" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/authentication.png"></span><span class="mtext"> Authorization </span> </a>
					</li>
					<li>
						<a href="#" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/reservation.png"></span><span class="mtext"> Reservation </span> </a>
					</li> -->
					<li>
						<a href="charging_session_statistics" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/sessions.png"></span><span class="mtext">Live Charging Sessions </span> </a>
					</li>
					<li>
						<a href="chargepoints" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/chargingpoints.png"></span><span class="mtext"> Charge Points </span> </a>
					</li>
						<li>
						<a href="remoteaccess" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/transactions.png"></span><span class="mtext">Remote Control </span> </a>
					</li>
					<li>
						<a href="wallettrack" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/earnings.png"></span><span class="mtext">Wallet Track </span> </a>
					</li>
				<!--	<li>
						<a href="transaction.php" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/transactions.png"></span><span class="mtext">Transactions </span> </a>
					</li>-->
						<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<div class="sidebar-small-cap">Idtags</div>
					</li>
					<li>
						<a href="users" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/authentication.png"></span><span class="mtext"> Users </span> </a>
					</li>
					<li>
						<a href="testers" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/authentication.png"></span><span class="mtext"> Testers </span> </a>
					</li>
					<li>
						<a href="freeusers" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/authentication.png"></span><span class="mtext"> Freeusers </span> </a>
					</li>
					<li>
						<a href="groupusers" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/authentication.png"></span><span class="mtext"> Groupusers </span> </a>
					</li>
					<li>
						<a href="ownerusers" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/authentication.png"></span><span class="mtext"> Owner Cardusers </span> </a>
					</li>
					<li>
						<a href="cardusers" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/authentication.png"></span><span class="mtext"> Cardusers </span> </a>
					</li>
					<li>
						<a href="giftusers" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/authentication.png"></span><span class="mtext"> Gift Cardusers </span> </a>
					</li>
					<li>
						<a href="addusers" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/sessions.png"></span><span class="mtext"> RFID </span> </a>
					</li>

					<li>
						<div class="dropdown-divider"></div>
					</li>

					<li>
						<div class="sidebar-small-cap">Assets</div>
					</li>

					<li>
						<a href="cms" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/sessions.png"></span><span class="mtext"> CMS </span> </a>
					</li>
					<li>
						<a href="cpo" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/chargingnetworks.png"></span><span class="mtext"> CPO </span> </a>
					</li>

					<li>
						<a href="stations" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/chargingpoints.png"></span><span class="mtext"> Stations </span> </a>
					</li>
					<li>
						<a href="chargers" class="dropdown-toggle no-arrow"><span class="micon"><img src="images/icons/chargingzones.png"></span><span class="mtext"> Chargers </span> </a>
					</li>
					<!-- <li>
						<a href="#" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/chargingzones.png"></span><span class="mtext"> Charging Zones </span> </a>
					</li> -->


					<li>
						<div class="dropdown-divider"></div>
					</li>

					<li>
						<div class="sidebar-small-cap"> Reports </div>
					</li>

					<li>
						<a href="history" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/charginghistory.png"></span><span class="mtext"> History </span>	</a>
					</li>

					<li>
						<a href="earnings" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/earnings.png"></span><span class="mtext"> Earnings </span> </a>
					</li>
				<!--	<li>
						<a href="faults.php" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/faults.png"></span><span class="mtext"> Fault </span> </a>
					</li>-->

					<!-- <li>
						<div class="sidebar-small-cap">CRM</div>
					</li>


					<li><a href="#" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/users.png"></span><span class="mtext"> Users </span> </a></li>

					<li><a href="#" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/rfid.png"></span><span class="mtext"> RFID Tags </span> </a></li>

					<li><a href="#" class="dropdown-toggle no-arrow"> <span class="micon"><img src="images/icons/receipts.png"></span><span class="mtext"> Receipts </span> </a></li> -->

					<!-- <li class="dropdown">
						<a class="dropdown-toggle">
							<span class="micon"><img src="images/icons/sld.png"></span><span class="mtext"> Station Management </span>
						</a>
						<ul class="submenu">
							<li><a href="bylocation.php"> By Location </a></li>
							<li><a href="bynetwork.php"> By Network </a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle">
							<span class="micon"><img src="images/icons/reports.png"></span><span class="mtext"> Reports </span>
						</a>
						<ul class="submenu">
							<li><a href="graphical_overview.php"> Chart </a></li>
							<li>
							<?php
								if($curPageName=='charging_points.php')
								{
									?><a> Charging Points </a><?php
								}
								else
								{
									?><a href="charging_points.php"> Charging Points </a><?php
								}
							?>
							</li>
							<li><a href="charging_session_statistics.php"> Charging Session Statistics </a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle">
							<span class="micon"><img src="images/icons/reports.png"></span><span class="mtext"> CRM </span>
						</a>
						<ul class="submenu">
							<li><a href="#"> Users </a></li>
							<li><a href="#"> RFID Tags </a></li>
							<li><a href="#"> Receipts </a></li>
						</ul>
					</li> -->
					
				</ul>
			</div>

		</div>
	</div>
	<div class="mobile-menu-overlay"></div>