<ul class="breadcrumb">
	<i class="icon-chevron-right"></i> 
	<li><a href="index.php?page=ucp"><?php echo GetC($_SESSION['CLogged'], "Name"); ?>'s profile</a></li>
	<li class="active">/ Account Settings</li><br>
	<li><font color="red">Please make sure you disconnect in-game while editing your account settings.</font></li>
</ul>

<?php
if(isset($_POST['save']))
{
	$email = mysql_real_escape_string($_POST['emailadress']);
	$forum = mysql_real_escape_string($_POST['forumname']);
	
	$aviv = mysql_query("SELECT * FROM `characters` WHERE `Online` = 1 AND `ID` = ".GetC($_SESSION['CLogged'], "ID")."");
	if(mysql_num_rows($aviv))
	{
		echo GetMessage("ERROR:", "You can not change your settings while connected to the server. Please disconnect and try again.", 4);
	}
	else
	{
		if(!empty($_POST['newpass']))
		{
			$newpass = mysql_real_escape_string($_POST['newpass']);
			$confirmpass = mysql_real_escape_string($_POST['confirmpass']);
			if($newpass != $confirmpass)
				echo GetMessage("ERROR:", "Passwords do not match. Please be more careful.", 4);
				
			else
			{
				$newpass = hash('whirlpool', $newpass);
				$newpass = strtoupper($newpass);
				mysql_query("UPDATE `players` SET `Email` = '".$email."', `Forumname` = '".$forum."', `Password` = '".$newpass."' WHERE `ID` = ".$_SESSION['Logged']."");
				echo GetMessage("SUCCESS::", "You have successfully changed your settings. You may connect to the server now.", 7);
			}
		}
		else
		{
			mysql_query("UPDATE `players` SET `Email` = '".$email."', `Forumname` = '".$forum."' WHERE `ID` = ".$_SESSION['Logged']."");
			echo GetMessage("SUCCESS:", "You have successfully changed your settings. You may connect to the server now.", 7);
		}
	}
}
?>

<form method="POST" style="padding: 10px;">
	<div style="font-weight: bold;">
	Email Address: <br />
	<input type="text" name="emailadress" id="inputEmail" value="<?php echo GetP($_SESSION['Logged'], "Email"); ?>" /> <br />
	Forum name: <br />
	<input type="text" name="forumname" id="inputEmail" value="<?php echo GetP($_SESSION['Logged'], "Forumname"); ?>" /> <br />
	New Password: <br />
	<input type="text" name="newpass" id="inputEmail" /> <br />
	Confirm New Password: <br />
	<input type="text" name="confirmpass" id="inputEmail" />
	</div>
	<div class="form-actions" >
		<button type="submit" name="save" class="btn btn-success">Save</button> 
	</div>
</form>