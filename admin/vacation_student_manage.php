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
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          5: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 0: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
<!--*******************************************************************-->

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
<?php 
if($_REQUEST['action']=='approve'){
	$string="status='0'";
	$dbf->updateTable("student_vacation",$string,"id='$_REQUEST[id]'");
	header("Location:vacation_student_manage.php?msg=open");
}

if($_REQUEST['action']=='unapprove'){
	$string="status='1'";
	$dbf->updateTable("student_vacation",$string,"id='$_REQUEST[id]'");
	header("Location:vacation_student_manage.php?msg=open");
}
?>
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("ADMIN_VACATION_STUDENT_MANAGE_REQVACATION");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" bgcolor="#FFFFFF">
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="000000"  class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                <th width="5%" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                <th width="7%" height="25" align="center" valign="middle" bgcolor="#99CC99" ><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></span></th>
				<th width="24%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_S2_NAME");?></th>
                <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_PASSWORD_CONTACTNO");?>.</th>
                <th width="42%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
                </tr>
			  </thead>
              <?php
					$i = 1;
					$color="#ECECFF";
					
					//Get number of rows
                    $num=$dbf->countRows('student_vacation',"","");
					
					//Loop start
					foreach($dbf->fetchOrder('student',"id in (select student_id from student_vacation)","id DESC","") as $val)
					{

				    //Get Student Detail
					$stud_info = $dbf->strRecordID("student","*","id='$val[student_id]'");
					$num_voc=$dbf->countRows('student_vacation',"student_id='$val[id]'","");
					?>
                    
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                <td align="center" valign="middle" class="contenttext">
                <a href="javascript:void(0);" onClick="show_details('<?php echo $val[id];?>');">
                    <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" ></span>
                    </a> 
                </td>
                <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                    
				<td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?><?php echo ' ['.$num_voc."]";?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;">
				<?php echo $val[student_mobile]."/".$val[alt_contact];?></td>
                <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[email];?></td>
                </tr>
                
              <tr style="display:none;" id="<?php echo $val[id];?>">
                <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"  style="background-color:<?php echo $color;?>;">&nbsp;</td>
                <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"  style="background-color:<?php echo $color;?>;">&nbsp;</td>
                <td height="25" colspan="5" align="left" valign="middle" style="padding-left:5px;background-color:<?php echo $color;?>;">
                
                    <table width="700" border="1" bordercolor="CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr class="amt_head">
                          <td width="9%" align="left" valign="middle" style="background-color:#DDDDDD;"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                          <td width="35%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("TEACHER_MANAGE_SICKLEAVE_FROMDT");?></td>
                          <td width="13%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("TEACHER_MANAGE_SICKLEAVE_TODT");?></td>
                          <td width="17%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("TEACHER_MANAGE_SICKLEAVE_REASON");?></td>
                          <td width="26%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("TEACHER_MANAGE_SICKLEAVE_STATUS");?></td>
                          </tr>
                          <?php
						  	$color1="#ECECFF";
							$j=1;
							foreach($dbf->fetchOrder('student_vacation',"student_id='$val[id]'","id") as $valinv)
							{
							?>
                            
                          <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                            <td align="left" valign="middle"><span class="contenttext"><?php echo $j;?></span></td>
                          <td height="25" align="left" valign="middle"><?php echo $valinv[frm];?></td>
                          <td align="left" valign="middle"><?php echo $valinv[tto];?></td>
                          <td align="left" valign="middle"><?php echo $valinv[reason];?></td>
                          <td align="left" valign="middle">
						   <?php if ($valinv[status]==1){?>
						    <a href="vacation_student_manage.php?action=approve&id=<?php echo $valinv[id];?>">
							Approved
							</a>
							<?php } else { ?>
							<a href="vacation_student_manage.php?action=unapprove&id=<?php echo $valinv[id];?>">
							Pending
							</a><?php } ?>
						  </td>
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
                
                </td>
                </tr>
              
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
					  
				  }
				  ?>
                  
            </table>
            
            
            </td>
          </tr>
		  <?php
					if($num!=0)
					{
					?>
             
          <tr>
              <td>
            
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="display:none;">
              <tr>
                <td width="76%" align="center">&nbsp;</td>
                <td width="24%" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
			   <?php
			   }
					if($num==0)
					{
					?>
              <tr>
                <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?> </td>
              </tr>
              <?php
					}
					?>
            
            </table>
            
            </td>
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
