<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$res_arf = $dbf->strRecordID("arf","*","id='$_REQUEST[id]'");
$res_std = $dbf->strRecordID("student","*","id='$res_arf[student_id]'");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.loginheading{
font-family:Arial, Helvetica, sans-serif;
font-size:18px;
color:#000000;
font-weight:normal;
padding-left:15px;
}
</style>
<?php
if($_SESSION[font]=='big')
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}
else if($_SESSION[font]=="small")
{
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}
else
{
	?>
    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<body>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="border-color:#CCCCCC;">
  <tr>
    <td align="center" valign="middle" class="loginheading">&nbsp;</td>
  </tr>
  <tr>
    <td width="63" align="center" valign="middle" class="loginheading"><?php echo constant("TEACHER_ARF_MANAGE_ACTIONREQUESTFRM");?> </td>
  </tr>
</table>
<br>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="1" style="border:solid 2px; border-color:#000000;">
  <tr>
    <td height="15" colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width="63">&nbsp;</td>
    <td width="115" height="30" bgcolor="#CCCCCC" class="leftmenu" style="border-left:solid 1px; border-color:#636;border-top:solid 1px; border-color:#636;border-bottom:solid 1px; border-color:#636;border-right:solid 1px; border-color:#636;"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?> :</td>
    <td width="202" class="mytext"><?php echo $res_std[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_std["id"]));?></td>
    <td width="16">&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="196" class="mytext">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> :</td>
    <td align="left" valign="middle"  class="mytext"><?php echo $res_arf[dated];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_NR");?> :</td>
    <td align="left" valign="middle" class="mytext"><?php echo $res_arf[nr];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONOWNER");?> :</td>
    <td align="left" valign="middle"  class="mytext"><?php echo $res_arf[action_owner];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="mytext">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="center" valign="middle" class="mytext">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="mytext">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTBY");?> :</td>
    <td align="left" valign="middle" class="mytext"><?php echo $res_arf[report_by];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORTEDTO");?>:</td>
    <td align="left" valign="middle" class="mytext"><?php echo $res_arf[report_to];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?> : </td>
    <td align="center" valign="middle" class="mytext">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_FUNCTION");?>:</td>
    <td align="left" valign="middle" class="mycon">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CUSTOMER");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[customer];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td width="74" align="right" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?> : </td>
    <td height="25" align="left" valign="middle" class="mycon"><span class="mytext">
      <?php echo $res_arf[reception2];?>
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_TEACHER");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[teacher];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_LCD");?> : </td>
    <td height="25" align="left" valign="middle" class="mycon"><span class="mytext">
      <?php echo $res_arf[lcd];?>
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RECEPTION");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[reception1];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_LIS");?> : </td>
    <td height="25" align="left" valign="middle" class="mycon"><span class="mytext">
      <?php echo $res_arf[lis];?>
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CS");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[cs1];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_CS");?> : </td>
    <td height="25" align="left" valign="middle" class="mycon"><span class="mytext">
      <?php echo $res_arf[cs2];?>
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[other1];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="right" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> :</td>
    <td height="25" align="left" valign="middle" class="mycon"><span class="mytext">
      <?php echo $res_arf[other2];?>
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SUBJECT");?> : </td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_INSTRUCTION");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[instruction];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_MATERIAL");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[material];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_PROGRAMME");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[programme];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_PREMISSES");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[premisses];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ADMINST");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[administration];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_OTHER");?> : </td>
    <td height="25" align="left" valign="middle" class="mytext"><?php echo $res_arf[other3];?></td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_REPORT");?></td>
    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> : </td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?>:</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_ACTIONTAKEN");?></td>
    <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
    <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="top" class="leftmenu">&nbsp;</td>
    <td height="30" align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_DATE");?> : </td>
    <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
    <td align="left" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_SIGNED");?>:</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("RECEPTION_ARF_MANAGE_RESULTCHECKED");?></td>
    <td height="30" colspan="3" align="left" valign="top" class="leftmenu">&nbsp;</td>
    <td colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
  </tr>
</table>
<br>
</body>
</html>
<script type="text/javascript">
window.print();
</script>