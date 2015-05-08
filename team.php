<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="Stylesheet" type="text/css" href="new.css" />
<link rel="Stylesheet" type="text/css" href="menudol.css" />
<link rel="Stylesheet" type="text/css" href="login.css" />
<link rel="shortcut icon" href="img/favicon.png"/>

	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>L2BlackSide Interlude PvP server</title>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
</head>

<body>


<div id="wrap">

<div id="all">
  <div id="menu">        
   <a href="index.php"  style="margin-left:210px;">Home</a>
        <span></span>
        <a href="team.php" class="active">Equip</a>
        <span></span>
        <a href="information.php" style="margin-right:265px;">Information</a>
   
        <a href="/forum">Forum</a>
        <span></span>
        <a href="status.php">Status</a>
        <span></span>
        <a href="donation.php">Donation</a> </div>
</div>



  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="1613" height="431" class="swf" id="FlashID" title="">
    <param name="movie" value="fames.SWF" />
    <param name="quality" value="high" />
    <param name="wmode" value="opaque" />
    <param name="swfversion" value="8.0.35.0" />
    <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
    <param name="expressinstall" value="Scripts/expressInstall.swf" />
    <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="fames.SWF" width="1613" height="431">
      <!--<![endif]-->
      <param name="quality" value="high" />
      <param name="wmode" value="opaque" />
      <param name="swfversion" value="8.0.35.0" />
      <param name="expressinstall" value="Scripts/expressInstall.swf" />
      <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
      
        <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
        <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
    
      <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
  </object>

<script type="text/javascript">
swfobject.registerObject("FlashID");
</script>

<div id="all2">
<table border="0" cellpadding="0" cellspacing="0">
<tr valign="top">

<td width="340"><div id="box_left" >
	 <?php include('login.php') ?>
     <?php include('serverstatus.php') ?>
	</div>
</td>
<td width="733"> 
	<div id="box_right"> 
    	    	<table border="0" cellspacing="0" cellpadding="0">
 				  <tr valign="top">
                 <td><img src="img/team.png" alt="" style="margin-left:65px;margin-bottom:10px;"/></td>
                 <td width="209"> <img src="img/voteforus.png" alt="" style="margin-bottom:10px;margin-left:45px;" />
                 
               
                 </td>
        <tr valign="top">
    				
                    <td width="485" height="620">
                    <div style="margin-left:65px;">
                    


<?php include('teamtxt.php')?>






</div>
				   </td>
                   
					<td width="209"> 
					 <?php include ("vote.php") ?>
                     <?php include ("support.php") ?>
			    </td>
 				 </tr>
  				 
   					<tr valign="top"><td>
                    <img src="img/video.png" alt="" style="margin-left:63px;margin-top:5px;margin-bottom:5px;"/>
                    <div style="margin-top:10px;margin-left:65px;">
					<?php include("video.php");?></div></td>
   					<td> <img src="img/screenshots.png" alt="" style="margin-left:38px;margin-top:5px;margin-bottom:5px;"/>
                    
                    
                    
<?php

  $template = "obrazki";
  $category = "2";
  $number = "2";
  include("cutenews15/show_news.php");
?>
                    
                    
                   <div style="margin-left:76px;margin-top:8px"> <a href="cutenews15/uploads" style="color:#ffc053;;text-decoration:underline;font-size:12px;">Watch all screenshots</a></div>
                    </td></tr>
  				
                </table>
    
    
    </div>
</td>

</tr>
</table>


</div>



<div id="footer">
 <div id="menudol"><?php include('menudol.php')?></div>
 <div style="margin-left:800px;padding-top:30px;"><?php include('footer.php')?></div>
 <div id="footerdeco"></div>
</div>









</div>
</body>
</html>

	