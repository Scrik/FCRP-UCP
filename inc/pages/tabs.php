<div class="tab-pane fade" id="ban">
<p>
	<i class="icon-Sirajuddin-right"></i> Ban
	<hr />
	<form method="POST">
		<div style="font-weight: bold;">
		Master account name: <br />
		<input type="text" name="mname" id="inputEmail" /> <br />
		Banned by:<br />
		<input type="text" name="bannedby" id="inputPassword" value="<?php echo GetP($_SESSION['Logged'], "Name"); ?>" disabled /> <br />
		Reason displayed to player:<br />
		<textarea name="reason" cols="3" style="resize: none;"></textarea><br />
		<div class="form-actions" >
			<button type="submit" name="ban" class="btn btn-success">Submit Ban</button> 
		</div>
		</div>
	</form>
</p>
</div>

<div class="tab-pane fade" id="unban">
<p>
	<i class="icon-Sirajuddin-right"></i> Unban
	<hr />
	<form method="POST">
		<div style="font-weight: bold;">
		Master account name: <br />
		<input type="text" name="mname" id="inputEmail" /> <br />
		<div class="form-actions" >
			<button type="submit" name="unban" class="btn btn-success">Unban</button> 
		</div>
		</div>
	</form>
</p>
</div>

<div class="tab-pane fade" id="checkstats">
<p>
	<i class="icon-Sirajuddin-right"></i> Check Stats
	<hr />
	<form method="POST">
		<div style="font-weight: bold;">
		Character name: <br />
		<input type="text" name="cname" id="inputEmail" /> <br />
		<div class="form-actions" >
			<button type="submit" name="checkstats" class="btn btn-success">Check Stats</button> 
		</div>
		</div>
	</form>
</p>
</div>

<div class="tab-pane fade" id="checkip">
<p>
	<i class="icon-Sirajuddin-right"></i> Check IP
	<hr />
	<form method="POST">
		<div style="font-weight: bold;">
		IP Address: <br />
		<input type="text" name="ipaddress" id="inputEmail" /> <br />
		<div class="form-actions" >
			<button type="submit" name="checkip" class="btn btn-success">Check IP</button> 
		</div>
		</div>
	</form>
</p>
</div>

<div class="tab-pane fade" id="searchlogs">
	<div style="overflow-y: scroll; overflow-x: scroll; height: 300px">
      				<center><h4 style="text-decoration: none; font-family: cMyriadPro; src: url(fonts/myriadpro.otf); color: #1A167D;">Kicks and Bans</h4></center>
      				<p>
	  			</p>
				<?php $logs = GetLogs();
				echo $logs; ?>
				
	</div>
</div>

<div class="tab-pane fade" id="restarts">
	<div style="overflow-y: scroll; overflow-x: scroll; height: 300px">
      				<center><h4 style="text-decoration: none; font-family: cMyriadPro; src: url(fonts/myriadpro.otf); color: #1A167D;">Server restarts</h4></center>
      				<p>
	  			</p>
				<?php $logs = GetRestartLogs();
				echo $logs; ?>
				
	</div>
</div>

<?php
if(isset($_POST['checkip']) && !empty($_POST['ipaddress']))
{
	$ip = mysql_real_escape_string($_POST['ipaddress']);
	echo '<i class="icon-Sirajuddin-right"></i> Checking IP '.$ip.'<br />';
	echo "<hr />";
	$check1 = mysql_query("SELECT * FROM `banned` WHERE `IP` = '".$ip."'");
	if(mysql_num_rows($check1))
		echo "<strong><span style='color: red;'>Given IP is in the banned IP list.</span></strong>";
		
	else
		echo "<strong>Given IP is not in the banned IP list.</strong>";
		
	$check2 = mysql_query("SELECT * FROM `characters`");
	echo "<hr />";
	echo "<strong>Characters that registered with this IP:</strong><ul>";
	$count1 = 0;
	$count2 = 0;
	while($row = mysql_fetch_array($check2, MYSQL_ASSOC)) 
	{
		if($row['RegisteredIP'] == $ip && $ip != "127.0.0.1")
		{
			$count1++;
			$pid = GetPlayerID(GetC($row['ID'], "Creator"));
			$banned = GetP($pid, "Banned") ? ("<span style=color:red>Banned</span>") : ("Not banned");
			echo ">> <strong>".GetP($pid, "Name")."</strong> registered his character <strong>".GetC($row['ID'], "Name")."</strong> with the given IP <strong>$ip</strong> ($banned) <br />";
		}
	}
	echo "</ul>Showing total of $count1 results.";
	echo "<hr /><strong>Characters that their last visit was with this IP:</strong><ul>";
	while($row = mysql_fetch_array($check2, MYSQL_ASSOC)) 
	{
		if($row['LastIP'] == $ip && $ip != "127.0.0.1")
		{
			$count2++;
			$pid = GetPlayerID(GetC($row['ID'], "Creator"));
			$banned = GetP($pid, "Banned") ? ("<span style=color:red>Banned</span>") : ("Not banned");
			echo ">> <strong>".GetC($row['ID'], "Name")."</strong>'s last visit was involved with the IP <strong>$ip</strong> ($banned) <br />";
		}
	}
	echo "</ul>Showing total of $count2 results.";
}
if(isset($_POST['ban']))
{
	if(!empty($_POST['mname']) && !empty($_POST['reason']))
	{
		$check = mysql_query("SELECT * FROM `players` WHERE `Name` = '".$_POST['mname']."' AND `Banned` = 0");
		if(mysql_num_rows($check))
		{
			$reason = mysql_real_escape_string($_POST['reason']);
			$mname = mysql_real_escape_string($_POST['mname']);
			mysql_query("UPDATE `players` SET `Banned` = 1, `BannedBy` = '".GetP($_SESSION['Logged'], "Forumname")."', `BanReason` = '$reason' WHERE `Name` = '$mname'");
			echo SendMsg("Banned!", "Player <strong>$mname</strong> has been banned for <i>$reason</i>", 2);
			echo "<meta http-equiv='refresh' content='2.0;url=?page=cp'>";
		}
		else
		{
			$mname = mysql_real_escape_string($_POST['mname']);
			echo SendMsg("404!", "Player <strong>$mname</strong> could not be found or is already banned.", 1);
			echo "<meta http-equiv='refresh' content='2.0;url=?page=cp'>";
		}
	}
}
if(isset($_POST['unban']))
{
	if(!empty($_POST['mname']))
	{
		$check = mysql_query("SELECT * FROM `players` WHERE `Name` = '".$_POST['mname']."' AND `Banned` = 1");
		if(mysql_num_rows($check))
		{
			$mname = mysql_real_escape_string($_POST['mname']);
			mysql_query("UPDATE `players` SET `Banned` = 0 WHERE `Name` = '$mname'");
			echo SendMsg("Banned!", "Player <strong>$mname</strong> has been unbanned.", 2);
			echo "<meta http-equiv='refresh' content='2.0;url=?page=cp'>";
		}
		else
		{
			$mname = mysql_real_escape_string($_POST['mname']);
			echo SendMsg("404!", "Player <strong>$mname</strong> could not be found or is not banned.", 1);
			echo "<meta http-equiv='refresh' content='2.0;url=?page=cp'>";
		}
	}
}
if(isset($_POST['checkstats']))
{
	if(!empty($_POST['cname']))
	{
		$cname = mysql_real_escape_string($_POST['cname']);
		$check = mysql_query("SELECT * FROM `characters` WHERE `Name` = '$cname'");
		if(mysql_num_rows($check))
		{
			echo SendMsg("Check Stats", "<strong>Viewing $cname's statistics:</strong>", 2);
			$cid = GetCharacterID($cname);
			$dontname = array(
				0 => "Regular Member",
				1 => "<span style='color: #681d0b;'>Bronze Donator</span>",
				2 => "<span style='color: #909090;'>Silver Donator</span>",
				3 => "<span style='color: #c28910;'>Gold Donator</span>",
			);
			?>
			PLAYER ID: <strong>#<?php echo GetC($cid, "ID"); ?></strong><br />
			CREATOR: <strong><?php echo GetC($cid, "Creator"); ?></strong><br />
			REGISTERED IP: <strong><?php echo GetC($cid, "RegisteredIP"); ?></strong><br />
			LAST IP USED: <strong><?php echo GetC($cid, "LastIP"); ?></strong><br />
			LAST VISIT: <strong><?php echo GetC($cid, "Lastseen"); ?></strong><br />
			DONATOR STATUS: <strong><?php echo $dontname[GetC($cid, "Donator")]; ?></strong><br />
			BANNED:
			<?php
			$pid = GetPlayerID(GetC($cid, "Creator"));
			if(GetP($pid, "Banned") == 1)
				echo "<span style='color: red;'>Is banned for '<i>".GetP($pid, "BanReason")."</i>' by <strong>".GetP($pid, "BannedBy")."</strong></span>";
			
			else
				echo "<strong>No</strong>";
			?>
			<div style="width: 100%; border-top: 1px solid #E3E3E3; height: 7px; margin-top: 7px;"></div>
			MONEY: <strong>$<?php echo number_format(GetC($cid, "Money")); ?></strong><br />
			BANK ACCOUNT: <strong>$<?php echo number_format(GetC($cid, "Bank")); ?></strong><br />
			PAYDAY: <strong>$<?php echo number_format(GetC($cid, "Paycheck")); ?></strong><br />
			SAVINGS: <strong>$<?php echo number_format(GetC($cid, "Savings")); ?></strong><br />
			<div style="width: 100%; border-top: 1px solid #E3E3E3; height: 7px; margin-top: 7px;"></div>
			<div class="row-fluid">
			<ul class="thumbnails">
			<?php
			$vehicleCheck = mysql_query("SELECT * FROM `Vehicles` WHERE `Owner` = $cid");
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
						<div class="thumbnail">
						  <img src="cars/Vehicle_<?php echo GetV($row['ID'], "Model"); ?>.jpg" alt="">
						  <div class="caption">
							<h3><?php echo vehiclename($row['Model']); ?></h3>
							<p>
							Owner: <strong><?php echo GetC(GetV($row['ID'], "Owner"), "Name"); ?></strong><br />
							Model: <strong><?php echo GetV($row['ID'], "Model"); ?></strong><br />
							Insurances: <strong><?php echo GetV($row['ID'], "Insurances"); ?></strong><br />
							Plate: <strong><?php echo GetV($row['ID'], "Plate"); ?></strong>
							</p>
						  </div>
						</div>
					  </li>
					<?php
				}
				?>
				</ul>
				</div>
				<?php
			}
		}
		else
		{
			$cname = mysql_real_escape_string($_POST['cname']);
			echo SendMsg("404!", "Character <strong>$cname</strong> could not be found.", 1);
			echo "<meta http-equiv='refresh' content='2.0;url=?page=cp'>";
		}
	}
}
?>