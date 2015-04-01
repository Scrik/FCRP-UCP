<!-- 
╔═══════════════════════════════════════════════════════════════════════════╗
║ Release: Fort Carson Roleplay UCP                                         ║
║ Version: 1.0                                                              ║
║ File: index.php                                                           ║
║ ------------------------------------------------------------------------- ║
║ Author(s): Sirajuddin Asjad                                               ║
║ Contact: sirabots@gmail.com                                               ║
║ GitHub: https://github.com/sirajuddin97                                   ║
║ ------------------------------------------------------------------------- ║
║ License: Distributed under the Lesser General Public License (LGPL).      ║
║ This program is distributed in the hope that it will be useful - WITHOUT  ║
║ ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     ║
║ FITNESS FOR A PARTICULAR PURPOSE.                                         ║
╚═══════════════════════════════════════════════════════════════════════════╝
-->

<?php
require("inc/preferences.php");
ob_start();
session_start();

if(!isset($_GET['page'])) 
{
	header("Location: ?page=homepage");
	exit();
}

if(isset($_SESSION['Logged']))
{
	$id = $_SESSION['Logged'];
	$check = mysql_query("SELECT * FROM `players` WHERE `ID` = '$id'");
	if(!mysql_num_rows($check))
	{
		unset($_SESSION['Logged']);
		header("Location: ?page=homepage");
	}
}

$aviv = 0;
?>

<!DOCTYPE html>
<html>
  <head>
    <title>UCP - Fort Carson Roleplay
	
	</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
  </head>
  <script>
  $('#swaptooltip').tooltip('toggle')
  </script>
  <style type="text/css">
	.dotted
	{
		background: url('images/tile2.png');
		padding-top: 10px;
	}
	@font-face
	{
		font-family: cBebas;
		src: url(fonts/bebas.ttf);	
	}@font-face
	{
		font-family: cHurtm;
		src: url(fonts/hurtm.ttf);	
	}@font-face
	{
		font-family: cMyriadPro;
		src: url(fonts/myriadpro.otf);	
	}
	.container
	{
		background: white;
		width: 1000px;
		padding-left: 20px;
		padding-bottom: 20px;
		border-bottom-right-radius: 5px;
		border-bottom-left-radius: 5px;
		-moz-border-bottom-left-radius: 5px;
		-moz-border-bottom-right-radius: 5px;
	}
	body
	{
		margin: 4% auto; 
		background: #3c3c3c url('images/bg2.png'); 
		font-family: cMyriadPro; src: url(fonts/myriadpro.otf);
		background-repeat:no-repeat;
	}
	.media-object
	{
		opacity:0.6;
		filter:alpha(opacity=60);		
	}
	.media-object:hover
	{
		opacity:1.0;
		filter:alpha(opacity=100);			
	}
	.shadow
	{
		display:block;
		position:relative;
		width: 204px;
		margin: 0 auto;
	}


	.shadow:before
	{
		display:block;
		content:'';
		position:absolute;
		width:100%;
		height:100%;
	}
  </style>
  <body>
	<a href="index.php?page=homepage" border="0"><div align="left" style="background: url('images/logo.png'); width: 584px; height: 66px; margin: 10px auto;"></div></a>
    <div class="container">  
	  <div class="bs-docs-section clearfix">
        <div class="row">
          <div class="col-lg-12">
			<div id="avivon" class="navbar navbar-inverse">
			  <div class="navbar-inner" align="left">
				<ul class="nav">
				  <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-home icon-white"></i> Home <b class="caret"></b></a>
					<ul class="dropdown-menu" style="padding-left: 0px;">
					  <li><a href="?page=homepage" style="padding-left: 13px;"><i class="icon-list-alt"></i> Information</a></li>
					  <li><a href="?page=onlineplayers" style="padding-left: 13px;"><i class="icon-list"></i> Who's online?</a></li>
					  <li><a href="?page=diagnoses" style="padding-left: 13px;"><i class="icon-bookmark"></i> Diagnoses</a></li>
					  <li><a href="?page=credits" style="padding-left: 13px;"><i class="icon-star-empty"></i> Credits</a></li>
					</ul>
				  </li>
				  <li><a href="www.forum.pr-rp.com/forum.php"><i class="icon-align-justify icon-white"></i> Forums</a></li>
				  <li><a href="?page=donation"><i class="icon-flag icon-white"></i> Donation</a></li>
				</ul>
				
				<?php if(isset($_SESSION['Logged'])) { ?>
				<div class="pull-right">
					<div class="btn-group">
						<a class="btn btn-warning" href="?page=ucp"><i class="icon-user icon-white"></i>
						<?php 
							if(!isset($_SESSION['CLogged']))
								echo GetP($_SESSION['Logged'], "Name");
								
							else
								echo GetC($_SESSION['CLogged'], "Name");
						?>
						</a>
						<?php 
							if(isset($_SESSION['CLogged']))
							{
								?>
								<a id="swaptooltip" class="btn btn-warning" href="index.php?page=ucp&option=logout" data-placement="top" data-toggle="tooltip" title="Swap Characters"><i class="icon-th-list icon-white"></i></a>
								<?php
							}
							else
							{
								?>
								<a id="swaptooltip" class="btn btn-warning" href="index.php?page=logout" data-placement="top" data-toggle="tooltip" title="Logout"><i class="icon-remove icon-white"></i></a>
								<?php
							}
						?>
					</div>
				</div>
				<?php } ?>
			  </div>
			</div>
			<div style="padding: 5px; padding-top: 0;">
			<?php
			if($aviv != 0 && !isset($_SESSION['Logged']) || $aviv !=0 && GetP($_SESSION['Logged'], "AdminLevel") <= 0)
			{
				if(isset($_SESSION['Logged'])) unset($_SESSION['Logged']);
				echo GetMessage("ERROR:", "The UCP is currently unreachable, please try again later.", 4);
				if(isset($_POST['submit']))
				{
					$name = xss_clean($_POST['username']);
					$password = xss_clean($_POST['password']);
					$password = hash('whirlpool', $password);
					$password = strtoupper($password);
					$loginCheck_Username = mysql_query("SELECT * FROM `players` WHERE `Name` = '$name'");
					$loginCheck_Password = mysql_query("SELECT * FROM `players` WHERE `Name` = '$name' AND `Password` = '$password'");
					mysql_real_escape_string($name);
					mysql_real_escape_string($password);
					
					if(mysql_num_rows($loginCheck_Username) <= 0) 
					{
						echo GetMessage("ERROR::", "Your account couldn't be found in the database. Please register in-game!", 4);
					}
						
					else if(mysql_num_rows($loginCheck_Password) <= 0)
					{
						echo GetMessage("ERROR:", "Incorrect password, please try again.", 4);
					}
						
					else
					{
						echo GetMessage("SUCCESS:", "You have logged into your account, please wait...", 7);
						echo "<meta http-equiv='refresh' content='1.5;url=?page=ucp'>";
						while($getInfo = mysql_fetch_array($loginCheck_Password, MYSQL_ASSOC)) {
							$_SESSION['Logged'] = $getInfo['ID'];
						}
					}
				}
				?>
				<button type="button" style="line-height: 100%;" class="btn btn-link" data-toggle="collapse" data-target="#demo" border="0">
				  ADMIN LOGIN!
				</button>
				 
				<div id="demo" class="collapse" style="font-weight: bold; margin-top: 1%;">
				<form method="POST">
				  <fieldset>
					Username <br />
					<input type="text" name="username" id="inputEmail" placeholder="Username"> <br />
					Password <br />
					<input type="password" name="password" id="inputPassword" placeholder="Password"> <br />
					<div class="form-actions" style="width: 94%;">
						<button type="reset" class="btn btn-default">Clear</button> 
						<button type="submit" name="submit" class="btn btn-primary">Login</button> 
					</div>
				  </fieldset>
				</form>
				</div>
				<?php
			}
			else if(isset($_SESSION['Logged']) && GetP($_SESSION['Logged'], "Banned") == 1)
			{
				$myip = $_SERVER['REMOTE_ADDR'];
				$check = mysql_query("SELECT * FROM `banned` WHERE `IP` = '$myip'");
				if(!mysql_num_rows($check)) mysql_query("INSERT INTO `banned`(`IP`) VALUES ('$myip')");
				echo GetMessage("You are banned from the UCP!", "<br />You have logged into a banned account. Your IP address has been blocked for further use.", 4);
				unset($_SESSION['Logged']);
			}
			else if(IsBannedIP($_SERVER['REMOTE_ADDR']) && !isset($_SESSION['Logged']))
			{
				echo GetMessage("You are banned from the UCP!", "<br />You have logged into a banned account. YourIP address has been blocked for further use.", 4);
			}
			else
			{
				switch($_GET['page'])
				{
					case 'homepage': include("inc/pages/homepage.php"); break;
					case 'register': include("inc/pages/register.php"); break;
					case 'login': include("inc/pages/login.php"); break;
					case 'logout': include("inc/pages/logout.php"); break;
					case 'ucp': include("inc/pages/ucp.php"); break;
					case 'onlineplayers': include("inc/pages/onlineplayers.php"); break;
					case 'managefriend': include("inc/pages/managefriend.php"); break;
					case 'settings': include("inc/pages/settings.php"); break;
					case 'cp': include("inc/pages/cp.php"); break;
					case 'donate': include("inc/pages/donation.php"); break;
					case 'checkapp': include("inc/pages/checkapp.php"); break;
					case 'diagnoses': include("inc/pages/diagnoses.php"); break;
					case 'donation': include("inc/pages/donation.php"); break;
					case 'friends': include("inc/pages/friends.php"); break;
					case 'credits': include("inc/pages/credits.php"); break;
					case 'managefriend': include("inc/pages/managefriend.php"); break;
					default: echo "<ul class='breadcrumb'><i class='icon-chevron-right'></i> <li class='active'>404: Page was not found!</li></ul> <div align='center'><img src='images/404-not-found.gif' /></div>"; break;
				}
			}
			?>
		</div>
		</div>
		</div>
	</div>
	<div style="padding-right: 15px; text-shadow: 0.1em 0.1em 0.05em #eeeeee;">
		<hr class="avivon" />
	  <span style="color: #999999;">Fort Carson Roleplay &copy; Copyright 2009-2014<br>Created by Sirajuddin</span>
	  <?php if(isset($_SESSION['Logged']) && GetP($_SESSION['Logged'], "AdminLevel") >= 2) { ?> <span class="pull-right"><a href="?page=cp" style="color: #5ca400; font-weight: normal;">Administration Control Panel</a></span> <?php } ?>
	</div>
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
	<script src="js/bootstrap-tooltip.js"></script>
  </body>
</html>
<?php
    ob_flush();
?>