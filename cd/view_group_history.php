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
<?php if($_SESSION[lang] == "EN"){ ?>
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
                <td width="54%" height="30" class="logintext"><?php echo constant("CD_VIEW_GROUP_HISTORY_VIEW_GROUP_HISTORY");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top">
            <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
              <thead>
                <tr class="logintext">
                  <th width="3%" align="center" valign="middle">&nbsp;</th>
                  <th width="4%" height="25" align="center" valign="middle"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></span></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#E6E6E6" class="pedtext"><span class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_GROUPNAME");?></span></th>
                  <th width="17%" align="left" valign="middle" class="pedtext"><span class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_NAMEOFTHE");?></span></th>
                  <th width="18%" align="left" valign="middle" class="pedtext"><span class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_DATEOF");?></span></th>
                  <th width="13%" align="left" valign="middle" class="pedtext"><span class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_GROUPST");?></span></th>
                  <th width="13%" align="left" valign="middle" class="pedtext"><span class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_GROUPEND");?></span></th>
                  <th width="14%" align="left" valign="middle" class="pedtext"><span class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_TYPEOF");?></span></th>
                  <th width="5%" align="center" valign="middle" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                  </tr>
              </thead>
              <?php
					$i = 1;
					$j=1;
					$color = "#ECECFF";

					//Get number of rows
                    $num=$dbf->countRows('student_group_history',"centre_id='$_SESSION[centre_id]'","");
					
					//Loop start
					foreach($dbf->fetchOrder('student_group_history',"centre_id='$_SESSION[centre_id]'","","") as $val){
					
					//Get group name
					$val_group = $dbf->strRecordID("student_group","*","id='$val[group_id]'");
					
					//Get group Type name
					$val_group_type = $dbf->strRecordID("common","*","id='$val[group_id]'");
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val_group[course_id]'");
					
					//Get the number of student in a group
			    	$num_dtls=$dbf->countRows('student_group_history_dtls',"parent_id='$val[id]'");

					?>
                    
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                <td width="3%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span> </a></td>
                <td width="4%" height="25" align="center" valign="middle" class="mycon"><?php echo $j; ?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_group[group_name]." [".$num_dtls."]";?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_course[name];?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d, M,Y h:i:s A',strtotime($val[dated]));?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d-M-Y',strtotime($val_group[start_date]));?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d-M-Y',strtotime($val_group[end_date]));?></td>
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
                <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $type;?></td>
                
                <td align="center" valign="middle" class="mycon"><img src="<?php echo $file;?>" title="<?php echo $type;?>"/></td>
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
                <td height="25" colspan="7" align="left" bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;padding-top:3px;padding-bottom:3px;"><?php if($num_dtls <=0 ) { ?>
                  <table width="700" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("CD_VIEW_GROUP_HISTORY_TEXT2");?></td>
                    </tr>
                  </table>
                  <?php
                }
				else
				{
				?>
                  <table width="700" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <tr class="amt_head">
                      <td width="7%" align="left" valign="middle" class="pedtext" style="background-color:#999;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                      <td width="30%" height="25" align="left" valign="middle" class="pedtext" style="background-color:#999;"><?php echo constant("CD_VIEW_GROUP_HISTORY_STDNM");?></td>
                      <td width="22%" height="25" align="left" valign="middle" class="pedtext" style="background-color:#999;">&nbsp;&nbsp;<?php echo constant("CD_VIEW_GROUP_HISTORY_STDID");?></td>
                      <td width="16%" height="25" align="left" valign="middle" class="pedtext" style="background-color:#999;">&nbsp;&nbsp;<?php echo constant("CD_VIEW_GROUP_HISTORY_MOBNO");?></td>
                      <td width="25%" height="25" align="left" valign="middle" class="pedtext" style="background-color:#999;">&nbsp;&nbsp;<?php echo constant("CD_VIEW_GROUP_HISTORY_EMAILADD");?></td>
                    </tr>
                    <?php
					$color1="#ECECFF";
					$k=1;
						foreach($dbf->fetchOrder('student_group_history_dtls',"parent_id='$val[id]'","id") as $valinv)
						{
							
							//Get student name
							$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						?>
                        
                    <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
                      <td align="left" valign="middle">&nbsp;&nbsp;<?php echo $k;?></td>
                      <td align="left" valign="middle">&nbsp;<a href="single-home.php?student_id=<?php echo $val_student[id];?>" style="cursor:pointer;"><?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></a></td>
                      <td align="left" valign="middle">&nbsp;<?php echo $val_student[student_id];?></td>
                      <td align="left" valign="middle">&nbsp;<?php echo $val_student[student_mobile];?></td>
                      <td align="left" valign="middle">&nbsp;<?php echo $val_student[email];?>&nbsp;&nbsp;</td>
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
					$k++;
                        }
                        ?>
                  </table>
                  <?php
				}
				?></td>
              </tr>
              <?php
			     $j++;
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
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        <table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="right" valign="middle" class="logintext"><?php echo constant("CD_VIEW_GROUP_HISTORY_VIEW_GROUP_HISTORY");?>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          <tr>
            <td height="450" align="left" valign="top">
              <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                <thead>
                  <tr class="logintext">
                  <th width="4%" align="center" valign="middle" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>                   
                    <th width="18%" align="right" valign="middle" class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_NAMEOFTHE");?>&nbsp;</th>
                    <th width="18%" align="right" valign="middle" class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_DATEOF");?>&nbsp;</th>
                    <th width="11%" align="right" valign="middle" class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_GROUPST");?>&nbsp;</th>
                    <th width="12%" align="right" valign="middle" class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_GROUPEND");?>&nbsp;</th>
                    <th width="13%" align="right" valign="middle" class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_TYPEOF");?>&nbsp;</th>
                     <th width="17%" align="right" valign="middle" bgcolor="#E6E6E6" class="pedtext"><?php echo constant("CD_VIEW_GROUP_HISTORY_GROUPNAME");?>&nbsp;</th>
                    <th width="4%" height="25" align="center" valign="middle"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?>&nbsp;</th>
                    <th width="3%" align="center" valign="middle">&nbsp;</th>
                    </tr>
                  </thead>
                <?php
					$i = 1;
					$j=1;
					$color = "#ECECFF";

					//Get number of rows
                    $num=$dbf->countRows('student_group_history',"centre_id='$_SESSION[centre_id]'","");
					
					//Loop start
					foreach($dbf->fetchOrder('student_group_history',"centre_id='$_SESSION[centre_id]'","","") as $val){
					
					//Get group name
					$val_group = $dbf->strRecordID("student_group","*","id='$val[group_id]'");
					
					//Get group Type name
					$val_group_type = $dbf->strRecordID("common","*","id='$val[group_id]'");
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val_group[course_id]'");
					
					//Get the number of student in a group
			    	$num_dtls=$dbf->countRows('student_group_history_dtls',"parent_id='$val[id]'");

					?>
                
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="center" valign="middle" class="mycon"><img src="<?php echo $file;?>" title="<?php echo $type;?>"/></td>
                  
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_course[name];?>&nbsp;</td>
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d, M,Y h:i:s A',strtotime($val[dated]));?>&nbsp;</td>
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d-M-Y',strtotime($val_group[start_date]));?>&nbsp;</td>
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date('d-M-Y',strtotime($val_group[end_date]));?>&nbsp;</td>
                  <?php
					if($val[type]=='0'){
						$file = "../images/add_small.png";
						$type = "Adding Student";
					}else{
						$file = "../images/remove_small.png";
						$type = "Removing Student";
					}
					?>
                  <td height="25" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $type;?>&nbsp;</td>                  
                  <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_group[group_name]." [".$num_dtls."]";?>&nbsp;</td>
                  <td width="4%" height="25" align="center" valign="middle" class="mycon"><?php echo $j; ?></td>
                  <td width="3%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onclick="show_details('<?php echo $val[id];?>');"> <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" /></span> </a></td>
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
                  
                  <td height="25" colspan="7" align="right" bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;padding-top:3px;padding-bottom:3px;"><?php if($num_dtls <=0 ) { ?>
                    <table width="700" border="1" bordercolor="#FF9900" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td height="25" align="center" valign="middle" class="nametext1" style="background-color:#FFF8F4;">&nbsp;&nbsp;<?php echo constant("CD_VIEW_GROUP_HISTORY_TEXT2");?></td>                        
                        </tr>
                      </table>
                    <?php
                }
				else
				{
				?>
                    <table width="700" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                      <tr class="amt_head">                       
                        
                        <td width="22%" height="25" align="right" valign="middle" class="pedtext" style="background-color:#999;"><?php echo constant("CD_VIEW_GROUP_HISTORY_STDID");?>&nbsp;</td>
                        <td width="16%" height="25" align="right" valign="middle" class="pedtext" style="background-color:#999;"><?php echo constant("CD_VIEW_GROUP_HISTORY_MOBNO");?>&nbsp;</td>
                        <td width="25%" height="25" align="right" valign="middle" class="pedtext" style="background-color:#999;"><?php echo constant("CD_VIEW_GROUP_HISTORY_EMAILADD");?>&nbsp;</td>
                        <td width="30%" height="25" align="right" valign="middle" class="pedtext" style="background-color:#999;"><?php echo constant("CD_VIEW_GROUP_HISTORY_STDNM");?>&nbsp;</td>
                        <td width="7%" align="left" valign="middle" class="pedtext" style="background-color:#CCC;"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?>&nbsp;</td>
                        </tr>
                      <?php
						$color1="#ECECFF";
						$k=1;
						foreach($dbf->fetchOrder('student_group_history_dtls',"parent_id='$val[id]'","id") as $valinv){						
							//Get student name
							$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
						?>
                      
                      <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'" style="cursor:pointer;">
                        <td align="right" valign="middle">&nbsp;<?php echo $val_student[student_id];?></td>
                        <td align="right" valign="middle">&nbsp;<?php echo $val_student[student_mobile];?></td>
                        <td align="right" valign="middle">&nbsp;<?php echo $val_student[email];?>&nbsp;&nbsp;</td>
                        <td height="25" align="right" valign="middle"><a href="single-home.php?student_id=<?php echo $val_student[id];?>" style="cursor:pointer;"><?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></a></td>
                        <td align="center" valign="middle">&nbsp;&nbsp;<?php echo $k;?></td>
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
					$k++;
                        }
                        ?>
                      </table>
                    <?php
				}
				?></td>
                <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                  </tr>
                <?php
			     $j++;
					}
					?>
                </table></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php } ?>
</body>
</html>
