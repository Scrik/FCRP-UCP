<ul class="breadcrumb">
	<i class="icon-chevron-right"></i> 
	<li><a href="index.php?page=ucp"><?php echo GetC($_SESSION['CLogged'], "Name"); ?>'s Profile</a></li>
	<li class="active">/ My Profile</li>
</ul>

<center><h4 style="font-family: cMyriadPro; src: url(fonts/myriadpro.otf);">
<img height="725" width="725" src="images/skins/<?php echo GetC($_SESSION['CLogged'], "Skin"); ?>.png" />
<?php
$checkonline = mysql_query("SELECT * FROM `characters` WHERE `Online` = 1 AND `Name` = '".GetC($_SESSION['CLogged'], "Name")."'");
if(mysql_num_rows($checkonline))
	echo "<span style='color: green;'><li>Online</li></span>";

else
	echo "<span style='color: red;'><li>Offline</li></span>";
?>
</h4></center>

<div style="padding: 10px; padding: 10px; line-height: 180%; font-size: 13.5px; border-radius: 5px; -moz-border-radius: 5px;">
	<ul id="myTab" class="nav nav-tabs">
	  <li class="active"><a href="#general" data-toggle="tab">General</a></li>
	  <li><a href="#money" data-toggle="tab">Financial</a></li>
	  <li><a href="#phone" data-toggle="tab">Cellular</a></li>
	  <li><a href="#donate" data-toggle="tab">Donation</a></li>
	  <li><a href="#vehicles" data-toggle="tab">Vehicles</a></li>
	</ul>
	<div id="myTabContent" class="tab-content">
	  <div class="tab-pane fade in active" id="general">
		<div class="row">
			<div class="span7">
				PLAYER ID: #<?php echo GetC($_SESSION['CLogged'], "ID"); ?> <br />
				NAME: <?php echo GetC($_SESSION['CLogged'], "Name"); ?><br />
				<?php 
				$needexp = ((GetC($_SESSION['CLogged'], "Level") + 1) * 4);
				?>
				EXPERIENCE POINTS: <?php echo GetC($_SESSION['CLogged'], "EXP"); ?>/<?php echo $needexp; ?> <br />
				LEVEL: <?php echo GetC($_SESSION['CLogged'], "Level"); ?> <br />
				HOURS ON: <?php echo GetC($_SESSION['CLogged'], "TotalHours"); ?> <br />
				<div style="width: 200px; border-top: 1px solid #eeeeee; height: 7px; margin-top: 7px;"></div>
				EMAIL: <?php echo GetP($_SESSION['Logged'], "Email"); ?> <br />
				FORUMNAME: <?php echo GetP($_SESSION['Logged'], "Forumname"); ?> <br />
			</div>
		</div>
	  </div>
	  <div class="tab-pane fade" id="money">
		<p>
			<?php
			$cash = number_format(GetC($_SESSION['CLogged'], "Money"));
			$bank = number_format(GetC($_SESSION['CLogged'], "Bank"));
			$payday = number_format(GetC($_SESSION['CLogged'], "Paycheck"));
			$savings = number_format(GetC($_SESSION['CLogged'], "Savings"));
			?>
			CASH: $<?php echo $cash; ?> <br />
			BANK BALANCE: $<?php echo $bank; ?> <br />
			PAYDAY: $<?php echo $payday; ?> <br />
			SAVINGS: $<?php echo $savings; ?> <br />
		</p>	
	  </div>
	  <div class="tab-pane fade" id="donate">
		<p>
			<?php
			$dontname = array(
				0 => "<span style='color: black;'>Regular Member</span>",
				1 => "<span style='color: #681d0b;'>Bronze Donator</span>",
				2 => "<span style='color: #909090;'>Silver Donator</span>",
				3 => "<span style='color: #c28910;'>Gold Donator</span>",
			);
			?>
			DONATOR: <?php echo $dontname[GetC($_SESSION['CLogged'], "Donator")]; ?> <br />
			NAME CHANGES: <?php echo GetC($_SESSION['CLogged'], "Namechanges"); ?> <br />
			NUMBER CHANGES: <?php echo GetC($_SESSION['CLogged'], "Numberchanges"); ?> <br />
		</p>	
	  </div>
	  <div class="tab-pane fade" id="phone">
		<p>
			<?php
			$phonename = array(
				0 => "None",
				1 => "White",
				2 => "Red",
				3 => "Green",
				4 => "Blue",
				5 => "Yellow",
				6 => "Purple"
			);
			?>
			PHONE NUMBER: <?php echo GetC($_SESSION['CLogged'], "Phone"); ?> <br />
			PHONE CREDITS: <?php echo GetC($_SESSION['CLogged'], "PhoneCredits"); ?> <br />
			PHONE TYPE: <?php echo $phonename[GetC($_SESSION['CLogged'], "PhoneType")]; ?> <br />
		</p>	
	  </div>
	  <div class="tab-pane fade" id="vehicles">
		<p>
			<div class="row-fluid">
				<ul class="thumbnails">
				<?php
				$vehicleCheck = mysql_query("SELECT * FROM `Vehicles` WHERE `Owner` = ".$_SESSION['CLogged']."");
				if(!mysql_num_rows($vehicleCheck))
				{
					echo "This character does not have any vehicles.";
				}
				else
				{
					$count = 0;
					while($row = mysql_fetch_array($vehicleCheck, MYSQL_ASSOC)) 
					{
						$count ++;
						?>
						  <li class="span4">
							<div class="alert alert-success">
							  <div class="shadow" align="center"><img src="cars/Vehicle_<?php echo GetV($row['ID'], "Model"); ?>.jpg" alt=""></div>
							  <div class="caption">
								<h3><?php echo vehiclename($row['Model']); ?></h3>
								<p>
								Owner: <?php echo GetC(GetV($row['ID'], "Owner"), "Name"); ?><br />
								Model: <?php echo GetV($row['ID'], "Model"); ?><br />
								Insurances: <?php echo GetV($row['ID'], "Insurances"); ?><br />
								Plate: <?php echo GetV($row['ID'], "Plate"); ?>
								</p>
							  </div>
							</div>
						  </li>
						<?php
					}
				}					
				?>
				</ul>
			</div>
		</p>	
	  </div>
	</div>	
</div>
