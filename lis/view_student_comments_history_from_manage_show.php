<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
?>	

<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION["lang"] == "EN"){

	$num=$dbf->countRows('student_comment',"student_id='$_REQUEST[ids]'");
	if($num > 0) {
	?>
	<table width="648" border="0" cellspacing="0" cellpadding="0">
	  <?php
	  $i = 0;
	  foreach($dbf->fetchOrder('student_comment',"student_id='$_REQUEST[ids]'","id") as $resc) {
	  
	  //Get user name
	  $user = $dbf->strRecordID("user","*","id='$resc[user_id]'");
	  
		if ($i % 2) {
			?>
			<tr>
		<td width="313" align="left" valign="middle">
		<!-- Green -->
		  <table width="99%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			  <td width="34" align="left" valign="top"><img src="../images/1leftgrbg.png" width="34" height="15" /></td>
			  <td background="../images/1midgrbg.png" class="shop2"><?php echo constant("STUDENT_ADVISOR_HOME_POSTEDBY");?> : <?php echo $user[user_name];?></td>
			  <td width="9" align="right" valign="top" bgcolor="#C8EF54"><img src="../images/1right_grbg.png" width="9" height="9" /></td>
			</tr>
			<tr>
			  <td background="../images/1left_mid.png">&nbsp;</td>
			  <td align="left" valign="middle" bgcolor="#C8EF54" class="shop1"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : <?php echo date("D, d M Y",strtotime($resc["date_time"]));?>&nbsp;,&nbsp;<?php echo date("h:m",strtotime($resc["date_time"]));?><br>
			    <span class="shop2"><?php echo $resc["comments"];?></span></td>
			  <td bgcolor="#C8EF54">&nbsp;</td>
			</tr>
			<tr>
			  <td><img src="../images/1right_bot_bg.png" width="34" height="43" /></td>
			  <td align="left" valign="top" background="../images/1bot_mid.png" class="shop2"></td>
			  <td><img src="../images/1right_bot.png" width="11" height="43" /></td>
			</tr>
		  </table></td>
		<td width="235" align="left" valign="middle">&nbsp;</td>
	  </tr>
			<?php
		} else {
			?>                            
			<tr>
		<td align="left" valign="middle">&nbsp;</td>
		<td align="right" valign="middle">
		<!-- Gray -->
		  <table width="98%" border="0" align="right" cellpadding="0" cellspacing="0">
			<tr>
			  <td width="12"><img src="../images/left_topgrey.png" width="12" height="10" /></td>
			  <td background="../images/top_mid_grey.png"></td>
			  <td width="28" align="left" valign="top"><img src="../images/right_top_grey.png" width="28" height="10" /></td>
			</tr>
			<tr>
			  <td background="../images/left_mid_grey.png">&nbsp;</td>
			  <td align="left" valign="middle" class="shop2"><?php echo constant("STUDENT_ADVISOR_HOME_POSTEDBY");?> : <?php echo $user[user_name];?></td>
			  <td background="../images/right_midgrey.png">&nbsp;</td>
			</tr>
			<tr>
			  <td background="../images/left_mid_grey.png">&nbsp;</td>
			  <td align="left" valign="middle" class="shop1"><?php echo constant("TEACHER_REPORT_TEACHER_DATE");?> : <?php echo date("D, d M Y",strtotime($resc["date_time"]));?>&nbsp;,&nbsp;<?php echo date("h:m",strtotime($resc["date_time"]));?><br>
			    <span class="shop2"><?php echo $resc["comments"];?></span></td>
			  <td background="../images/right_midgrey.png">&nbsp;</td>
			</tr>
			<tr>
			  <td><img src="../images/left_bot_grey.png" width="12" height="44" /></td>
			  <td align="left" valign="top" background="../images/bot_mid_grey.png" class="shop2"></td>
			  <td align="left"><img src="../images/right_bot_grey.png" width="28" height="44" /></td>
			</tr>
		  </table></td>
	  </tr>
			<?php
		}
	  ?>
	  <tr>
		<td align="left" valign="middle">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
	  </tr>
	  <tr>
		<td align="left" valign="middle"></td>
		<td align="left" valign="middle"></td>
	  </tr>
	  <?php $i++; } ?>
	</table>
	<?php
	}else{
	?>
	<br />
	<table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
	  <tr>
		<td width="39" align="center" valign="middle" bgcolor="#FFF1DF"><img src="../images/news.jpeg" width="18" height="21" /></td>
		<td width="311" align="left" valign="middle" bgcolor="#FFF1DF"><?php echo constant("NO_COMMENTS");?></td>
		</tr>
	</table>
	<br />
    <?php
	}
} else {
	$num=$dbf->countRows('student_comment',"student_id='$_REQUEST[ids]'");
	if($num > 0) {
	?>
	<table width="648" border="0" cellspacing="0" cellpadding="0">
	  <?php
	  $i = 0;
	  foreach($dbf->fetchOrder('student_comment',"student_id='$_REQUEST[ids]'","id") as $resc) {
	  
	  //Get user name
	  $user = $dbf->strRecordID("user","*","id='$resc[user_id]'");
	  
		if ($i % 2) {
		?>
	  <tr>
		<td width="313" align="left" valign="middle">
		  <!-- Green -->
		  <table width="99%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			  <td width="34" align="left" valign="top"><img src="../images/1leftgrbg.png" width="34" height="15" /></td>
			  <td align="right" background="../images/1midgrbg.png" class="shop2"><?php echo $user[user_name];?> : <?php echo constant("STUDENT_ADVISOR_HOME_POSTEDBY");?></td>
			  <td width="9" align="right" valign="top" bgcolor="#C8EF54"><img src="../images/1right_grbg.png" width="9" height="9" /></td>
			  </tr>
			<tr>
			  <td background="../images/1left_mid.png">&nbsp;</td>
			  <td align="right" valign="middle" bgcolor="#C8EF54" class="shop1"><?php echo date("D, d M Y",strtotime($resc["date_time"]));?>&nbsp;,&nbsp;<?php echo date("h:m",strtotime($resc["date_time"]));?> : <?php echo constant("TEACHER_REPORT_TEACHER_DATE");?><br>
			    <span class="shop2"><?php echo $resc["comments"];?></span></td>
			  <td bgcolor="#C8EF54">&nbsp;</td>
			  </tr>
			<tr>
			  <td><img src="../images/1right_bot_bg.png" width="34" height="43" /></td>
			  <td align="right" valign="top" background="../images/1bot_mid.png" class="shop2"></td>
			  <td><img src="../images/1right_bot.png" width="11" height="43" /></td>
			  </tr>
			</table></td>
		<td width="235" align="left" valign="middle">&nbsp;</td>
		</tr>
	  <?php
	} else {
		?>                            
	  <tr>
		<td align="left" valign="middle">&nbsp;</td>
		<td align="right" valign="middle">
		  <!-- Gray -->
		  <table width="98%" border="0" align="right" cellpadding="0" cellspacing="0">
			<tr>
			  <td width="12"><img src="../images/left_topgrey.png" width="12" height="10" /></td>
			  <td background="../images/top_mid_grey.png"></td>
			  <td width="28" align="left" valign="top"><img src="../images/right_top_grey.png" width="28" height="10" /></td>
			  </tr>
			<tr>
			  <td background="../images/left_mid_grey.png">&nbsp;</td>
			  <td align="right" valign="middle" class="shop2"><?php echo $user[user_name];?> : <?php echo constant("STUDENT_ADVISOR_HOME_POSTEDBY");?></td>
			  <td background="../images/right_midgrey.png">&nbsp;</td>
			  </tr>
			<tr>
			  <td background="../images/left_mid_grey.png">&nbsp;</td>
			  <td align="right" valign="middle" class="shop1"><?php echo date("D, d M Y",strtotime($resc["date_time"]));?>&nbsp;,&nbsp;<?php echo date("h:m",strtotime($resc["date_time"]));?> : <?php echo constant("TEACHER_REPORT_TEACHER_DATE");?><br>
			    <span class="shop2"><?php echo $resc["comments"];?></span></td>
			  <td background="../images/right_midgrey.png">&nbsp;</td>
			  </tr>
			<tr>
			  <td><img src="../images/left_bot_grey.png" width="12" height="44" /></td>
			  <td align="right" valign="top" background="../images/bot_mid_grey.png" class="shop2"></td>
			  <td align="left"><img src="../images/right_bot_grey.png" width="28" height="44" /></td>
			  </tr>
			</table></td>
		</tr>
	  <?php
	}
	?>
	  <tr>
		<td align="left" valign="middle">&nbsp;</td>
		<td align="left" valign="middle">&nbsp;</td>
		</tr>
	  <tr>
		<td align="left" valign="middle"></td>
		<td align="left" valign="middle"></td>
		</tr>
	  <?php $i++; } ?>
	  </table>
	<?php } else { ?>
	<br />
	<table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF6600;">
	  <tr>
		
		<td width="311" align="right" valign="middle" bgcolor="#FFF1DF"><?php echo constant("NO_COMMENTS");?>&nbsp;</td>
		<td width="39" align="center" valign="middle" bgcolor="#FFF1DF"><img src="../images/news.jpeg" width="18" height="21" /></td>
		</tr>
	  </table>
	<br />
	<?php } ?>
<?php } ?>