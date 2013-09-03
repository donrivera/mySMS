<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

$teacher_id = $_SESSION[uid];

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

if($_REQUEST[action]=='delete'){
	
	$res_sick = $dbf->strRecordID("sick_leave","*","id='$_REQUEST[id]' and teacher_id='$teacher_id'");
	$path="sickleave/".$res_sick[sick_attachment];
	
	if($res_sick[sick_attachment] != ''){
		unlink($path);
	}
	$dbf->deleteFromTable("sick_leave","id='$_REQUEST[id]'");
}
?>	

<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
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
<link rel="stylesheet" href="../datepicker/jquery.ui.all.css">
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script src="../datepicker/jquery.ui.core.js"></script>
<script src="../datepicker/jquery.ui.widget.js"></script>
<script src="../datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="../datepicker/demos.css">

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

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen"/>
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
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
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <?php if($_SESSION[lang]=="EN"){?>
	<script type="text/javascript">
        $(function() {
            $("#sort_table")
                .tablesorter({ 
            headers: { 
              6: { 
                    sorter: false 
                },            
            } 
        })			
        .tablesorterPager({container: $("#pager"), size: 10});
        });
    </script>
    <?php }else{ ?>
    <script type="text/javascript">
        $(function() {
            $("#sort_table")
                .tablesorter({ 
            headers: { 
              0: { 
                    sorter: false 
                },            
            } 
        })			
        .tablesorterPager({container: $("#pager"), size: 10});
        });
    </script>
    <?php }?>
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#000000" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr class="logintext">
                <td width="39%" height="30" align="left" class="logintext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_MANAGE_SICKLEAVE");?></td>
                <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                <td width="13%" align="left">&nbsp;</td>
                <td width="4%" align="center">&nbsp;</td>
                <td width="26%" align="left"></td>
                <td width="10%" align="left"><a href="sick_leave.php"> 
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top">
            <form name="frm" id="frm" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0"  bordercolor="#000000" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                <th width="3%" height="25" align="center" valign="middle">&nbsp;</th>
                <th width="5%" align="left" valign="middle" class="pedtext" >From :</th>
                <?php if($_REQUEST[start_date]!=''){
					$start_date = $_REQUEST[start_date];
				}else{
					$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
				}
				?>
				<th width="12%" align="left" valign="middle" class="pedtext" >
                <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/></th>
				 <th width="4%" align="left" valign="middle" class="pedtext" >To :</th>
                 <?php if($_REQUEST[end_date]!=''){
					$end_date = $_REQUEST[end_date];
				}else{
					$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
				}
				?>
                 <th width="10%" align="left" valign="middle" class="pedtext" >                 
                 <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/>
                 </th>
                 <th width="66%" colspan="3" align="left" valign="middle" class="pedtext" ><input type="image" src="../images/searchButton.png" width="50" height="22" /></th>
              </tr>
			  </thead>
              
            </table>
            </form>
            <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
                
				<thead>
				<tr class="logintext">
                  <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_FROMDT");?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_TODT");?></th>
                  <th width="31%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_REASON");?></th>
                  <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?></th>
                  <th width="13%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_STATUS");?></th>
                 <th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                </tr>
				</thead>
				
                <?php
					$i = 1;
					$color = "#ECECFF";
					$cond = '';
					if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != ''){
						$cond = "(from_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
					}else{
						$cond = "(from_date BETWEEN '$start_date' And '$end_date')";
					}
					
					$num=$dbf->countRows('sick_leave', $cond);
					foreach($dbf->fetchOrder('sick_leave',"teacher_id='$teacher_id' And ".$cond,"id") as $val) {
					
					if($val[sick_status]== '0'){
						$status='Pending';
					}elseif($val[sick_status]== '1'){
						$status='Approved';
					}else{
						$status='Rejected';
					}
				?>	
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='sick_leave.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                
                  <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[from_date];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[to_date];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[sick_reason];?></td>
                  
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;">
				  <a href="sickleave/<?php echo $val[sick_attachment];?>" target="_blank" style="text-decoration:none;background-color:<?php echo $color;?>"> <?php echo $val[sick_attachment];?></a></td>
                  
                  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $status;?></td>                  
                  <td width="5%" align="center" valign="middle" class="contenttext" style="padding-left:5px;">
				  <a href="sick_leave.php?id=<?php echo $val[id];?>">
                  <?php
				  if($val[sick_status] <=0 ){?>
                  <img src="../images/edit.gif" name="edit" id="edit" title="Edit" border="0"/>
                  <?php } ?>
                  </a></td>                  
				  <td width="5%" align="center" valign="middle" class="contenttext" style="padding-left:5px;">
				 <a href="manage_sick_leave.php?action=delete&id=<?php echo $val[id];?>" onClick="return confirm('Are you sure to delete this Record?')" >
                 <?php
				  if($val[sick_status] <=0 ){ ?>
                 <img src="../images/delete.png" name="delete" id="delete" title="Delete" border="0"/>
                 <?php } ?>
                 </a></td>
                 
                </tr>
                <?php
					$i = $i + 1;
					if($color=="#ECECFF"){
						$color = "#FBFAFA";
					}else{
						$color="#ECECFF";
					}
				}
				?>
            </table></td>
          </tr>
          <tr>
            <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="75%" height="25" align="center">&nbsp;</td>
                <td width="25%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                        <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#999999;"/>
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
          <?php
			if($num==0){
			?>
			<tr>
			  <td height="25" colspan="10" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
			</tr>
			<?php } ?>
        </table>
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
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#000000" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr class="logintext">
                <td width="39%" height="30" align="left"><a href="sick_leave.php"> 
                  <input type="button" value="<?php echo constant("btn_add_btn");?>" class="btn2" border="0" align="left" /></a></td>
                <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                <td width="13%" align="left">&nbsp;</td>
                <td width="4%" align="center">&nbsp;</td>
                <td width="26%" align="left"></td>
                <td width="10%" align="right" class="logintext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_MANAGE_SICKLEAVE");?></td>
              </tr>
            </table></td>
          </tr>
          <?php if($_REQUEST[start_date]!=''){
				$start_date = $_REQUEST[start_date];
			}else{
				$start_date = $dbf->MonthFirstDay(date('m'),date('Y'));
			}
			if($_REQUEST[end_date]!=''){
				$end_date = $_REQUEST[end_date];
			}else{
				$end_date = $dbf->MonthLastDay(date('m'),date('Y'));
			}
			?>
          <tr>
            <td align="left" valign="top">
            <form name="frm" id="frm" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0"  bordercolor="#000000" style="border-collapse:collapse;">
			<thead>
              <tr class="logintext">
                
                <th width="66%" colspan="3" align="right" valign="middle" class="pedtext" >
                <input type="image" src="../images/searchButtonar.png" width="50" height="22" /></th>                
                <th width="10%" align="right" valign="middle" class="pedtext" >                 
                <input name="end_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="end_date" value="<?php echo $end_date;?>"/>
                </th>
                <th width="4%" align="left" valign="middle" class="pedtext" >: <?php echo constant('ADMIN_REPORT_TEACHER_LEAVE_REPORT_TO');?></th>
                <th width="12%" align="right" valign="middle" class="pedtext" >
                <input name="start_date" readonly="" type="text" class="datepick validate[required] new_textbox80" id="start_date" value="<?php echo $start_date;?>"/>
                </th>
                <th width="5%" align="left" valign="middle" class="pedtext" >: <?php echo constant('ADMIN_REPORT_TEACHER_LEAVE_REPORT_FROM');?></th>
                <th width="3%" height="25" align="center" valign="middle">&nbsp;</th>
              </tr>
			  </thead>
              
            </table>
            </form>
            <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
                
				<thead>
				<tr class="logintext">
                  <th colspan="2" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("COMMON_ACTION");?></th>
                  <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_FROMDT");?></th>
                  <th width="12%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_TODT");?></th>
                  <th width="31%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_REASON");?></th>
                  <th width="19%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?></th>
                  <th width="13%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_STATUS");?></th>
                 
                 <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                </tr>
				</thead>
				
                <?php
					$i = 1;
					$color = "#ECECFF";
					$cond = '';
					if($_REQUEST[start_date] != '' && $_REQUEST[end_date] != ''){
						$cond = "(from_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
					}else{
						$cond = "(from_date BETWEEN '$start_date' And '$end_date')";
					}
					
					$num=$dbf->countRows('sick_leave', $cond);
					foreach($dbf->fetchOrder('sick_leave',"teacher_id='$teacher_id' And ".$cond,"id") as $val) {
					
					if($val[sick_status]== '0'){
						$status='Pending';
					}elseif($val[sick_status]== '1'){
						$status='Approved';
					}else{
						$status='Rejected';
					}
				?>	
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" onClick="javascript:window.location.href='sick_leave.php?id=<?php echo $val[id];?>'" style="cursor:pointer;">
                <td width="5%" align="center" valign="middle" class="contenttext" style="padding-left:5px;">
				  <a href="sick_leave.php?id=<?php echo $val[id];?>">
                  <?php
				  if($val[sick_status] <=0 ){?>
                  <img src="../images/edit.gif" name="edit" id="edit" title="Edit" border="0"/>
                  <?php } ?>
                  </a></td>                  
				  <td width="5%" align="center" valign="middle" class="contenttext" style="padding-left:5px;">
				 <a href="manage_sick_leave.php?action=delete&id=<?php echo $val[id];?>" onClick="return confirm('Are you sure to delete this Record?')" >
                 <?php
				  if($val[sick_status] <=0 ){ ?>
                 <img src="../images/delete.png" name="delete" id="delete" title="Delete" border="0"/>
                 <?php } ?>
                 </a></td>
                  
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[from_date];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[to_date];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $val[sick_reason];?></td>
                  
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;">
				  <a href="sickleave/<?php echo $val[sick_attachment];?>" target="_blank" style="text-decoration:none;background-color:<?php echo $color;?>"> <?php echo $val[sick_attachment];?></a></td>
                  
                  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"><?php echo $status;?></td>                  
                  
                 <td height="25" align="center" valign="middle" class="contenttext"><?php echo $i;?></td>
                </tr>
                <?php
					$i = $i + 1;
					if($color=="#ECECFF"){
						$color = "#FBFAFA";
					}else{
						$color="#ECECFF";
					}
				}
				?>
            </table></td>
          </tr>
          <tr>
            <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="75%" height="25" align="center">&nbsp;</td>
                <td width="25%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                        <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#999999;"/>
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
          <?php
			if($num==0){
			?>
			<tr>
			  <td height="25" colspan="10" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
			</tr>
			<?php } ?>
        </table></td>
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