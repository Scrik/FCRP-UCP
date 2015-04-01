<ul class="breadcrumb">
	<i class="icon-chevron-right"></i> 
	<li><a href="index.php?page=ucp"><?php echo GetC($_SESSION['CLogged'], "Name"); ?>'s profile</a></li>
	<li class="active">/ Change Spawn</li><br>
	<li><font color="red">Please make sure you disconnect in-game while editing your account settings.</font></li>
</ul>
<?php
$aviv = mysql_query("SELECT * FROM `characters` WHERE `Online` = 1 AND `ID` = ".GetC($_SESSION['CLogged'], "ID")."");
if(mysql_num_rows($aviv))
{
	echo GetMessage("ERROR:", "You can not change your location while connected to the server. Please disconnect and try again.", 4);
}
else
{
?>
<ul id="myTab" class="nav nav-tabs">
  <li class="active"><a href="#airport" data-toggle="tab">Airport</a></li>
  <?php if(GetC($_SESSION['CLogged'], "Faction") == 1 || 2) { ?><li><a href="#faction" data-toggle="tab">Faction</a></li><?php } ?>
  <?php 
	$check = mysql_query("SELECT * FROM `houses` WHERE `Owner` = ".GetC($_SESSION['CLogged'], "ID")."");
	if(mysql_num_rows($check)) echo '<li><a href="#house" data-toggle="tab">House</a></li>';	
?>
</ul>
<form method="POST">
	<div id="myTabContent" class="tab-content">
	  <div class="tab-pane fade in active" id="airport">
		<p>
			<center>
				<img style="border: 1px solid black;" src="images/airport.png" width="500" /><br />
				<strong>Airport</strong>
				<br /><button name="setspawn" value="1" type="submit" class="btn btn-small">Change Spawn</button>
			</center>
		</p>
	  </div>
	  <div class="tab-pane fade" id="faction">
		<p>
			<center>
				<?php
					if(GetC($_SESSION['CLogged'], "Faction") == 1)
					{
						echo '<img style="border: 1px solid black;" src="images/police.png" width="500" /><br />';
					}
					else if(GetC($_SESSION['CLogged'], "Faction") == 2)
					{
						echo '<img style="border: 1px solid black;" src="images/hospital.png" width="500" /><br />';
					}
				?>
				<strong>Faction (<?php echo GetFactionName(GetC($_SESSION['CLogged'], "Faction")); ?>)</strong>
				<br /><button name="setspawn" value="2" type="submit" class="btn btn-small">Change Spawn</button>
			</center> 
		</p>
	  </div>
	  <div class="tab-pane fade" id="house">
		<p>
			<center>
				<span class="label label-important">This option is unavailable at the moment!</span><br />
				<strong>House</strong>
				<br /><button name="setspawn" value="3" type="submit" class="btn btn-small" disabled>Change Spawn</button>
			</center>
		</p>
	  </div>
	</div>
</form>

<?php
}
if(isset($_POST['setspawn']))
{
	if($_POST['setspawn'] == 1)
	{
		mysql_query("UPDATE `characters` SET `Spawn0` = 1685.54, `Spawn1` = -2203.27, `Spawn2` = 13.5469 WHERE `ID` = ".GetC($_SESSION['CLogged'], "ID")."");
		echo GetMessage("SUCCESS:", "Your spawning location has been changed to the Airport", 7);
	}
	else if($_POST['setspawn'] == 2)
	{
		if(GetC($_SESSION['CLogged'], "Faction") == 1)
			mysql_query("UPDATE `characters` SET `Spawn0` = 1543.7792, `Spawn1` = -1675.5090, `Spawn2` = 13.5571 WHERE `ID` = ".GetC($_SESSION['CLogged'], "ID")."");
		else
			mysql_query("UPDATE `characters` SET `Spawn0` = 1182.4381, `Spawn1` = -1324.1027, `Spawn2` = 13.5795 WHERE `ID` = ".GetC($_SESSION['CLogged'], "ID")."");
		echo GetMessage("SUCCESS:", "Your spawn has been changed to your faction headquarter.", 7);
	}
	else if($_POST['setspawn'] == 3)
	{
	
	}	
}
?>