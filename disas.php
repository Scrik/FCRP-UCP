<?php
require("inc/preferences.php");
if(!isset($_GET['user']) || !isset($_GET['pass']))
	print("Missing parameters");
	
else
{
	$checkName = mysql_query("SELECT * FROM `players` WHERE `Name` = '".$_GET['user']."'");
	if(!mysql_num_rows($checkName))
	print
	('
	{
		"status": {"success":"False"}
	}
	');

	else
	{
		$password = hash('whirlpool', $_GET['pass']);
		$password = strtoupper($password);
		$checkPassword = mysql_query("SELECT * FROM `players` WHERE `Name` = '".$_GET['user']."' AND `Password` = '$password' LIMIT 1");
		if(!mysql_num_rows($checkPassword))
		{
			print
			('
			{
				"status": {"success":"False"}
			}
			');
		}
		
		else
		{
			while($getInfo = mysql_fetch_array($checkPassword, MYSQL_ASSOC)) 
			{
				$skin1 = GetCharacterID($getInfo['Character1']);
				$skin1 = GetC($skin1, "Skin");
				$skin2 = GetCharacterID($getInfo['Character2']);
				$skin2 = GetC($skin2, "Skin");
				$skin3 = GetCharacterID($getInfo['Character3']);
				$skin3 = GetC($skin3, "Skin");				
				print
				('
				{
					"status":{"success":"True"} ,
					"characters":
					{ "Character1":"'.$getInfo['Character1'].'",
					 "Character2":"'.$getInfo['Character2'].'",
					 "Character3":"'.$getInfo['Character3'].'", 
					 "Character1Skin": "'.$skin1.'",
					 "Character2Skin": "'.$skin2.'",
					 "Character3Skin": "'.$skin3.'"
					}					 
				}
				');
			}
		}
	}
}
?>