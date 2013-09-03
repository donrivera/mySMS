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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$res_ped = $dbf->strRecordID("ped","*","group_id='$_REQUEST[cmbgroup]'");

$teacher_id = $res_ped[teacher_id];

$month = date("m");
$year = date("Y");
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

<script type="text/javascript">
function setsubmit(){
	var cmbgroup = document.getElementById('cmbgroup').value;
	var mystatus = document.getElementById('mystatus').value;
	
	document.location.href='ped.php?cmbgroup='+cmbgroup+'&mystatus='+mystatus;
}

$(document).ready(function(){
	$("#mystatus").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("ped_group.php", {status: $(this).val()}); // Page Name and Condition
	});
});
</script>
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
<?php if($_SESSION[lang] == "EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
        
        
        <form action="ped_process.php?action=insert" name="frm1" method="post" id="frm1">
          <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#CC9900;">
            <tr>
              <td width="17%" height="30">&nbsp;</td>
              <td width="61%" align="center">
                </td>
              <td width="22%" align="center">
                <?php //if($_REQUEST[cmbgroup]!='') { ?>
                <table width="50%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="36" align="center" valign="middle"><a href="ped_word.php?cmbgroup=<?php echo $_REQUEST[cmbgroup];?>&mystatus=<?php echo $_REQUEST['mystatus'];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
                    <td width="36" align="center" valign="middle"><a href="ped_print.php?cmbgroup=<?php echo $_REQUEST[cmbgroup];?>&mystatus=<?php echo $_REQUEST['mystatus'];?>" target="_blank">                  
                      <img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
                    </tr>
                  </table>
                <?php //} ?>
                </td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top" style="padding-left:5px;">
                
                <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
                  <tr>
                    <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext">Status :</td>
                    <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading">
                      <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                        <option value="">All</option>
                        <option value="Not Started" <?php if($_REQUEST['mystatus']=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
                        <option value="Continue" <?php if($_REQUEST['mystatus']=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
                        <option value="Completed" <?php if($_REQUEST['mystatus']=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
                        </select>
                      </td>
                    </tr>
                  <tr>
                    <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?>:</td>
                    <td width="72%" align="left" valign="middle" bgcolor="#FFCB7D" class="heading" id="statusresult">
                      <select name="cmbgroup" id="cmbgroup" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
                        <option value="">Select Group</option>
                        <?php
						if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
						foreach($dbf->fetchOrder('student_group', $cond,"","") as $res_group) {
						?>
                        <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[cmbgroup]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
                        <?php
						  }
						  ?>
                        </select>
                      </td>
                    </tr>
                  <tr>
                    <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?>:</td>
                    <?php
					  //Get course name
					  $course = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
					  $course_name = $dbf->strRecordID("course","*","id='$course[course_id]'");
					  $teacher_name = $dbf->getDataFromTable("teacher", "name" , "id='$course[teacher_id]'");
					  ?>                      
                    <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading"><?php echo $course_name[name];?></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext">Teacher:</td>
                    <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading"><?php echo $teacher_name;?></td>
                    </tr>
                  <tr>
                    <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                  </table>
                
                </td>
              <td align="center" valign="middle" class="heading"><img src="../logo/logo.png" width="215" height="62"></td>
            </tr>
            <tr>
              <td colspan="2" align="right" valign="top" class="loginheading"><span class="heading"><?php echo constant("STUDENT_ADVISOR_PED_PEDAGOCARD");?></span></td>
              <td align="center" valign="middle" class="heading">&nbsp;</td>
            </tr>
            <?php
			  $res_teacher_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
			  $res_size = $dbf->strRecordID("group_size","*","group_id='$course[group_id]'");
			  $res_group_name = $dbf->strRecordID("common","*","id='$course[group_id]'");
			  $res_cource_name = $dbf->strRecordID("course","*","id='$course[group_id]'");
			  
			  $teacher_id = $res_teacher_group[teacher_id];
			  
			  $unit = $res_size["units"];			  
			?>
            <tr>
              <td colspan="3" align="left" valign="top">
                
                <table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bgcolor="#FFFFFF">
                  <?php
                  //===================================================
                  // Get Number of Students in a Group
                  //===================================================	
    
                  $no_student = 0;
                  $sa_name = '';
				  $prev_sa = '';
				  $no_student = 0;
				  $no_student = $dbf->countRows('student_group_dtls',"parent_id='$_REQUEST[cmbgroup]'");
                  foreach($dbf->fetchOrder('student_group',"id='$_REQUEST[cmbgroup]'","","") as $res_group)
                  {
						$res_sa_name = $dbf->strRecordID("user","*","id='$res_group[sa_id]'");
						if($sa_name == '')
						{
							$sa_name = $res_sa_name["user_name"];
							$prev_sa = $sa_name;
						}
						else
						{
							if($prev_sa != $res_sa_name["user_name"])
							{
								$sa_name = $sa_name.",".$res_sa_name["user_name"];
							}
						}
                  }
                  //======================================================                  
                  
                  ?>
                  <tr>
                    <td width="35%" height="25" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_UNITS");?> : <?php echo $res_size[units];?></td>
                    <td width="65%" align="left" valign="middle" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?> : <?php echo $res_group_name[name];?></td>
                    </tr>
                  <tr>
                  <?php
				  if($res_ped["estart_date"] != "0000-00-00")
				  {
				  	$est = $res_ped["estart_date"];
				  }
				  ?>
                    <td height="30" align="left" valign="middle" class="pedtext"> <?php echo constant("STUDENT_ADVISOR_PED_STARTING");?> : 
                      <?php echo $est;?>
                    </td>
                    <td align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_BLGOAL");?> :
                      <?php echo $res_ped["bl"];?>
                    </td>
                    </tr>
                  <tr>
                   <?php
                    $level = $res_ped["level"];					
					?>
                    <td height="25" align="left" valign="middle">
					<table width="400" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="97" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_MATERIALS");?> :</td>
					    <td width="303" align="left" valign="middle">
                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
					      <?php
						  $chk_list = explode(",",$res_ped["material"]);                          
						  foreach($dbf->fetchOrder('common',"type='material type'","") as $valmate){
							  $chk = in_array($valmate["id"],$chk_list);
						  ?>
                          <tr>                          
					        <td align="left" valign="top" class="mycon"><input type="checkbox" name="mate[]" id="mate[]" value="<?php echo $valmate[id];?>" <?php if($chk == 1) { ?> checked="checked" <?php } ?>>&nbsp;<?php echo $valmate[name];?></td>
							
					        </tr>
                            <?php
							}
							?>
					      </table>
                          
                          </td>
					    </tr>
					  </table></td>
                   
                    <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="pedtext">
                        <td width="54%" height="25" align="left" valign="middle" style="border-right:solid 1px;"><strong class="pedtext" >
						<?php echo constant("STUDENT_ADVISOR_PED_PROGREPORT");?> : </strong>
                        <?php if($res_ped[pro_report]=="1") { echo "Yes"; } ?>
                        <?php if($res_ped[pro_report]=="2") { echo "No";} ?>
                        </td>
                        <td width="46%" align="left" valign="top" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_LEVELCK");?> :
                          <input type="radio" name="level" id="level" value="Yes" <?php if($level == "Yes") { ?> checked="checked" <?php } ?>>
                          <?php echo constant("STUDENT_ADVISOR_PED_YES");?>
                          <input type="radio" name="level" id="level" value="No" <?php if($level == "No") { ?> checked="checked" <?php } ?>>
                          <?php echo constant("STUDENT_ADVISOR_PED_NO");?></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_STARTDT");?> : <?php echo $res_teacher_group[start_date];?></td>
                    <td align="left" valign="middle" class="pedtext"><strong><?php echo constant("STUDENT_ADVISOR_PED_TMDAY");?>:
                      <?php
					  if($_REQUEST[cmbgroup] != '')
					  {
						$dt = date("Y-m-d",strtotime($res_teacher_group[start_date]));
						echo $dt = $dt." - ".$res_teacher_group[group_time];
					  }
					?>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php
					if($res_teacher_group[week_no]=='1')
					{
						echo 'Sat - Wed';
					}
					elseif($res_teacher_group[week_no]=='2')
					{
						echo 'Sat';
					}
					elseif($res_teacher_group[week_no]=='3')
					{
						echo 'Sun';
					}
					elseif($res_teacher_group[week_no]=='4')
					{
						echo 'Mon';
					}
					elseif($res_teacher_group[week_no]=='5')
					{
						echo 'Tue';
					}
					elseif($res_teacher_group[week_no]=='6')
					{
						echo 'Wed';
					}
					elseif($res_teacher_group[week_no]=='7')
					{
						echo 'Thu';
					}
					?>
                      </strong></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_NOFSTUDENT");?>  : <?php echo $no_student;?></td>
                    <td align="left" valign="middle" class="pedtext"><strong><?php echo constant("STUDENT_ADVISOR_PED_TXT");?></strong></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><strong><?php echo constant("STUDENT_ADVISOR_PED_SLSPERSON");?></strong> : <?php echo $sa_name;?></td>
                    <td align="left" valign="middle" class="pedtext"><strong><?php echo constant("STUDENT_ADVISOR_PED_TXT1");?> :<?php echo constant("STUDENT_ADVISOR_PED_STANDARD");?></strong></td>
                    </tr>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="21%" height="75" align="left" valign="middle" style="border-right:solid 1px;" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_COMMENTS");?> :</td>
                        <td width="79%" align="left" valign="middle">&nbsp;&nbsp;
                          <?php echo $res_ped["comments"];?></td>
                        </tr>
                      <?php
                      $center_name = '';
                      
                      foreach($dbf->fetchOrder('centre c,teacher_centre t',"c.id=t.centre_id AND t.teacher_id='$teacher_id'","","c.*") as $res_center)
                      {
                            //Sum according to Course
                            $res_count = $dbf->strRecordID("student_course","COUNT(id)","course_id='$res_group[course_id]'");
                            if($center_name == '')	
                            {
                                $center_name = $res_center["name"];
                            }
                            else
                            {
                                $center_name = $center_name." , ".$res_center["name"];
                            }
                      
                      }
                      ?>
                      <tr>
                        <td height="30" align="left" valign="middle" class="pedtext" style="border-right:solid 1px; border-top:solid 1px;"><strong><?php echo constant("STUDENT_ADVISOR_PED_LOCADIRECTION");?></strong>: </td>
                        <td align="left" valign="middle" class="pedtext" style="border-top:solid 1px;"><?php echo $center_name;?>&nbsp;&nbsp;
                          <?php echo $res_ped["location"];?></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TXT2");?>:</td>
                    </tr>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <?php
                        $chk_list = explode(",",$res_ped["checklist"]);
                        $chk = in_array("Software orientation",$chk_list);
                        ?>
                        <td width="4%" height="25" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Software orientation" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td width="30%" align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT3");?></td>
                        <?php
                        $chk = in_array("Level Test explained",$chk_list);
                        ?>
                        <td width="4%" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Level Test explained" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td width="28%" align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT4");?></td>
                        <?php
                        $chk = in_array("Guide arround centre and location of facilities",$chk_list);
                        ?>
                        <td width="4%" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Guide arround centre and location of facilities" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td width="30%" align="left" valign="middle" class="pedtext_normal" style="border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT5");?></td>
                        </tr>
                      <tr>
                        <?php
                        $chk = in_array("Feedbock Forms explained",$chk_list);
                        ?>
                        <td height="25" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Feedbock Forms explained" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT6");?></td>
                        <?php
                        $chk = in_array("Set expectations (principles of the Berlitz Method)",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Set expectations (principles of the Berlitz Method)" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT7");?></td>
                        <?php
                        $chk = in_array("Cancellation policy explained",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Cancellation policy explained" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT8");?></td>
                        </tr>
                      <tr>
                        <?php
                        $chk = in_array("Material received and how to use it",$chk_list);
                        ?>
                        <td height="25" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Material received and how to use it" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT9");?></td>
                        <?php
                        $chk = in_array("Importance of regular attendance",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Importance of regular attendance" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT10");?></td>
                        <?php
                        $chk = in_array("Teacher team",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Teacher team" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TEACHERTM");?></td>
                        </tr>
                      <tr>
                        <?php
                        $chk = in_array("Confirmation of goals",$chk_list);
                        ?>
                        <td height="25" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Confirmation of goals" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT11");?></td>
                        <?php
                        $chk = in_array("Importance of completing homework assigments",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Importance of completing homework assigments" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT12");?></td>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;">&nbsp;</td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-bottom:solid 1px; border-color:#000000;">&nbsp;</td>
                        </tr>
                      <tr>
                        <td height="25" colspan="4" align="left" valign="middle" style="border-right:solid 1px; border-color:#000000;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2%" height="25" align="center" valign="middle" >&nbsp;</td>
                            <td width="19%" height="30" align="left" valign="middle" class="pedtext_normal" ><?php echo constant("STUDENT_ADVISOR_PED_TXT13");?> :</td>
                            <td width="43%" align="left" valign="middle" class="pedtext_normal" ><?php echo $res_ped["point_cover1"];?></td>
                            <td width="9%" align="center" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?> :</td>
                            <?php if($res_ped["point_date1"] != '0000-00-00') {
								$point_date1 = $res_ped["point_date1"];
							}
							?>
                            <td width="27%" align="left" valign="middle" class="pedtext_normal"><?php echo $point_date1;?></td>
                            </tr>
                          </table></td>
                        <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2%" height="25" align="center" valign="middle" >&nbsp;</td>
                            <td width="38%" align="left" valign="middle" class="pedtext_normal" ><?php echo constant("STUDENT_ADVISOR_PED_TXT13");?> :</td>
                            <td width="20%" align="left" valign="middle" class="pedtext_normal" ><?php echo $res_ped["point_cover2"];?></td>
                            <td width="12%" align="center" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                            <?php if($res_ped["point_date2"] != '0000-00-00') {
								$point_date2 = $res_ped["point_date2"];
							}
							?>
                            <td width="28%" align="left" valign="middle" class="pedtext_normal"><?php echo $point_date2;?></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="middle">&nbsp;</td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="middle">
                    <table width="1000" border="1" cellspacing="0" bordercolor="#000000" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="230" height="25" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TXT14");?></td>
                        <td width="37" align="center" valign="middle"><img src="../images/ped_lis.jpg" width="37" height="54"></td>
                        <td width="31" align="center" valign="middle"><img src="../images/ped-units.jpg" width="31" height="41"></td>
                        <td width="100" align="center" valign="middle"><img src="../images/ped-date.jpg" width="31" height="41"></td>
                        <td width="31" align="center" valign="middle"><img src="../images/ped-attd.jpg" width="31" height="41"></td>
                        <td width="130" align="center" valign="middle" class="pedtext2"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?></td>
                        <td width="230" align="center" valign="middle" class="pedtext2"><?php echo constant("STUDENT_ADVISOR_PED_MATERIALCOVER");?></td>
                        <td align="center" valign="middle" class="pedtext2"><?php echo constant("STUDENT_ADVISOR_PED_HOMEWORK");?></td>
                        </tr>
                      <tr bgcolor="#E9EFEF">
                        <td width="230" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="30" height="20" align="center" valign="middle">&nbsp;</td>
                            <td width="88%" align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_INTIFEDBACK");?></td>
                          </tr>
                          <?php
							$chk_feed = explode(",",$res_ped["ini_feedback"]);
							$ch = in_array("Correct Level ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" value="Correct Level ?" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q1");?></td>
                          </tr>
                          <?php
							$ch = in_array("Group hoogeneous ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" value="Group hoogeneous ?" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q2");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <?php
							$ch = in_array("Have all material ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" value="Have all material ?" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q3");?></td>
                          </tr>
                          <?php
							$ch = in_array("Materials appropriate ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q4");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <?php
							$ch = in_array("Doing homework ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q5");?></td>
                          </tr>
                          <?php
							$ch = in_array("Learning Tech ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q6");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?>: </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped[inst1];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["date1"] != '0000-00-00') {
								$date1 = $res_ped["date1"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $date1?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php
								$arf = $res_ped["arf_submit"];							
							?>
                            <td height="23" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="48%" align="left">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_PED_Q7");?></td>
                                <td width="18%" align="center"><?php echo constant("STUDENT_ADVISOR_PED_YES");?></td>
                                <td width="10%" align="left"><input type="radio" name="arf" id="arf" value="Yes" <?php if($arf == "Yes") { ?> checked="checked" <?php } ?>></td>
                                <td width="14%" align="center"><?php echo constant("STUDENT_ADVISOR_PED_NO");?></td>
                                <td width="10%" align="left"><input type="radio" name="arf" id="arf" value="No" <?php if($arf == "No") { ?> checked="checked" <?php } ?>></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT1");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DISTRIBTBY");?>: </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped[dby1];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["dby1_date1"] != '0000-00-00') {
								$dby1_date1 = $res_ped["dby1_date1"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $dby1_date1;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_COLLECTBY");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped[cby1];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["cby1_date1"] != '0000-00-00') {
								$cby1_date1 = $res_ped["cby1_date1"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $cby1_date1;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT2");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped[inst2];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["inst2_date2"] != '0000-00-00') {
								$inst2_date2 = $res_ped["inst2_date2"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $inst2_date2;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_COUNSEL");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <?php
							$chk_coun = explode(",",$res_ped["counselling"]);
							$ch1 = in_array("Confirm students are progressing at appropriate pace",$chk_coun);
							?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Confirm students are progressing at appropriate pace" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT3");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
						  $ch1 = in_array("Confirm that students are satisfied with the materials",$chk_coun);
						  ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Confirm that students are satisfied with the materials" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT4");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
                          $ch1 = in_array("Check that  students are  making use of the HW / learning technology",$chk_coun);
                          ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Check that  students are  making use of the HW / learning technology" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT5");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
                          $ch1 = in_array("Hand over progress reports",$chk_coun);
                          ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Hand over progress reports" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT6");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
                          $ch1 = in_array("Check for general satisfaction",$chk_coun);
                          ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Check for general satisfaction" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT7");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
                          $ch1 = in_array("Remind them of LIS support",$chk_coun);
                          ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Remind them of LIS support" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT8");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT9");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?>: </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["inst3"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["inst3_date3"] != '0000-00-00') {
								$inst3_date3 = $res_ped["inst3_date3"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $inst3_date3;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q7");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT10");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?>: </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["inst4"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["inst4_date4"] != '0000-00-00') {
								$inst4_date4 = $res_ped["inst4_date4"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $inst4_date4;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT11");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT12");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["not_apply"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DISTRIBTBY");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["distrbute_by"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["distrbute_date"] != '0000-00-00') {
								$distrbute_date =$res_ped["distrbute_date"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $distrbute_date;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_COLLECTBY");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["collect_by"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["collect_date"] != '0000-00-00') {
								$collect_date = $res_ped["collect_date"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $collect_date;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                        </table></td>
                        <td width="37" bgcolor="#F7F3F8">&nbsp;</td>
                        <td colspan="6" align="left" valign="top" bgcolor="#F7F3F8">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <?php
                        for($i = 1; $i<=$unit; $i++) { 
						
						//Get record from PED units
						$res_unit = $dbf->strRecordID("ped_units","*","group_id='$_REQUEST[cmbgroup]' And teacher_id='$teacher_id' AND units='$i'");
						
						//Get the Number of Present in a particular Units
						$present = $dbf->strRecordID("ped_attendance","COUNT(id)","unit='$res_unit[units]' And teacher_id='$teacher_id' And group_id='$_REQUEST[cmbgroup]' And (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
						
						$res_teacher = $dbf->strRecordID("teacher","*","id='$teacher_id'");
						?>
                          <tr>
                            <td width="31" height="30" align="center" valign="middle" bgcolor="#F7F3F8" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;"><?php echo $i;?></td>
                            <td width="100" align="center" valign="middle" bgcolor="#F7F3F8" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;"><?php echo $res_unit["dated"];?></td>
                            <td width="31" align="center" valign="middle" bgcolor="#F7F3F8" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;"><?php echo $present["COUNT(id)"];?></td>
                            <td width="130" align="center" valign="middle" bgcolor="#F7F3F8" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; ">
							<?php echo $res_teacher[name];?></td>
                            <td width="230" align="middle" valign="middle" bgcolor="#F7F3F8" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;">
                            <?php echo $res_unit["material_overed"];?></td>
                            <td  align="left" valign="middle" bgcolor="#F7F3F8" style="border-bottom:solid 1px; border-color:#000000;">&nbsp;
                              <?php echo $res_unit["homework"];?></td>
                            </tr>
                          <?php } ?>
                          
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="middle">&nbsp;</td>
                    </tr>
                  <?php
					if($res_teacher_group[course_id]!='')
					{
					?>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle" class="nametext" style="padding-left:16px;"><table width="850" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                      <tr class="pedtext">
                        <td width="49" bgcolor="#FFFF00" class="redtext">&nbsp;<?php echo constant("STUDENT_ADVISOR_PED_NOTE");?> :</td>
                        <td width="699" align="left" valign="middle" class="pedtext" style="border-left:solid 1px; border-color:#FFCC00;"><strong><?php echo constant("STUDENT_ADVISOR_PED_TEXT13");?></strong></td>
                        </tr>
                      </table></td>
                    </tr>
                  <?php
					}
					?>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle"><?php
					$count_course = 1;
                     //Get Group Name
					 
                      foreach($dbf->fetchOrder('student_group',"id='$_REQUEST[cmbgroup]'","","") as $val_course)
                      {
					  	$courseName=$dbf->getDataFromTable('course','name',"id='$val_course[course_id]'");
                    ?>
                      <div style="width:1000px;">
                        <div style="width:100%; overflow:scroll;overflow-y:hidden; margin-bottom:15px;" >
                          <table width="100%" border="1" align="center" cellpadding="3" bordercolor="#000000" cellspacing="0" style="border-collapse:collapse;">
                            <!-- Start Column Heading -->
                            <tr>
                              <td width="10%" align="left" bgcolor="#4D7373"><div class="logouttext" style="width:130px;"><strong><?php echo "Student Name";?></strong>
                                </div></td>
                              <?php
							$no_cols = $unit / 2;
							$num = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
							$j=1;
							$z = 1;
							for($i=0;$i<$no_cols;$i++){
								
							$dayNum = date('d/m', strtotime($hs_date));
							
							//Get per unit date
							$attend_date=$dbf->strRecordID('ped_units','*',"units='$z' And ped_id='$res_ped[id]'");
							if($attend_date["dated"] == '0000-00-00'){ $attend_dt = '';}else{ $attend_dt = $attend_date["dated"]; }
							?>
                              <td height="28" colspan="3" align="center" bgcolor="#4D7373" class="logouttext"><strong><?php echo $j;?></strong>
                              <br>
                              <input type="text" readonly="" style="width:60px; height:12px; font-size:10px;" name="attend_date<?php echo $j;?>" id="attend_date<?php echo $j;?>"  value="<?php echo $attend_dt;?>">
                              </td>
                              <?php
							 $j++;
							 $z = $z + $perday;
							}
							?>
                          </tr>
                        <?php
					  
					    $s_count = 1;
					  
                        //Retrive all records the table
                        foreach($dbf->fetchOrder('student_group_dtls d,student s',"s.id=d.student_id AND d.parent_id='$_REQUEST[cmbgroup]'","s.first_name","s.*") as $r) {
                        ?>
                            <tr>
                              <td width="10%" align="left" bgcolor="#E9EFEF" class="pedtext"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?>
                                </td>
                              <?php
							$no_cols = $unit / 2;
							$num = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
							$j=1;
							$st = 1;
							$shift_count = 1;
							//$no_shift = $val_course[units];
							
							//Get the number of shift in a Days
							$no_shift = $dbf->getDataFromTable("common","name","id='$val_course[units]'");
							
							for($i=0;$i<$no_cols;$i++)
							{
							?>
                          <td colspan="3" align="center" bgcolor="#E9EFEF">
                          <?php
						
						//Get status of the student in a particular Unit
						$status_shift1 = $dbf->getDataFromTable("ped_attendance","shift1","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift2 = $dbf->getDataFromTable("ped_attendance","shift2","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift3 = $dbf->getDataFromTable("ped_attendance","shift3","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						
						$status_shift4 = $dbf->getDataFromTable("ped_attendance","shift4","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift5 = $dbf->getDataFromTable("ped_attendance","shift5","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift6 = $dbf->getDataFromTable("ped_attendance","shift6","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						
						$status_shift7 = $dbf->getDataFromTable("ped_attendance","shift7","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift8 = $dbf->getDataFromTable("ped_attendance","shift8","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift9 = $dbf->getDataFromTable("ped_attendance","shift9","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$shift_no = 1;
						for($k=0;$k<$no_shift;$k++){?>
                        
                        <div style="padding:3px;">
                        
                        <?php
						//echo "shift".$shift_no."_".$s_count."_".$st."_".$count_course;
						
						if($k == 0)
						{
							$status_shift1 = $status_shift1;
						}
						else if($k == 1)
						{
							$status_shift1 = $status_shift2;
						}
						else if($k == 2)
						{
							$status_shift1 = $status_shift3;
						}
						else if($k == 3)
						{
							$status_shift1 = $status_shift4;
						}
						else if($k == 4)
						{
							$status_shift1 = $status_shift5;
						}
						else if($k == 5)
						{
							$status_shift1 = $status_shift6;
						}
						else if($k == 6)
						{
							$status_shift1 = $status_shift7;
						}
						else if($k == 7)
						{
							$status_shift1 = $status_shift8;
						}
						else if($k == 8)
						{
							$status_shift1 = $status_shift9;
						}
						echo '<span class="pedtext">'.$status_shift1.'</span>';
						?>
                          </div>
                        <?php
                        $shift_no++;
						}
						?>
                        </td>
                        <?php
                        
						$st++;
												
						$shift_count++;
						}
						?>
                              </tr>
                            <!-- End Column Heading -->
                            <?php                      
							  $s_count++;
							  }
                      	?>                            
                            </table>
                          </div>
                        </div>
                      <?php
					  $count_course++;
					  }
                    ?>
                      </td>
                    </tr>
                  
                </table>
                
                </td>
            </tr>
            <tr>
              <td height="20" align="left" valign="middle" class="nametext">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="20" align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
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
<?php }else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
        
        
        <form action="ped_process.php?action=insert" name="frm1" method="post" id="frm1">
          <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#CC9900;">
            <?php
			  if($_REQUEST['msg']=='added')
			  {
			  ?>
            <tr>
              <td width="17%">&nbsp;</td>
              <td width="71%" align="center">&nbsp;</td>
              <td width="9%">&nbsp;</td>
            </tr>
            <?php
				}
			?>
            <tr>
              <td width="17%" height="30">&nbsp;</td>
              <td width="71%" align="center">
              </td>
              <td width="9%" align="center">
              <?php //if($_REQUEST[cmbgroup]!='') { ?>
                    <table width="50%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="36" align="center" valign="middle"><a href="ped_word.php?cmbgroup=<?php echo $_REQUEST[cmbgroup];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
                        <td width="36" align="center" valign="middle"><a href="ped_print.php?cmbgroup=<?php echo $_REQUEST[cmbgroup];?>" target="_blank">                  
                        <img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
                      </tr>
                    </table>
                <?php //} ?>
              </td>
            </tr>
            <tr>
              <td align="left" valign="top" class="loginheading1"><?php echo constant("STUDENT_ADVISOR_PED_TNAME");?></td>
              <td align="left" valign="middle" class="heading"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="36%" align="left" valign="middle" class="heading"><?php echo $res_teacher["name"];?></td>
                  <td width="32%">&nbsp;</td>
                  <td width="32%" align="left" valign="middle" class="heading">&nbsp;</td>
                </tr>
              </table></td>
              <td align="center" valign="middle" class="heading">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="left" valign="top" style="padding-left:5px;">
              
              <table width="250" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#993030;">
                  <tr>
                    <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext">Status :</td>
                    <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading">
                      <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                        <option value="">All</option>
                        <option value="Not Started" <?php if($_REQUEST['mystatus']=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
                        <option value="Continue" <?php if($_REQUEST['mystatus']=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
                        <option value="Completed" <?php if($_REQUEST['mystatus']=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
                        </select>
                      </td>
                    </tr>
                  <tr>
                    <td width="28%" height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_GROUP");?>:</td>
                    <td width="72%" align="left" valign="middle" bgcolor="#FFCB7D" class="heading" id="statusresult">
                      <select name="cmbgroup" id="cmbgroup" style="width:150px; border:solid 1px; border-color:#999999;" onChange="setsubmit();">
                        <option value="">Select Group</option>
                        <?php
						if($_REQUEST["mystatus"] != ""){ $cond = " And status='$_REQUEST[mystatus]'";}else{ $cond = ""; }
						foreach($dbf->fetchOrder('student_group', $cond ,"","") as $res_group) {
					    ?>
                        <option value="<?php echo $res_group['id'];?>" <?php if($_REQUEST[cmbgroup]==$res_group["id"]) { ?> selected="selected" <?php } ?>><?php echo $res_group['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_group['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_group['end_date'])) ?>, <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></option>
                        <?php
						  }
						  ?>
                        </select>
                      </td>
                    </tr>
                  <tr>
                    <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext"><?php echo constant("TEACHER_REPORT_TEACHER_COURSE");?>:</td>
                    <?php
					  //Get course name
					  $course = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
					  $course_name = $dbf->strRecordID("course","*","id='$course[course_id]'");
					  $teacher_name = $dbf->getDataFromTable("teacher", "name" , "id='$course[teacher_id]'");
					  ?>                      
                    <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading"><?php echo $course_name[name];?></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" bgcolor="#FFCB7D" class="pedtext">Teacher:</td>
                    <td align="left" valign="middle" bgcolor="#FFCB7D" class="heading"><?php echo $teacher_name;?></td>
                    </tr>
                  <tr>
                    <td height="5" colspan="2" align="left" bgcolor="#FFCB7D" class="pedtext"></td>
                    </tr>
                  </table>
              
              </td>
              <td align="center" valign="middle" class="heading">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="right" valign="top" class="loginheading"><span class="heading"><?php echo constant("STUDENT_ADVISOR_PED_PEDAGOCARD");?></span></td>
              <td align="center" valign="middle" class="heading">&nbsp;</td>
            </tr>
            <?php
			  $res_teacher_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
			  $res_size = $dbf->strRecordID("group_size","*","group_id='$course[group_id]'");
			  $res_group_name = $dbf->strRecordID("common","*","id='$course[group_id]'");
			  $res_cource_name = $dbf->strRecordID("course","*","id='$course[group_id]'");
			  
			  $teacher_id = $res_teacher_group[teacher_id];
			  
			  $unit = $res_size["units"];			  
			?>
            <tr>
              <td colspan="3" align="left" valign="top">
                
                <table width="1000" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bgcolor="#FFFFFF">
                  <?php
                  //===================================================
                  // Get Number of Students in a Group
                  //===================================================	
    
                  $no_student = 0;
                  $sa_name = '';
				  $prev_sa = '';
				  $no_student = 0;
				  $no_student = $dbf->countRows('student_group_dtls',"parent_id='$_REQUEST[cmbgroup]'");
                  foreach($dbf->fetchOrder('student_group',"id='$_REQUEST[cmbgroup]'","","") as $res_group)
                  {
						$res_sa_name = $dbf->strRecordID("user","*","id='$res_group[sa_id]'");
						if($sa_name == '')
						{
							$sa_name = $res_sa_name["user_name"];
							$prev_sa = $sa_name;
						}
						else
						{
							if($prev_sa != $res_sa_name["user_name"])
							{
								$sa_name = $sa_name.",".$res_sa_name["user_name"];
							}
						}
                  }
                  //======================================================                  
                  
                  ?>
                  <tr>
                    <td width="35%" height="25" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_UNITS");?> : <?php echo $res_size[units];?></td>
                    <td width="65%" align="left" valign="middle" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?> : <?php echo $res_group_name[name];?></td>
                    </tr>
                  <tr>
                  <?php
				  if($res_ped["estart_date"] != "0000-00-00")
				  {
				  	$est = $res_ped["estart_date"];
				  }
				  ?>
                    <td height="30" align="left" valign="middle" class="pedtext"> <?php echo constant("STUDENT_ADVISOR_PED_STARTING");?> : 
                      <?php echo $est;?>
                    </td>
                    <td align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_BLGOAL");?> :
                      <?php echo $res_ped["bl"];?>
                    </td>
                    </tr>
                  <tr>
                   <?php
                    $level = $res_ped["level"];					
					?>
                    <td height="25" align="left" valign="middle">
					<table width="400" border="0" cellspacing="0" cellpadding="0">
					  <tr>
					    <td width="97" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_MATERIALS");?> :</td>
					    <td width="303" align="left" valign="middle">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
					      <tr>
                          <?php
						  $chk_list = explode(",",$res_ped["material"]);                          
						  foreach($dbf->fetchOrder('common',"type='material type'","") as $valmate){
							  $chk = in_array($valmate["id"],$chk_list);
						  ?>
					        <td align="left" valign="top" class="mycon"><input type="checkbox" name="mate[]" id="mate[]" value="<?php echo $valmate[id];?>" <?php if($chk == 1) { ?> checked="checked" <?php } ?>>&nbsp;<?php echo $valmate[name];?></td>
							<?php
							}
							?>
					        </tr>
					      </table></td>
					    </tr>
					  </table></td>
                   
                    <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="pedtext">
                        <td width="54%" height="25" align="left" valign="middle" style="border-right:solid 1px;"><strong class="pedtext" >
						<?php echo constant("STUDENT_ADVISOR_PED_PROGREPORT");?> : </strong>
                        <?php if($res_ped[pro_report]=="1") { echo "Yes"; } ?>
                        <?php if($res_ped[pro_report]=="2") { echo "No";} ?>
                        </td>
                        <td width="46%" align="left" valign="top" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_LEVELCK");?> :
                          <input type="radio" name="level" id="level" value="Yes" <?php if($level == "Yes") { ?> checked="checked" <?php } ?>>
                          <?php echo constant("STUDENT_ADVISOR_PED_YES");?>
                          <input type="radio" name="level" id="level" value="No" <?php if($level == "No") { ?> checked="checked" <?php } ?>>
                          <?php echo constant("STUDENT_ADVISOR_PED_NO");?></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_STARTDT");?> : <?php echo $res_teacher_group[start_date];?></td>
                    <td align="left" valign="middle" class="pedtext"><strong><?php echo constant("STUDENT_ADVISOR_PED_TMDAY");?>:
                      <?php
					  if($_REQUEST[cmbgroup] != '')
					  {
						$dt = date("Y-m-d",strtotime($res_teacher_group[start_date]));
						echo $dt = $dt." - ".$res_teacher_group[group_time];
					  }
					?>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php
					if($res_teacher_group[week_no]=='1')
					{
						echo 'Sat - Wed';
					}
					elseif($res_teacher_group[week_no]=='2')
					{
						echo 'Sat';
					}
					elseif($res_teacher_group[week_no]=='3')
					{
						echo 'Sun';
					}
					elseif($res_teacher_group[week_no]=='4')
					{
						echo 'Mon';
					}
					elseif($res_teacher_group[week_no]=='5')
					{
						echo 'Tue';
					}
					elseif($res_teacher_group[week_no]=='6')
					{
						echo 'Wed';
					}
					elseif($res_teacher_group[week_no]=='7')
					{
						echo 'Thu';
					}
					?>
                      </strong></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_NOFSTUDENT");?>  : <?php echo $no_student;?></td>
                    <td align="left" valign="middle" class="pedtext"><strong><?php echo constant("STUDENT_ADVISOR_PED_TXT");?></strong></td>
                    </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><strong><?php echo constant("STUDENT_ADVISOR_PED_SLSPERSON");?></strong> : <?php echo $sa_name;?></td>
                    <td align="left" valign="middle" class="pedtext"><strong><?php echo constant("STUDENT_ADVISOR_PED_TXT1");?> :<?php echo constant("STUDENT_ADVISOR_PED_STANDARD");?></strong></td>
                    </tr>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="21%" height="75" align="left" valign="middle" style="border-right:solid 1px;" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_COMMENTS");?> :</td>
                        <td width="79%" align="left" valign="middle">&nbsp;&nbsp;
                          <?php echo $res_ped["comments"];?></td>
                        </tr>
                      <?php
                      $center_name = '';
                      
                      foreach($dbf->fetchOrder('centre c,teacher_centre t',"c.id=t.centre_id AND t.teacher_id='$teacher_id'","","c.*") as $res_center)
                      {
                            //Sum according to Course
                            $res_count = $dbf->strRecordID("student_course","COUNT(id)","course_id='$res_group[course_id]'");
                            if($center_name == '')	
                            {
                                $center_name = $res_center["name"];
                            }
                            else
                            {
                                $center_name = $center_name." , ".$res_center["name"];
                            }
                      
                      }
                      ?>
                      <tr>
                        <td height="30" align="left" valign="middle" class="pedtext" style="border-right:solid 1px; border-top:solid 1px;"><strong><?php echo constant("STUDENT_ADVISOR_PED_LOCADIRECTION");?></strong>: </td>
                        <td align="left" valign="middle" class="pedtext" style="border-top:solid 1px;"><?php echo $center_name;?>&nbsp;&nbsp;
                          <?php echo $res_ped["location"];?></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TXT2");?>:</td>
                    </tr>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <?php
                        $chk_list = explode(",",$res_ped["checklist"]);
                        $chk = in_array("Software orientation",$chk_list);
                        ?>
                        <td width="4%" height="25" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Software orientation" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td width="30%" align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT3");?></td>
                        <?php
                        $chk = in_array("Level Test explained",$chk_list);
                        ?>
                        <td width="4%" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Level Test explained" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td width="28%" align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT4");?></td>
                        <?php
                        $chk = in_array("Guide arround centre and location of facilities",$chk_list);
                        ?>
                        <td width="4%" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Guide arround centre and location of facilities" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td width="30%" align="left" valign="middle" class="pedtext_normal" style="border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT5");?></td>
                        </tr>
                      <tr>
                        <?php
                        $chk = in_array("Feedbock Forms explained",$chk_list);
                        ?>
                        <td height="25" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Feedbock Forms explained" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT6");?></td>
                        <?php
                        $chk = in_array("Set expectations (principles of the Berlitz Method)",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Set expectations (principles of the Berlitz Method)" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT7");?></td>
                        <?php
                        $chk = in_array("Cancellation policy explained",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Cancellation policy explained" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT8");?></td>
                        </tr>
                      <tr>
                        <?php
                        $chk = in_array("Material received and how to use it",$chk_list);
                        ?>
                        <td height="25" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Material received and how to use it" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT9");?></td>
                        <?php
                        $chk = in_array("Importance of regular attendance",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Importance of regular attendance" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT10");?></td>
                        <?php
                        $chk = in_array("Teacher team",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Teacher team" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TEACHERTM");?></td>
                        </tr>
                      <tr>
                        <?php
                        $chk = in_array("Confirmation of goals",$chk_list);
                        ?>
                        <td height="25" align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Confirmation of goals" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT11");?></td>
                        <?php
                        $chk = in_array("Importance of completing homework assigments",$chk_list);
                        ?>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;"><input type="checkbox" name="checklist[]" id="checklist[]" value="Importance of completing homework assigments" <?php if($chk == 1) { ?> checked="checked" <?php } ?>></td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; border-color:#000000;"><?php echo constant("STUDENT_ADVISOR_PED_TXT12");?></td>
                        <td align="center" valign="middle" style="border-bottom:solid 1px; border-color:#000000;">&nbsp;</td>
                        <td align="left" valign="middle" class="pedtext_normal" style="border-bottom:solid 1px; border-color:#000000;">&nbsp;</td>
                        </tr>
                      <tr>
                        <td height="25" colspan="4" align="left" valign="middle" style="border-right:solid 1px; border-color:#000000;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2%" height="25" align="center" valign="middle" >&nbsp;</td>
                            <td width="19%" height="30" align="left" valign="middle" class="pedtext_normal" ><?php echo constant("STUDENT_ADVISOR_PED_TXT13");?> :</td>
                            <td width="43%" align="left" valign="middle" class="pedtext_normal" ><?php echo $res_ped["point_cover1"];?></td>
                            <td width="9%" align="center" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?> :</td>
                            <?php if($res_ped["point_date1"] != '0000-00-00') {
								$point_date1 = $res_ped["point_date1"];
							}
							?>
                            <td width="27%" align="left" valign="middle" class="pedtext_normal"><?php echo $point_date1;?></td>
                            </tr>
                          </table></td>
                        <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="2%" height="25" align="center" valign="middle" >&nbsp;</td>
                            <td width="38%" align="left" valign="middle" class="pedtext_normal" ><?php echo constant("STUDENT_ADVISOR_PED_TXT13");?> :</td>
                            <td width="20%" align="left" valign="middle" class="pedtext_normal" ><?php echo $res_ped["point_cover2"];?></td>
                            <td width="12%" align="center" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                            <?php if($res_ped["point_date2"] != '0000-00-00') {
								$point_date2 = $res_ped["point_date2"];
							}
							?>
                            <td width="28%" align="left" valign="middle" class="pedtext_normal"><?php echo $point_date2;?></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="middle">&nbsp;</td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="middle">
                    <table width="1000" border="1" cellspacing="0" bordercolor="#000000" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="230" height="25" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TXT14");?></td>
                        <td width="37" align="center" valign="middle"><img src="../images/ped_lis.jpg" width="37" height="54"></td>
                        <td width="31" align="center" valign="middle"><img src="../images/ped-units.jpg" width="31" height="41"></td>
                        <td width="100" align="center" valign="middle"><img src="../images/ped-date.jpg" width="31" height="41"></td>
                        <td width="31" align="center" valign="middle"><img src="../images/ped-attd.jpg" width="31" height="41"></td>
                        <td width="130" align="center" valign="middle" class="pedtext2"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?></td>
                        <td width="230" align="center" valign="middle" class="pedtext2"><?php echo constant("STUDENT_ADVISOR_PED_MATERIALCOVER");?></td>
                        <td align="center" valign="middle" class="pedtext2"><?php echo constant("STUDENT_ADVISOR_PED_HOMEWORK");?></td>
                        </tr>
                      <tr bgcolor="#E9EFEF">
                        <td width="230" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="30" height="20" align="center" valign="middle">&nbsp;</td>
                            <td width="88%" align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_INTIFEDBACK");?></td>
                          </tr>
                          <?php
							$chk_feed = explode(",",$res_ped["ini_feedback"]);
							$ch = in_array("Correct Level ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" value="Correct Level ?" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q1");?></td>
                          </tr>
                          <?php
							$ch = in_array("Group hoogeneous ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" value="Group hoogeneous ?" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q2");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <?php
							$ch = in_array("Have all material ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" value="Have all material ?" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q3");?></td>
                          </tr>
                          <?php
							$ch = in_array("Materials appropriate ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q4");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <?php
							$ch = in_array("Doing homework ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q5");?></td>
                          </tr>
                          <?php
							$ch = in_array("Learning Tech ?",$chk_feed);
							?>
                          <tr>
                            <td align="center" valign="middle"><input type="checkbox" name="ini_feedback[]" id="ini_feedback[]" <?php if($ch == 1) {?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q6");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?>: </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped[inst1];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["date1"] != '0000-00-00') {
								$date1 = $res_ped["date1"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $date1?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php
								$arf = $res_ped["arf_submit"];							
							?>
                            <td height="23" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="48%" align="left">&nbsp;&nbsp;<?php echo constant("STUDENT_ADVISOR_PED_Q7");?></td>
                                <td width="18%" align="center"><?php echo constant("STUDENT_ADVISOR_PED_YES");?></td>
                                <td width="10%" align="left"><input type="radio" name="arf" id="arf" value="Yes" <?php if($arf == "Yes") { ?> checked="checked" <?php } ?>></td>
                                <td width="14%" align="center"><?php echo constant("STUDENT_ADVISOR_PED_NO");?></td>
                                <td width="10%" align="left"><input type="radio" name="arf" id="arf" value="No" <?php if($arf == "No") { ?> checked="checked" <?php } ?>></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT1");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DISTRIBTBY");?>: </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped[dby1];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["dby1_date1"] != '0000-00-00') {
								$dby1_date1 = $res_ped["dby1_date1"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $dby1_date1;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_COLLECTBY");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped[cby1];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["cby1_date1"] != '0000-00-00') {
								$cby1_date1 = $res_ped["cby1_date1"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $cby1_date1;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT2");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped[inst2];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["inst2_date2"] != '0000-00-00') {
								$inst2_date2 = $res_ped["inst2_date2"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $inst2_date2;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_COUNSEL");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <?php
							$chk_coun = explode(",",$res_ped["counselling"]);
							$ch1 = in_array("Confirm students are progressing at appropriate pace",$chk_coun);
							?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Confirm students are progressing at appropriate pace" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT3");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
						  $ch1 = in_array("Confirm that students are satisfied with the materials",$chk_coun);
						  ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Confirm that students are satisfied with the materials" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT4");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
                          $ch1 = in_array("Check that  students are  making use of the HW / learning technology",$chk_coun);
                          ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Check that  students are  making use of the HW / learning technology" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT5");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
                          $ch1 = in_array("Hand over progress reports",$chk_coun);
                          ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Hand over progress reports" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT6");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
                          $ch1 = in_array("Check for general satisfaction",$chk_coun);
                          ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Check for general satisfaction" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT7");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="top"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <?php
                          $ch1 = in_array("Remind them of LIS support",$chk_coun);
                          ?>
                          <tr>
                            <td align="center" valign="top"><input type="checkbox" name="counselling[]" id="counselling[]" value="Remind them of LIS support" <?php if($ch1 == 1) { ?> checked="checked" <?php } ?>></td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT8");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"></td>
                            <td height="5" align="left" valign="middle" class="pedtext_normal"></td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT9");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?>: </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["inst3"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["inst3_date3"] != '0000-00-00') {
								$inst3_date3 = $res_ped["inst3_date3"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $inst3_date3;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_Q7");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT10");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_INSTRUCTOR");?>: </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["inst4"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["inst4_date4"] != '0000-00-00') {
								$inst4_date4 = $res_ped["inst4_date4"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $inst4_date4;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="23" colspan="2" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_PED_TEXT11");?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_TEXT12");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["not_apply"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DISTRIBTBY");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["distrbute_by"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["distrbute_date"] != '0000-00-00') {
								$distrbute_date =$res_ped["distrbute_date"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $distrbute_date;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_COLLECTBY");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $res_ped["collect_by"];?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo constant("STUDENT_ADVISOR_PED_DATE");?>:</td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <?php if($res_ped["collect_date"] != '0000-00-00') {
								$collect_date = $res_ped["collect_date"];
							}
							?>
                            <td height="23" align="left" valign="middle" class="pedtext_normal"><?php echo $collect_date;?></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle">&nbsp;</td>
                            <td height="23" align="left" valign="middle" class="pedtext_normal">&nbsp;</td>
                          </tr>
                        </table></td>
                        <td width="37" bgcolor="#F7F3F8">&nbsp;</td>
                        <td colspan="6" align="left" valign="top" bgcolor="#F7F3F8">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <?php
                        for($i = 1; $i<=$unit; $i++) { 
						
						//Get record from PED units
						$res_unit = $dbf->strRecordID("ped_units","*","group_id='$_REQUEST[cmbgroup]' And teacher_id='$teacher_id' AND units='$i'");
						
						//Get the Number of Present in a particular Units
						$present = $dbf->strRecordID("ped_attendance","COUNT(id)","unit='$res_unit[units]' And teacher_id='$teacher_id' And group_id='$_REQUEST[cmbgroup]' And (shift1='X' OR shift2='X' OR shift3='X' OR shift4='X' OR shift5='X' OR shift6='X' OR shift7='X' OR shift8='X' OR shift9='X')");
						
						$res_teacher = $dbf->strRecordID("teacher","*","id='$teacher_id'");
						?>
                          <tr>
                            <td width="31" height="30" align="center" valign="middle" bgcolor="#F7F3F8" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;"><?php echo $i;?></td>
                            <td width="100" align="center" valign="middle" bgcolor="#F7F3F8" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;"><?php echo $res_unit["dated"];?></td>
                            <td width="31" align="center" valign="middle" bgcolor="#F7F3F8" class="pedtext_normal" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;"><?php echo $present["COUNT(id)"];?></td>
                            <td width="130" align="center" valign="middle" bgcolor="#F7F3F8" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px; ">
							<?php echo $res_teacher[name];?></td>
                            <td width="230" align="middle" valign="middle" bgcolor="#F7F3F8" style="border-right:solid 1px; border-color:#000000;border-bottom:solid 1px;">
                            <?php echo $res_unit["material_overed"];?></td>
                            <td  align="left" valign="middle" bgcolor="#F7F3F8" style="border-bottom:solid 1px; border-color:#000000;">&nbsp;
                              <?php echo $res_unit["homework"];?></td>
                            </tr>
                          <?php } ?>
                          
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="middle">&nbsp;</td>
                    </tr>
                  <?php
					if($res_teacher_group[course_id]!='')
					{
					?>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle" class="nametext" style="padding-left:16px;"><table width="850" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FFCC00;">
                      <tr class="pedtext">
                        <td width="49" bgcolor="#FFFF00" class="redtext">&nbsp;<?php echo constant("STUDENT_ADVISOR_PED_NOTE");?> :</td>
                        <td width="699" align="left" valign="middle" class="pedtext" style="border-left:solid 1px; border-color:#FFCC00;"><strong><?php echo constant("STUDENT_ADVISOR_PED_TEXT13");?></strong></td>
                        </tr>
                      </table></td>
                    </tr>
                  <?php
					}
					?>
                  <tr>
                    <td height="25" colspan="2" align="left" valign="middle"><?php
					$count_course = 1;
                     //Get Group Name
					 
                      foreach($dbf->fetchOrder('student_group',"id='$_REQUEST[cmbgroup]'","","") as $val_course)
                      {
					  	$courseName=$dbf->getDataFromTable('course','name',"id='$val_course[course_id]'");
                    ?>
                      <div style="width:1000px;">
                        <div style="width:100%; overflow:scroll;overflow-y:hidden; margin-bottom:15px;" >
                          <table width="100%" border="1" align="center" cellpadding="3" bordercolor="#000000" cellspacing="0" style="border-collapse:collapse;">
                            <!-- Start Column Heading -->
                            <tr>
                              <td width="10%" align="left" bgcolor="#4D7373"><div class="logouttext" style="width:130px;"><strong><?php echo "Student Name";?></strong>
                                </div></td>
                              <?php
							$no_cols = $unit / 2;
							$num = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
							$j=1;
							$z = 1;
							for($i=0;$i<$no_cols;$i++){
								
							$dayNum = date('d/m', strtotime($hs_date));
							
							//Get per unit date
							$attend_date=$dbf->strRecordID('ped_units','*',"units='$z' And ped_id='$res_ped[id]'");
							if($attend_date["dated"] == '0000-00-00'){ $attend_dt = '';}else{ $attend_dt = $attend_date["dated"]; }
							?>
                              <td height="28" colspan="3" align="center" bgcolor="#4D7373" class="logouttext"><strong><?php echo $j;?></strong>
                              <br>
                              <input type="text" readonly="" style="width:60px; height:12px; font-size:10px;" name="attend_date<?php echo $j;?>" id="attend_date<?php echo $j;?>"  value="<?php echo $attend_dt;?>">
                              </td>
                              <?php
							 $j++;
							 $z = $z + $perday;
							}
							?>
                          </tr>
                        <?php
					  
					    $s_count = 1;
					  
                        //Retrive all records the table
                        foreach($dbf->fetchOrder('student_group_dtls d,student s',"s.id=d.student_id AND d.parent_id='$_REQUEST[cmbgroup]'","s.first_name","s.*") as $r) {
                        ?>
                            <tr>
                              <td width="10%" align="left" bgcolor="#E9EFEF" class="pedtext"><?php echo $r[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($r["id"]));?>
                                </td>
                              <?php
							$no_cols = $unit / 2;
							$num = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
							$j=1;
							$st = 1;
							$shift_count = 1;
							//$no_shift = $val_course[units];
							
							//Get the number of shift in a Days
							$no_shift = $dbf->getDataFromTable("common","name","id='$val_course[units]'");
							
							for($i=0;$i<$no_cols;$i++)
							{
							?>
                          <td colspan="3" align="center" bgcolor="#E9EFEF">
                          <?php
						
						//Get status of the student in a particular Unit
						$status_shift1 = $dbf->getDataFromTable("ped_attendance","shift1","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift2 = $dbf->getDataFromTable("ped_attendance","shift2","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift3 = $dbf->getDataFromTable("ped_attendance","shift3","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						
						$status_shift4 = $dbf->getDataFromTable("ped_attendance","shift4","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift5 = $dbf->getDataFromTable("ped_attendance","shift5","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift6 = $dbf->getDataFromTable("ped_attendance","shift6","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						
						$status_shift7 = $dbf->getDataFromTable("ped_attendance","shift7","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift8 = $dbf->getDataFromTable("ped_attendance","shift8","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$status_shift9 = $dbf->getDataFromTable("ped_attendance","shift9","ped_id='$res_ped[id]' AND teacher_id='$teacher_id' AND student_id='$r[id]' AND unit='$shift_count'");
						
						$shift_no = 1;
						for($k=0;$k<$no_shift;$k++){?>
                        
                        <div style="padding:3px;">
                        
                        <?php
						//echo "shift".$shift_no."_".$s_count."_".$st."_".$count_course;
						
						if($k == 0)
						{
							$status_shift1 = $status_shift1;
						}
						else if($k == 1)
						{
							$status_shift1 = $status_shift2;
						}
						else if($k == 2)
						{
							$status_shift1 = $status_shift3;
						}
						else if($k == 3)
						{
							$status_shift1 = $status_shift4;
						}
						else if($k == 4)
						{
							$status_shift1 = $status_shift5;
						}
						else if($k == 5)
						{
							$status_shift1 = $status_shift6;
						}
						else if($k == 6)
						{
							$status_shift1 = $status_shift7;
						}
						else if($k == 7)
						{
							$status_shift1 = $status_shift8;
						}
						else if($k == 8)
						{
							$status_shift1 = $status_shift9;
						}
						echo '<span class="pedtext">'.$status_shift1.'</span>';
						?>
                          </div>
                        <?php
                        $shift_no++;
						}
						?>
                        </td>
                        <?php
                        
						$st++;
												
						$shift_count++;
						}
						?>
                              </tr>
                            <!-- End Column Heading -->
                            <?php                      
							  $s_count++;
							  }
                      	?>                            
                            </table>
                          </div>
                        </div>
                      <?php
					  $count_course++;
					  }
                    ?>
                      </td>
                    </tr>
                  
                </table>
                
                </td>
            </tr>
            <tr>
              <td height="20" align="left" valign="middle" class="nametext">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
            <tr>
              <td height="20" align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
            </tr>
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
<?php } ?>
</body>
</html>