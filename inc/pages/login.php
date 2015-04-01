<ul class="breadcrumb">
  <i class="icon-chevron-right"></i> <li class="active">Login to your account</li>
</ul>
<?php
if(isset($_SESSION['Logged'])) 
{
	header("Location: ?page=ucp");
	exit();
}
?>
			<div style="font-size: 14px; font-weight: bold; padding-left: 1%;">
			<form method="POST">
				<?php
				if(isset($_POST['submit']))
				{
					if(!empty($_POST['username']))
					{
						$name = xss_clean($_POST['username']);
						$password = xss_clean($_POST['password']);
						$password = hash('whirlpool', $password);
						$password = strtoupper($password);
						$loginCheck_Username = mysql_query("SELECT * FROM `players` WHERE `Name` = '$name'");
						$loginCheck_Password = mysql_query("SELECT * FROM `players` WHERE `Name` = '$name' AND `Password` = '$password'");
						mysql_real_escape_string($name);
						mysql_real_escape_string($password);
						
						if(!mysql_num_rows($loginCheck_Username)) 
						{
							echo GetMessage("Oops!", "Your account wasn't found in the database. Connect in-game and register your account!", 4);
						}
							
						else if(!mysql_num_rows($loginCheck_Password))
						{
							echo GetMessage("Oops!", "Looks like you have entered an incorrect password!", 4);
						}
							
						else
						{
							echo GetMessage("<img src='images/ajax-loader.gif'/> SUCCESS:", "You have logged into your account!", 7);
							echo "<meta http-equiv='refresh' content='1.0;url=?page=ucp'>";
							while($getInfo = mysql_fetch_array($loginCheck_Password, MYSQL_ASSOC)) 
							{
								$_SESSION['Logged'] = $getInfo['ID'];
							}
						}
					}
				}
				?>
				Forum name <br />
				<input type="text" name="username" id="inputEmail" placeholder="Username"> <br />
				Password <br />
				<input type="password" name="password" id="inputPassword" placeholder="Password"> <br />
				<div class="form-actions" style="width: 94%;">
					<button type="reset" class="btn btn-default">Clear</button> 
					<button type="submit" name="submit" class="btn btn-success">Login</button> 
				</div>
			</form>
			</div>