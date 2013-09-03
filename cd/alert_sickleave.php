<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';
include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';
include '../includes/pagination.php'; //For Pagination

if($_SESSION[font]=='big'){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-big.css" />
    <?php
}else if($_SESSION[font]=="small"){
	?>
    <link rel="stylesheet" type="text/css" href="glowtabs-small.css" />
    <?php
}else{
	?>    
    <link rel="stylesheet" type="text/css" href="glowtabs.css" />
    <?php
}
?>
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/page_style.css" type="text/css" media="screen" /> <!--Pagination CSS-->
<body>
<?php if($_SESSION['lang']=='EN'){?>
<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="right" valign="top" style="padding-right:3px;">
      <img src="../images/close.png" width="22" height="20" onClick="javascript:self.parent.tb_remove();" style="cursor:pointer;"></td>
    </tr>
    <tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
    	<td height="1" colspan="3" bgcolor="#d8dfea"></td>
    </tr>
    <tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">
       <?php
		$i = 1;		
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
		$page = ($page == 0 ? 1 : $page);
		$perpage = 1;//limit in each page
		$startpoint = ($page * $perpage) - $perpage;		
		foreach($dbf->fetchOrder('sick_leave',"centre_id='$_SESSION[centre_id]'","from_date DESC LIMIT $startpoint,$perpage") as $valalert) {
			$teacher = $dbf->strRecordID("teacher","*","id='$valalert[teacher_id]'");
		?>
        <table width="450" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
            <td width="4">&nbsp;</td>
            <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="68%" align="left" valign="middle" class="hometest_name"><?php echo constant("STUDENT_HOME_POSTEDBY");?> <?php echo $teacher["name"];?></td>
                 <td width="32%" align="left" valign="middle" class="hometest_time">
				 <?php echo date("l, d M Y",strtotime($valalert["from_date"]));?></td>
                </tr>
                <tr>
                  <td height="5"></td>
                  <td height="5"></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top" class="hometest_time"><?php echo constant("STUDENT_LEAVE_MANAGE_REASON");?> : <?php echo $valalert["sick_reason"];?></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="10" colspan="3"></td>
          </tr>
          <tr>
            <td height="1" colspan="3" bgcolor="#d8dfea"></td>
          </tr>
        </table>
        <?php
        $i++;
		}
		?>
        </td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top"><?php echo Pages("sick_leave",$perpage,"alert_sickleave.php?","centre_id='$_SESSION[centre_id]'");?></td>
    </tr>
</table>
<?php } else {?>
<table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" style="padding-left:3px;">
      <img src="../images/close.png" width="22" height="20" onClick="javascript:self.parent.tb_remove();" style="cursor:pointer;"></td>
    </tr>
    <tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
    	<td height="1" colspan="3" bgcolor="#d8dfea"></td>
    </tr>
    <tr>
      <td width="3" align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">
       <?php
		$i = 1;		
		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
		$page = ($page == 0 ? 1 : $page);
		$perpage = 1;//limit in each page
		$startpoint = ($page * $perpage) - $perpage;		
		foreach($dbf->fetchOrder('sick_leave',"centre_id='$_SESSION[centre_id]'","from_date DESC LIMIT $startpoint,$perpage") as $valalert) {
			$teacher = $dbf->strRecordID("teacher","*","id='$valalert[teacher_id]'");
		?>
        <table width="450" border="0" cellspacing="0" cellpadding="0">
          <tr>
          <td width="432" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                 <td width="32%" align="right" valign="middle" class="hometest_time">
				 <?php echo date("l, d M Y",strtotime($valalert["from_date"]));?></td>
                 <td width="68%" align="right" valign="middle" class="hometest_name"><?php echo constant("STUDENT_HOME_POSTEDBY");?> <?php echo $teacher["name"];?></td>
                </tr>
                <tr>
                  <td height="5"></td>
                  <td height="5"></td>
                </tr>
                <tr>
                 <td colspan="2" align="right" valign="top" class="hometest_time"><?php echo $valalert["sick_reason"];?> : <?php echo constant("STUDENT_LEAVE_MANAGE_REASON");?></td>
              </tr>
            </table></td>
            <td width="4">&nbsp;</td>
            <td width="64" align="center" valign="middle"><img src="../images/admin.png" width="55" height="55" /></td>
          </tr>
          <tr>
            <td height="10" colspan="3"></td>
          </tr>
          <tr>
            <td height="1" colspan="3" bgcolor="#d8dfea"></td>
          </tr>
        </table>
        <?php
        $i++;
		}
		?>
        </td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="center" valign="top"><?php echo Pages("sick_leave",$perpage,"alert_sickleave.php?","centre_id='$_SESSION[centre_id]'");?></td>
    </tr>
</table>
<?php }?>
</body>