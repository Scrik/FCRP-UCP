<?php
if(!isset($_SESSION['Logged'])) 
{
	header("Location: ?page=homepage");
	exit();
}
else
{
	if(isset($_GET['option']))
	{
		switch($_GET['option'])
		{
			case 'logout':
			{
				unset($_SESSION['CLogged']);
				header("Location: ?page=ucp");
				break;
			}
			case 'changeskin':
			{
				include("inc/pages/changeskin.php");
				break;
			}
			case 'changespawn':
			{
				include("inc/pages/changespawn.php");
				break;
			}
			case 'changesettings':
			{
				include("inc/pages/changesettings.php");
				break;
			}
			case 'myprofile':
			{
				include("inc/pages/myprofile.php");
				break;
			}
			case 'friends':
			{
				include("inc/pages/friends.php");
				break;
			}
			default:
			{
				header("Location: ?page=ucp");
				break;
			}
		}
	}
	else
	{
		if(isset($_SESSION['CLogged']))
		{
			?>
			<ul class="breadcrumb">
			  <i class="icon-chevron-right"></i> <li class="active"><?php echo GetC($_SESSION['CLogged'], "Name"); ?>'s profile</li>
			</ul>
			<div class="row" style="margin-left: 0%;">
				<div class="span4">
					<div class="media">
					  <a class="pull-left" href="index.php?page=ucp&option=changeskin">
						<img class="media-object" src="images/changeskin.png">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">Change Skin</h4>
						You are able to change the way your character looks	from a varied list of skins.
					  </div>
					</div>
				</div>
				<div class="span4">
					<div class="media">
					  <a class="pull-left" href="index.php?page=ucp&option=changespawn">
						<img class="media-object" src="images/changespawn.png">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">Change Spawn</h4>
						You can change your spawn location upon login from this panel.
					  </div>
					</div>
				</div>				
				<div class="span4">
					<div class="media">
					  <a class="pull-left" href="index.php?page=ucp&option=changesettings">
						<img class="media-object" src="images/changesettings.png">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">Account Settings</h4>
						You are able to change your password, forum name and email in here.
					  </div>
					</div>
				</div>
				<div class="span4" style="margin-top: 5%;">
					<div class="media">
					  <a class="pull-left" href="index.php?page=ucp&option=myprofile">
						<img class="media-object" src="images/myprofile.png">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">My Profile</h4>
						You can view your character statistics, information and admin records from this panel.
					  </div>
					</div>
				</div>
				<?php
				if(GetC($_SESSION['CLogged'], "Faction") > 0)
				{
				?>
				<div class="span4" style="margin-top: 5%;">
					<div class="media">
					  <a class="pull-left" href="index.php?page=ucp&option=managefaction">
						<img class="media-object" src="images/factioncentre.png">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">Faction Centre <span class="label label-important">Disabled</span></h4> 
						You can view your faction members and other options depending on your position.
					  </div>
					</div>
				</div>
				<div class="span4" style="margin-top: 5%;">
					<div class="media">
					  <a class="pull-left" href="index.php?page=ucp&option=factioncentre">
						<img class="media-object" src="images/factioncentre.png">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">Chatlog <span class="label label-important">Disabled</span></h4> 
						You can view your recent server log from this panel, based on your character actions.
					  </div>
					</div>
				</div>
				<div class="span4" style="margin-top: 5%;">
					<div class="media">
					  <a class="pull-left" href="index.php?page=ucp&option=friends">
						<img class="media-object" src="images/myprofile.png">
					  </a>
					  <div class="media-body">
						<h4 class="media-heading">Friends</h4> 
						You can view your UCP friends here, add friends so you can view their statistics and activity.
					  </div>
					</div>
				</div>
				<?php
				}
				?>
			</div>
			<?php
		}
		else
		{
			if((GetP($id, "Character1") == "None") && (GetP($id, "Character2") == "None") && (getP($id, "Character3") == "None"))
			{
				?>
				<ul class="breadcrumb">
				  <i class="icon-chevron-right"></i> <li class="active">You do not possess any characters!</li>
				</ul>
				You do not possess any characters, therefore you have no selectable characters.
				<?php
			}
			else
			{
				?>
				<ul class="breadcrumb">
				  <i class="icon-chevron-right"></i> <li class="active">Selecting Character</li>
				</ul>
				<form method="POST">
					<div style="padding-left: 5px;">
					<?php
					for ($i=1; $i <= 3; $i++)
					{
						if(GetP($id, "Character".$i."") != "None")
						{
							?>
							<label class="radio">
							  <input type="radio" name="selectChar" value="<?php echo $i; ?>">
							  <?php echo GetP($id, "Character".$i.""); ?>
							</label>
							<?php
						}
					}
					?>
					</div>
					<div class="form-actions">
						<button name="select" type="submit" class="btn btn-small">Select Character</button>
					</div>
				</form>
				<?php
				if(isset($_POST['select']) && isset($_POST['selectChar']))
				{
					$_SESSION['CLogged'] = GetCharacterID(GetP($id, "Character".$_POST['selectChar'].""));
					echo GetMessage("<img src='images/ajax-loader.gif'/> Success:", "You have selected ".GetP($id, "Character".$_POST['selectChar']."").".", 7);
					echo "<meta http-equiv='refresh' content='2.0;url=?page=ucp'>";
				}
			}
		}
	}
}
?>
<div class="jumbotron">
<?php
switch(GetP($_SESSION['Logged'], "Status"))
{
	case 2:
	{
		if(isset($_GET['category']))
		{
			if(!isset($_SESSION['CLogged'])) header("Location: index.php?page=ucp");
			switch($_GET['category'])		
			{
				case 'mycharacters':
				{
					include("inc/pages/mycharacters.php");
					break;
				}
				case 'managefaction':
				{
					include("inc/pages/managefaction.php");			
					break;
				}
				case 'friends':
				{
					include("inc/pages/friends.php");
					break;
				}
				case 'factionmembers':
				{
					if(!isset($_GET['id'])) header("Location: ?page=ucp"); 
					$fID = $_GET['id'];
					$checkMe = mysql_query("SELECT * FROM `characters` WHERE `Creator` = '".GetP($_SESSION['Logged'], "Name")."' AND `Faction` = '$fID'");
					if(!mysql_num_rows($checkMe)) header("Location: ?page=ucp"); 
					
					$checkFaction = mysql_query("SELECT * FROM `factions` WHERE `ID` = '$fID'");
					if(!mysql_num_rows($checkFaction)) header("Location: ?page=ucp"); 
					?>
					<h3 style="color: #666666; font-weight: bold; font-family: cMyriadPro; src: url(fonts/myriadpro.otf); line-height: 100%;"><?php echo ''.GetFactionName($fID).' ('.$fID.')'; ?></h3>
					<table class="table table-hover" style="margin-top: 1%;">
					  <tbody>
						<tr style="color: #666666; font-weight: bold;">
						  <td>Username</td>
						  <td>Rank</td>
						  <td>Status</td>
						</tr>
						<?php
						$checkUsers = mysql_query("SELECT * FROM `characters` WHERE `Faction` = '$fID'");					
						while($row = mysql_fetch_array($checkUsers, MYSQL_ASSOC)) 
						{
							$id = $row['ID'];
							$name = $row['Name'];
							$frank = $row['Rank'];
							$rank = GetFactionRank($fID, $frank);
							$online = $row['Online'] ? ("<span style='color: green; font-weight: bold;'>Online</span>") : ("<span style='color: red; font-weight: bold;'>Offline</span>");
							echo "
							  <tr>
								<td>$name</td>
								<td>$rank</td>
								<td>$online</td>
							  </tr>	";
						}
						?>
					  </tbody>
					</table>
					<?php
					break;
				}
				default: header("Location: ?page=ucp");
			}
		}
		else
		{
			
		}
		break;
	}
	case 3:
	{
		?>
			<div class="jumbotron">
			<div style="font-size: 14px; padding-top: 2%; padding-left: 1%;">
			<form method="POST">
                <fieldset>
				<?php
				if(isset($_POST['submit']))
				{
					if(!isset($_POST['rules'])) 
					{
						echo GetMessage("Error:", "You did not read and understood the server rules.", 4);
					}
						
					else if(!isset($_POST['question_1']) || !isset($_POST['question_2']) || !isset($_POST['question_3'])) 
					{
						echo GetMessage("Error:", "You did not complete all the required fields or some of them are invalid.", 4);
					}
						
					else 
					{
						echo GetMessage("Success:", "Your master account application has been re-submitted and will be reviewed again by our testers shortly.", 7);
						$question1 = mysql_real_escape_string($_POST['question_1']);
						$question2 = mysql_real_escape_string($_POST['question_2']);
						$question3 = mysql_real_escape_string($_POST['question_3']);								
						mysql_query("UPDATE `players` SET `Question1` = '$question1', `Question2` = '$question2', `Question3` = '$question3', `Status` = '1' WHERE `ID` = '".$_SESSION['Logged']."'");			
					}	
				}
				echo GetMessage("Pending Application:", "<br />Your master account has been flagged as pending by a Supporter (".GetP($_SESSION['Logged'], "CheckedBy").") <br />Reason: ".GetP($_SESSION['Logged'], "Note")."", 4);
				?>
					  <span class="help-block" style="font-weight: bold; ">Why would you like to join Influential Roleplay? Where did you first hear about the community? Explain in depth.</span>	
                      <textarea style="width: 90%;" class="form-control" name="question_1" rows="5" id="textArea" placeholder="Your answer.."><?php echo GetP($_SESSION['Logged'], "Question2"); ?></textarea>
					  
					  <span class="help-block" style="font-weight: bold; ">What are our server policies/etiquette when it comes to robbing and scamming?</span>	
                      <textarea style="width: 90%;" class="form-control" name="question_2" rows="5" id="textArea" placeholder="Your answer.."><?php echo GetP($_SESSION['Logged'], "Question2"); ?></textarea>

					  <span class="help-block" style="font-weight: bold;">How would you define roleplay and can you explain some of the elements in roleplaying, like powergaming and metagaming?:</span>	
                      <textarea style="width: 90%;" class="form-control" name="question_3" rows="5" id="textArea" placeholder="Your answer.."><?php echo GetP($_SESSION['Logged'], "Question2"); ?></textarea>


					  <span class="help-block" style="font-weight: bold;">
                      <input type="checkbox" name="rules"> I have read and understood the server <a href="">rules</a>!</span>
                    </div>
					<div class="form-actions" style="width: 94%;">
					  <button type="reset" class="btn btn-default">Clear</button> 
					  <button type="submit" name="submit" class="btn btn-primary">Re-submit</button> 
					</div>
                </fieldset>
              </form>
            </div>
		<?php
		break;
	}
}
?>
</div>