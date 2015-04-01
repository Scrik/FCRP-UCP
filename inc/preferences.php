<?php

define("SQL_HOST", "#");
define("SQL_USER", "#");
define("SQL_PASS", "");
define("SQL_DB", "#");

mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DB); 

// ---------------------------------------------------- //
// Session parameters and variables.

if(isset($_SESSION['Logged'])) $_SESSION['MemberID'] = $_SESSION['Logged'];
// ---------------------------------------------------- //

function GetP($playerid, $state) {

	$gUser = mysql_query("SELECT * FROM `players` WHERE `ID` = '$playerid'");
	if(mysql_num_rows($gUser) <= 0) {
		return mysql_error();
	}
	else {
		while($User = mysql_fetch_array($gUser, MYSQL_ASSOC))
			return $User[$state];
	}
}

function GetV($playerid, $state) {

	$gUser = mysql_query("SELECT * FROM `vehicles` WHERE `ID` = '$playerid'");
	if(mysql_num_rows($gUser) <= 0) {
		return mysql_error();
	}
	else {
		while($User = mysql_fetch_array($gUser, MYSQL_ASSOC))
			return $User[''.$state.''];
	}
}

function GetLogs()
{
	$query = mysql_query("SELECT * FROM adminlogs ORDER BY ID ASC LIMIT 1");
	$numrows = mysql_num_rows($query);
	$logs = '';
	if($numrows <= 0)
	{
		return 'The administrator log is currently empty!';
	}
	else
	{
		$logRow = mysql_query("SELECT * FROM adminlogs");
		while($col = mysql_fetch_array($logRow, MYSQL_ASSOC))
		{
			$admin = GetC($col['By'], 'Name');
			$user = GetC($col['cID'], 'Name');
			$reason = $col['Reason'];
			$minutes = $col['Minutes'];
			$date = $col['Date'];
			switch ($col['Type'])
			{
				case 1:
					$logs .= '<strong>'.$date.'</strong> - '.$user.' was ajailed by '.$admin.', reason: '.$reason.' ('.$minutes.' minutes) <br>';
					break;
				case 2:
					$logs .= '<strong>'.$date.'</strong> - '.$user.' was kicked by '.$admin.', reason: '.$reason.' <br>';
					break;
				case 3:
					$logs .= '<strong>'.$date.'</strong> - '.$user.' was banned by '.$admin.', reason: '.$reason.' <br>';
					break;
			}
		}
	}
	return $logs;
}

function GetRestartLogs()
{
	$query = mysql_query("SELECT * FROM restartlogs ORDER BY ID ASC LIMIT 1");
	$numrows = mysql_num_rows($query);
	$logs = '';
	if($numrows <= 0)
	{
		return 'The restart log is currently empty!';
	}
	else
	{
		$logRow = mysql_query("SELECT * FROM restartlogs");
		while($col = mysql_fetch_array($logRow, MYSQL_ASSOC))
		{
			$admin = GetC($col['By'], 'Name');
			$date = $col['Date'];
			switch ($col['Type'])
			{
				case 1:
					$logs .= '<strong>'.$date.'</strong> - '.$admin.' has restarted the server. ('.$minutes.' minutes) <br>';
					break;
				case 2:
					$logs .= '<strong>'.$date.'</strong> - '.$$admin.' has restarted the server. ('.$minutes.' minutes) <br>';
					break;
				case 3:
					$logs .= '<strong>'.$date.'</strong> - '.$$admin.' has restarted the server. ('.$minutes.' minutes) <br>';
					break;
			}
		}
	}
	return $logs;
}
	

function GetC($playerid, $state) {

	$gUser = mysql_query("SELECT * FROM `characters` WHERE `ID` = '$playerid'");
	if(mysql_num_rows($gUser) <= 0) {
		return mysql_error();
	}
	else {
		while($User = mysql_fetch_array($gUser, MYSQL_ASSOC))
			return $User[''.$state.''];
	}
}

function Set($playerid, $state, $key)
{
	$gUser = mysql_query("SELECT * FROM `users` WHERE `ID` = '$playerid'");
	if(mysql_num_rows($gUser) <= 0) {
		return mysql_error();
	}
	mysql_query("UPDATE `users` SET `$state` = '$key' WHERE `ID` = '$playerid'");
}

function GetFaction($playerid)
{
	if(IsPlayerExists($playerid))
	{
		$factionID = Get($playerid, "Faction");
		if($factionID == 0) return "None";
		else {
			$gFaction = mysql_query("SELECT * FROM `factions` WHERE `ID` = '$factionID'");
			while($Faction = mysql_fetch_array($gFaction, MYSQL_ASSOC)) {
				return $Faction['Name'];
			}
		}
	}
}

function GetRank($playerid)
{
	if(IsPlayerExists($playerid))
	{
		$factionID = Get($playerid, "Faction");
		if($factionID == 0) return "None";
		else {
			$gFaction = mysql_query("SELECT * FROM `factions` WHERE `ID` = '$factionID'");
			while($Faction = mysql_fetch_array($gFaction, MYSQL_ASSOC)) {
				return $Faction['Rank'.Get($playerid, "Rank").''];
			}
		}
	}
}

define("TYPE_JAIL", 1);
define("TYPE_KICK", 2);
define("TYPE_BAN", 3);

function IsPlayerExists($playerid)
{
	$gUser = mysql_query("SELECT * FROM `users` WHERE `ID` = '$playerid'");
	if(mysql_num_rows($gUser) <= 0)
		return false;
		
	else 
		return true;
}

function GetRole($playerid)
{
	if(!IsPlayerExists($playerid)) return false;
	$adminlvl = Get($playerid, "Admin");
	$array = array(
		0 => "Player",
		1 => "Moderator",
		2 => "Administrator",
		3 => "Administrator Level 2",
		4 => "Administrator Level 3",
		5 => "Lead Administrator",
		6 => "Management",
	);
	return isset($array[$adminlvl]) ? $array[$adminlvl] : "Player";
}

function GetWeaponName($playerid, $weapon)
{
	$array = array(
		0 => "None",
		1 => "Knuckles",
		2 => "Golf Club",
		3 => "Baton",
		4 => "Knife",
		5 => "Baseball Bat",
		6 => "Shovel",
		7 => "Pool Cue",
		8 => "Katana",
		9 => "Chainsaw",
		10 => "Double-ended Dildo",
		11 => "Dildo",
		12 => "Vibrator",
		13 => "Silver Vibrator",
		14 => "Flowers",
		15 => "Cane",
		16 => "Grenade",
		17 => "Tear Gas",
		18 => "Molotov",
		22 => "Beretta 9mm",
		23 => "Heckler & Koch USP",
		24 => "Walther PPK",
		25 => "Mossberg 500",
		26 => "Mossberg 590",
		27 => "Mossberg 930 Autoloader",
		28 => "MAC-10",
		29 => "Heckler & Koch MP5/10",
		30 => "Kalashnikov",
		31 => "M4 Carbine",
		32 => "AB-10",
		33 => "Lee-Enfield",
		34 => "THOR M408 Long Range",
		35 => "RPG",
		36 => "RPG-7",
		37 => "LPO-50",
		38 => "Minigun",
		39 => "Satchel Charge",
		40 => "Detonator",
		41 => "Spraycan",
		42 => "Fire Extinguisher",
		43 => "Nikon D3200",
	);
	return $array[''.Get($playerid, 'Weapon'.$weapon.'').''];
}

function xss_clean($data)
{
// Fix &entity\n;
$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

// Remove any attribute starting with "on" or xmlns
$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

// Remove javascript: and vbscript: protocols
$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

// Remove namespaced elements (we do not need them)
$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

do
{
	// Remove really unwanted tags
	$old_data = $data;
	$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
}
while ($old_data !== $data);

// we are done...
return $data;
}

function GetMessage($subject, $message, $type)
{
	// Type 1 - Regular Message
	// Type 2 - Error Message
	// Type 3 - Success
	switch($type)
	{
		case 1:
		{
			return "<div class='alert alert-warning' style='font-size: 14px; width: 90%;'>
			  <strong>$subject</strong> $message
			</div>";
		}
		case 2:
		{
			return "<div class='alert alert-danger alert-dismissable' style='font-size: 14px; width: 90%;'>
			  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			  <strong>$subject</strong> $message
			</div>";
		}
		case 3:
		{
			return "<div class='alert alert-success alert-dismissable' style='font-size: 14px; width: 90%;'>
			  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			  <strong>$subject</strong> $message
			</div>";
		}
		case 4:
		{
			return "<div class='alert alert-danger alert-dismissable' style='font-size: 14px; width: 90%;'>
			  <strong>$subject</strong> $message
			</div>";
		}
		case 5:
		{
			return "<div class='alert alert-warning alert-dismissable' style='font-size: 14px; width: 90%;'>
			  <strong>$subject</strong> $message
			</div>";
		}
		case 6:
		{
			return "<div class='panel panel-default' style='font-size: 14px;  width: 90%;'>
			<div class='panel-body'>
			  <strong><span style='color: #428bca;'>$subject</span></strong> $message
			</div>
			</div>";
		}
		case 7:
		{
			return "<div class='alert alert-success alert-dismissable' style='font-size: 14px; width: 90%;'>
			  <strong>$subject</strong> $message
			</div>";
		}
		case 8:
		{
			return "<div class='alert alert-info alert-dismissable' style='font-size: 14px; width: 90%;'>
			  <strong>$subject</strong> $message
			</div>";
		}
	}
}

// Limiting text for news pages
function limitString($string, $limit = 100) {
    // Return early if the string is already shorter than the limit
    if(strlen($string) < $limit) {return $string;}

    $regex = "/(.{1,$limit})\b/";
    preg_match($regex, $string, $matches);
    return ''.$matches[1].'...';
}

function GetSubAddress()
{	
	if(isset($_GET['page'])) {
		switch($_GET['page'])
		{
			case 'home': return 'Main';
			case 'adminpanel': return 'Administration Control Panel';
			case 'ucp': return 'User Control Panel';
			case 'changepassword': return 'Change Password';
			case 'changeskin': return 'Change Skin';
			case 'login': return 'Login';
			case 'inspect': return 'Inspect Application';
			case 'article': return 'Viewing an Article';
			case 'search': return 'Searching';
			case 'createcharacter': return 'Creating a Character';
			case 'register': return 'Registering';
			default: return 'Error 404';
		}
	}
}

function GetIP() 
{
	return $_SERVER['REMOTE_ADDR'];
}

function IsValidRPName($string)
{
	if( stristr( $string , '_' ) )
		$_explodedName = explode( "_" , $string ); 

	else return false; 
		
	for ($i = 0; $i < $firstName; $i++) 
	{ 
		if( !ctype_upper ( $_explodedName[ 0 ][ 0 ] ) )  
			return false;
			
		else if( !$i ) 
			continue; 
			
		else if( ctype_upper( $_explodedName[ 0 ][ $i ] ) ) 
			return false;
	}
	for ($i = 0; $i < $lastName; $i++) 
	{ 
		if(!ctype_upper($_explodedName[ 1 ][ 0 ] ) ) 
			return false;
		
		else if( !$i ) 
			continue;
			
		else if( ctype_upper( $_explodedName[ 1 ][ $i ] ) ) 
			return false;
	}
	if( count( $_explodedName ) < 2 || strlen( $Name[ 0 ] ) < 1 || strlen($_explodedName[ 1 ]) < 1 || strlen( $string ) >= 25 ) 
		return false;
	
	else 
		return true;
}

function IsAvailableName($input)
{
	$check = mysql_query("SELECT * FROM `players` WHERE `Name` = '$input'");
	if(mysql_num_rows($check) >= 1)
		return false;
		
	else 
		return true;
}

function IsAvailableEmail($input)
{
	$check = mysql_query("SELECT * FROM `players` WHERE `Email` = '$input'");
	if(mysql_num_rows($check) >= 1)
		return false;
		
	else 
		return true;
}

function get_key($key, $arr){
    return isset($arr[$key])?$arr[$key]:'Unset';
}


function generatePassword($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

function isValidEmail($email)
{
    $lengthPattern = "/^[^@]{1,64}@[^@]{1,255}$/";
    $syntaxPattern = "/^((([\w\+\-]+)(\.[\w\+\-]+)*)|(\"[^(\\|\")]{0,62}\"))@(([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9]{2,})|\[?([1]?\d{1,2}|2[0-4]{1}\d{1}|25[0-5]{1})(\.([1]?\d{1,2}|2[0-4]{1}\d{1}|25[0-5]{1})){3}\]?)$/";
    return ((preg_match($lengthPattern, $email) > 0) && (preg_match($syntaxPattern, $email) > 0)) ? true : false;
}

function isValidName($input)
{
	if(preg_match("/^[A-Za-z0-9-_\",'\s]+$/", $input))
		return true;
	
	else
		return false;
}

function GetPlayerID($name)
{
	$gCharacter = mysql_query("SELECT * FROM `players` WHERE `Name` = '$name'");
	while($getInfo = mysql_fetch_array($gCharacter, MYSQL_ASSOC)) {
		return $getInfo['ID'];
	}
}

function GetCharacterID($name)
{
	$gCharacter = mysql_query("SELECT * FROM `characters` WHERE `Name` = '$name'");
	while($getInfo = mysql_fetch_array($gCharacter, MYSQL_ASSOC)) {
		return $getInfo['ID'];
	}
}

function GetCharacterName($id)
{
	$gCharacter = mysql_query("SELECT * FROM `characters` WHERE `ID` = '$id'");
	while($getInfo = mysql_fetch_array($gCharacter, MYSQL_ASSOC)) {
		return $getInfo['Name'];
	}
}

function GetFactionName($id)
{
	$gFaction = mysql_query("SELECT * FROM `factions` WHERE `ID` = '$id'");
	if(mysql_num_rows($gFaction) <= 0) 
		return "None";
		
	while($getInfo = mysql_fetch_array($gFaction, MYSQL_ASSOC)) {
		return $getInfo['Name'];
	}
}

function GetFactionRank($id, $rankid)
{
	$gFaction = mysql_query("SELECT * FROM `factions` WHERE `ID` = '$id'");
	if(mysql_num_rows($gFaction) <= 0) 
		return "None";
		
	if($rankid == 0)
		return "Unset"; 
		
	while($getInfo = mysql_fetch_array($gFaction, MYSQL_ASSOC)) {
		return $getInfo['Rank'.$rankid.''];
	}
}

function GetFactionInfo($id, $input)
{
	$gFaction = mysql_query("SELECT * FROM `factions` WHERE `ID` = '$id'");
	if(mysql_num_rows($gFaction) <= 0) 
		return false;
		
	while($getInfo = mysql_fetch_array($gFaction, MYSQL_ASSOC)) {
		return $getInfo[$input];
	}
}

function GetJob($id)
{
	switch($id)
	{
		default: return "None";
	}
}

function GetForumName($character_id)
{
	$name = GetCharacterName($character_id);
	$gUser = mysql_query("SELECT * FROM `players` WHERE `Character1` = '$name' OR `Character2` = '$name' OR `Character3` = '$name'");
	while($getInfo = mysql_fetch_array($gUser, MYSQL_ASSOC)) {
		return $getInfo['Forumname'];
	}
}

function Auth($data_User, $data_Pass)
{
	if(!isset($_GET['username']) || !isset($_GET['password']))
		return false;
	
	$data_User = $_GET['username'];
	$data_Pass = $_GET['password'];
	$auth_Check = mysql_query("SELECT * FROM `players` WHERE `Name` = '$data_User'");
	if(!mysql_num_rows($auth_Check)) // If player does not exist
		return false;
		
	$auth_Check = mysql_query("SELECT * FROM `players` WHERE `Name` = '$data_User' AND `Password` = '$data_Pass'"); // If password is correct
	if(!mysql_num_rows($auth_Check))
		return false;
		
	else
	{
		while($getCharacter = mysql_fetch_array($auth_Check, MYSQL_ASSOC)) 
		{
			echo $getCharacter['Character1'];
			echo $getCharacter['Character2'];
			echo $getCharacter['Character3'];
		}
	}
}

function IsPlayerOnline($name)
{
	$id = GetPlayerID($name);
	$c1 = GetP($id, "Character1");
	$c1 = GetCharacterID($c1);
	$c2 = GetP($id, "Character2");
	$c2 = GetCharacterID($c2);
	$c3 = GetP($id, "Character3");
	$c3 = GetCharacterID($c3);
	if((GetC($c1, "Online") == 1) || (GetC($c2, "Online") == 1) || (GetC($c3, "Online") == 1))
		return true;
		
	else return false;
}

function IsBannedIP($ip)
{
	$check = mysql_query("SELECT * FROM `banned` WHERE `IP` = '$ip'");
	if(mysql_num_rows($check))
		return true;
	
	else 
		return false;
}

function SendMsg($title, $msg, $type)
{
	switch($type)
	{
		case 1:
		{
			return '<i class="icon-remove"></i> <span style="color: #d20000;">'.$title.'</span><hr /><ul>'.$msg.'</ul>';
		}
		case 2:
		{
			return '<i class="icon-ok"></i> <span style="color: #169b00;">'.$title.'</span><hr /><ul>'.$msg.'</ul>';
		}
	}
}

function vehiclename($vehiclemodel) {
	$vehiclelist = array(
		"Landstalker",
		"Bravura",
		"Buffalo",
		"Linerunner",
		"Perenniel",
		"Sentinel",
		"Dumper",
		"Firetruck",
		"Trashmaster",
		"Unique Vehicles",
		"Manana",
		"Infernus",
		"Lowriders",
		"Pony",
		"Mule",
		"Cheetah",
		"Ambulance",
		"Leviathan",
		"Moonbeam",
		"Esperanto",
		"Taxi",
		"Washington",
		"Bobcat",
		"Mr Whoopee",
		"BF Injection",
		"Hunter",
		"Premier",
		"Enforcer",
		"Securicar",
		"Banshee",
		"Predator",
		"Bus",
		"Rhino",
		"Barracks",
		"Hotknife",
		"Article Trailer",
		"Previon",
		"Coach",
		"Cabbie",
		"Stallion",
		"Rumpo",
		"RC Bandit",
		"Romero",
		"Packer",
		"Monster",
		"Admiral",
		"Squallo",
		"Seasparrow",
		"Pizzaboy",
		"Tram",
		"Article Trailer 2",
		"Turismo",
		"Speeder",
		"Reefer",
		"Tropic",
		"Flatbed",
		"Yankee",
		"Caddy",
		"Solair",
		"RC Van",
		"Skimmer",
		"PCJ-600",
		"Faggio",
		"Freeway",
		"RC Baron",
		"RC Raider",
		"Glendale",
		"Oceanic",
		"Sanchez",
		"Sparrow",
		"Patriot",
		"Quad",
		"Coastguard",
		"Dinghy",
		"Hermes",
		"Sabre",
		"Rustler",
		"ZR-350",
		"Walton",
		"Regina",
		"Comet",
		"BMX",
		"Burrito",
		"Camper",
		"Marquis",
		"Baggage",
		"Dozer",
		"Maverick",
		"SAN News Maverick",
		"Rancher",
		"FBI Rancher",
		"Virgo",
		"Greenwood",
		"Jetmax",
		"Hotring Racer",
		"Sandking",
		"Blista Compact",
		"Police Maverick",
		"Boxville",
		"Benson",
		"Mesa",
		"RC Goblin",
		"Hotring Racer",
		"Hotring Racer",
		"Bloodring Banger",
		"Rancher",
		"Super GT",
		"Elegant",
		"Journey",
		"Bike",
		"Mountain Bike",
		"Beagle",
		"Cropduster",
		"Stuntplane",
		"Tanker",
		"Roadtrain",
		"Nebula",
		"Majestic",
		"Buccaneer",
		"Shamal",
		"Hydra",
		"FCR-900",
		"NRG-500",
		"HPV1000",
		"Cement Truck",
		"Towtruck",
		"Fortune",
		"Cadrona",
		"FBI Truck",
		"Willard",
		"Forklift",
		"Tractor",
		"Combine Harvester",
		"Feltzer",
		"Remington",
		"Slamvan",
		"Blade",
		"Train Freight",
		"Train Brownstreak",
		"Vortex",
		"Vincent",
		"Bullet",
		"Clover",
		"Sadler",
		"Firetruck LA",
		"Hustler",
		"Intruder",
		"Primo",
		"Cargobob",
		"Tampa",
		"Sunrise",
		"Merit",
		"Utility Van",
		"Nevada",
		"Yosemite",
		"Windsor",
		"Monster A",
		"Monster B",
		"Uranus",
		"Jester",
		"Sultan",
		"tratum",
		"Elegy",
		"Raindance",
		"RC Tiger",
		"Flash",
		"Tahoma",
		"Savanna",
		"Bandito",
		"Train Freight Flat Trailer",
		"Train Streak Trailer",
		"Kart",
		"Mower",
		"Dune",
		"Sweeper",
		"Broadway",
		"Tornado",
		"AT400",
		"DFT-30",
		"Huntley",
		"Stafford",
		"BF-400",
		"Newsvan",
		"Tug",
		"Petrol Trailer",
		"Emperor",
		"Wayfarer",
		"Euros",
		"Hotdog",
		"Club",
		"Train Freight Box Trailer",
		"Article Trailer 3",
		"Andromada",
		"Dodo",
		"RC Cam",
		"Launch",
		"LSPD Police Car",
		"SFPD Police Car",
		"LVPD Police Car",
		"Police Ranger",
		"Picador",
		"S.W.A.T.",
		"Alpha",
		"Phoenix",
		"Glendale Shit",
		"Sadler Shit",
		"Baggage Trailer A",
		"Baggage Trailer B",
		"Tug Stairs Trailer",
		"Boxville",
		"Farm Trailer",
		"Utility Trailer"
	);
	//print_r($vehiclelist);
	$m = intval($vehiclemodel) - 400;
	$n = $vehiclelist[$m];
	return $n;
}

function locationfromzone($lx,$ly) {
	$gSAZones = array(
		array("The Big Ear",	             array(-410.00,1403.30,-3.00,-137.90,1681.20,200.00)),
		array("Aldea Malvada",               array(-1372.10,2498.50,0.00,-1277.50,2615.30,200.00)),
		array("Angel Pine",                  array(-2324.90,-2584.20,-6.10,-1964.20,-2212.10,200.00)),
		array("Arco del Oeste",              array(-901.10,2221.80,0.00,-592.00,2571.90,200.00)),
		array("Avispa Country Club",         array(-2646.40,-355.40,0.00,-2270.00,-222.50,200.00)),
		array("Avispa Country Club",         array(-2831.80,-430.20,-6.10,-2646.40,-222.50,200.00)),
		array("Avispa Country Club",         array(-2361.50,-417.10,0.00,-2270.00,-355.40,200.00)),
		array("Avispa Country Club",         array(-2667.80,-302.10,-28.80,-2646.40,-262.30,71.10)),
		array("Avispa Country Club",         array(-2470.00,-355.40,0.00,-2270.00,-318.40,46.10)),
		array("Avispa Country Club",         array(-2550.00,-355.40,0.00,-2470.00,-318.40,39.70)),
		array("Back o Beyond",               array(-1166.90,-2641.10,0.00,-321.70,-1856.00,200.00)),
		array("Battery Point",               array(-2741.00,1268.40,-4.50,-2533.00,1490.40,200.00)),
		array("Bayside",                     array(-2741.00,2175.10,0.00,-2353.10,2722.70,200.00)),
		array("Bayside Marina",              array(-2353.10,2275.70,0.00,-2153.10,2475.70,200.00)),
		array("Beacon Hill",                 array(-399.60,-1075.50,-1.40,-319.00,-977.50,198.50)),
		array("Blackfield",                  array(964.30,1203.20,-89.00,1197.30,1403.20,110.90)),
		array("Blackfield",                  array(964.30,1403.20,-89.00,1197.30,1726.20,110.90)),
		array("Blackfield Chapel",           array(1375.60,596.30,-89.00,1558.00,823.20,110.90)),
		array("Blackfield Chapel",           array(1325.60,596.30,-89.00,1375.60,795.00,110.90)),
		array("Blackfield Intersection",     array(1197.30,1044.60,-89.00,1277.00,1163.30,110.90)),
		array("Blackfield Intersection",     array(1166.50,795.00,-89.00,1375.60,1044.60,110.90)),
		array("Blackfield Intersection",     array(1277.00,1044.60,-89.00,1315.30,1087.60,110.90)),
		array("Blackfield Intersection",     array(1375.60,823.20,-89.00,1457.30,919.40,110.90)),
		array("Blueberry",                   array(104.50,-220.10,2.30,349.60,152.20,200.00)),
		array("Blueberry",                   array(19.60,-404.10,3.80,349.60,-220.10,200.00)),
		array("Blueberry Acres",             array(-319.60,-220.10,0.00,104.50,293.30,200.00)),
		array("Caligula's Palace",           array(2087.30,1543.20,-89.00,2437.30,1703.20,110.90)),
		array("Caligula's Palace",           array(2137.40,1703.20,-89.00,2437.30,1783.20,110.90)),
		array("Calton Heights",              array(-2274.10,744.10,-6.10,-1982.30,1358.90,200.00)),
		array("Chinatown",                   array(-2274.10,578.30,-7.60,-2078.60,744.10,200.00)),
		array("City Hall",                   array(-2867.80,277.40,-9.10,-2593.40,458.40,200.00)),
		array("Come-A-Lot",                  array(2087.30,943.20,-89.00,2623.10,1203.20,110.90)),
		array("Commerce",                    array(1323.90,-1842.20,-89.00,1701.90,-1722.20,110.90)),
		array("Commerce",                    array(1323.90,-1722.20,-89.00,1440.90,-1577.50,110.90)),
		array("Commerce",                    array(1370.80,-1577.50,-89.00,1463.90,-1384.90,110.90)),
		array("Commerce",                    array(1463.90,-1577.50,-89.00,1667.90,-1430.80,110.90)),
		array("Commerce",                    array(1583.50,-1722.20,-89.00,1758.90,-1577.50,110.90)),
		array("Commerce",                    array(1667.90,-1577.50,-89.00,1812.60,-1430.80,110.90)),
		array("Conference Center",           array(1046.10,-1804.20,-89.00,1323.90,-1722.20,110.90)),
		array("Conference Center",           array(1073.20,-1842.20,-89.00,1323.90,-1804.20,110.90)),
		array("Cranberry Station",           array(-2007.80,56.30,0.00,-1922.00,224.70,100.00)),
		array("Creek",                       array(2749.90,1937.20,-89.00,2921.60,2669.70,110.90)),
		array("Dillimore",                   array(580.70,-674.80,-9.50,861.00,-404.70,200.00)),
		array("Doherty",                     array(-2270.00,-324.10,-0.00,-1794.90,-222.50,200.00)),
		array("Doherty",                     array(-2173.00,-222.50,-0.00,-1794.90,265.20,200.00)),
		array("Downtown",                    array(-1982.30,744.10,-6.10,-1871.70,1274.20,200.00)),
		array("Downtown",                    array(-1871.70,1176.40,-4.50,-1620.30,1274.20,200.00)),
		array("Downtown",                    array(-1700.00,744.20,-6.10,-1580.00,1176.50,200.00)),
		array("Downtown",                    array(-1580.00,744.20,-6.10,-1499.80,1025.90,200.00)),
		array("Downtown",                    array(-2078.60,578.30,-7.60,-1499.80,744.20,200.00)),
		array("Downtown",                    array(-1993.20,265.20,-9.10,-1794.90,578.30,200.00)),
		array("Downtown Los Santos",         array(1463.90,-1430.80,-89.00,1724.70,-1290.80,110.90)),
		array("Downtown Los Santos",         array(1724.70,-1430.80,-89.00,1812.60,-1250.90,110.90)),
		array("Downtown Los Santos",         array(1463.90,-1290.80,-89.00,1724.70,-1150.80,110.90)),
		array("Downtown Los Santos",         array(1370.80,-1384.90,-89.00,1463.90,-1170.80,110.90)),
		array("Downtown Los Santos",         array(1724.70,-1250.90,-89.00,1812.60,-1150.80,110.90)),
		array("Downtown Los Santos",         array(1370.80,-1170.80,-89.00,1463.90,-1130.80,110.90)),
		array("Downtown Los Santos",         array(1378.30,-1130.80,-89.00,1463.90,-1026.30,110.90)),
		array("Downtown Los Santos",         array(1391.00,-1026.30,-89.00,1463.90,-926.90,110.90)),
		array("Downtown Los Santos",         array(1507.50,-1385.20,110.90,1582.50,-1325.30,335.90)),
		array("East Beach",                  array(2632.80,-1852.80,-89.00,2959.30,-1668.10,110.90)),
		array("East Beach",                  array(2632.80,-1668.10,-89.00,2747.70,-1393.40,110.90)),
		array("East Beach",                  array(2747.70,-1668.10,-89.00,2959.30,-1498.60,110.90)),
		array("East Beach",                  array(2747.70,-1498.60,-89.00,2959.30,-1120.00,110.90)),
		array("East Los Santos",             array(2421.00,-1628.50,-89.00,2632.80,-1454.30,110.90)),
		array("East Los Santos",             array(2222.50,-1628.50,-89.00,2421.00,-1494.00,110.90)),
		array("East Los Santos",             array(2266.20,-1494.00,-89.00,2381.60,-1372.00,110.90)),
		array("East Los Santos",             array(2381.60,-1494.00,-89.00,2421.00,-1454.30,110.90)),
		array("East Los Santos",             array(2281.40,-1372.00,-89.00,2381.60,-1135.00,110.90)),
		array("East Los Santos",             array(2381.60,-1454.30,-89.00,2462.10,-1135.00,110.90)),
		array("East Los Santos",             array(2462.10,-1454.30,-89.00,2581.70,-1135.00,110.90)),
		array("Easter Basin",                array(-1794.90,249.90,-9.10,-1242.90,578.30,200.00)),
		array("Easter Basin",                array(-1794.90,-50.00,-0.00,-1499.80,249.90,200.00)),
		array("Easter Bay Airport",          array(-1499.80,-50.00,-0.00,-1242.90,249.90,200.00)),
		array("Easter Bay Airport",          array(-1794.90,-730.10,-3.00,-1213.90,-50.00,200.00)),
		array("Easter Bay Airport",          array(-1213.90,-730.10,0.00,-1132.80,-50.00,200.00)),
		array("Easter Bay Airport",          array(-1242.90,-50.00,0.00,-1213.90,578.30,200.00)),
		array("Easter Bay Airport",          array(-1213.90,-50.00,-4.50,-947.90,578.30,200.00)),
		array("Easter Bay Airport",          array(-1315.40,-405.30,15.40,-1264.40,-209.50,25.40)),
		array("Easter Bay Airport",          array(-1354.30,-287.30,15.40,-1315.40,-209.50,25.40)),
		array("Easter Bay Airport",          array(-1490.30,-209.50,15.40,-1264.40,-148.30,25.40)),
		array("Easter Bay Chemicals",        array(-1132.80,-768.00,0.00,-956.40,-578.10,200.00)),
		array("Easter Bay Chemicals",        array(-1132.80,-787.30,0.00,-956.40,-768.00,200.00)),
		array("El Castillo del Diablo",      array(-464.50,2217.60,0.00,-208.50,2580.30,200.00)),
		array("El Castillo del Diablo",      array(-208.50,2123.00,-7.60,114.00,2337.10,200.00)),
		array("El Castillo del Diablo",      array(-208.50,2337.10,0.00,8.40,2487.10,200.00)),
		array("El Corona",                   array(1812.60,-2179.20,-89.00,1970.60,-1852.80,110.90)),
		array("El Corona",                   array(1692.60,-2179.20,-89.00,1812.60,-1842.20,110.90)),
		array("El Quebrados",                array(-1645.20,2498.50,0.00,-1372.10,2777.80,200.00)),
		array("Esplanade East",              array(-1620.30,1176.50,-4.50,-1580.00,1274.20,200.00)),
		array("Esplanade East",              array(-1580.00,1025.90,-6.10,-1499.80,1274.20,200.00)),
		array("Esplanade East",              array(-1499.80,578.30,-79.60,-1339.80,1274.20,20.30)),
		array("Esplanade North",             array(-2533.00,1358.90,-4.50,-1996.60,1501.20,200.00)),
		array("Esplanade North",             array(-1996.60,1358.90,-4.50,-1524.20,1592.50,200.00)),
		array("Esplanade North",             array(-1982.30,1274.20,-4.50,-1524.20,1358.90,200.00)),
		array("Fallen Tree",                 array(-792.20,-698.50,-5.30,-452.40,-380.00,200.00)),
		array("Fallow Bridge",               array(434.30,366.50,0.00,603.00,555.60,200.00)),
		array("Fern Ridge",                  array(508.10,-139.20,0.00,1306.60,119.50,200.00)),
		array("Financial",                   array(-1871.70,744.10,-6.10,-1701.30,1176.40,300.00)),
		array("Fisher's Lagoon",             array(1916.90,-233.30,-100.00,2131.70,13.80,200.00)),
		array("Flint Intersection",          array(-187.70,-1596.70,-89.00,17.00,-1276.60,110.90)),
		array("Flint Range",                 array(-594.10,-1648.50,0.00,-187.70,-1276.60,200.00)),
		array("Fort Carson",                 array(-376.20,826.30,-3.00,123.70,1220.40,200.00)),
		array("Foster Valley",               array(-2270.00,-430.20,-0.00,-2178.60,-324.10,200.00)),
		array("Foster Valley",               array(-2178.60,-599.80,-0.00,-1794.90,-324.10,200.00)),
		array("Foster Valley",               array(-2178.60,-1115.50,0.00,-1794.90,-599.80,200.00)),
		array("Foster Valley",               array(-2178.60,-1250.90,0.00,-1794.90,-1115.50,200.00)),
		array("Frederick Bridge",            array(2759.20,296.50,0.00,2774.20,594.70,200.00)),
		array("Gant Bridge",                 array(-2741.40,1659.60,-6.10,-2616.40,2175.10,200.00)),
		array("Gant Bridge",                 array(-2741.00,1490.40,-6.10,-2616.40,1659.60,200.00)),
		array("Ganton",                      array(2222.50,-1852.80,-89.00,2632.80,-1722.30,110.90)),
		array("Ganton",                      array(2222.50,-1722.30,-89.00,2632.80,-1628.50,110.90)),
		array("Garcia",                      array(-2411.20,-222.50,-0.00,-2173.00,265.20,200.00)),
		array("Garcia",                      array(-2395.10,-222.50,-5.30,-2354.00,-204.70,200.00)),
		array("Garver Bridge",               array(-1339.80,828.10,-89.00,-1213.90,1057.00,110.90)),
		array("Garver Bridge",               array(-1213.90,950.00,-89.00,-1087.90,1178.90,110.90)),
		array("Garver Bridge",               array(-1499.80,696.40,-179.60,-1339.80,925.30,20.30)),
		array("Glen Park",                   array(1812.60,-1449.60,-89.00,1996.90,-1350.70,110.90)),
		array("Glen Park",                   array(1812.60,-1100.80,-89.00,1994.30,-973.30,110.90)),
		array("Glen Park",                   array(1812.60,-1350.70,-89.00,2056.80,-1100.80,110.90)),
		array("Green Palms",                 array(176.50,1305.40,-3.00,338.60,1520.70,200.00)),
		array("Greenglass College",          array(964.30,1044.60,-89.00,1197.30,1203.20,110.90)),
		array("Greenglass College",          array(964.30,930.80,-89.00,1166.50,1044.60,110.90)),
		array("Hampton Barns",               array(603.00,264.30,0.00,761.90,366.50,200.00)),
		array("Hankypanky Point",            array(2576.90,62.10,0.00,2759.20,385.50,200.00)),
		array("Harry Gold Parkway",          array(1777.30,863.20,-89.00,1817.30,2342.80,110.90)),
		array("Hashbury",                    array(-2593.40,-222.50,-0.00,-2411.20,54.70,200.00)),
		array("Hilltop Farm",                array(967.30,-450.30,-3.00,1176.70,-217.90,200.00)),
		array("Hunter Quarry",               array(337.20,710.80,-115.20,860.50,1031.70,203.70)),
		array("Idlewood",                    array(1812.60,-1852.80,-89.00,1971.60,-1742.30,110.90)),
		array("Idlewood",                    array(1812.60,-1742.30,-89.00,1951.60,-1602.30,110.90)),
		array("Idlewood",                    array(1951.60,-1742.30,-89.00,2124.60,-1602.30,110.90)),
		array("Idlewood",                    array(1812.60,-1602.30,-89.00,2124.60,-1449.60,110.90)),
		array("Idlewood",                    array(2124.60,-1742.30,-89.00,2222.50,-1494.00,110.90)),
		array("Idlewood",                    array(1971.60,-1852.80,-89.00,2222.50,-1742.30,110.90)),
		array("Jefferson",                   array(1996.90,-1449.60,-89.00,2056.80,-1350.70,110.90)),
		array("Jefferson",                   array(2124.60,-1494.00,-89.00,2266.20,-1449.60,110.90)),
		array("Jefferson",                   array(2056.80,-1372.00,-89.00,2281.40,-1210.70,110.90)),
		array("Jefferson",                   array(2056.80,-1210.70,-89.00,2185.30,-1126.30,110.90)),
		array("Jefferson",                   array(2185.30,-1210.70,-89.00,2281.40,-1154.50,110.90)),
		array("Jefferson",                   array(2056.80,-1449.60,-89.00,2266.20,-1372.00,110.90)),
		array("Julius Thruway East",         array(2623.10,943.20,-89.00,2749.90,1055.90,110.90)),
		array("Julius Thruway East",         array(2685.10,1055.90,-89.00,2749.90,2626.50,110.90)),
		array("Julius Thruway East",         array(2536.40,2442.50,-89.00,2685.10,2542.50,110.90)),
		array("Julius Thruway East",         array(2625.10,2202.70,-89.00,2685.10,2442.50,110.90)),
		array("Julius Thruway North",        array(2498.20,2542.50,-89.00,2685.10,2626.50,110.90)),
		array("Julius Thruway North",        array(2237.40,2542.50,-89.00,2498.20,2663.10,110.90)),
		array("Julius Thruway North",        array(2121.40,2508.20,-89.00,2237.40,2663.10,110.90)),
		array("Julius Thruway North",        array(1938.80,2508.20,-89.00,2121.40,2624.20,110.90)),
		array("Julius Thruway North",        array(1534.50,2433.20,-89.00,1848.40,2583.20,110.90)),
		array("Julius Thruway North",        array(1848.40,2478.40,-89.00,1938.80,2553.40,110.90)),
		array("Julius Thruway North",        array(1704.50,2342.80,-89.00,1848.40,2433.20,110.90)),
		array("Julius Thruway North",        array(1377.30,2433.20,-89.00,1534.50,2507.20,110.90)),
		array("Julius Thruway South",        array(1457.30,823.20,-89.00,2377.30,863.20,110.90)),
		array("Julius Thruway South",        array(2377.30,788.80,-89.00,2537.30,897.90,110.90)),
		array("Julius Thruway West",         array(1197.30,1163.30,-89.00,1236.60,2243.20,110.90)),
		array("Julius Thruway West",         array(1236.60,2142.80,-89.00,1297.40,2243.20,110.90)),
		array("Juniper Hill",                array(-2533.00,578.30,-7.60,-2274.10,968.30,200.00)),
		array("Juniper Hollow",              array(-2533.00,968.30,-6.10,-2274.10,1358.90,200.00)),
		array("K.A.C.C. Military Fuels",     array(2498.20,2626.50,-89.00,2749.90,2861.50,110.90)),
		array("Kincaid Bridge",              array(-1339.80,599.20,-89.00,-1213.90,828.10,110.90)),
		array("Kincaid Bridge",              array(-1213.90,721.10,-89.00,-1087.90,950.00,110.90)),
		array("Kincaid Bridge",              array(-1087.90,855.30,-89.00,-961.90,986.20,110.90)),
		array("King's",                      array(-2329.30,458.40,-7.60,-1993.20,578.30,200.00)),
		array("King's",                      array(-2411.20,265.20,-9.10,-1993.20,373.50,200.00)),
		array("King's",                      array(-2253.50,373.50,-9.10,-1993.20,458.40,200.00)),
		array("LVA Freight Depot",           array(1457.30,863.20,-89.00,1777.40,1143.20,110.90)),
		array("LVA Freight Depot",           array(1375.60,919.40,-89.00,1457.30,1203.20,110.90)),
		array("LVA Freight Depot",           array(1277.00,1087.60,-89.00,1375.60,1203.20,110.90)),
		array("LVA Freight Depot",           array(1315.30,1044.60,-89.00,1375.60,1087.60,110.90)),
		array("LVA Freight Depot",           array(1236.60,1163.40,-89.00,1277.00,1203.20,110.90)),
		array("Las Barrancas",               array(-926.10,1398.70,-3.00,-719.20,1634.60,200.00)),
		array("Las Brujas",                  array(-365.10,2123.00,-3.00,-208.50,2217.60,200.00)),
		array("Las Colinas",                 array(1994.30,-1100.80,-89.00,2056.80,-920.80,110.90)),
		array("Las Colinas",                 array(2056.80,-1126.30,-89.00,2126.80,-920.80,110.90)),
		array("Las Colinas",                 array(2185.30,-1154.50,-89.00,2281.40,-934.40,110.90)),
		array("Las Colinas",                 array(2126.80,-1126.30,-89.00,2185.30,-934.40,110.90)),
		array("Las Colinas",                 array(2747.70,-1120.00,-89.00,2959.30,-945.00,110.90)),
		array("Las Colinas",                 array(2632.70,-1135.00,-89.00,2747.70,-945.00,110.90)),
		array("Las Colinas",                 array(2281.40,-1135.00,-89.00,2632.70,-945.00,110.90)),
		array("Las Payasadas",               array(-354.30,2580.30,2.00,-133.60,2816.80,200.00)),
		array("Las Venturas Airport",        array(1236.60,1203.20,-89.00,1457.30,1883.10,110.90)),
		array("Las Venturas Airport",        array(1457.30,1203.20,-89.00,1777.30,1883.10,110.90)),
		array("Las Venturas Airport",        array(1457.30,1143.20,-89.00,1777.40,1203.20,110.90)),
		array("Las Venturas Airport",        array(1515.80,1586.40,-12.50,1729.90,1714.50,87.50)),
		array("Last Dime Motel",             array(1823.00,596.30,-89.00,1997.20,823.20,110.90)),
		array("Leafy Hollow",                array(-1166.90,-1856.00,0.00,-815.60,-1602.00,200.00)),
		array("Liberty City",                array(-1000.00,400.00,1300.00,-700.00,600.00,1400.00)),
		array("Lil' Probe Inn",              array(-90.20,1286.80,-3.00,153.80,1554.10,200.00)),
		array("Linden Side",                 array(2749.90,943.20,-89.00,2923.30,1198.90,110.90)),
		array("Linden Station",              array(2749.90,1198.90,-89.00,2923.30,1548.90,110.90)),
		array("Linden Station",              array(2811.20,1229.50,-39.50,2861.20,1407.50,60.40)),
		array("Little Mexico",               array(1701.90,-1842.20,-89.00,1812.60,-1722.20,110.90)),
		array("Little Mexico",               array(1758.90,-1722.20,-89.00,1812.60,-1577.50,110.90)),
		array("Los Flores",                  array(2581.70,-1454.30,-89.00,2632.80,-1393.40,110.90)),
		array("Los Flores",                  array(2581.70,-1393.40,-89.00,2747.70,-1135.00,110.90)),
		array("Los Santos International",    array(1249.60,-2394.30,-89.00,1852.00,-2179.20,110.90)),
		array("Los Santos International",    array(1852.00,-2394.30,-89.00,2089.00,-2179.20,110.90)),
		array("Los Santos International",    array(1382.70,-2730.80,-89.00,2201.80,-2394.30,110.90)),
		array("Los Santos International",    array(1974.60,-2394.30,-39.00,2089.00,-2256.50,60.90)),
		array("Los Santos International",    array(1400.90,-2669.20,-39.00,2189.80,-2597.20,60.90)),
		array("Los Santos International",    array(2051.60,-2597.20,-39.00,2152.40,-2394.30,60.90)),
		array("Marina",                      array(647.70,-1804.20,-89.00,851.40,-1577.50,110.90)),
		array("Marina",                      array(647.70,-1577.50,-89.00,807.90,-1416.20,110.90)),
		array("Marina",                      array(807.90,-1577.50,-89.00,926.90,-1416.20,110.90)),
		array("Market",                      array(787.40,-1416.20,-89.00,1072.60,-1310.20,110.90)),
		array("Market",                      array(952.60,-1310.20,-89.00,1072.60,-1130.80,110.90)),
		array("Market",                      array(1072.60,-1416.20,-89.00,1370.80,-1130.80,110.90)),
		array("Market",                      array(926.90,-1577.50,-89.00,1370.80,-1416.20,110.90)),
		array("Market Station",              array(787.40,-1410.90,-34.10,866.00,-1310.20,65.80)),
		array("Martin Bridge",               array(-222.10,293.30,0.00,-122.10,476.40,200.00)),
		array("Missionary Hill",             array(-2994.40,-811.20,0.00,-2178.60,-430.20,200.00)),
		array("Montgomery",                  array(1119.50,119.50,-3.00,1451.40,493.30,200.00)),
		array("Montgomery",                  array(1451.40,347.40,-6.10,1582.40,420.80,200.00)),
		array("Montgomery Intersection",     array(1546.60,208.10,0.00,1745.80,347.40,200.00)),
		array("Montgomery Intersection",     array(1582.40,347.40,0.00,1664.60,401.70,200.00)),
		array("Mulholland",                  array(1414.00,-768.00,-89.00,1667.60,-452.40,110.90)),
		array("Mulholland",                  array(1281.10,-452.40,-89.00,1641.10,-290.90,110.90)),
		array("Mulholland",                  array(1269.10,-768.00,-89.00,1414.00,-452.40,110.90)),
		array("Mulholland",                  array(1357.00,-926.90,-89.00,1463.90,-768.00,110.90)),
		array("Mulholland",                  array(1318.10,-910.10,-89.00,1357.00,-768.00,110.90)),
		array("Mulholland",                  array(1169.10,-910.10,-89.00,1318.10,-768.00,110.90)),
		array("Mulholland",                  array(768.60,-954.60,-89.00,952.60,-860.60,110.90)),
		array("Mulholland",                  array(687.80,-860.60,-89.00,911.80,-768.00,110.90)),
		array("Mulholland",                  array(737.50,-768.00,-89.00,1142.20,-674.80,110.90)),
		array("Mulholland",                  array(1096.40,-910.10,-89.00,1169.10,-768.00,110.90)),
		array("Mulholland",                  array(952.60,-937.10,-89.00,1096.40,-860.60,110.90)),
		array("Mulholland",                  array(911.80,-860.60,-89.00,1096.40,-768.00,110.90)),
		array("Mulholland",                  array(861.00,-674.80,-89.00,1156.50,-600.80,110.90)),
		array("Mulholland Intersection",     array(1463.90,-1150.80,-89.00,1812.60,-768.00,110.90)),
		array("North Rock",                  array(2285.30,-768.00,0.00,2770.50,-269.70,200.00)),
		array("Ocean Docks",                 array(2373.70,-2697.00,-89.00,2809.20,-2330.40,110.90)),
		array("Ocean Docks",                 array(2201.80,-2418.30,-89.00,2324.00,-2095.00,110.90)),
		array("Ocean Docks",                 array(2324.00,-2302.30,-89.00,2703.50,-2145.10,110.90)),
		array("Ocean Docks",                 array(2089.00,-2394.30,-89.00,2201.80,-2235.80,110.90)),
		array("Ocean Docks",                 array(2201.80,-2730.80,-89.00,2324.00,-2418.30,110.90)),
		array("Ocean Docks",                 array(2703.50,-2302.30,-89.00,2959.30,-2126.90,110.90)),
		array("Ocean Docks",                 array(2324.00,-2145.10,-89.00,2703.50,-2059.20,110.90)),
		array("Ocean Flats",                 array(-2994.40,277.40,-9.10,-2867.80,458.40,200.00)),
		array("Ocean Flats",                 array(-2994.40,-222.50,-0.00,-2593.40,277.40,200.00)),
		array("Ocean Flats",                 array(-2994.40,-430.20,-0.00,-2831.80,-222.50,200.00)),
		array("Octane Springs",              array(338.60,1228.50,0.00,664.30,1655.00,200.00)),
		array("Old Venturas Strip",          array(2162.30,2012.10,-89.00,2685.10,2202.70,110.90)),
		array("Palisades",                   array(-2994.40,458.40,-6.10,-2741.00,1339.60,200.00)),
		array("Palomino Creek",              array(2160.20,-149.00,0.00,2576.90,228.30,200.00)),
		array("Paradiso",                    array(-2741.00,793.40,-6.10,-2533.00,1268.40,200.00)),
		array("Pershing Square",             array(1440.90,-1722.20,-89.00,1583.50,-1577.50,110.90)),
		array("Pilgrim",                     array(2437.30,1383.20,-89.00,2624.40,1783.20,110.90)),
		array("Pilgrim",                     array(2624.40,1383.20,-89.00,2685.10,1783.20,110.90)),
		array("Pilson Intersection",         array(1098.30,2243.20,-89.00,1377.30,2507.20,110.90)),
		array("Pirates in Men's Pants",      array(1817.30,1469.20,-89.00,2027.40,1703.20,110.90)),
		array("Playa del Seville",           array(2703.50,-2126.90,-89.00,2959.30,-1852.80,110.90)),
		array("Prickle Pine",                array(1534.50,2583.20,-89.00,1848.40,2863.20,110.90)),
		array("Prickle Pine",                array(1117.40,2507.20,-89.00,1534.50,2723.20,110.90)),
		array("Prickle Pine",                array(1848.40,2553.40,-89.00,1938.80,2863.20,110.90)),
		array("Prickle Pine",                array(1938.80,2624.20,-89.00,2121.40,2861.50,110.90)),
		array("Queens",                      array(-2533.00,458.40,0.00,-2329.30,578.30,200.00)),
		array("Queens",                      array(-2593.40,54.70,0.00,-2411.20,458.40,200.00)),
		array("Queens",                      array(-2411.20,373.50,0.00,-2253.50,458.40,200.00)),
		array("Randolph Industrial Estate",  array(1558.00,596.30,-89.00,1823.00,823.20,110.90)),
		array("Redsands East",               array(1817.30,2011.80,-89.00,2106.70,2202.70,110.90)),
		array("Redsands East",               array(1817.30,2202.70,-89.00,2011.90,2342.80,110.90)),
		array("Redsands East",               array(1848.40,2342.80,-89.00,2011.90,2478.40,110.90)),
		array("Redsands West",               array(1236.60,1883.10,-89.00,1777.30,2142.80,110.90)),
		array("Redsands West",               array(1297.40,2142.80,-89.00,1777.30,2243.20,110.90)),
		array("Redsands West",               array(1377.30,2243.20,-89.00,1704.50,2433.20,110.90)),
		array("Redsands West",               array(1704.50,2243.20,-89.00,1777.30,2342.80,110.90)),
		array("Regular Tom",                 array(-405.70,1712.80,-3.00,-276.70,1892.70,200.00)),
		array("Richman",                     array(647.50,-1118.20,-89.00,787.40,-954.60,110.90)),
		array("Richman",                     array(647.50,-954.60,-89.00,768.60,-860.60,110.90)),
		array("Richman",                     array(225.10,-1369.60,-89.00,334.50,-1292.00,110.90)),
		array("Richman",                     array(225.10,-1292.00,-89.00,466.20,-1235.00,110.90)),
		array("Richman",                     array(72.60,-1404.90,-89.00,225.10,-1235.00,110.90)),
		array("Richman",                     array(72.60,-1235.00,-89.00,321.30,-1008.10,110.90)),
		array("Richman",                     array(321.30,-1235.00,-89.00,647.50,-1044.00,110.90)),
		array("Richman",                     array(321.30,-1044.00,-89.00,647.50,-860.60,110.90)),
		array("Richman",                     array(321.30,-860.60,-89.00,687.80,-768.00,110.90)),
		array("Richman",                     array(321.30,-768.00,-89.00,700.70,-674.80,110.90)),
		array("Robada Intersection",         array(-1119.00,1178.90,-89.00,-862.00,1351.40,110.90)),
		array("Roca Escalante",              array(2237.40,2202.70,-89.00,2536.40,2542.50,110.90)),
		array("Roca Escalante",              array(2536.40,2202.70,-89.00,2625.10,2442.50,110.90)),
		array("Rockshore East",              array(2537.30,676.50,-89.00,2902.30,943.20,110.90)),
		array("Rockshore West",              array(1997.20,596.30,-89.00,2377.30,823.20,110.90)),
		array("Rockshore West",              array(2377.30,596.30,-89.00,2537.30,788.80,110.90)),
		array("Rodeo",                       array(72.60,-1684.60,-89.00,225.10,-1544.10,110.90)),
		array("Rodeo",                       array(72.60,-1544.10,-89.00,225.10,-1404.90,110.90)),
		array("Rodeo",                       array(225.10,-1684.60,-89.00,312.80,-1501.90,110.90)),
		array("Rodeo",                       array(225.10,-1501.90,-89.00,334.50,-1369.60,110.90)),
		array("Rodeo",                       array(334.50,-1501.90,-89.00,422.60,-1406.00,110.90)),
		array("Rodeo",                       array(312.80,-1684.60,-89.00,422.60,-1501.90,110.90)),
		array("Rodeo",                       array(422.60,-1684.60,-89.00,558.00,-1570.20,110.90)),
		array("Rodeo",                       array(558.00,-1684.60,-89.00,647.50,-1384.90,110.90)),
		array("Rodeo",                       array(466.20,-1570.20,-89.00,558.00,-1385.00,110.90)),
		array("Rodeo",                       array(422.60,-1570.20,-89.00,466.20,-1406.00,110.90)),
		array("Rodeo",                       array(466.20,-1385.00,-89.00,647.50,-1235.00,110.90)),
		array("Rodeo",                       array(334.50,-1406.00,-89.00,466.20,-1292.00,110.90)),
		array("Royal Casino",                array(2087.30,1383.20,-89.00,2437.30,1543.20,110.90)),
		array("San Andreas Sound",           array(2450.30,385.50,-100.00,2759.20,562.30,200.00)),
		array("Santa Flora",                 array(-2741.00,458.40,-7.60,-2533.00,793.40,200.00)),
		array("Santa Maria Beach",           array(342.60,-2173.20,-89.00,647.70,-1684.60,110.90)),
		array("Santa Maria Beach",           array(72.60,-2173.20,-89.00,342.60,-1684.60,110.90)),
		array("Shady Cabin",                 array(-1632.80,-2263.40,-3.00,-1601.30,-2231.70,200.00)),
		array("Shady Creeks",                array(-1820.60,-2643.60,-8.00,-1226.70,-1771.60,200.00)),
		array("Shady Creeks",                array(-2030.10,-2174.80,-6.10,-1820.60,-1771.60,200.00)),
		array("Sobell Rail Yards",           array(2749.90,1548.90,-89.00,2923.30,1937.20,110.90)),
		array("Spinybed",                    array(2121.40,2663.10,-89.00,2498.20,2861.50,110.90)),
		array("Starfish Casino",             array(2437.30,1783.20,-89.00,2685.10,2012.10,110.90)),
		array("Starfish Casino",             array(2437.30,1858.10,-39.00,2495.00,1970.80,60.90)),
		array("Starfish Casino",             array(2162.30,1883.20,-89.00,2437.30,2012.10,110.90)),
		array("Temple",                      array(1252.30,-1130.80,-89.00,1378.30,-1026.30,110.90)),
		array("Temple",                      array(1252.30,-1026.30,-89.00,1391.00,-926.90,110.90)),
		array("Temple",                      array(1252.30,-926.90,-89.00,1357.00,-910.10,110.90)),
		array("Temple",                      array(952.60,-1130.80,-89.00,1096.40,-937.10,110.90)),
		array("Temple",                      array(1096.40,-1130.80,-89.00,1252.30,-1026.30,110.90)),
		array("Temple",                      array(1096.40,-1026.30,-89.00,1252.30,-910.10,110.90)),
		array("The Camel's Toe",             array(2087.30,1203.20,-89.00,2640.40,1383.20,110.90)),
		array("The Clown's Pocket",          array(2162.30,1783.20,-89.00,2437.30,1883.20,110.90)),
		array("The Emerald Isle",            array(2011.90,2202.70,-89.00,2237.40,2508.20,110.90)),
		array("The Farm",                    array(-1209.60,-1317.10,114.90,-908.10,-787.30,251.90)),
		array("The Four Dragons Casino",     array(1817.30,863.20,-89.00,2027.30,1083.20,110.90)),
		array("The High Roller",             array(1817.30,1283.20,-89.00,2027.30,1469.20,110.90)),
		array("The Mako Span",               array(1664.60,401.70,0.00,1785.10,567.20,200.00)),
		array("The Panopticon",              array(-947.90,-304.30,-1.10,-319.60,327.00,200.00)),
		array("The Pink Swan",               array(1817.30,1083.20,-89.00,2027.30,1283.20,110.90)),
		array("The Sherman Dam",             array(-968.70,1929.40,-3.00,-481.10,2155.20,200.00)),
		array("The Strip",                   array(2027.40,863.20,-89.00,2087.30,1703.20,110.90)),
		array("The Strip",                   array(2106.70,1863.20,-89.00,2162.30,2202.70,110.90)),
		array("The Strip",                   array(2027.40,1783.20,-89.00,2162.30,1863.20,110.90)),
		array("The Strip",                   array(2027.40,1703.20,-89.00,2137.40,1783.20,110.90)),
		array("The Visage",                  array(1817.30,1863.20,-89.00,2106.70,2011.80,110.90)),
		array("The Visage",                  array(1817.30,1703.20,-89.00,2027.40,1863.20,110.90)),
		array("Unity Station",               array(1692.60,-1971.80,-20.40,1812.60,-1932.80,79.50)),
		array("Valle Ocultado",              array(-936.60,2611.40,2.00,-715.90,2847.90,200.00)),
		array("Verdant Bluffs",              array(930.20,-2488.40,-89.00,1249.60,-2006.70,110.90)),
		array("Verdant Bluffs",              array(1073.20,-2006.70,-89.00,1249.60,-1842.20,110.90)),
		array("Verdant Bluffs",              array(1249.60,-2179.20,-89.00,1692.60,-1842.20,110.90)),
		array("Verdant Meadows",             array(37.00,2337.10,-3.00,435.90,2677.90,200.00)),
		array("Verona Beach",                array(647.70,-2173.20,-89.00,930.20,-1804.20,110.90)),
		array("Verona Beach",                array(930.20,-2006.70,-89.00,1073.20,-1804.20,110.90)),
		array("Verona Beach",                array(851.40,-1804.20,-89.00,1046.10,-1577.50,110.90)),
		array("Verona Beach",                array(1161.50,-1722.20,-89.00,1323.90,-1577.50,110.90)),
		array("Verona Beach",                array(1046.10,-1722.20,-89.00,1161.50,-1577.50,110.90)),
		array("Vinewood",                    array(787.40,-1310.20,-89.00,952.60,-1130.80,110.90)),
		array("Vinewood",                    array(787.40,-1130.80,-89.00,952.60,-954.60,110.90)),
		array("Vinewood",                    array(647.50,-1227.20,-89.00,787.40,-1118.20,110.90)),
		array("Vinewood",                    array(647.70,-1416.20,-89.00,787.40,-1227.20,110.90)),
		array("Whitewood Estates",           array(883.30,1726.20,-89.00,1098.30,2507.20,110.90)),
		array("Whitewood Estates",           array(1098.30,1726.20,-89.00,1197.30,2243.20,110.90)),
		array("Willowfield",                 array(1970.60,-2179.20,-89.00,2089.00,-1852.80,110.90)),
		array("Willowfield",                 array(2089.00,-2235.80,-89.00,2201.80,-1989.90,110.90)),
		array("Willowfield",                 array(2089.00,-1989.90,-89.00,2324.00,-1852.80,110.90)),
		array("Willowfield",                 array(2201.80,-2095.00,-89.00,2324.00,-1989.90,110.90)),
		array("Willowfield",                 array(2541.70,-1941.40,-89.00,2703.50,-1852.80,110.90)),
		array("Willowfield",                 array(2324.00,-2059.20,-89.00,2541.70,-1852.80,110.90)),
		array("Willowfield",                 array(2541.70,-2059.20,-89.00,2703.50,-1941.40,110.90)),
		array("Yellow Bell Station",         array(1377.40,2600.40,-21.90,1492.40,2687.30,78.00)),
		// Main Zones
		array("Los Santos",                  array(44.60,-2892.90,-242.90,2997.00,-768.00,900.00)),
		array("Las Venturas",                array(869.40,596.30,-242.90,2997.00,2993.80,900.00)),
		array("Bone County",                 array(-480.50,596.30,-242.90,869.40,2993.80,900.00)),
		array("Tierra Robada",               array(-2997.40,1659.60,-242.90,-480.50,2993.80,900.00)),
		array("Tierra Robada",               array(-1213.90,596.30,-242.90,-480.50,1659.60,900.00)),
		array("San Fierro",                  array(-2997.40,-1115.50,-242.90,-1213.90,1659.60,900.00)),
		array("Red County",                  array(-1213.90,-768.00,-242.90,2997.00,596.30,900.00)),
		array("Flint County",                array(-1213.90,-2892.90,-242.90,44.60,-768.00,900.00)),
		array("Whetstone",                   array(-2997.40,-2892.90,-242.90,-1213.90,-1115.50,900.00))
	);
	foreach ($gSAZones as $value)
	{
		if(($lx >= $value[1][0]) && ($lx <= $value[1][3]) && ($ly >= $value[1][1]) && ($ly <= $value[1][4]))
		{
			
			return $value[0];
		}
	}
	return false;
}

?>