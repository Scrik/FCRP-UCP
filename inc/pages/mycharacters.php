<?php
if(isset($_GET['user']))
{
	$userID = $_GET['user'];
	$check = mysql_query("SELECT * FROM `characters` WHERE `ID` = '$userID'");
	if(mysql_num_rows($check) < 0)
		header("Location: ?page=ucp&category=mycharacters");
	else 	
	{
		$userName = GetCharacterName($userID);
		if((GetP($_SESSION['Logged'], "Character1") == $userName) || (GetP($_SESSION['Logged'], "Character2") == $userName) || (GetP($_SESSION['Logged'], "Character3") == $userName))
		{
			$nxtlevel = GetC($userID, "Level") + 1;
			$expamount = $nxtlevel*4;
			$formula = (GetC($userID, "EXP") / $expamount) * 100;
			$formula = round($formula);
			$nametag = str_replace("_", " ", GetC($userID, "Name"));
			?>
			<span class="label label-inverse"><i class="icon-share-alt icon-white"></i> Viewing Stats of <?php echo $nametag; ?></span>
			<h1 style="font-family: cMyriadPro; src: url(fonts/myriadpro.otf);"><?php echo $nametag; ?><span class="pull-right"><?php echo '<img height="180" width="180" src="images/skins/'.GetC($userID, "Skin").'.png" />';?></span></h1>
			<div style="font-size: 14px; line-height: 180%;">
			<strong>ID:</strong> <?php echo GetC($userID, "ID"); ?><br />
			<strong>Creator:</strong> <?php echo GetC($userID, "Creator"); ?><br />
			<strong>Level:</strong> <?php echo GetC($userID, "Level"); ?><br />
			<strong>Experience Points:</strong> <?php echo ''.GetC($userID, "EXP").'/'.$expamount.''; ?><br />
			<strong>Money:</strong> $<?php echo GetC($userID, "Money"); ?><br />
			<strong>Bank:</strong> $<?php echo GetC($userID, "Bank"); ?><br />
			<strong>Faction:</strong> <?php echo GetFactionName(GetC($userID, "Faction")); ?> <?php if(GetC($userID, "Leader") == GetC($userID, "Faction") && GetC($userID, "Faction") != 0) { ?><span class="label label-info"><a href="?page=ucp&category=managefaction&id=<?php echo GetC($userID, "Faction"); ?>" style="color: white;">Administrate</a></span><?php } ?><br />
			<strong>Rank:</strong> <?php echo GetFactionRank(GetC($userID, "Faction"), GetC($userID, "Rank")); ?><br />
			<strong>Job:</strong> <?php echo GetJob(GetC($userID, "Job")); ?><br />
			</div>
			<?php
		}
		else 
			header("Location: ?page=ucp&category=mycharacters");
	}
}
else
{
	?>
	<blockquote style="margin-top: 3%; font-size: 18px;">
	  <p>My Characters:</p>
		<?php
		$id = $_SESSION['Logged'];
		if((GetP($id, "Character1") == "None") && (GetP($id, "Character2") == "None") && (getP($id, "Character3") == "None"))
		{
			echo "<small>You do not possess any characters.</small>";
		}
		for($i = 1; $i < 4; $i++)
		{
			if(strcmp(GetP($id, "Character$i"), "None"))
			{
				$name = GetP($_SESSION['Logged'], "Character$i");
				$cID = GetCharacterID($name);
				echo '
				<small>
				<div class="media">
				  <a class="pull-left" href="#">
					<img class="media-object" height="50" width="50" src="images/skins/'.GetC($cID, "Skin").'.png" alt="...">
				  </a>
				  <div class="media-body">
					<h4 class="media-heading">Character '.$i.': '.GetP($id, "Character$i").'</h4>
					Character ID: '.$cID.' | <a href="?page=ucp&category=mycharacters&user='.$cID.'">View Profile</a>
				  </div>
				</div>
				</small>';
			}
		}
	?>
	</blockquote>
<?php
}
?>