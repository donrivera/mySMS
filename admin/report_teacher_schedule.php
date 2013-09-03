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
<link href="css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[font]=='big')
{
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
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
         7: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },
			0: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 50});
	});
	</script>
<!--*******************************************************************-->

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
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_teacher_schedule_word.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_teacher_schedule_csv.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_teacher_schedule_pdf.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_schedule_print.php?teacher=<?php echo $_REQUEST[teacher];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="99%" border="0" cellpadding="0" cellspacing="0">
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
        <td width="79%" align="left" valign="top">
		<form name="frm" id="frm" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="35%" height="30" align="left" class="logintext"><img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS");?><img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?></td>
                  <td width="14%" align="right" class="logintext"><?php echo constant("ADMIN_REPORT_TEACHER_SCHEDULE_SELECTTEACHER");?> : </td>
                  <td width="35%" align="left">
				  <select name="teacher" id="teacher"  style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onChange="javascript:document.frm.action='report_teacher_schedule.php',document.frm.submit();">
                    <option value="">-- Select a Teacher --</option>
                    <?php
						foreach($dbf->fetchOrder('teacher',"","name") as $val1) {	
					  ?>
                    <option value="<?php echo $val1[id];?>" <?php if($_REQUEST[teacher]==$val1["id"]) { ?> selected="selected" <?php } ?>><?php echo $val1[name];?></option>
					
                    <?php
					   }
					   ?>
                  </select>				  </td>
                  <td width="8%" align="left">&nbsp; </td>
                  <td width="8%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="5%" align="left" valign="middle" bgcolor="#99CC99" class="menutext">&nbsp;</th>
                  <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                  <th width="19%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_CURRENTGROUP");?></th>
                  <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE");?></th>
                  <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_NUMBEROFSTUD");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_CLASSROOM");?></th>
                  </tr>
				</thead>
                <?php
					
					if($_REQUEST[teacher]!=''){
						$cond = "teacher_id='$_REQUEST[teacher]'";
					}else{
						$cond = "";
					}
					$i = 1;
					$k=1;
					$color="#ECECFF";
					
					$num1=$dbf->countRows('student_group',$cond);
					//echo $num1;exit;
					if($num1!=0){
						foreach($dbf->fetchOrder('student_group',$cond,"id DESC") as $val) {
						
							$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
							$grp = $dbf->strRecordID("common","*","id='$val[group_id]'");
							$std = $dbf->strRecordID("student_group_dtls","COUNT(student_id)","parent_id='$val[id]'");
							$room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");					
					?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><a href="javascript:void(0);" onClick="show_details('<?php echo $val[id];?>');"><span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" ></span></a></td>
                  
                  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $k; ?></td>
                  <td height="25" align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[group_name];?> <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[start_date];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[end_date];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $std["COUNT(student_id)"];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $room["name"];?></td>
                  
                </tr>
                <tr style="display:none;" id="<?php echo $val[id];?>">
                  <td height="25" colspan="7" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:35px;">
                  
                  	<table width="700" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr class="leftmenu">
                          <td width="9%" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                          <td width="41%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME");?></td>
                          <td width="9%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTID");?></td>
                          <td width="16%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?></td>
                          <td width="25%" height="25" align="left" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_EMAILADDRESS");?></td>
                          </tr>
                          <?php
						  	$color1="#ECECFF";
						    $j=1;
							foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$val[id]'","id") as $valinv){
								
								//Get student name
								$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
					
							?>
                          <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                            <td align="center" valign="middle"><?php echo $j; ?></td>
                          <td height="25" align="left" valign="middle"><?php echo $val_student[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                          <td align="left" valign="middle"><?php echo $val_student[student_id];?></td>
                          <td align="left" valign="middle"><?php echo $val_student[student_mobile];?></td>
                          <td align="left" valign="middle"><?php echo $val_student[email];?>&nbsp;&nbsp;</td>
                          </tr>
                        <?php
						if($color1=="#ECECFF"){
							  $color1 = "#FBFAFA";
						  }else{
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
				  $k++;
				  if($color=="#ECECFF"){
					  $color = "#FBFAFA";
				  }else{
					  $color="#ECECFF";
				  }  
				}					  
              }
            ?>
            </table></td>
          </tr>
		  <?php
		  if($num1!=0)
			{
			?>
		  <tr>
              <td height="25" colspan="9" align="center" valign="middle">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="display:none;">
                  <tr>
                    <td width="76%" height="25" align="center">&nbsp;</td>
                    <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                      <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                      <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                      <select name="select" class="pagesize">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option  value="50" selected="selected">50</option>
                      </select>
                    </div></td>
                  </tr>
                </table>
             </td>
          </tr>
		   <?php
			}
			if($num1==0)
			{
			?>
				
			<tr>
			  <td height="25" colspan="8" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
			</tr>
			<?php
			}					
			?>
        </table>
	   </form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header_right.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_teacher_schedule_word.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_teacher_schedule_csv.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_teacher_schedule_pdf.php?teacher=<?php echo $_REQUEST[teacher];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_schedule_print.php?teacher=<?php echo $_REQUEST[teacher];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
        
        <form name="frm" id="frm" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
                <table width="100%" border="0" cellspacing="0">
                  <tr class="logintext">
                    <td width="15%" align="left">&nbsp;</td>
                    <td width="12%" align="right" class="headingtext">&nbsp;</td>
                    <td width="24%" align="right" valign="middle">
                      <select name="teacher" id="teacher"  style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onChange="javascript:document.frm.action='report_teacher_schedule.php',document.frm.submit();">
                        <option value="">-- Select a Teacher --</option>
                        <?php
						foreach($dbf->fetchOrder('teacher',"","name") as $val1) {	
					  ?>
                        <option value="<?php echo $val1[id];?>" <?php if($_REQUEST[teacher]==$val1["id"]) { ?> selected="selected" <?php } ?>><?php echo $val1[name];?></option>
                        
                        <?php
					   }
					   ?>
                        </select>				  </td>
                    <td width="16%" align="left"><?php echo constant("ADMIN_REPORT_TEACHER_SCHEDULE_SELECTTEACHER");?></td>
                    <td width="33%" height="30" align="right" class="headingtext"><img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_SCHEDULE");?><img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_SCHEDULE_TEACHERSSCHEDULE");?></td>
                    
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">                                          
                      
                  <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPSTARTDATE");?></th>
                  <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_GROUPENDDATE");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_NUMBEROFSTUD");?></th>
                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_CLASSROOM");?></th>
                                            
                      <th width="19%" height="25" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_CURRENTGROUP");?></th>
                      <th width="7%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                      <th width="5%" align="left" valign="middle" bgcolor="#99CC99" class="menutext">&nbsp;</th>
                      </tr>
                    </thead>
                  <?php					
					if($_REQUEST[teacher]!=''){
						$cond = "teacher_id='$_REQUEST[teacher]'";
					}else{
						$cond = "";
					}
					$i = 1;
					$k=1;
					$color="#ECECFF";
					
					$num1=$dbf->countRows('student_group',$cond);
					//echo $num1;exit;
					if($num1!=0){
						foreach($dbf->fetchOrder('student_group',$cond,"id DESC") as $val) {
						
							$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
							$grp = $dbf->strRecordID("common","*","id='$val[group_id]'");
							$std = $dbf->strRecordID("student_group_dtls","COUNT(student_id)","parent_id='$val[id]'");
							$room = $dbf->strRecordID("centre_room","*","id='$val[room_id]'");					
					?>
                  
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                                        
                    <td align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $val[start_date];?></td>
                    <td align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $val[end_date];?></td>
                    <td align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $std["COUNT(student_id)"];?></td>
                    <td align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $room["name"];?></td>
                    
                    <td height="25" align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $val[group_name];?> <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></td>
                    <td align="center" valign="middle" class="contenttext" ><?php echo $k; ?></td>
                    <td align="center" valign="middle" class="contenttext" ><a href="javascript:void(0);" onClick="show_details('<?php echo $val[id];?>');"><span id="plusArrow<?php echo $val[id];?>"><img src="../images/plus.gif" border="0" ></span></a></td>
                    </tr>
                  <tr style="display:none;" id="<?php echo $val[id];?>">
                    <td height="25" colspan="7" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:35px;">
                      
                      <table width="700" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                        <tr class="leftmenu">                          
                          <td width="25%" height="25" align="right" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_EMAILADDRESS");?></td>
                          <td width="16%" height="25" align="right" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?></td>
                          
                          <td width="9%" height="25" align="right" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTID");?></td>
                          <td width="41%" height="25" align="right" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME");?></td>
                          <td width="9%" align="center" valign="middle" style="background-color:#DDDDDD;">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                          </tr>
                        <?php
						  	$color1="#ECECFF";
						    $j=1;
							foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$val[id]'","id") as $valinv){
								
								//Get student name
								$val_student = $dbf->strRecordID("student","*","id='$valinv[student_id]'");
					
							?>
                        <tr bgcolor="<?php echo $color1;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color1;?>'">
                          <td align="right" valign="middle"><?php echo $val_student[email];?>&nbsp;&nbsp;</td>                          
                          <td align="right" valign="middle"><?php echo $val_student[student_mobile];?></td>
                          <td align="right" valign="middle"><?php echo $val_student[student_id];?></td>
                          <td height="25" align="right" valign="middle"><?php echo $val_student[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val_student["id"]));?></td>
                          <td align="center" valign="middle"><?php echo $j; ?></td>
                          </tr>
                        <?php
						if($color1=="#ECECFF"){
							  $color1 = "#FBFAFA";
						  }else{
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
                          $k++;
                          if($color=="#ECECFF"){
                              $color = "#FBFAFA";
                          }else{
                              $color="#ECECFF";
                          }  
                    }					  
              }
            ?>
                  </table></td>
                </tr>
              <?php
		  if($num1!=0)
			{
			?>
              <tr>
                <td height="25" colspan="9" align="center" valign="middle">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="display:none;">
                    <tr>
                      <td width="76%" height="25" align="center">&nbsp;</td>
                      <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                        <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                        <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                        <select name="select" class="pagesize">
                          <option value="10">10</option>
                          <option value="25">25</option>
                          <option  value="50" selected="selected">50</option>
                          </select>
                        </div></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              <?php
				}
				if($num1==0)
				{
				?>              
              <tr>
                <td height="25" colspan="8" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
              <?php
					}					
					?>
              </table>
          </form>
          
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
  <?php include '../footer.php';?>
</table>
<?php } ?>
</body>
</html>
