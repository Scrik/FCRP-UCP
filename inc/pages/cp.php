<?php
if(!isset($_SESSION['Logged']))
	header("Location: ?page=homepage");
	
if(GetP($_SESSION['Logged'], "AdminLevel") <= 1)
	header("Location: ?page=homepage");

	
	$check = mysql_query("SELECT * FROM `players` WHERE `Status` = '1' AND `Banned` = '0'");
?>

<ul class="breadcrumb">
	<i class="icon-chevron-right"></i> 
	<li class="active">Administration Control Panel</li>
</ul>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
			<?php
			if(GetP($_SESSION['Logged'], "AdminLevel") >= 2)
			{
			?>
              <li class="nav-header">Administrators</li>
              <li><a href="#ban" data-toggle="tab">Ban</a></li>
			  <li><a href="#unban" data-toggle="tab">Unban</a></li>
              <li><a href="#checkstats" data-toggle="tab">Check statistics</a></li>
              <li><a href="#checkip" data-toggle="tab">Check IP address</a></li>
			<?php
			}
			if(GetP($_SESSION['Logged'], "AdminLevel") >= 2)
			{
			?>
              <li class="nav-header">Logs</li>
              <li><a href="#searchlogs" data-toggle="tab">Kicks and Bans</a></li>
			  <li><a href="#restarts" data-toggle="tab">Server restarts</a></li>
			<?php
			}
			if(GetP($_SESSION['Logged'], "AdminLevel") >= 5)
			{
			?>
              <li class="nav-header">Senior Administrators</li>
              <li><a href="#donatorset" data-toggle="tab">Set Donator</a></li>
			  <li><a href="#numberchanges" data-toggle="tab">Set Numberchanges</a></li>
			  <li><a href="#namechanges" data-toggle="tab">Set Namechanges</a></li>
			<?php
			}
			if(GetP($_SESSION['Logged'], "AdminLevel") >= 6)
			{
			?>
              <li class="nav-header">Lead Administrators</li>
              <li><a href="#addstaff" data-toggle="tab">Add Staff</a></li>
              <li><a href="#removestaff" data-toggle="tab">Remove Staff</a></li>
			<?php
			}
			?>
            </ul>
          </div><!--/.well -->
    </div>
    <div class="span9">
		<div id="myTabContent" class="tab-content">
		<?php include("inc/pages/tabs.php"); ?>
	  </div>
    </div>
  </div>
</div>