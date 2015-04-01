<?php
if(!isset($_SESSION['Logged'])) header("Location: ?page=homepage");
if(GetP($_SESSION['Logged'], "Status") != 2)
	header("Location: ?page=homepage");
?>
<span class="label label-inverse"><i class="icon-share-alt icon-white"></i> Settings</span>
<?php
$query = mysql_query("SELECT * FROM `characters` WHERE `Online` = '1'");
?>
<h3 style="color: #666666; font-weight: bold; font-family: cMyriadPro; src: url(fonts/myriadpro.otf); line-height: 0%;">Settings</h3>
<div style="font-size: 14px; padding-top: 2%; padding-left: 1%;">
<form method="POST">
  <fieldset>
	<?php
	if(isset($_POST['submit']))
	{
		if(empty($_POST['forumname']) || empty($_POST['email']))
			echo GetMessage("Error:", "Forum name or Email Address is empty.", 4);
			
		else 
		{
			$email = $_POST['email'];
			$forumname = $_POST['forumname'];
			$forumname = xss_clean($_POST['forumname']);
			$email = xss_clean($_POST['email']);
			$id = $_SESSION['Logged'];
			if($email != GetP($id, "Email") || $forumname != GetP($id, "Forumname"))
			{
				mysql_query("UPDATE `players` SET `Forumname`='{$forumname}',`Email`='{$email}' WHERE `ID` = '$id'");
				mysql_real_escape_string($forumname);
				mysql_real_escape_string($email);
				echo GetMessage("Success:", "Forum name and Email Address were saved.", 7);
			}
		}
		
		if(!empty($_POST['currentpass']) || !empty($_POST['avivpass']))
		{
			$cur_hashpass = xss_clean($_POST['currentpass']);
			$cur_hashpass = hash('whirlpool', $_POST['currentpass']);
			$cur_hashpass = strtoupper($cur_hashpass);
			$new_hashpass = xss_clean($_POST['avivpass']);
			$new_hashpass = hash('whirlpool', $_POST['avivpass']);
			$new_hashpass = strtoupper($new_hashpass);
			if($cur_hashpass != GetP($_SESSION['Logged'], "Password"))
				echo GetMessage("Error:", "Current password is incorrect.", 4);
			
			else if($new_hashpass == GetP($_SESSION['Logged'], "Password"))
				echo GetMessage("Error:", "New password is equal to currect.", 4);
				
			else
			{
				mysql_query("UPDATE `players` SET `Password` = '{$new_hashpass}' WHERE `ID` = '$id'");
				echo GetMessage("Success:", "Your password has been changed to ".$_POST['avivpass']."", 7);
			}
		}
	}
	?>
	<div style="font-weight: bold;">
	Forum name <br />
	<input type="text" name="forumname" id="inputEmail" value="<?php echo GetP($_SESSION['Logged'], "Forumname"); ?>"> <br />
	Email Address<br />
	<input type="text" name="email" id="inputPassword" value="<?php echo GetP($_SESSION['Logged'], "Email"); ?>"> <br />
	<hr />
	Change password<br />
	<input type="text" name="currentpass" id="inputPassword" placeholder="Current Password"> <br />
	<input type="text" name="avivpass" id="inputPassword" placeholder="New Password"> <br />
	<div class="form-actions" style="width: 94%;">
		<button type="submit" name="submit" class="btn btn-primary">Save</button> 
	</div>
	</div>
  </fieldset>
</form>
</div>