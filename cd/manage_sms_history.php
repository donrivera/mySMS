<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Center Director")
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
<script type="text/javascript" src="dropdowntabs.js"></script>

<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />

<script type="text/javascript">
function show_details(a)
{
	var arrow="plusArrow"+a;
	var content="content"+a;
	if(document.getElementById(a).style.display=='')
	{
		document.getElementById(a).style.display='none';
		document.getElementById(arrow).innerHTML='<img src="../images/plus.gif" alt="Loading" />';
	}
	else
	{
		document.getElementById(a).style.display='';
		document.getElementById(arrow).innerHTML='<img src="../images/minus.gif" alt="Loading" />';
	}
}
</script>
<script type="text/javascript">
function show_details1(a)
{
	var arrow="plusArrow"+a;
	var content="content"+a;
	if(document.getElementById(a).style.display=='')
	{
		document.getElementById(a).style.display='none';
		document.getElementById(arrow).innerHTML='<img src="../images/plus.gif" alt="Loading" />';
	}
	else
	{
		document.getElementById(a).style.display='';
		document.getElementById(arrow).innerHTML='<img src="../images/minus.gif" alt="Loading" />';
	}
}
</script>
</head>
<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger(){
    if(countdown_number > 0){
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0){
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION['lang']=='EN'){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <form id="frm" name="frm" action="">
    <table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include '../admin/left_menu.php';?></td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("ADMIN_SMS_HISTORY_VIEW_SMS_HISTORY");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top">
            <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="71" height="36" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?> :</td>
                    <td width="155" height="36" align="left" valign="middle" ><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                    <td width="81" height="36" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?> :</td>
                    <td width="102" height="36" align="left" valign="middle" ><input name="stid" type="text" class="new_textbox100" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="68" height="36" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?> :</td>
                    <td width="102" height="36" align="left" valign="middle" ><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="58" height="36" align="right" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?> :</td>
                    <td width="113" height="36" align="left" valign="middle" ><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                    <td width="164" align="right" valign="middle">
                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
                  </tr>
                </table>
            <table width="99%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      <th width="6%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                      <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_SENDBY");?></th>
                      <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_SENDTO");?></th>
                      <th width="21%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_DATEOF");?></th>
                      <th width="40%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_MESSAGE");?></th>
                      </tr>
                  </thead>
                  <?php
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.email LIKE '$_REQUEST[email]%'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.id>'0'";
					}
					//End 4.
					
					$i = 1;
					$color = "#ECECFF";
					
					//Loop start
					//SELECT * FROM sms_history WHERE centre_id='2' and id in (select parent_id from sms_history_dtls where student_id > 0) order by id 
					foreach($dbf->fetchOrder('sms_history m,sms_history_dtls d,student s', $condition." And m.id=d.parent_id And s.id=d.student_id And d.student_id > '0' And s.centre_id='$_SESSION[centre_id]'","m.id","m.*") as $val){
						
						$num_user=$dbf->countRows('sms_history_dtls',"parent_id='$val[id]'");	
						//Get user name
						$val_user = $dbf->strRecordID("user","*","id='$val[user_id]'");					
				 ?>                    
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                    <td width="4%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span></a></td>
                    <td width="6%" height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                    <td width="14%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_user[user_name];?><?php if($num_user!=0){echo " [".$num_user."]"; }?></td>
                    <td width="15%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[send_to];?></td>
                    <td width="21%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d, M,Y h:i:s A',strtotime($val[dated]));?></td>
                    <td width="40%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[msg];?></td>
                    <?php
					  $i = $i + 1;
					  if($color=="#ECECFF")
					  {
						  $color = "#FBFAFA";
					  }
					  else
					  {
						  $color="#ECECFF";
					  }
					  
				  ?>
                  </tr>
                  <tr style="display:none;" id="<?php echo $val[id];?>">
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" colspan="4" align="left" valign="middle" style="padding-left:5px;padding-top:3px;padding-bottom:3px;">
					<?php if($val[type] == "1")
					{
					?>
                      <table width="700" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr>
                          <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("ADMIN_S10_SMSTOMOB");?> [<?php echo $val[mobile];?>]</td>
                        </tr>
                      </table>
                      <?php
					}
					else
					{
					?>
                      <table width="700" border="1" bordercolor="#CCCCCC" cellspacing="0" class="tablesorter" cellpadding="0" style="border-collapse:collapse;">
                      	<thead>
                        <tr>
                        <th width="7%" height="25" align="left" valign="middle" >&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                          <th width="24%" height="25" align="left" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
                          <th width="19%" height="25" align="left" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_STUDENTID");?></th>
                          <th width="25%" height="25" align="left" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_MOBILENO");?></th>
                          <th width="25%" height="25" align="left" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_EMAILADDRESS");?></th>
                        </tr>
                        </thead>
                        <?php
						$j=1;
						$color1 = "#ECECFF";
						foreach($dbf->fetchOrder('sms_history_dtls',"student_id > 0 And parent_id='$val[id]'","id") as $valinv){
														
							//Get student name
							$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						?>
                        
                        <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                         <td height="25" align="center" valign="middle" class="mycon">&nbsp;<?php echo $valinv[student_id];?></td>
                          <td height="25" align="left" valign="middle" class="mycon">&nbsp;<?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                          <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $val_student[student_id];?></td>
                          <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $val_student[student_mobile];?></td>
                          <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $val_student[email];?>&nbsp;&nbsp;</td>
                        </tr>
                        <?php
						if($color1=="#ECECFF")
						  {
							  $color1 = "#FBFAFA";
						  }
						  else
						  {
							  $color1="#ECECFF";
						  }
						$j++;
                        }
                        ?>
                      </table>
                      <?php
				}
				?></td>
                  </tr>
                  <?php
					}
					?>
                </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
        
        <form id="frm" name="frm" action="">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="54%" height="30" class="logintext" align="right"><?php echo constant("ADMIN_SMS_HISTORY_VIEW_SMS_HISTORY");?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
            <td height="450" align="right" valign="top">
            <table width="100%" height="36" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="164" align="left" valign="middle">
                    <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn2"/></td>
                    <td width="108" height="36" align="right" valign="middle" ><input name="email" type="text" class="new_textbox100" id="email" value="<?php echo $_REQUEST[email];?>"></td>
                    <td width="72" height="36" align="right" valign="middle" class="leftmenu"> :<?php echo constant("STUDENT_ADVISOR_SEARCH_EMAIL");?></td>
                    <td width="116" height="36" align="right" valign="middle" ><input name="mobile" type="text" class="new_textbox100" id="mobile" value="<?php echo $_REQUEST[mobile];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="73" height="36" align="right" valign="middle" class="leftmenu"> :<?php echo constant("STUDENT_ADVISOR_SEARCH_MOBILENO");?></td>
                    <td width="107" height="36" align="right" valign="middle" ><input name="stid" type="text" class="new_textbox100" id="stid" value="<?php echo $_REQUEST[stid];?>" onKeyPress="return PhoneNo(event);"></td>
                    <td width="95" height="36" align="right" valign="middle" class="leftmenu"> :<?php echo constant("STUDENT_ADVISOR_SEARCH_STUDENTID");?></td>
                    <td width="108" height="36" align="right" valign="middle" ><input name="fname" type="text" class="new_textbox100" id="fname" value="<?php echo $_REQUEST[fname];?>"></td>
                    <td width="71" height="36" align="right" valign="middle" class="leftmenu"> :<?php echo constant("STUDENT_ADVISOR_SEARCH_FIRSTNAME");?></td>
                  </tr>
                </table>
            <table width="99%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      
                      
                      <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_SENDBY");?></th>
                      <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_SENDTO");?></th>
                      <th width="21%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_DATEOF");?></th>
                      <th width="40%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_MESSAGE");?></th>
                      <th width="6%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                      <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      </tr>
                  </thead>
                  <?php
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.email LIKE '$_REQUEST[email]%'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "s.id>'0'";
					}
					//End 4.
					
					$i = 1;
					$color = "#ECECFF";
					
					//Loop start
					//SELECT * FROM sms_history WHERE centre_id='2' and id in (select parent_id from sms_history_dtls where student_id > 0) order by id 
					foreach($dbf->fetchOrder('sms_history m,sms_history_dtls d,student s', $condition." And m.id=d.parent_id And s.id=d.student_id And d.student_id > '0' And s.centre_id='$_SESSION[centre_id]'","m.id","m.*") as $val){
						
						$num_user=$dbf->countRows('sms_history_dtls',"parent_id='$val[id]'");	
						//Get user name
						$val_user = $dbf->strRecordID("user","*","id='$val[user_id]'");					
				 ?>                    
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                    <td width="14%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_user[user_name];?><?php if($num_user!=0){echo " [".$num_user."]"; }?></td>
                    <td width="15%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[send_to];?></td>
                    <td width="21%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d, M,Y h:i:s A',strtotime($val[dated]));?></td>
                    <td width="40%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[msg];?></td>
                    <td width="6%" height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                    <td width="4%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span></a></td>
                    <?php
					  $i = $i + 1;
					  if($color=="#ECECFF")
					  {
						  $color = "#FBFAFA";
					  }
					  else
					  {
						  $color="#ECECFF";
					  }
					  
				  ?>
                  </tr>
                  <tr style="display:none;" id="<?php echo $val[id];?>">
                    
                    
                    <td height="25" colspan="4" align="right" valign="middle" style="padding-left:5px;padding-top:3px;padding-bottom:3px;">
					<?php if($val[type] == "1")
					{
					?>
                      <table width="700" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr>
                          <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("ADMIN_S10_SMSTOMOB");?> [<?php echo $val[mobile];?>]</td>
                        </tr>
                      </table>
                      <?php
					}
					else
					{
					?>
                      <table width="700" border="1" bordercolor="#CCCCCC" cellspacing="0" class="tablesorter" cellpadding="0" style="border-collapse:collapse;">
                      	<thead>
                        <tr>
                        
                          <th width="24%" height="25" align="left" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
                          <th width="19%" height="25" align="left" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_STUDENTID");?></th>
                          <th width="25%" height="25" align="left" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_MOBILENO");?></th>
                          <th width="25%" height="25" align="left" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_EMAILADDRESS");?></th>
                          <th width="7%" height="25" align="left" valign="middle" >&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                        </tr>
                        </thead>
                        <?php
						$j=1;
						$color1 = "#ECECFF";
						foreach($dbf->fetchOrder('sms_history_dtls',"student_id > 0 And parent_id='$val[id]'","id") as $valinv){
														
						//Get student name
						$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						?>
                        
                        <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">                         
                          <td height="25" align="right" valign="middle" class="mycon">&nbsp;<?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                          <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $val_student[student_id];?></td>
                          <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $val_student[student_mobile];?></td>
                          <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $val_student[email];?>&nbsp;&nbsp;</td>
                          <td height="25" align="center" valign="middle" class="mycon">&nbsp;<?php echo $valinv[student_id];?></td>
                        </tr>
                        <?php
						if($color1=="#ECECFF")
						  {
							  $color1 = "#FBFAFA";
						  }
						  else
						  {
							  $color1="#ECECFF";
						  }
						$j++;
                        }
                        ?>
                      </table>
                      <?php
						}
						?>
                </td>
                	<td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                	<td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                  </tr>
                  <?php
					}
					?>
                </table>
            </td>
          </tr>
                <tr>
                  <td height="450" align="left" valign="top" >
                    <table width="99%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" style="border-collapse:collapse;">
                      <thead>
                        <tr>
                          <th width="15%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_SENDTO");?></th>
                          <th width="21%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_DATEOF");?></th>
                          <th width="40%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_MESSAGE");?></th>
                          <th width="14%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_SENDBY");?></th>
                          <th width="6%" height="25" align="right" valign="middle" bgcolor="#99CC99"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                          <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                          </tr>
                        </thead>
                      <?php
					$i = 1;
					$color = "#ECECFF";
					
					//Loop start
					foreach($dbf->fetchOrder('sms_history',"centre_id='$_SESSION[centre_id]'","id") as $val)
					{
					$num_user=$dbf->countRows('sms_history_dtls',"parent_id='$val[id]'");	
					//Get user name
					$val_user = $dbf->strRecordID("user","*","id='$val[user_id]'");					
				 ?>                      
                      <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                        <td width="15%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[send_to];?></td>
                        <td width="21%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d, M,Y h:i:s A',strtotime($val[dated]));?></td>
                        <td width="40%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[msg];?></td>
                        <td width="14%" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_user[user_name];?><?php if($num_user!=0){echo " [".$num_user."]"; }?></td>
                        <td width="6%" height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                        <td width="4%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span></a></td>
                        <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }					  
				  ?>
                        </tr>
                      <tr style="display:none;" id="<?php echo $val[id];?>">
                        <td height="25" colspan="4" align="right" valign="middle" style="padding-left:5px;padding-top:3px;padding-bottom:3px;">
                          <?php if($val[type] == "1"){ ?>
                          <table width="700" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("ADMIN_S10_SMSTOMOB");?> [<?php echo $val[mobile];?>]</td>
                              </tr>
                            </table>
                          <?php }else{ ?>
                          <table width="700" border="1" bordercolor="#CCCCCC" cellspacing="0" class="tablesorter" cellpadding="0" style="border-collapse:collapse;">
                            <thead>
                              <tr>
                                <th width="19%" height="25" align="right" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_STUDENTID");?></th>
                                <th width="25%" height="25" align="right" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_MOBILENO");?></th>
                                <th width="25%" height="25" align="right" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_EMAILADDRESS");?></th>
                                <th width="24%" height="25" align="right" valign="middle" class="lable1" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
                           <th width="7%" height="25" align="left" valign="middle" class="lable1">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                                </tr>
                              </thead>
                            <?php
						$j=1;
						$color1 = "#ECECFF";
						foreach($dbf->fetchOrder('sms_history_dtls',"parent_id='$val[id]'","id") as $valinv){
														
							//Get student name
							$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						?>
                            
                            <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                              <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $val_student[student_id];?></td>
                              <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $val_student[student_mobile];?></td>
                              <td align="right" valign="middle" class="mycon">&nbsp;<?php echo $val_student[email];?>&nbsp;&nbsp;</td>
                              <td height="25" align="right" valign="middle" class="mycon">&nbsp;<?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                              <td height="25" align="center" valign="middle" class="mycon">&nbsp;<?php echo $j;?></td>
                              </tr>
                            <?php
						if($color1=="#ECECFF")
						  {
							  $color1 = "#FBFAFA";
						  }
						  else
						  {
							  $color1="#ECECFF";
						  }
						$j++;
                        }
                        ?>
                        </table>
                      <?php } ?></td>
                       <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                       <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                        </tr>
                      <?php
					}
					?>
                      </table>
                    </td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
          </table>
          </form>
          </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php }?>
</body>
</html>
