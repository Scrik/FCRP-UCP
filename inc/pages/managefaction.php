<?php
if(!isset($_GET['id'])) header("Location: ?page=homepage"); 
$fID = $_GET['id'];
$checkFaction = mysql_query("SELECT * FROM `factions` WHERE `ID` = '$fID'");
if(!mysql_num_rows($checkFaction)) header("Location: ?page=ucp&category=managefaction"); 
if(isset($_POST['save']))
{
	echo GetMessage("Success:", "Changes were saved.", 3);
	$name = $_POST['name'];
	mysql_query("UPDATE `factions` SET `Name` = '{$name}' WHERE `ID` = '$fID'");
	for($i = 1; $i < 16; $i++)
	{
		$aviv = "Rank$i";
		$avivtwo = $_POST['rank'.$i.''];
		mysql_query("UPDATE `factions` SET `$aviv` = '{$avivtwo}' WHERE `ID` = '$fID'");
	}
}
?>
<h3 style="color: #666666; font-weight: bold; font-family: cMyriadPro; src: url(fonts/myriadpro.otf); line-height: 100%;"><?php echo ''.GetFactionName($fID).' ('.$fID.')'; ?></h3>
<span class="label label-warning" style="font-size: 14px; font-weight: normal;">Total members in faction: <strong><?php echo GetFactionInfo($fID, 'TotalMembers'); ?></strong> </span> <span class="label label-primary" style="font-size: 14px; margin-left: 5px; font-weight: normal;"><a href="?page=ucp&category=factionmembers&id=<?php echo $fID; ?>" style="color: white;">Manage faction members</a></span>
	  <form method="POST" style="padding-left: 1%; padding-top: 1%;">
		<fieldset>
		  <div class="form-group" style="font-weight: bold;">
			Name:
			<div class="col-lg-10"><input type="text" name="name" class="form-control" value="<?php echo GetFactionInfo($fID, "Name"); ?>" /></div>
		  </div>
			<?php
			for($i = 1; $i < 16; $i++)
			{
				echo '
				  <div class="form-group" style="font-weight: bold;">
					Rank '.$i.':
					<div class="col-lg-10"><input type="text" name=rank'.$i.' class="form-control" value="'.GetFactionInfo($fID, 'Rank'.$i.'').'" /></div>
				  </div>
				';
			}
			?>
		  <div class="form-actions" style="width: 94%;">
			<div class="col-lg-10 col-lg-offset-2">
			  <button type="submit" name="save" class="btn btn-primary">Save Changes</button> 
			</div>
		  </div>
		  </fieldset>
		</form>