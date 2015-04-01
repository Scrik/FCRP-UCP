<?php
if(!isset($_SESSION['Logged']))
	header("Location: ?page=homepage");
	
if(GetP($_SESSION['Logged'], "AdminLevel") <= 0)
	header("Location: ?page=homepage");
	
if(!isset($_GET['page']))
	header("Location: ?page=homepage");

$playerID = $_GET['id'];	
$check = mysql_query("SELECT * FROM `players` WHERE `ID` = '$playerID' AND `Status` = '1' OR `Status` = '2'");
if(!mysql_num_rows($check))
	header("Location: ?page=homepage");

?>

<span class="label label-inverse"><i class="icon-share-alt icon-white"></i> <?php if(GetP($playerID, "Status") != 2) echo "Checking"; else echo "Viewing";?> application of <?php echo GetP($_GET['id'], "Name"); ?></span>
<div style="padding-top: 1%; padding-left: 1%;">
	<form method="POST">
		<input type="submit" name="check_similarity" class="btn btn-inverse btn-small" value="Plagiarism" />
		<br />
		<?php
		if(isset($_POST['check_similarity']))
		{
			$checkSimilar = mysql_query("SELECT * FROM `players` WHERE `Name` != '".GetP($_GET['id'], "Name")."'");
			$count = 0;
			while($row = mysql_fetch_array($checkSimilar, MYSQL_ASSOC)) 
			{
				similar_text($row['Question1'], GetP($_GET['id'], "Question1"), $percent1);
				similar_text($row['Question2'], GetP($_GET['id'], "Question2"), $percent2);
				similar_text($row['Question3'], GetP($_GET['id'], "Question3"), $percent3);
				$checkme = $percents = (($percent1 + $percent2 + $percent3)/3);
				if($checkme >= 65)
				{
					$count++;
					$aviv = ($percent1 + $percent2 + $percent3);
					$percents = (($percent1 + $percent2 + $percent3)/3);
					if($percents >= 65)
						$percentcolor = "<span style='color: green; font-weight: 300:'><strong>(LOW)</strong></span>";
						
					if($percents >= 80)
						$percentcolor = "<span style='color: orange; font-weight: 300:'><strong>(MEDIUM)</strong></span>";	

					if($percents >= 90)
						$percentcolor = "<span style='color: red; font-weight: 300:'><strong>(HIGH)</strong></span>";					
					echo "<br />$percentcolor Found application (".$row['Name'].") with similarity of <strong>".$percents."%</strong> (percentage):  <a href='?page=checkapp&id=".$row['ID']."'>View Application [ID ".$row['ID']."]</a>";
				}
			}
			if($count <= 0) echo "<br />No plagiarism was found, application is good to go :).";
		}
		?>
	</form>
	<hr />
	<?php
	$playerID = $_GET['id'];
	if(isset($_POST['accept']))
	{
		mysql_query("UPDATE `players` SET `Status` = '2', `CheckedBy` = '".GetP($_SESSION['Logged'], "Name")."' WHERE `ID` = '$playerID'");
		echo GetMessage("SUCCESS:", "".GetP($playerID, "Name")." has been accepted.", 7);
	}
	else if(isset($_POST['postpone']))
	{
		if(empty($_POST['note']))
			echo GetMessage("ERROR:", "Reason/Note is empty.", 4);
		
		else 
		{
			$note = $_POST['note'];
			$note = xss_clean($note);
			$note = mysql_real_escape_string($note);
			mysql_query("UPDATE `players` SET `Status` = '3', `Note` = '{$note}', `CheckedBy` = '".GetP($_SESSION['Logged'], "Name")."' WHERE `ID` = '$playerID'");
			echo GetMessage("SUCCESS:", "".GetP($playerID, "Name")." has been denied for '".$_POST['note']."'", 7);			
		}
	}
	else if(isset($_POST['ban']))
	{
		if(empty($_POST['note']))
			echo GetMessage("Error:", "Reason/Note is empty.", 4);
			
		else
		{
			$by = GetP($_SESSION['Logged'], "Name");
			$by = mysql_real_escape_string($by);
			$note = $_POST['note'];
			$note = xss_clean($_POST['note']);
			$note = mysql_real_escape_string($note);
			$name = GetP($playerID, "Name");
			$name = mysql_real_escape_string($name);
			mysql_query("UPDATE `players` SET `Banned`='1',`BanReason`='{$note}',`BannedBy`='{$by}', `CheckedBy` = '".GetP($_SESSION['Logged'], "Name")."' WHERE `Name` = '{$name}'");
			echo GetMessage("SUCCESS:", "$name has been banned for '$note'", 7);
		}
	}
	switch(GetP($playerID, "Status"))
	{
		case 1: $status = "<span style='color: red;'>Unchecked</span>"; break;
		case 2: $status = "<span style='color: green;'>Checked</span>"; break;
		case 3: $status = "<span style='color: orange;'>Pending</span>"; break;
	}
	echo "<strong>Status:</strong> $status<br />";
	if(GetP($playerID, "Status") == 3) echo "<strong>Reason:</strong> ".GetP($playerID, "Note")."<br />";
	echo "<strong>Checked By:</strong> ".GetP($playerID, "CheckedBy")."<br />";
	?>
	<strong>Name:</strong> <?php echo GetP($_GET['id'], "Name"); ?><br />
	<strong>Email:</strong> <?php echo GetP($_GET['id'], "Email"); ?><br /><br />
	<blockquote>
	  <p style="font-size: 16px;">Why would you like to join Fort Carson Roleplay? Where did you first hear about the community? Explain in depth.</p>
	  <small style="font-size: 14px; color: #7d7d7d;"><?php echo nl2br(GetP($_GET['id'], "Question1")); ?></small>
	</blockquote>

	<blockquote>
	  <p style="font-size: 18px;">What are our server policies/etiquette when it comes to robbing and scamming?</p>
	  <small style="font-size: 14px; color: #7d7d7d;"><?php echo nl2br(GetP($_GET['id'], "Question2")); ?></small>
	</blockquote>

	<blockquote>
	  <p style="font-size: 16px;">How would you define roleplay and can you explain some of the elements in roleplaying, like powergaming and metagaming?:</p>
	  <small style="font-size: 14px; color: #7d7d7d;"><?php echo nl2br(GetP($_GET['id'], "Question3")); ?></small>
	</blockquote>
	<?php
	if(GetP($playerID, "Status") != 2)
	{
	?>
	<form method="POST">
		<div class="form-actions" >
			<textarea name="note" placeholder="Reason/Note" style="width: 450px"></textarea>
			<div class="pull-right">
			<button type="submit" name="ban" class="btn btn-inverse">Ban</button>
			<button type="submit" name="postpone" class="btn btn-danger">Deny</button>
			<button type="submit" name="accept" class="btn btn-success">Accept</button>
			</div>
		</div>
	</form>
	<?php
	}
	?>
</div>