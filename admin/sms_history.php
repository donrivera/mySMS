<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
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
<script type="text/javascript" src="dropdowntabs.js"></script>

<script type="text/javascript">
function show_details(a)
{
	var arrow="plusArrow"+a;
	var content="content"+a;
	if(document.getElementById(a).style.display==''){
		document.getElementById(a).style.display='none';
		document.getElementById(arrow).innerHTML='<img src="../images/plus.gif" alt="Loading" />';
	}else{
		document.getElementById(a).style.display='';
		document.getElementById(arrow).innerHTML='<img src="../images/minus.gif" alt="Loading" />';
	}
}
</script>
<script type="text/javascript">
function show_details1(a){
	var arrow="plusArrow"+a;
	var content="content"+a;
	if(document.getElementById(a).style.display==''){
		document.getElementById(a).style.display='none';
		document.getElementById(arrow).innerHTML='<img src="../images/plus.gif" alt="Loading" />';
	}else{
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

function countdown_trigger() {
    if(countdown_number > 0) {
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0)
	{
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout[name]+1; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" valign="top"><?php include 'left_menu.php';?></td>
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
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" >
            
            <table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
            <?php 
			$k=1;
			$color1 = "#ECECFF";
			$num=$dbf->countRows('centre');
			foreach($dbf->fetchOrder('centre',"","","") as $val_centre){
				
				//No of time SMS has been sent by the User
				$num_centre=$dbf->countRows('sms_history',"centre_id='$val_centre[id]'");
				$sm = "";
				if($num_centre > 0){
					$sm = " [".$num_centre."]";
				}
				?>
              <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
                <td width="35" align="center"><a href="javascript:void(0);" onclick="show_details1('<?php echo "m".$val_centre[id];?>');"><span id="plusArrow<?php echo "m".$val_centre[id];?>"><img src="../images/plus.gif" border="0" /></span></a></td>
                <td width="47" align="center" valign="middle" class="leftmenu"><?php echo $k; ?></td>
                <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo $val_centre[name];?> <?php echo $sm;?></td>
              </tr>
              <tr style="display:none;" id="<?php echo "m".$val_centre[id];?>">
                <td width="35" align="center" bgcolor="#FFFFFF">&nbsp;</td>
                <td width="47" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-top:3px; padding-bottom:3px; padding-left:3px;">&nbsp;</td>
                <td width="881" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-top:3px; padding-bottom:3px; padding-left:3px;">
                <?php
				//Check exist				
				if($num_centre > 0){
				?>
                <table width="99%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" align="center" valign="middle" bgcolor="#999999">&nbsp;</th>
                      <th width="6%" height="25" align="center" valign="middle" bgcolor="#999999" class="pedtext">
					  <?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                      <th width="14%" align="left" valign="middle" bgcolor="#999999" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_SENDBY");?></th>
                      <th width="15%" align="left" valign="middle" bgcolor="#999999" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_SENDTO");?></th>
                      <th width="21%" align="left" valign="middle" bgcolor="#999999" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_DATEOF");?></th>
                      <th width="40%" align="left" valign="middle" bgcolor="#999999" class="pedtext"><?php echo constant("ADMIN_SMS_HISTORY_MESSAGE");?></th>
                      </tr>
                  </thead>
                  <?php
					$i = 1;
					$color = "#ECECFF";
					
					//Loop start
					foreach($dbf->fetchOrder('sms_history',"centre_id='$val_centre[id]'","","") as $val){
					
					$num_user=$dbf->countRows('sms_history_dtls',"parent_id='$val[id]'");	
					//Get user name
					$val_user = $dbf->strRecordID("user","*","id='$val[user_id]'");
					
					?>
                    
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    <td width="4%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span></a></td>
                    <td width="6%" height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                    <td width="14%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_user[user_name];?><?php if($num_user!=0){echo " [".$num_user."]"; }?></td>
                    <td width="15%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[send_to];?></td>
                    <td width="21%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d, M,Y h:i:s A',strtotime($val[dated]));?></td>
                    <td width="40%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[msg];?></td>
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
					}else{
						
						$is_rec = $dbf->countRows('sms_history_dtls',"parent_id='$val[id]' And student_id>'0'");
						if($is_rec > 0){
					?>
                      <table width="700" border="1" bordercolor="#CCCCCC" cellspacing="0" class="tablesorter" cellpadding="0" style="border-collapse:collapse;">
                      	<thead>
                        <tr class="pedtext">
                        <th width="7%" height="25" align="left" valign="middle" class="amt_head" >&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                          <th width="24%" height="25" align="left" valign="middle" class="amt_head" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_STUDENTNAME");?></th>
                          <th width="19%" height="25" align="left" valign="middle" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_STUDENTID");?></th>
                          <th width="25%" height="25" align="left" valign="middle" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_MOBILENO");?>.</th>
                          <th width="25%" height="25" align="left" valign="middle" >&nbsp;&nbsp;<?php echo constant("RECEPTION_S_MANAGE_EMAILADDRESS");?></th>
                        </tr>
                        </thead>
                        <?php
						$j=1;
						$color2 = "#ECECFF";
						foreach($dbf->fetchOrder('sms_history_dtls',"parent_id='$val[id]' And student_id>'0'","id") as $valinv){
							
							//Get student name
							$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						?>
                        
                        <tr bgcolor="<?php echo $color2;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color2;?>'">
                         <td height="25" align="center" valign="middle">&nbsp;<?php echo $j;?></td>
                          <td height="25" align="left" valign="middle">&nbsp;<?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                          <td align="left" valign="middle">&nbsp;<?php echo $val_student[student_id];?></td>
                          <td align="left" valign="middle">&nbsp;<?php echo $val_student[student_mobile];?></td>
                          <td align="left" valign="middle">&nbsp;<?php echo $val_student[email];?>&nbsp;&nbsp;</td>
                        </tr>
                        <?php
						if($color2=="#ECECFF")
						  {
							  $color2 = "#FBFAFA";
						  }
						  else
						  {
							  $color2="#ECECFF";
						  }
						$j++;
                        }
                        ?>
                      </table>
                      <?php
						}
				}
				?></td>
                  </tr>
                  <?php
					}
					?>
                </table>
                <?php
				}
				else
				{
				?>
                <table width="90%" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("ADMIN_SMS_HISTORY_TEXT");?></td>
                  </tr>
                </table>                
				<?php
				}
				?>
                </td>
              </tr>
              <?php
			  $k++;
			  if($color1=="#ECECFF"){
				  $color1 = "#FBFAFA";
			  } else {
				  $color1="#ECECFF";
			  }
			  
			}
			?>
            </table>
            <?php if($num == 0){ ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="25" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
              </tr>
            </table>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
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
</body>
</html>
