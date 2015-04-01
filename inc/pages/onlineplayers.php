<ul class="breadcrumb">
	<i class="icon-chevron-right"></i> 
	<li class="active">Online Players</li>
</ul>

<?php 
if(!isset($_GET['view'])) 
{ 
if(isset($_SESSION['Logged'])) $name = GetP($_SESSION['Logged'], "Name");
if(isset($_SESSION['Logged'])) $query = mysql_query("SELECT * FROM `characters` WHERE `Online` = '1'");
else $query = mysql_query("SELECT * FROM `characters` WHERE `Online` = 1");
if(!mysql_num_rows($query))
	echo "<span style='padding: 30px; color: gray;'>There are no players online at the moment.</span>";

else
{
?>
<table class="table table-hover" style="margin-top: 1%;">
  <tbody>
	<tr style="color: #666666; font-weight: bold;">
	  <td>Username</td>
	  <td>Forum name</td>
	  <td>Level</td>
	</tr>
	<?php
	while($row = mysql_fetch_array($query, MYSQL_ASSOC)) 
	{
		if(isset($_SESSION['Logged']) && $row['Creator'] == GetP($_SESSION['Logged'], "Name"))
		{
			if($row['AdminLevel'] == 1) {
				echo '
				<tr class="danger">
				  <td>'.$row['Name'].'</td>
				  <td>'.GetForumName($row['ID']).'</td>
				  <td>'.$row['Level'].'</td>
				</tr>
				';
			}
			else if($row['AdminLevel'] > 1) {
				echo ' 
				<tr class="success">
				  <td>'.$row['Name'].'</td>
				  <td>'.GetForumName($row['ID']).'</td>
				  <td>'.$row['Level'].'</td>
				</tr>
				';
			}
			else if($row['AdminLevel'] <= 0) {
				echo ' 
				<tr class="default">
				  <td>'.$row['Name'].'</td>
				  <td>'.GetForumName($row['ID']).'</td>
				  <td>'.$row['Level'].'</td>
				</tr>
				';
			}

		}
		else
		{
			if($row['AdminLevel'] == 1) {
				echo '
				<tr class="danger">
				  <td><a href="?page=onlineplayers&view='.$row['ID'].'">'.$row['Name'].'</a></td>
				  <td>'.GetForumName($row['ID']).'</td>
				  <td>'.$row['Level'].'</td>
				</tr>
				';
			}
			else if($row['AdminLevel'] > 1) {
				echo ' 
				<tr class="success">
				  <td><a href="?page=onlineplayers&view='.$row['ID'].'">'.$row['Name'].'</a></td>
				  <td>'.GetForumName($row['ID']).'</td>
				  <td>'.$row['Level'].'</td>
				</tr>
				';
			}
			else if($row['AdminLevel'] <= 0) {
				echo ' 
				<tr class="default">
				  <td><a href="?page=onlineplayers&view='.$row['ID'].'">'.$row['Name'].'</a></td>
				  <td>'.GetForumName($row['ID']).'</td>
				  <td>'.$row['Level'].'</td>
				</tr>
				';
			}
		}
	}
	?>
  </tbody>
</table>
<?php 
}
}
else
{
	if(isset($_SESSION['Logged']))
	{
		$insertedID = $_GET['view'];
		$name = GetCharacterName($insertedID);
		$myid = $_SESSION['Logged'];
		$aviv = mysql_query("SELECT * FROM `players` WHERE `ID` = '$myid'");
		$check = mysql_query("SELECT * FROM `characters` WHERE `ID` = '$insertedID'");
		if(!mysql_num_rows($check))
			header("Location: ?page=onlineplayers"); 	
			
		if(GetC($insertedID, "Creator") == GetP($_SESSION['Logged'], "Name"))
			header("Location: ?page=onlineplayers");
			
		if(mysql_num_rows($aviv) < 0)
			header("Location: ?page=onlineplayers"); 
			
		$checkFriend = mysql_query("SELECT * FROM `friends` WHERE `playerID` = '".$_SESSION['Logged']."' AND `friendID` = '$insertedID'");
		$nxtlevel = GetC($insertedID, "Level") + 1;
		$expamount = $nxtlevel*4;
		$formula = (GetC($insertedID, "EXP") / $expamount) * 100;
		$formula = round($formula);
		$nametag = str_replace("_", " ", GetC($insertedID, "Name"));
		?>
		<span class="label label-inverse"><i class="icon-share-alt icon-white"></i> Viewing profile of <?php echo GetC($insertedID, "Name"); ?></span>
		<div align="center"><?php echo mysql_num_rows($checkFriend) ? ('<a href="?page=managefriend&id='.$insertedID.'" class="btn btn-danger"><i class="icon-heart icon-white"></i> Remove Friend</a>') : ('<a href="?page=managefriend&id='.$insertedID.'" class="btn btn-info"><i class="icon-heart icon-white"></i> Add Friend</a>'); ?></div>
		<h1 style="font-family: cMyriadPro; src: url(fonts/myriadpro.otf);"><?php echo $nametag; ?><span class="pull-right"><?php echo '<img height="180" width="180" src="images/skins/'.GetC($insertedID, "Skin").'.png" />';?></span></h1>
		<div style="font-size: 14px; line-height: 180%;">
		<strong>ID:</strong> <?php echo GetC($insertedID, "ID"); ?><br />
		<strong>Forum:</strong> <?php echo GetC($insertedID, "Creator"); ?><br />
		<strong>Level:</strong> <?php echo GetC($insertedID, "Level"); ?><br />
		<strong>Experience:</strong> <?php echo ''.GetC($insertedID, "EXP").'/'.$expamount.''; ?><br />
		<strong>Faction:</strong> <?php echo GetFactionName(GetC($insertedID, "Faction")); ?> <br />
		<strong>Rank:</strong> <?php echo GetFactionRank(GetC($insertedID, "Faction"), GetC($insertedID, "Rank")); ?><br />
		<strong>Job:</strong> <?php echo GetJob(GetC($insertedID, "Job")); ?><br />
		</div>
		<?php
	}
	else
	{
		echo GetMessage("Error:", "You are not logged in.", 4);
	}
}
?>