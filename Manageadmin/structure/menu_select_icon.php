<?php
include("../libs/session.php");
include("../libs/config.php");
		if($_SESSION['core_session_sys_language']=="thai"){
			include("../structure/language_thai.php");
		}else if($_SESSION['core_session_sys_language']=="eng"){
			include("../structure/language_eng.php");
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Select Icon</title>
		<meta name="description" content="top menu &amp; navigation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<link rel="stylesheet" href="../../assets/css/dashlite.css?ver=2.2.0">
    <link id="skin-default" rel="stylesheet" href="../../assets/css/theme.css?ver=2.2.0">
<script src="../structure/menu.js"></script>
		</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#f5f5f5 !important;">
  <tr class="tbHeader">
    <td  bgcolor="#C3C3C3" align="center">
    <table width="450" border="0" cellpadding="0" cellspacing="0"  >
  <tr>

    <td width="369" height="20" align="left" ><h5><?php echo $txt_mod["menu:clickicon"];?>  </h5> </td>
         <td width="81" height="20" align="right" style="padding-right:5px;" ><span style="cursor:pointer;"  onClick="window.close(); "><h5><?php echo $txt_mod["menu:close"];?></h5></span>     </td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td valign="top"  align="center">
    <table width="450" height="250" border="0" cellspacing="0" cellpadding="0" style="padding-top:20px" >
    <tr>
  	<td>	

	</td>
  </tr>
  <tr>
    <td valign="top" >
    <div class="row">

									<div class="col-xs-12 col-sm-3" id="changecolor" style="font-size:20px;">
										<table border="1" cellpadding="0" cellspacing="0" bordercolor="#C3C3C3">	
											<tr align="center">
												<td width="30" height="30"><i class="icon ni ni-calendar" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-calendar')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-camera" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-camera')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-layers" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-layers')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-db" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-db')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-grid-c" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-grid-c')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-chart-up" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-chart-up')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-growth" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-growth')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-activity-round" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-activity-round')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-home" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-home')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-inbox-in" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-inbox-in')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-mail" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-mail')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-location" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-location')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-map" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-map')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-movie" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-movie')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-user-alt" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-user-alt')" ></i></td>
												
											</tr>
											
											<tr align="center">
												<td width="30" height="30"><i class="icon ni ni-user-c" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-user-c')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-laptop" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-laptop')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-coins" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-coins')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-coin" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-coin')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-setting" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-setting')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-share" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-share')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-network" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-network')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-rss" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-rss')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-shield-check" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-shield-check')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-wallet" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-wallet')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-star" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-star')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-star-round" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-star-round')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-tag" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-tag')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-ticket" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-ticket')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-building" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-building')" ></i></td>
												
											</tr>
											
											<tr align="center">
												<td width="30" height="30"><i class="icon ni ni-aperture" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-aperture')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-award" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-award')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-briefcase" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-briefcase')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-gift" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-gift')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-globe" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-globe')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-youtube-round" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-youtube-round')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-focus" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-focus')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-video" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-video')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-alert" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-alert')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-archived" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-archived')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-bell" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-bell')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-bag" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-bag')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-wifi" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-wifi')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-live" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-live')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-book-read" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-book-read')" ></i></td>
												
											</tr>

											<tr align="center">
												<td width="30" height="30"><i class="icon ni ni-bulb" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-bulb')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-call" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-call')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-cart" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-cart')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-msg" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-msg')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-clip" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-clip')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-clipboard" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-clipboard')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-upload-cloud" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-upload-cloud')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-contact" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-contact')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-coffee" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-coffee')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-toolbar" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-toolbar')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-box" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-box')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-package" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-package')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-color-palette" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-color-palette')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-copy" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-copy')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-crosshair" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-crosshair')" ></i></td>
												
											</tr>

											<tr align="center">	
												<td width="30" height="30"><i class="icon ni ni-file" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-file')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-dashboard" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-dashboard')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-grid" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-grid')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-grid-box" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-grid-box')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-bar-c" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-bar-c')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-line-chart-up" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-line-chart-up')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-meter" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-meter')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-pie-alt" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-pie-alt')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-happy" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-happy')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-img" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-img')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-link-group" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-link-group')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-music" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-music')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-offer" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-offer')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-monitor" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-monitor')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-mobile" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-mobile')" ></i></td>
												
											</tr>
											<tr align="center">	
												<td width="30" height="30"><i class="icon ni ni-tranx" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-tranx')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-article" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-article')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-money" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-money')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-spark" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-spark')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-heart" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-heart')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-alarm" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-alarm')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-truck" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-truck')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-sign-steller" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-sign-steller')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-sign-steem" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-sign-steem')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-sign-ada" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-sign-ada')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-sign-dash" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-sign-dash')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-react" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-react')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-notice" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-notice')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-b-si" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-b-si')" ></i></td>
												<td width="30" height="30"><i class="icon ni ni-comments" onMouseOver="this.style.cursor='pointer'" onClick="setImageSelected('icon ni ni-comments')" ></i></td>

											</tr>
										</table>
									</div>
	</div>
   
    </td>
  </tr>

</table>
</td>
  </tr>

    <tr>
    <td  class="bg_footerbarhome" ></td>
  </tr>  
  <tr>
    <td align="center" style="padding-top:5px;"></td>
  </tr>
</table>

</body>
</html>
