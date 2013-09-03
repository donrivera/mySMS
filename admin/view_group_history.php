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

<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript">
function show_details(a){
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
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onload="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
                <td width="54%" height="30" class="logintext"><?php echo constant("ADMIN_VIEW_GROUP_HISTORY_VIEW_GROUP_HISTORY");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" >
            
            <table width="100%" border="1" bordercolor="#AAAAAA" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
            <?php 
			$k=1;
			$color="#ECECFF";
			
			foreach($dbf->fetchOrder('centre',"","","") as $val_centre)
			{
				//count No.Of Group
				$num_centre=$dbf->countRows('student_group_history',"centre_id='$val_centre[id]'");
				
				?>
                
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                <td width="38" align="center"><a href="javascript:void(0);" onclick="show_details1('<?php echo "m".$val_centre[id];?>');"><span id="plusArrow<?php echo "m".$val_centre[id];?>"><img src="../images/plus.gif" border="0" /></span></a></td>
                <td width="77" align="center" valign="middle" class="leftmenu"><?php echo $k; ?></td>
                <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;&nbsp;<?php echo $val_centre[name];?><?php if($num_centre!=0){echo " [".$num_centre."]"; }?></td>
              </tr>
              <tr style="display:none;" id="<?php echo "m".$val_centre[id];?>">
                <td width="38" align="center" bgcolor="#FFFFFF">&nbsp;</td>
                <td width="77" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-top:3px; padding-bottom:3px; padding-left:3px;">&nbsp;</td>
                <td width="848" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-top:3px; padding-bottom:3px; padding-left:3px;">
                <?php
				//Check exist				
				if($num_centre > 0)
				{
				?>
                <table width="99%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      <th width="5%" height="25" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                      <th width="12%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_HISTORY_GROUPNAME");?></th>
                      <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_HISTORY_NAMEOFTHE");?></th>
                      <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_HISTORY_DATEOF");?></th>
                      <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_HISTORY_ADDING");?></th>
                      <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_GROUP_HISTORY_TYPEOF");?></th>
                      <th width="15%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"></th>
                    </tr>
                  </thead>
                  <?php
					$i = 1;
					$color1 = "#ECECFF";
					//Loop start
					foreach($dbf->fetchOrder('student_group_history',"centre_id='$val_centre[id]'","","") as $val) {
					
					//Get the number of student in a group
			        $num_dtls=$dbf->countRows('student_group_history_dtls',"parent_id='$val[id]'");
					//Get group name
					$val_group = $dbf->strRecordID("student_group","*","id='$val[group_id]'");
					
					//Get group Type name
					$val_group_type = $dbf->strRecordID("common","*","id='$val[group_id]'");
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val_group[course_id]'");
					
					
					?>
                    
                  <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                    <td align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span></a></td>
                    <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i; ?></td>
                    <td width="12%" align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_group[group_name]." [".$num_dtls."]";?></td>
                    <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_course[name];?></td>
                    <td width="20%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo date('d, M,Y h:i:s A',strtotime($val[dated]));?></td>
                    <?php
				
				
				
				//Get user name
				$val_user = $dbf->strRecordID("user","*","id='$val[user_id]'");
				?>
                    <td width="20%" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val_user[user_name];?></td>
                    <?php
				if($val[type]=='0')
				{
					$file = "../images/add_small.png";
					$type = "Adding Student";
				}
				else
				{
					$file = "../images/remove_small.png";
					$type = "Removing Student";
				}
				?>
                    <td width="20%" height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $type;?></td>
                    <td width="15%" align="center" valign="middle" class="contenttext"><h5><img src="<?php echo $file;?>" title="<?php echo $type;?>"/></h5></td>

                  </tr>
                  <tr style="display:none;" id="<?php echo $val[id];?>">
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" colspan="6" align="left" valign="middle" bgcolor="#FFFFFF" style="padding-left:5px;padding-top:3px;padding-bottom:3px;"><?php if($num_dtls <=0 ) { ?>
                      <table width="700" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr>
                          <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("ADMIN_VIEW_GROUP_HISTORY_TEXT2");?></td>
                        </tr>
                      </table>
                      <?php
					    
                }
				
				else
				{
				?>
                      <table width="700" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                       <thead>
                        <tr class="pedtext">
                         <td width="10%" height="25" align="center" valign="middle" class="amt_head" style="background-color:#DDDDDD;"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                          <td width="26%" height="25" align="left" valign="middle" class="amt_head" style="background-color:#DDDDDD;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></td>
                          <td width="22%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
                          <td width="18%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></td>
                          <td width="24%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></td>
                        </tr>
                        </thead>
                        <?php
						$j=1;
						$color2="#ECECFF";
						foreach($dbf->fetchOrder('student_group_history_dtls',"parent_id='$val[id]'","id") as $valinv)
						{							
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
				?></td>
                  </tr>
                  <?php
				  $i = $i + 1;
					  if($color1=="#ECECFF")
					  {
						  $color1 = "#FBFAFA";
					  }
					  else
					  {
						  $color1="#ECECFF";
					  }
		
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
                    <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("ADMIN_VIEW_GROUP_HISTORY_TEXT");?></td>
                  </tr>
                </table>                
				<?php
				}
				?>
                </td>
              </tr>
              <?php
				$k++;
				if($color=="#ECECFF")
				  {
					  $color = "#FBFAFA";
				  }
				  else
				  {
					  $color="#ECECFF";
				  }
			
				}
			  ?>
              </table></td>
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
