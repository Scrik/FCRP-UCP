<ul class="breadcrumb">
	<i class="icon-chevron-right"></i> 
	<li><a href="index.php?page=ucp"><?php echo GetC($_SESSION['CLogged'], "Name"); ?>'s profile</a></li>
	<li class="active">/ Change Skin</li><br>
	<li><font color="red">Please make sure you disconnect in-game while changing your skin.</font></li>
</ul>
<?php
$aviv = mysql_query("SELECT * FROM `characters` WHERE `Online` = 1 AND `ID` = ".GetC($_SESSION['CLogged'], "ID")."");
if(mysql_num_rows($aviv))
{
	echo GetMessage("ERROR:", "You can not change your skin while connected to the server. Please disconnect and try again.", 4);
}
else
{
	$forbiddenskins = array(264, 265, 266, 267, 274, 275, 276, 277, 278, 279, 280, 281, 282, 283, 284, 285, 286, 287, 288, 0, 92, 99, 74);
	if(!isset($_GET['pickedskin']))
	{
		if(!isset($_GET['startpoint']))
			header("Location: index.php?page=ucp&option=changeskin&startpoint=1");
				
		switch($_GET['startpoint'])
		{
			case 1:
			{
				for ($i=1; $i <= 52; $i++)
				{	
					if(in_array($i, $forbiddenskins, true)) continue;
					echo "<a href='index.php?page=ucp&option=changeskin&startpoint=1&pickedskin=".$i."' title='Skin ".$i."'><img style='margin: 10px; ' src='Skins/Skin_".$i.".png' /></a>";
				}	
				break;
			}
			case 2:
			{
				for ($i=52; $i <= 106; $i++)
				{
					if(in_array($i, $forbiddenskins, true)) continue;
					echo "<a href='index.php?page=ucp&option=changeskin&startpoint=2&pickedskin=".$i."' title='Skin ".$i."'><img style='margin: 10px; ' src='Skins/Skin_".$i.".png' /></a>";
				}	
				break;
			}
			case 3:
			{
				for ($i=106; $i <= 157; $i++)
				{
					if(in_array($i, $forbiddenskins, true)) continue;
					echo "<a href='index.php?page=ucp&option=changeskin&startpoint=3&pickedskin=".$i."' title='Skin ".$i."'><img style='margin: 10px; ' src='Skins/Skin_".$i.".png' /></a>";
				}	
				break;
			}
			case 4:
			{
				for ($i=157; $i <= 208; $i++)
				{
					if(in_array($i, $forbiddenskins, true)) continue;
					echo "<a href='index.php?page=ucp&option=changeskin&startpoint=4&pickedskin=".$i."' title='Skin ".$i."'><img style='margin: 10px; ' src='Skins/Skin_".$i.".png' /></a>";
				}	
				break;
			}
			case 5:
			{
				for ($i=208; $i <= 259; $i++)
				{
					if(in_array($i, $forbiddenskins, true)) continue;
					echo "<a href='index.php?page=ucp&option=changeskin&startpoint=5&pickedskin=".$i."' title='Skin ".$i."'><img style='margin: 10px; ' src='Skins/Skin_".$i.".png' /></a>";
				}	
				break;
			}		
			case 6:
			{
				for ($i=259; $i <= 299; $i++)
				{
					if(in_array($i, $forbiddenskins, true)) continue;
					echo "<a href='index.php?page=ucp&option=changeskin&startpoint=6&pickedskin=".$i."' title='Skin ".$i."'><img style='margin: 10px; ' src='Skins/Skin_".$i.".png' /></a>";
				}	
				break;
			}	
			default:
			{
				header("Location: index.php?page=ucp&option=changeskin&startpoint=1");
				break;
			}
		}
		?>
		<div align="center" style="margin-top: 2%;">
			<form method="POST">
				<div class="btn-group">
					<button name="prev" type="submit" class="btn btn-warning"
					<?php
					if($_GET['startpoint'] <= 1) echo "disabled";
					?>><i class="icon-chevron-left icon-white"></i> Previous Page</button>
					<button name="next" type="submit" class="btn btn-warning"
					<?php
					if($_GET['startpoint'] >= 6) echo "disabled";
					?>
					>Next Page <i class="icon-chevron-right icon-white"></i></button>
				</div>
			</form>
		</div>
		<?php
		if(isset($_POST['next']))
		{
			header("Location: index.php?page=ucp&option=changeskin&startpoint=".($_GET['startpoint']+1)."");
		}
		else if(isset($_POST['prev']))
		{
			header("Location: index.php?page=ucp&option=changeskin&startpoint=".($_GET['startpoint']-1)."");
		}
	}
	else
	{	
		$forbiddenskins = array(264, 265, 266, 267, 274, 275, 276, 277, 278, 279, 280, 281, 282, 283, 284, 285, 286, 287, 288, 0, 92, 99, 74);
		if(in_array($_GET['pickedskin'], $forbiddenskins, false) || $_GET['pickedskin'] > 299 || $_GET['pickedskin'] <= 0)
		{	
			echo GetMessage("Error:", "Selected skin is invalid.", 4);
			echo "<meta http-equiv='refresh' content='1.5;url=?page=ucp&option=changeskin'>";
		}
		else
		{
			echo "<center><img src='Skins/Skin_".$_GET['pickedskin'].".png' /></center><br />";
			echo GetMessage("Success:", "Skin ID ".$_GET['pickedskin']." has been set to your character. You may connect to the server now.", 7);
			mysql_query("UPDATE `characters` SET `Skin` = ".$_GET['pickedskin']." WHERE `ID` = ".$_SESSION['CLogged']."");
			echo "<meta http-equiv='refresh' content='2.5;url=?page=ucp'>";
		}
	}
}
?>
