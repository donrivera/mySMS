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

<!--*******************************************************************-->

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
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
          9: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
	});
	</script>
      <tr>
        <td align="left" height="25" valign="top">
        <?php //if($_REQUEST[centre_id] != '' && $_REQUEST[teacher_id] != '') { ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_missed_ped_report_word.php?centre_id=<?php echo $_REQUEST[centre_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_missed_ped_report_csv.php?centre_id=<?php echo $_REQUEST[centre_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_missed_ped_report_pdf.php?centre_id=<?php echo $_REQUEST[centre_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_missed_ped_report_print.php?centre_id=<?php echo $_REQUEST[centre_id];?>&teacher_id=<?php echo $_REQUEST[teacher_id];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
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
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("LISM_MISSED_EPED");?> </td>
                  <td width="8%" align="right" valign="middle" class="headingtext">&nbsp;</td>
                  <td width="13%" align="left">&nbsp;</td>
                  <td width="4%" align="center">&nbsp;</td>
                  <td width="26%" align="left">&nbsp;</td>
                  <td width="10%" align="left">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="25" colspan="8" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                    </tr>
                  <tr>
                    <td width="4%" align="right" valign="middle" class="mymenutext">&nbsp;</td>
                    <td width="8%" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> : &nbsp;</td>
                    <td width="14%" align="center" valign="middle" class="mymenutext"><select name="centre_id" id="centre_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:170px;">
                      <option value=""> Select Centre </option>
                      <?php
                        foreach($dbf->fetchOrder('centre',"","") as $valc) {
                      ?>
                      <option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["centre_id"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
                      <?php
                       }
                       ?>
                    </select></td>
                    <td width="9%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?> : &nbsp;</td>
                    <td width="17%" align="center" valign="middle">
                    <select name="teacher_id" id="teacher_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:170px;">
                      <option value=""> Select Teacher </option>
                      <?php
                        foreach($dbf->fetchOrder('teacher',"","") as $valc) {
                      ?>
                      <option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["teacher_id"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
                      <?php
                       }
                       ?>
                    </select></td>
                    <td width="9%" align="left" valign="middle" class="hometest_name"><input type="image" src="../images/searchButton.png" width="50" height="22"></td>
                    <td width="10%" align="left" valign="middle">&nbsp;</td>
                    <td width="29%" align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="5" colspan="8" align="left" valign="middle">&nbsp;</td>
                    </tr>
                </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="3%" height="30" align="center" valign="middle">&nbsp;</th>
                      <th width="9%" align="left" valign="middle" class="pedtext"><?php echo constant("LISM_DUE_DATE");?></th>
                      <th width="21%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
                      <th width="17%" height="30" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></th>
                      <th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME");?></th>
                      <th width="15%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></th>
                      <th width="11%" align="center" valign="middle" class="pedtext"><?php echo constant("CD_REPORT_CD_GRAPHS_NOOFSTUDENT");?></th>
                      <th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("LISM_UPDATE_DATE");?></th>
                      </tr>
                    </thead>
                    <?php
                        $i = 1;
                        $color="#ECECFF";
                        
                        //Get Number of Rows
                       $num=$dbf->countRows('ped_daily_status m,student_group g',"g.id=m.group_id And g.centre_id='$_REQUEST[centre_id]' And m.teacher_id='$_REQUEST[teacher_id]'");
                        
                        //loop start
                        foreach($dbf->fetchOrder('ped_daily_status m,student_group g',"g.id=m.group_id And g.centre_id='$_REQUEST[centre_id]' And m.teacher_id='$_REQUEST[teacher_id]'","","m.*") as $val_leave) {
							$group = $dbf->strRecordID("student_group","*","id='$val_leave[group_id]'");
                            $teacher = $dbf->strRecordID("teacher","*","id='$group[teacher_id]'");
							$centre = $dbf->strRecordID("centre","*","id='$group[centre_id]'");
							$course = $dbf->strRecordID("course","*","id='$group[course_id]'");
							$no_of_students = $dbf->countRows("student_group_dtls","parent_id='$group[id]'");
							$tdt = date('Y-m-d',strtotime(date("Y-m-d", strtotime($val_leave["dated"])) . "-2 day"));
                        ?>                    
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                      <td align="center" valign="middle" class="mycon">&nbsp;</td>
                      <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $tdt;?></td>
                      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $teacher[name];?></td>
                      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $centre[name];?></td>
                      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $dbf->FullGroupInfo($group["id"]);?></td>
                      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course[name];?></td>
                      <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $no_of_students;?></td>
                      <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val_leave[dated];?></td>
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
          <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
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
