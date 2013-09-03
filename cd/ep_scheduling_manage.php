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

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<?php if($_SESSION[lang]=="EN"){?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
		  0: {  sorter: false }, 
		  7: {  sorter: false },           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
<?php }else{?>
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
		  0: {  sorter: false }, 
		  7: {  sorter: false },           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
<?php } ?>
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
<?php if($_SESSION[lang]=="EN"){?>
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
            <td align="left" valign="middle" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr class="logintext">
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("CD_EP_SCHEDULING_MANAGE_HEADING");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="ep_schedulng_add.php"><input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  align="left" valign="top" bgcolor="#FFFFFF">
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="000000"  class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                <th width="5%" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                <th width="5%" height="25" align="center" valign="middle" bgcolor="#99CC99" ><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></span></th>
				<th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_COURSE_MANAGE_COURSENAME");?></th>
                <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_EP_SCHEDULING_MANAGE_SCHEDULEDATE");?></th>
                <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_EP_SCHEDULING_MANAGE_CLASSDATE");?></th>
                <th width="20%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_CLASSROOM");?></th>
                <th width="13%"colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("COMMON_ACTION");?></th>
              </tr>
			  </thead>
              <?php
					$i = 1;
					$color="#ECECFF";
					
					//Get number of rows
                    $num=$dbf->countRows('cd_makeup_class',"centre_id='$_SESSION[centre_id]'","");
										
					//Loop start
					foreach($dbf->fetchOrder('cd_makeup_class',"centre_id='$_SESSION[centre_id]'","id DESC","") as $val){

				    //Get group name
					$val_centre = $dbf->strRecordID("centre","*","id='$val[centre_id]'");
					
					//Get group name
					$val_group = $dbf->strRecordID("student_group","*","id='$val[group_id]'");
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
										
					//Get Classroom Number
					if($val["room_id"] > 0){
						$val_room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
						$room = $val_room["name"];			
					}else{
						$room = "";
					}
					//Get No. Of student 
					$num_std=$dbf->countRows('cd_makeup_class_dtls',"parent_id='$val[id]'","");
					?>
                    
              <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                <td width="5%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onClick="show_details('<?php echo $val[id];?>');">
                    <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" ></span>
                    </a></td>
                <td width="5%" height="25" align="center" valign="middle" class="mycon"><?php echo $i; ?></td>
				<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_group[group_name]." [".$num_std."]";?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_course[name];?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date("d/m/Y",strtotime($val[schedule_date]));?></td>
                <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date("d/m/Y",strtotime($val[dated]));?></td>
                <td width="20%" align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $room;?></td>
                <td width="13%" align="center" valign="middle"><a href="ep_scheduling_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onclick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png"width="16" height="16" border="0" title="Delete" /></a></td>
               
              </tr>
              <tr style="display:none;" id="<?php echo $val[id];?>">
                <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"  style="background-color:<?php echo $color;?>;">&nbsp;</td>
                <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"  style="background-color:<?php echo $color;?>;">&nbsp;</td>
                <td height="25" colspan="6" align="left" valign="middle" style="padding-left:5px;background-color:<?php echo $color;?>;">
                
                    <table width="700" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr class="amt_head">
                          <td width="8%" align="center" valign="middle" style="background-color:#DDDBE8;"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></span></td>
                          <td width="36%" height="25" align="left" valign="middle" style="background-color:#DDDBE8;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_STUDENTNAME");?></td>
                          <td width="13%" height="25" align="left" valign="middle" style="background-color:#DDDBE8;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
                          <td width="17%" height="25" align="left" valign="middle" style="background-color:#DDDBE8;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_MOBILENO");?></td>
                          <td width="26%" height="25" align="left" valign="middle" style="background-color:#DDDBE8;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></td>
                          </tr>
                          <?php
						  $k=1;
						  $color="#ECECFF";
							foreach($dbf->fetchOrder('cd_makeup_class_dtls',"parent_id='$val[id]'","id") as $valinv)
							{
								
								//Get student name
								$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
					
							?>
                          <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                            <td align="center" valign="middle"><?php echo $k; ?></td>
                          <td height="25" align="left" valign="middle"><?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                          <td align="left" valign="middle"><?php echo $val_student[student_id];?></td>
                          <td align="left" valign="middle"><?php echo $val_student[student_mobile];?></td>
                          <td align="left" valign="middle"><?php echo $val_student[email];?>&nbsp;&nbsp;</td>
                          </tr>
                        <?php
						$k++;
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
            
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
                <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
              </tr>
              <?php
					}
					?>
              <tr>
                <td>&nbsp;</td>
              </tr>
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
<?php } else {?>
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
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" valign="middle" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr class="logintext">
                      <td width="8%" align="left"><a href="ep_schedulng_add.php"><input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn2" border="0" align="left" /></a></td>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("CD_EP_SCHEDULING_MANAGE_HEADING");?></td>
                     </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td  align="left" valign="top" bgcolor="#FFFFFF">
                    <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="000000"  class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                      <thead>
                        <tr class="logintext">
                          <th width="11%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("COMMON_ACTION");?></th>   
                          <th width="12%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
                          <th width="16%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_COURSE_MANAGE_COURSENAME");?></th>
                          <th width="12%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("CD_EP_SCHEDULING_MANAGE_SCHEDULEDATE");?></th>
                          <th width="18%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("CD_EP_SCHEDULING_MANAGE_CLASSDATE");?></th>
                          <th width="22%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_CLASSROOM");?></th>
                          
                          <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99" style="padding-right:25px;"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></span></th>
                          <th width="5%" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                          </tr>
                        </thead>
                      <?php
					$i = 1;
					$color="#ECECFF";
					
					//Get number of rows
                    $num=$dbf->countRows('cd_makeup_class',"centre_id='$_SESSION[centre_id]'","");
										
					//Loop start
					foreach($dbf->fetchOrder('cd_makeup_class',"centre_id='$_SESSION[centre_id]'","id DESC","") as $val){

				    //Get group name
					$val_centre = $dbf->strRecordID("centre","*","id='$val[centre_id]'");
					
					//Get group name
					$val_group = $dbf->strRecordID("student_group","*","id='$val[group_id]'");
					
					//Get course name
					$val_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
										
					//Get Classroom Number
					if($val["room_id"] > 0){
						$val_room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");
						$room = $val_room["name"];			
					}else{
						$room = "";
					}
					
					//Get No. Of student 
					$num_std=$dbf->countRows('cd_makeup_class_dtls',"parent_id='$val[id]'","");
					?>
                      
                      <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                        <td width="11%" align="center" valign="middle"><a href="ep_scheduling_process.php?action=delete&amp;id=<?php echo $val[id];?>"  class="linktext" onclick="return confirm('Are you sure you want to delete this record ?')"><img src="../images/delete.png"width="16" height="16" border="0" title="Delete" /></a></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_group[group_name]." [".$num_std."]";?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_course[name];?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date("d/m/Y",strtotime($val[schedule_date]));?></td>
                        <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo date("d/m/Y",strtotime($val[dated]));?></td>
                        <td width="22%" align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $room;?></td>
                        
                        <td width="4%" height="25" align="center" valign="middle" class="mycon"><?php echo $i; ?></td>
                        <td width="5%" align="center" valign="middle" class="contenttext"><a href="javascript:void(0);" onClick="show_details('<?php echo $val[id];?>');">
                          <span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" ></span>
                          </a></td>
                        </tr>
                      <tr style="display:none;" id="<?php echo $val[id];?>">
                        
                        
                        <td height="25" colspan="6" align="right" valign="middle" style="padding-left:5px;background-color:<?php echo $color;?>;">
                          
                          <table width="700" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr class="amt_head">
                            <td width="26%" height="25" align="right" valign="middle" style="background-color:#DDDBE8;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_EMAILADDRESS");?></td>
                              <td width="36%" height="25" align="right" valign="middle" style="background-color:#DDDBE8;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_STUDENTNAME");?></td>
                              <td width="13%" height="25" align="right" valign="middle" style="background-color:#DDDBE8;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></td>
                              <td width="17%" height="25" align="right" valign="middle" style="background-color:#DDDBE8;">&nbsp;&nbsp;<?php echo constant("ADMIN_S_MANAGE_MOBILENO");?></td>       
                              <td width="8%" align="center" valign="middle" style="background-color:#DDDBE8;"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></span></td>

                              </tr>
                            <?php
						  $k=1;
						  $color="#ECECFF";
							foreach($dbf->fetchOrder('cd_makeup_class_dtls',"parent_id='$val[id]'","id") as $valinv)
							{
								
								//Get student name
								$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
					
							?>
                            <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'">
                              <td align="right" valign="middle"><?php echo $val_student[email];?>&nbsp;&nbsp;</td>
                              <td align="right" valign="middle"><?php echo $val_student[student_id];?></td>
                              <td align="right" valign="middle"><?php echo $val_student[student_mobile];?></td>
                              <td height="25" align="right" valign="middle"><?php echo $val_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                              <td align="center" valign="middle"><?php echo $k; ?></td>
                              </tr>
                            <?php
						$k++;
                        }
                        ?>
                            
                            </table>
                          
                          </td>
                          <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"  style="background-color:<?php echo $color;?>;">&nbsp;</td>
                          <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"  style="background-color:<?php echo $color;?>;">&nbsp;</td>
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
                    
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
                        <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                        </tr>
                      <?php
					}
					?>
                      <tr>
                        <td>&nbsp;</td>
                        </tr>
                      </table>
                    
                    </td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
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
