<?php
require("inc/SampQuery.class.php"); 
?>
<div style="padding-top: 0%; padding-left: 1%;">
<?php
	$query = new SampQuery("188.226.211.5", "7777"); 
	if ($query->connect()) 
	{
		$aviv = $query->getInfo();
		echo "<h3 style='color: #666666; font-family: cMyriadPro; src: url(fonts/myriadpro.otf); line-height: 0%;'>General Information</h3>";
		echo "<strong>Hostname:</strong> ".$aviv['hostname']."<br />";
		echo "<strong>Online Players:</strong> ".$aviv['players']."/".$aviv['maxplayers']."<br />";
		echo "<strong>Revision:</strong> ".$aviv['gamemode']."<br />";
		echo "<strong>Map:</strong> ".$aviv['map']."<br />";
		
		$aviv = $query->getRules();
		echo "<strong>Version:</strong> SA:MP ".$aviv['version']."<br />";
		$aviv = $query->getPing();
		echo "<strong>Ping:</strong> ".$aviv."ms<br />";
		$query->close(); 
	} 
	else 
	{ 
		echo GetMessage("Error:", "Server is not responding.", 4);
	} 
?>
</div>