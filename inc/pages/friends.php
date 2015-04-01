<ul class="breadcrumb">
	<i class="icon-chevron-right"></i> 
	<li><a href="index.php?page=ucp"><?php echo GetC($_SESSION['CLogged'], "Name"); ?>'s profile</a></li>
	<li class="active">/ Friends</li>
</ul>

<?php
if(!isset($_SESSION['Logged']))
{
	header("Location: ?page=friends");
	exit();
}	
	$checkFriend = mysql_query("SELECT * FROM `friends` WHERE `playerID` = '".$_SESSION['Logged']."'");
?>

<h3 style="color: #666666; font-weight: bold; font-family: cMyriadPro; src: url(fonts/myriadpro.otf);line-height: 0%;">Friends List (<?php echo mysql_num_rows($checkFriend); ?>)</h3>
<div class="jumbotron" align="center" style="padding-top: 1%;">
	<?php
	if(isset($_GET['action']))
	{
		switch($_GET['action'])
		{
			case 'deletefriend':
			{
				if(!isset($_GET['id'])) header("Location: ?page=ucp&category=friends");
					
				$fid = $_GET['id'];
				$id = $_SESSION['Logged'];
				$hey = mysql_query("SELECT * FROM `friends` WHERE `playerID` = '$id' AND `friendID` = '$fid'");
				if(!mysql_num_rows($hey)) header("Location: ?page=ucp&category=friends");
					
				$name = GetCharacterName($_GET['id']);
				echo GetMessage("ERROR:", "$name has been deleted from your friends list.", 4);
				mysql_query("DELETE FROM `friends` WHERE `playerID` = '".$_SESSION['Logged']."' AND `friendID` = '".$_GET['id']."'");
				echo "<meta http-equiv='refresh' content='2.0;url=?page=ucp&category=friends'>";
				break;
			}
		}
	}
	else
	{
		if(mysql_num_rows($checkFriend))
		{
			?>
			<table class="table table-hover" style="margin-top: 1%;">
			  <tbody>
				<tr style="color: #666666; font-weight: bold;">
				  <td></td>
				  <td>Username</td>
				  <td>Forum name</td>
				  <td>Last seen</td>
				</tr>
			<?php
			while($row = mysql_fetch_array($checkFriend, MYSQL_ASSOC)) 
			{
				$aviv = mysql_query("SELECT * FROM `characters` WHERE `ID` = '".$row['friendID']."'");
				while($avov = mysql_fetch_array($aviv, MYSQL_ASSOC)) 
				{
					if($avov['Online'] == 1)
					{
						echo ' 
						<tr class="success">
						  <td><a href="?page=onlineplayers&view='.$avov['ID'].'"><i class="icon-user"></i></a>
						  <a href="?page=ucp&category=friends&action=deletefriend&id='.$avov['ID'].'"><i class="icon-trash"></i></a>
						  </td>
						  <td><strong>(Online)</strong> '.$avov['Name'].'</td>
						  <td>'.GetForumName($avov['ID']).'</td>
						  <td>'.$avov['Lastseen'].'</td>
						</tr>
						';
					}
					else
					{
						echo ' 
						<tr class="error">
						  <td><a href="?page=onlineplayers&view='.$avov['ID'].'"><i class="icon-user"></i></a>
						  <a href="?page=ucp&category=friends&action=deletefriend&id='.$avov['ID'].'"><i class="icon-trash"></i></a>
						  </td>
						  <td><strong>(Offline)</strong> '.$avov['Name'].'</td>
						  <td>'.GetForumName($avov['ID']).'</td>
						  <td>'.$avov['Lastseen'].'</td>
						</tr>
						';
					}
				}
			}
		}
		else
		{
			echo GetMessage("", "You have no friends ;(", 4);
		}
	}
	?>
  </tbody>
</table>
</div>