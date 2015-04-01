<ul class="breadcrumb">
  <i class="icon-chevron-right"></i> <li class="active">FC-RP Staff Team</li>
</ul>

<?php
$catName = array(
    6 => "Management",
	5 => "Lead Administrators",
	4 => "Level 3 Administrators",
	3 => "Level 2 Administrators",
	2 => "Administrators",
	1 => "Moderators",
);

$typeColor = array(
    6 => "#1A167D",
	5 => "#E00000",
	4 => "#6C167D",
	3 => "#67A145",
	2 => "#49C700",
	1 => "#325F8C",
);

?>
<div class="row" style="margin: 0 auto; margin-left: 1%;">
<?php
//for ($i=1; $i <= 7; $i++)
for ($i=1; $i <= 7; $i++)
{
	?>
<div class="span4">
<ul class="thumbnails">
  <li class="span4">
    <div class="thumbnail">
      <center><h4 style="text-decoration: none; font-family: cMyriadPro; src: url(fonts/myriadpro.otf); color: <?php echo $typeColor[$i]; ?>;"><?php echo $catName[$i]; ?></h4></center>
      <p>
	  <?php
		$gstaff = mysql_query("SELECT * FROM `players` WHERE `AdminLevel` = ".$i."");
		if(mysql_num_rows($gstaff))
		{
			echo '<ul style="list-style-type:square;">';
			while($row = mysql_fetch_array($gstaff, MYSQL_ASSOC)) 
			{
				$name = $row['Name'];
				$link = $row['ForumLink'];
				$type = $row['AdminLevel'];
				$ingame = $row['Character1'];
				$cat = $row['AdminLevel'];
				if($i == $cat)
				{
					if($link == " ")
						echo "<span style='color: ".$typeColor[$type].";'><li><strong>".$name."</strong></span> - <span style='color: grey;'>".$ingame."</span></li>";
						
					else
						echo "<span style='color: ".$typeColor[$type].";'><li></span><a style='color: ".$typeColor[$type].";' href='".$link."'><strong>".$name."</strong></a> - <span style='color: grey;'>".$ingame."</span></li>";

				}
			}
			echo '</ul>';
		}
		else echo "<ul style='list-style-type:square;'><span style='color: gray;'><li>Vacant</li></ul></span>";
	  ?>
	  </p>
		</div>
		</li>
		</ul>
		</div>
	<?php
} 
?>
</div>