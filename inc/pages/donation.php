<div style="padding-top: 1%; padding-left: 1%;">
<?php
echo GetMessage("Note:", "You will receive your donation perks instantly after your successful payment.", 1);
?>
<div class="row-fluid">
	<ul class="thumbnails">
	  <li class="span4">
		<div class="thumbnail">
		  <img data-src="holder.js/300x200" alt="">
		  <div class="caption">
			<h3 style="color: #666666; font-weight: bold; font-family: cMyriadPro; src: url(fonts/myriadpro.otf);line-height: 0%;"><span style="color: #ad3500;">BRONZE</span></h3>
			<p>
				<ul>
					<li>Special forum rank</li>
					<li>2 namechange tickets</li>
					<li>1 numberchange ticket</li>
					<li>Free package vehicle</li>
					<li>Automatic level-up</li>
					<li>Saving mask</li>
					<li>Ability to block PMs</li>
				</ul>
			<br><br>
			<p><center><font color="black"><b>Free vehicle:</b></font></center></p>
			<center><img height="175" width="126" src="/img/bronze.png");/></center><br>
			</p><br>
			<p><center><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#purchase">Purchase</button></center></p>
			<p><center><font color="black"><b>Price: $4,00 USD</b><font></center></p>
		  </div>
		</div>
	  </li>
	  <li class="span4">
		<div class="thumbnail">
		  <img data-src="holder.js/300x200" alt="">
		  <div class="caption">
			<h3 style="color: #666666; font-weight: bold; font-family: cMyriadPro; src: url(fonts/myriadpro.otf);line-height: 0%;"><span style="color: grey;">SILVER</span></h3>
			<p>
				<ul>
					<li>Special forum rank</li>
					<li>5 namechange tickets</li>
					<li>3 numberchange tickets</li>
					<li>Free package vehicle</li>
					<li>Automatic level-up</li>
					<li>Saving mask</li>
					<li>Ability to block PMs</li>
					<li>25 % discount on house furniture</li>
					
				</ul>
			</p><br>
			<p><center><font color="black"><b>Free vehicle:</b></font></center></p>
			<center><img height="175" width="126" src="/img/silver.png");/></center><br>
			<br>
			<p><center><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#purchase">Purchase</button></center></p>
			<p><center><font color="black"><b>Price: $7,00 USD</b><font></center></p>
		  </div>
		</div>
	  </li>
	  <li class="span4">
		<div class="thumbnail">
		  <img data-src="holder.js/300x200" alt="">
		  <div class="caption">
			<h3 style="color: #666666; font-weight: bold; font-family: cMyriadPro; src: url(fonts/myriadpro.otf);line-height: 0%;"><span style="color: #a46e00;">GOLD</span></h3>
			<p>
				<ul>
					<li>Special forum rank</li>
					<li>10 namechange tickets</li>
					<li>5 numberchange tickets</li>
					<li>Free package vehicle</li>
					<li>Automatic level-up</li>
					<li>Saving mask</li>
					<li>Ability to block PMs</li>
					<li>Private Teamspeak channel</li>
					<li>50 % discount on house furniture</li>
					<li>25 % discount on dealership vehicles</li>
				</ul>
			</p>
			<p><center><font color="black"><b>Free vehicle:</b></font></center></p>
			<center><img height="180" width="140" src="/img/gold.png");/></center>
			
			<br><p><center><button type="button" class="btn btn-success" data-toggle="collapse" data-target="#purchase">Purchase</button></center></p>
			<p><center><font color="black"><b>Price: $10,00 USD</b><font></center></p>
		  </div>
		</div>
	  </li>
	</ul>
</div>
<div id="purchase" class="collapse" style="padding-top: 0%;" align="center">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="4DD7EX5ZXWJKQ">
	<table>
	<tr><td><input type="hidden" name="on0" value="Package">Package</td></tr><tr><td><select name="os0">
		<option value="Bronze package -">Bronze package - $4,00 USD</option>
		<option value="Silver package -">Silver package - $7,00 USD</option>
		<option value="Gold package -">Gold package - $10,00 USD</option>
	</select> </td></tr>
	<tr><td><input type="hidden" name="on1" value="Your Email Address">Email Address:</td></tr><tr><td><input type="text" name="os1" maxlength="200"></td></tr>
	</table>
	<input type="hidden" name="currency_code" value="USD">
	<center><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/no_NO/i/scr/pixel.gif" width="1" height="1"></center></form>
