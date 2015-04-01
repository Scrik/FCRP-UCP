<?php
if(!isset($_SESSION['Logged']) || !isset($_GET['id']))
	header("Location: ?page=onlineplayers");

if(GetP($_SESSION['Logged'], "Status") != 2)
	header("Location: ?page=homepage");
	
	$insertedID = $_GET['id'];
	$check = mysql_query("SELECT * FROM `characters` WHERE `ID` = '$insertedID'");
	if(!mysql_num_rows($check))
		header("Location: ?page=onlineplayers");
		
	$checkFriend = mysql_query("SELECT * FROM `friends` WHERE `playerID` = '".$_SESSION['Logged']."' AND `friendID` = '$insertedID'");
?>

<span class="label label-inverse"><i class="icon-share-alt icon-white"></i> <?php echo mysql_num_rows($checkFriend) ? ("Remove friend") : ("Add friend"); ?></span>
<div class="jumbotron" align="center" style="padding-top: 1%;">
<?php 
if(mysql_num_rows($checkFriend))
{
	echo GetMessage("Success:", ''.GetCharacterName($insertedID).' has been removed from your friends list.', 4);
	mysql_query("DELETE FROM `friends` WHERE `playerID` = '".$_SESSION['Logged']."' AND `friendID` = '$insertedID'");
	echo "<meta http-equiv='refresh' content='1.5;url=?page=onlineplayers&view=".$insertedID."'>";
}
else
{
	echo GetMessage("Success:", ''.GetCharacterName($insertedID).' has been added to friends list.', 7);
	mysql_query("INSERT INTO `friends`(`playerID`, `friendID`) VALUES ('".$_SESSION['Logged']."','$insertedID')");
	echo "<meta http-equiv='refresh' content='1.5;url=?page=onlineplayers&view=".$insertedID."'>";
}
?>
</div>