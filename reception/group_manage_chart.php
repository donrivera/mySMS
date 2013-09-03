<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include '../includes/FusionCharts.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
<link href="glowtabs.css" rel="stylesheet" type="text/css" />
</head>

<?php
//group id rom request
$group_id = $_REQUEST["group_id"];
$res_group = $dbf->strRecordID("student_group","*","id='$group_id'");

//Get currency from the table
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");

//Get no of unit of a group
$res_unit = $dbf->strRecordID("group_size","*","group_id='$res_group[group_id]'");
$group_unit = $res_unit["units"];

$group_name = $res_group["group_name"];

$left_units = $dbf->countRows('ped_units',"group_id='$group_id'");

if($group_unit > 0){
	$g_unit = $group_unit / 2;
	if($left_units > $g_unit){
		$status = 'Yes';
	}else{
		$status = 'No';
	}
}
?>
<script language="javascript" type="text/javascript">
function showme(){
	$('#td_show').toggle();
}
</script>
<body>
<?php if($_SESSION[lang]=="EN"){?>
<table width="400" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
  <tr>
    <td height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><table width="399" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="108" align="left" valign="middle"><span class="leftmenu"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></span></td>
        <td width="255" align="left" valign="middle"><?php echo constant("CD_MANAGE_CHART_GROUP_LEFT");?></td>        
        <td width="36" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle" class="leftmenu">
    <?php
		echo $strXML1="<chart palette='1' showValues='0' yAxisValuesPadding='10'>
					<categories>
						<category label='$group_name'/>
						</categories>
						<dataset seriesName='Total Unit(s)'>
						<set value='$group_unit'/>
						</dataset>
						<dataset seriesname='Completed Unit(s)'>
						<set value='$left_units'/>
						</dataset>
						</chart>";
		echo renderChartHTML("../FusionCharts/Charts/MSColumnLine3D.swf", "", $strXML1, "myNext", 400, 300);
		?>
    </td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle" class="red_smalltext"><?php echo constant("CD_MANAGE_CHART_GRADE_PRINT");?> : <?php echo $status;?></td>
  </tr>
  <tr>
    <td height="25" align="left" valign="middle" class="mymenutext"><a href="javascript:void(0);" onclick="showme();"><?php echo constant("CD_MANAGE_CHART_VIEW_CHAPTER");?></a></td>
  </tr>
  <tr id="td_show" style="display:none;">
    <td height="25" align="left" valign="middle" class="mymenutext" >
    <table width="390" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#999999">
      <tr>
        <td width="63" height="22" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
        <td width="327" height="22" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("CD_MANAGE_CHART_CHAPTERS");?></td>
      </tr>
      <?php
	  $sl = 1;
      foreach($dbf->fetchOrder('ped_units',"group_id='$group_id'","id") as $val_chap){
	  ?>
      <tr>
        <td height="20" align="center" valign="middle"><?php echo $sl;?></td>
        <td height="20" align="left" valign="middle">&nbsp;<?php echo $val_chap["material_overed"];?></td>
      </tr>
      <?php
	  $sl++;
	  }
	  ?>
    </table></td>
  </tr>
</table>
<?php } else{?>
<table width="400" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
  <tr>
    <td height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><table width="399" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();"/></td>
        <td width="253" align="right" valign="middle"><?php echo constant("CD_MANAGE_CHART_GROUP_LEFT");?></td>
        <td width="118" align="right" valign="middle"><img src="../logo/logo-ar.png" width="100" height="30" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle" class="leftmenu">
    <?php
		echo $strXML1="<chart palette='1' showValues='0' yAxisValuesPadding='10'>
					<categories>
						<category label='$group_name'/>
						</categories>
						<dataset seriesName='Total Unit(s)'>
						<set value='$group_unit'/>
						</dataset>
						<dataset seriesname='Completed Unit(s)'>
						<set value='$left_units'/>
						</dataset>
						</chart>";
		echo renderChartHTML("../FusionCharts/Charts/MSColumnLine3D.swf", "", $strXML1, "myNext", 400, 300);
		?>
    </td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle" class="red_smalltext"><?php echo $status;?> : <?php echo constant("CD_MANAGE_CHART_GRADE_PRINT");?></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="middle" class="mymenutext"><a href="javascript:void(0);" onclick="showme();"><?php echo constant("CD_MANAGE_CHART_VIEW_CHAPTER");?></a></td>
  </tr>
  <tr id="td_show" style="display:none;">
    <td height="25" align="left" valign="middle" class="mymenutext" >
    <table width="390" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#999999">
      <tr>
        
        <td width="327" height="22" align="right" valign="middle" bgcolor="#CCCCCC">&nbsp;<?php echo constant("CD_MANAGE_CHART_CHAPTERS");?></td>
        <td width="63" height="22" align="center" valign="middle" bgcolor="#CCCCCC"><?php echo constant("STUDENT_MYACCOUNT_SL");?></td>
      </tr>
      <?php
	  $sl = 1;
      foreach($dbf->fetchOrder('ped_units',"group_id='$group_id'","id") as $val_chap){
	  ?>
      <tr>
        <td height="20" align="right" valign="middle">&nbsp;<?php echo $val_chap["material_overed"];?></td>
        <td height="20" align="center" valign="middle"><?php echo $sl;?></td>
      </tr>
      <?php
	  $sl++;
	  }
	  ?>
    </table></td>
  </tr>
</table>
<?php }?>
</body>
</html>