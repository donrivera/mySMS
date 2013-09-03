<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="LIS Manager")
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

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->

<?php
//Get Number of Rows
$num=$dbf->countRows('teacher_vacation',"status='0'");
?>
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
        headers: {  
          9: { 
                sorter: false 
            },            
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
</script>
      <tr>
        <td align="left" height="25" valign="top">
        <?php //if($num > 0){ ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_outstanding_report_word.php"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_outstanding_report_csv.php"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_outstanding_report_pdf.php"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_outstanding_report_print.php" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
            </tr>
        </table>
        <?php //} ?>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    
    <form name="frm" id="frm" >
    <table width="99%" border="0" cellpadding="0" cellspacing="0">
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="39%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16">
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("LIS_OUT_APP");?> </td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="26%" align="left">&nbsp; </td>
                  <td width="10%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
              <thead>
                <tr class="logintext">
                  <th width="3%" height="30" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
                  <th width="10%" height="30" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVEFROM");?></th>
                  <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVETO");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("LIS_LEAVE_TYPE");?></th>
                  <th width="32%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                  <th width="10%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
														
					//loop start
					foreach($dbf->fetchOrder('teacher_vacation',"status='0'","frm") as $val_leave) {
						$teacher = $dbf->strRecordID("teacher","*","id='$val_leave[teacher_id]'")
					?>                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="center" valign="middle" class="mycon">&nbsp;</td>
                  <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $val_leave[frm];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $teacher[name];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[frm];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[tto];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[type];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"></td>
                  <td align="center" valign="middle" class="contenttext" style="padding-left:5px;"> - </td>
                  <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }					  
				  }
				  ?>
                </tr>
               
          </table>
            <br>
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			    <thead>
                <tr class="logintext">
                  <th width="3%" height="30" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_NEWS_MANAGE_DATE");?></th>
                  <th width="17%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
                  <th width="10%" height="30" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVEFROM");?></th>
                  <th width="9%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("STUDENT_LEAVE_MANAGE_LEAVETO");?></th>
                  <th width="10%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("LIS_LEAVE_TYPE");?></th>
                  <th width="34%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_COMMENTS");?></th>
                  <th width="8%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_ATTACH");?></th>
                  </tr>
				</thead>
                <?php
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					$num=$dbf->countRows('sick_leave',"");
					
					//loop start
					foreach($dbf->fetchOrder('sick_leave',"sick_status='0'","from_date") as $val_leave) {
						$teacher = $dbf->strRecordID("teacher","*","id='$val_leave[teacher_id]'")
					?>                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td align="center" valign="middle" class="mycon">&nbsp;</td>
                  <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $val_leave[from_date];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $teacher[name];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[from_date];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[to_date];?></td>
                  <td align="left" valign="middle" class="mycon"><?php echo constant("TEACHER_MANAGE_SICKLEAVE_SICKLV");?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave["sick_reason"];?></td>
                  <td align="left" valign="middle" class="contenttext" style="padding-left:5px;"><a href="../teacher/sickleave/<?php echo $val_leave[sick_attachment];?>" target="_blank" style="text-decoration:none;"> <?php echo $val_leave[sick_attachment];?></a></td>
                  <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }					  
				  }
				  ?>
                </tr>
               
            </table>
            </td>
          </tr>
		<?php				
            if($num <= 0){
            ?>
        <tr>
          <td height="25" colspan="9" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
        </tr>
        <?php
            }
            ?>		  
        </table></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>


</body>
</html>
