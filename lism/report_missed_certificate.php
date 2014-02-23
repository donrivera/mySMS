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
        <?php
		
		//if($num > 0) {
		?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_missed_certificate_report_word.php?centre_id=<?php echo $_REQUEST["centre_id"];?>&teacher_id=<?php echo $_REQUEST["teacher_id"];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_missed_certificate_report_csv.php?centre_id=<?php echo $_REQUEST["centre_id"];?>&teacher_id=<?php echo $_REQUEST["teacher_id"];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_missed_certificate_report_pdf.php?centre_id=<?php echo $_REQUEST["centre_id"];?>&teacher_id=<?php echo $_REQUEST["teacher_id"];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_missed_certificate_report_print.php?centre_id=<?php echo $_REQUEST["centre_id"];?>&teacher_id=<?php echo $_REQUEST["teacher_id"];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
                <tr class="logintext">
                  <td width="39%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16">
				  <?php echo constant("ADMIN_MENU_REPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("LISM_MISSED_CERTIFICATE");?> </td>
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
                <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table1" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                     <th width="21%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_TEACHERNAME");?></th>
                      <th width="17%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_CENTRE_MANAGE_CENTRENAME");?></th>
                      <th width="12%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_GROUP_TO_FINISH_GROUPNAME");?></th>
                      <th width="15%" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_GROUP_GRADE_COURSENAME");?></th>
                      <th width="11%" align="center" valign="middle" class="pedtext"><?php echo constant("CD_REPORT_CD_GRAPHS_NOOFSTUDENT");?></th>
                      </tr>
                    </thead>
                    <?php
                        $i = 1;
                        $color="#ECECFF";
                        //echo "preport_filled='No' And centre_id='$_REQUEST[centre_id]' And teacher_id='$_REQUEST[teacher_id]'";                                     
                        //loop start
						$teacher_id=$_REQUEST['teacher_id'];
						$centre_id=$_REQUEST['centre_id'];
						$query=$dbf->genericQuery("SELECT sg.id , CEIL( sg.units / MAX( p.units ) *100 ) AS percentage
													FROM student_group sg
													INNER JOIN ped_units p ON p.group_id = sg.id
													WHERE sg.teacher_id =  '$teacher_id'
													AND centre_id =  '$centre_id'
													AND p.dated !=  ''");
						//echo var_dump($query);
						foreach($query as $q)
						{
							$percent=$q['percentage'];
							$group_id=$q['id'];
							$progress=$dbf->getDataFromTable("teacher_progress","id","group_id='$group_id'"); 
							if($percent>=50 && empty($progress))
							{
								$data=$dbf->genericQuery("SELECT sg.group_name, c.name AS course_name, t.name AS teacher_name, COUNT( sgrp.id ) AS total,ctr.name as centre_name
														FROM student_group sg
														INNER JOIN course c ON c.id = sg.course_id
														INNER JOIN centre ctr ON ctr.id=sg.centre_id
														INNER JOIN teacher t ON t.id = sg.teacher_id
														INNER JOIN student_group_dtls sgrp ON sgrp.parent_id = sg.id
														WHERE sg.id ='$group_id'");
								$num=count($data);
							}
							else
							{
								$check_progress=$dbf->getDataFromTable("teacher_progress","id","group_id='$group_id' AND certificate_print=''"); 
								if(!empty($check_proress))
								{
									$data=$dbf->genericQuery("SELECT sg.group_name, c.name AS course_name, t.name AS teacher_name, COUNT( sgrp.id ) AS total,ctr.name as centre_name
														FROM student_group sg
														INNER JOIN course c ON c.id = sg.course_id
														INNER JOIN centre ctr ON ctr.id=sg.centre_id
														INNER JOIN teacher t ON t.id = sg.teacher_id
														INNER JOIN student_group_dtls sgrp ON sgrp.parent_id = sg.id
														WHERE sg.id ='$group_id'");
									$num=count($data);
								}
								else{$num=0;}
							}
							#$num=$dbf->countRows('student_group',"preport_filled='No'");
							/*
							foreach($dbf->fetchOrder('student_group',"(preport_filled='' OR preport_filled='No') And centre_id='$_REQUEST[centre_id]' And teacher_id='$_REQUEST[teacher_id]'","id") as $val_leave) 
							{
								$teacher = $dbf->strRecordID("teacher","*","id='$val_leave[teacher_id]'");
								$centre = $dbf->strRecordID("centre","*","id='$val_leave[centre_id]'");
								$course = $dbf->strRecordID("course","*","id='$val_leave[course_id]'");
								$no_of_students = $dbf->countRows("student_group_dtls","parent_id='$val_leave[id]'");
							*/
							foreach($data as $row)
							{
					?>
								<tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
									<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $row[teacher_name];?></td>
									<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $row[centre_name];?></td>
									<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $dbf->FullGroupInfo($group_id);?></td>
									<td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $row[course_name];?></td>
									<td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $row[total];?></td>
								<?php
									$i = $i + 1;
									if($color=="#ECECFF"){$color = "#FBFAFA";}else{$color="#ECECFF";}					  
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
