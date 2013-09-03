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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

?>	
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


<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">

<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( "#start_date" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#end_date" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#end_date" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onClose: function( selectedDate ) {
			$( "#start_date" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>
<!--UI JQUERY DATE PICKER-->

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->

<!--*******************************************************************-->

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
      <script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          4: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            }, 
           
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_leave_report_word.php?teacher=<?php echo $_REQUEST[teacher];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_leave_report_csv.php?teacher=<?php echo $_REQUEST[teacher];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_leave_report_pdf.php?teacher=<?php echo $_REQUEST[teacher];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_leave_report_print.php?teacher=<?php echo $_REQUEST[teacher];?>&start_date=<?php echo $_REQUEST[start_date];?>&end_date=<?php echo $_REQUEST[end_date];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
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
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr class="logintext">
                <td width="20%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");?></td>
                <td width="9%" align="right" valign="middle" class="logintext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHER");?> : </td>
                <td width="16%" align="left">
                <select name="teacher" id="teacher" style="border:solid 1px; border-color:#FFCC33; height:20px; width:150px;" onChange="javascript:document.frm.action='report_teacher_leave_report.php',document.frm.submit();" >
                  <option value="">--Select Teacher--</option>
                  <?php
						foreach($dbf->fetchOrder('teacher',"","name") as $val) {	
					  ?>
                  <option value="<?php echo $val[id];?>" <?php if($_REQUEST[teacher]==$val[id]){?> selected="selected"<?php }?>><?php echo $val[name];?></option>
                  <?php
					   }
					   ?>
                </select></td>
                <td width="6%" align="right" class="logintext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?> : </td>
                <td width="9%" align="right">
                  <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $_REQUEST[start_date];?>" size="45" minlength="4"/>
                </td>
                <td width="3%" align="center" class="logintext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?> : </td>
                <td width="26%" align="left"><table width="250" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100" align="left" valign="middle"><input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $_REQUEST[end_date];?>" size="45" minlength="4"/></td>
                    <td width="120" align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1" border="0" align="left" /></td>
                  </tr>
                </table></td>
                <td width="11%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB"class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			      <thead>
                <tr class="logintext">
                  <th width="5%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="24%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERNAME");?></th>
                  <th width="24%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_STARTDATE");?></th>
                  <th width="30%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_ENDDATE");?></th>
                  <th width="32%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_GROUPAFFECTED");?></th>
                  </tr>
				  </thead>
                <?php
					if($_REQUEST[teacher]!='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
					{
					 $cond="teacher_id='$_REQUEST[teacher]' And (frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
					}
					else if($_REQUEST[teacher]=='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
					{
					 $cond="(frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
					}
					else if($_REQUEST[teacher]!='' && $_REQUEST[start_date]=='' && $_REQUEST[end_date]=='')
					{
					 $cond="teacher_id='$_REQUEST[teacher]'";
					}
					else
					{
					 $cond="";
					}
					$i = 1;
					$color="#ECECFF";
					
					$num=$dbf->countRows('teacher_vacation',$cond);
					
					foreach($dbf->fetchOrder('teacher_vacation',$cond,"id DESC") as $val) {
					
					$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
		
				?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $res[name];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[frm];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[tto];?></td>
				  <?php if($val[group_affect]==0)
					{
				   $affect='NO';
					 }
					else
					{
					$affect='YES';
					} 
					?>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $affect;?></td>
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
                </tr>
            </table></td>
          </tr>
          <?php
					if($num!=0)
					{
					?>
				 <tr>
                  <td height="25" colspan="9" align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
            </table></td>
                </tr>
                <? }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?
					}
					?>
		  
        </table>
		</form>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header_right.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_teacher_board_word.php"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="top"><a href="report_teacher_board_csv.php"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="30" align="center" valign="top"><a href="report_teacher_board_pdf.php"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_board_print.php" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
        
        <form name="frm" id="frm" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr class="logintext">
                <td width="15%" height="30" class="headingtext">&nbsp;</td>
                <td width="30%" align="right" valign="middle" class="headingtext"><table width="230" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100" align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn2" border="0" align="left" /></td>
                    <td width="120" align="left" valign="middle"><input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $_REQUEST[end_date];?>" size="45" minlength="4"/></td>
                  </tr>
                </table></td>
                <td width="3%" align="left">: <?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO");?></td>
                <td width="9%" align="right" class="headingtext"><input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $_REQUEST[start_date];?>" size="45" minlength="4"/></td>
                <td width="6%" align="left">: <?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM");?></td>
                <td width="15%" align="center"><select name="teacher" id="teacher" style="border:solid 1px; border-color:#FFCC33; height:20px; width:150px;" onChange="javascript:document.frm.action='report_teacher_leave_report.php',document.frm.submit();" >
                  <option value="">--Select Teacher--</option>
                  <?php
						foreach($dbf->fetchOrder('teacher',"","name") as $val) {	
					  ?>
                  <option value="<?php echo $val[id];?>" <?php if($_REQUEST[teacher]==$val[id]){?> selected="selected"<?php }?>><?php echo $val[name];?></option>
                  <?php
					   }
					   ?>
                </select></td>
                <td width="6%" align="left">: <?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHER");?></td>
                <td width="16%" align="right"><?php echo constant("ADMIN_MENU_REPORTS_TEACHER_LEAVE");?><img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERLEAVE");?><img src="../images/arrow_small_right2.png" width="16" height="16"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB"class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			      <thead>
                <tr class="logintext">           
                  <th width="27%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_GROUPAFFECTED");?></th>                  
                  <th width="26%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_ENDDATE");?></th>
                  <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_STARTDATE");?></th>
                  <th width="21%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERNAME");?></th>
                  <th width="6%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  </tr>
				  </thead>
                <?php
					if($_REQUEST[teacher]!='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
					{
					 $cond="teacher_id='$_REQUEST[teacher]' And (frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
					}
					else if($_REQUEST[teacher]=='' && $_REQUEST[start_date]!='' && $_REQUEST[end_date]!='')
					{
					 $cond="(frm <= '$_REQUEST[end_date]' And tto >= '$_REQUEST[start_date]')";
					}
					else if($_REQUEST[teacher]!='' && $_REQUEST[start_date]=='' && $_REQUEST[end_date]=='')
					{
					 $cond="teacher_id='$_REQUEST[teacher]'";
					}
					else
					{
					 $cond="";
					}
					$i = 1;
					$color="#ECECFF";
					
					$num=$dbf->countRows('teacher_vacation',$cond);
					
					foreach($dbf->fetchOrder('teacher_vacation',$cond,"id DESC") as $val) {
					
					$res = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
					if($val[group_affect]==0){
				   		$affect='NO';
					}else{
						$affect='YES';
					}
				?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $affect;?></td>
                  <td align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $val[tto];?></td>
                  <td align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $val[frm];?></td>
                  <td align="right" valign="middle" class="contenttext" style="padding-right:5px;"><?php echo $res[name];?></td>
                  <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
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
                </tr>
            </table></td>
          </tr>
          <?php
					if($num!=0)
					{
					?>
				 <tr>
                  <td height="25" colspan="9" align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
            </table></td>
                </tr>
                <? }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?
					}
					?>
		  
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
  <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
