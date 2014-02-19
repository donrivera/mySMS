<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Receptionist")
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
<?php if($_SESSION['lang']=='EN'){?>
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
        <td width="3%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="97%" align="left" valign="top">
        
        <form name="frm" id="frm" method="post">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#000000;">
            <tr>
              <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_CENTRE_SCHEDULE_HEADTEXT");?></td>
                  <td width="22%">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="40" align="left" valign="middle" bgcolor="#EFEFEF" style="padding-left:15px;">
                <table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#993030;">
                    <tr>
                      <td width="70" height="35" align="left" valign="middle" bgcolor="#FFCB7D" class="leftmenu"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?></td>
                      <td width="10" align="left" valign="middle" bgcolor="#FFCB7D">&nbsp;</td>
                      <?php
                      if($_REQUEST[centre_id] == ''){
						$cid = $_SESSION['centre_id'];
					  }else{
						  $cid = $_REQUEST['centre_id'];
					  }
					  ?>
                      <td width="270" align="left" valign="middle" bgcolor="#FFCB7D">
                          <select name="centre_id" id="centre_id"  style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();">
                            <option value="">-- All Centre --</option>
                            <?php
                                foreach($dbf->fetchOrder('centre',"","name") as $val1) {	
                              ?>
                            <option value="<?php echo $val1[id];?>" <?php if($cid==$val1["id"]) { ?> selected="selected" <?php } ?>><?php echo $val1[name];?></option>
                            <?php } ?>
                          </select>
                      </td>
                    </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="40" align="left" valign="middle" bgcolor="#EFEFEF" style="padding-left:15px;">
              <table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999999;">
                <tr>
                  <td width="24" align="left" valign="middle" bgcolor="#DDDDDD"><input name="status" type="radio" id="status" value="All" checked="checked" onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();" /></td>
                  <td width="46" height="25" align="left" valign="middle" bgcolor="#DDDDDD" class="mycon"><?php echo constant("CD_CENTRE_SCHEDULE_All");?></td>
                  <td width="20" align="left" valign="middle" bgcolor="#DDDDDD"><input type="radio" name="status" id="status" value="Not Started" <?php if($_REQUEST[status]=="Not Started") {?> checked="checked" <?php } ?> onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();"/></td>
                  <td width="69" align="left" valign="middle" bgcolor="#DDDDDD" class="mycon"><?php echo constant("CD_CENTRE_SCHEDULE_NOTSATRTED");?></td>
                  <td width="20" align="left" valign="middle" bgcolor="#DDDDDD" class="mycon">
                    <input type="radio" name="status" id="status" value="Continue" <?php if($_REQUEST[status]=="Continue") {?> checked="checked" <?php } ?> onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();"/>
                  </td>
                  <td width="71" align="left" valign="middle" bgcolor="#DDDDDD" class="mycon"><?php echo constant("CD_CENTRE_SCHEDULE_CONTINUE");?></td>
                  <td width="20" align="left" valign="middle" bgcolor="#DDDDDD" class="mycon">
                    <input type="radio" name="status" id="status" value="Completed" <?php if($_REQUEST[status]=="Completed") {?> checked="checked" <?php } ?> onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();"/>
                  </td>
                  <td width="80" align="left" valign="middle" bgcolor="#DDDDDD" class="mycon"><?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="left" valign="top" bgcolor="#EFEFEF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#EFEFEF" class="mycon">
                  <td align="left" valign="middle" style="padding-left:15px;"><div id="ganttChart"></div>
                    <!--<link rel="stylesheet" type="text/css" href="js_gchart/jquery-ui-1.8.4.css" />-->
                    <!--<link rel="stylesheet" type="text/css" href="js_gchart/reset.css" />-->
                    <link rel="stylesheet" type="text/css" href="js_gchart/jquery.ganttView.css" />
                    <script type="text/javascript" src="js_gchart/jquery-1.4.2.js"></script>
                    <script type="text/javascript" src="js_gchart/date.js"></script>
                    <script type="text/javascript" src="js_gchart/jquery-ui-1.8.4.js"></script>
                    <script type="text/javascript" src="js_gchart/jquery.ganttView.js"></script>
                    <script type="text/javascript">
                    $(function () {
                        $("#ganttChart").ganttView({ 
							
                            data: ganttData,
							slideWidth: 1000,
                            behavior: {
                                onClick: function (data) { 
                                    var msg = "You clicked on an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                                    $("#eventMessage").text(msg);
                                },
                                onResize: function (data) { 
                                    var msg = "You resized an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                                    $("#eventMessage").text(msg);
                                },
                                onDrag: function (data) { 
                                    var msg = "You dragged an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                                    $("#eventMessage").text(msg);
                                }
                            }
                        });
                        
                        // $("#ganttChart").ganttView("setSlideWidth", 600);
                    });
                </script>
                    <?php				
				if($_REQUEST[status]=='' || $_REQUEST[status]=='All'){
					$cond = '';
				}else{
					$cond = "status='$_REQUEST[status]'";
				}
				if($_REQUEST[centre_id]!=''){
					if($cond == ''){
						$cond = "centre_id='$_REQUEST[centre_id]'";
					}else{
						$cond = $cond." And centre_id='$_REQUEST[centre_id]'";
					}
				}else{
					$cond = "centre_id='$_SESSION[centre_id]'";
				}
				//echo "d".$cond;
				$i = 1;
				$a="";
				$year_now=date('Y');
				foreach($dbf->fetchOrder('student_group',$cond."AND YEAR(start_date) = '$year_now'","group_name ASC") as $val){
					
					//Get Unit
					$val_unit = $dbf->strRecordID("common","*","id='$val[units]'");
										
					//Get course according to group
					$res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					//Count the Number of students withing a group
					$count_student = $dbf->countRows('student_group_dtls',"parent_id='$val[id]'");
					
					//Get Teacher Name according to group
					$res_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
					
					//Starting date of the group
					$sy = date('Y',strtotime($val[start_date]));
					$sm = date('m',strtotime($val[start_date]))-1;
					$sd = date('d',strtotime($val[start_date]));
					$ssm=(strlen($sm)==1?'0'.$sm:$sm);
					$ssd=(strlen($sd)==1?'0'.$sd:$sd);
					//Ending date of the group
					$ey = date('Y',strtotime($val[end_date]));
					$em = date('m',strtotime($val[end_date]))-1;
					$ed = date('d',strtotime($val[end_date]));
					$eem=(strlen($em)==1?'0'.$em:$em);
					$eed=(strlen($ed)==1?'0'.$ed:$ed);
					////Starting date of the group from Units Table (Min date)
					$num=$dbf->countRows('ped_units',"group_id='$val[id]'");
					if($num==0){
						//Starting date of the group
						$psy = $sy;
						$psm = $sm;
						$psd = $sd;
						$ppsm=(strlen($psm)==1?'0'.$psm:$psm);
						$ppsd=(strlen($psd)==1?'0'.$psd:$psd);
						//Ending date of the group
						$pey = $sy;
						$pem = $sm;
						$ped = $sd;
						$ppem=(strlen($pem)==1?'0'.$pem:$pem);
						$pped=(strlen($ped)==1?'0'.$ped:$ped);
					}else{
						$res_min = $dbf->strRecordID("ped_units","MIN(dated)","group_id='$val[id]'");
						
						
						//Starting date of the group
						$psy = date('Y',strtotime($res_min["MIN(dated)"]));
						$psm = date('m',strtotime($res_min["MIN(dated)"]))-1;
						$psd = date('d',strtotime($res_min["MIN(dated)"]));
						$ppsm=(strlen($psm)==1?'0'.$psm:$psm);
						$ppsd=(strlen($psd)==1?'0'.$psd:$psd);
						$res_min1 = $dbf->strRecordID("ped_units","MAX(dated)","group_id='$val[id]'");						
						
						//Ending date of the group
						$pey = date('Y',strtotime($res_min1["MAX(dated)"]));
						$pem = date('m',strtotime($res_min1["MAX(dated)"]))-1;
						$ped = date('d',strtotime($res_min1["MAX(dated)"]));
						$ppem=(strlen($pem)==1?'0'.$pem:$pem);
						$pped=(strlen($ped)==1?'0'.$ped:$ped);
					}
					
					$smonth = $sm + 1;
					
					if($count_student > 1){
						$count_student = $count_student. ' students';
					}else{
						$count_student = $count_student. ' student';
					}
					$title=strtoupper($val['group_name']);
					$timeSlot=$dbf->printClassTimeFormat($val['group_start_time'],$val['group_end_time']);
					/*
					$a =$a.','. '
					{id: 1, name: "'.$val[group_name].' ('.$res_course[name].')<br>['.$count_student.']<br>Teacher : '.$res_teacher[name].'", series: [{ name: "Start : '.date('d/M/Y',strtotime($val[start_date])).'<br>'.$val[group_time].'", start: new Date('.$sy.','.$sm.','.$sd.'), end: new Date('.$ey.','.$em.','.$ed.') },
																   { name: "End : '.date('d/M/Y',strtotime($val[end_date])).'<br>'.$val[group_time_end].'", start: new Date('.$psy.','.$psm.','.$psd.'), end: new Date('.$pey.','.$pem.','.$ped.'), color: "#FFF000" }]
					}
					';
					*/
					//Start:'.date('d/M/Y',strtotime($val[start_date])).'
					$a =$a.','. '
								{
									id: 1, name: "'.$val[group_name].' <br/>'.$timeSlot.'",
									series: [
												{	name:"Start: '.date('d/M/Y',strtotime($val[start_date])).'<br>End : '.date('d/M/Y',strtotime($val[end_date])).'", 
													title: "'.$title.'",
													start: new Date('.$sy.','.$ssm.','.$ssd.'),
													end: new Date('.$ey.','.$eem.','.$eed.'),
													color: "#f7c89a"
												},
												{	name:"Attendance:", 
													title: "'.$title.'",
													start: new Date('.$psy.','.$ppsm.','.$ppsd.'),
													end: new Date('.$pey.','.$ppem.','.$pped.'),
													color: "#FFF000"
												}
											]	
								}';
				}
				$a='['.substr($a,1).']';
				?>
                <script language="JavaScript" type="text/javascript">
                var ganttData =<?php echo $a;?>;
								/*$("#ganttChart").gantt({source: data, navigate: 'scroll', scale: 'days', maxScale: 'weeks', minScale: 'hours'});*/
                </script></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="300" align="left" valign="top" bgcolor="#EFEFEF">&nbsp;</td>
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
<?php } else{?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="3%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="97%" align="left" valign="top">
        
        <form name="frm" id="frm" method="post">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#000000;">
            <tr>
              <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                <tr>
                  
                  <td width="22%">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="8%" align="left">&nbsp;</td>
                  <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_CENTRE_SCHEDULE_HEADTEXT");?></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="40" align="right" valign="middle" bgcolor="#EFEFEF" style="padding-left:15px;">
                <table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#993030;">
                    <tr>
                      
                      <td width="10" align="left" valign="middle" bgcolor="#FFCB7D">&nbsp;</td>
                      <?php
                      if($_REQUEST['centre_id'] == ''){
						$cid = $_SESSION['centre_id'];
					  }else{
						  $cid = $_REQUEST['centre_id'];
					  }
					  ?>
                      <td width="270" align="right" valign="middle" bgcolor="#FFCB7D">
                          <select name="centre_id" id="centre_id"  style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();">
                            <option value="">--<?php echo constant("ALL_CENTER");?>--</option>
                            <?php
                                foreach($dbf->fetchOrder('centre',"","name") as $val1) {	
                              ?>
                            <option value="<?php echo $val1[id];?>" <?php if($cid==$val1["id"]) { ?> selected="selected" <?php } ?>><?php echo $val1[name];?></option>
                            <?php
                               }
                               ?>
                          </select>
                      </td>
                      <td width="70" height="35" align="right" valign="middle" bgcolor="#FFCB7D" class="leftmenu"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?></td>
                    </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td height="40" align="right" valign="middle" bgcolor="#EFEFEF" style="padding-left:15px;">
              <table width="350" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999999;">
                <tr>
                  
                  <td width="46" height="25" align="right" valign="middle" bgcolor="#DDDDDD" class="mycon"><?php echo constant("CD_CENTRE_SCHEDULE_All");?></td>
                  <td width="24" align="left" valign="middle" bgcolor="#DDDDDD"><input name="status" type="radio" id="status" value="All" checked="checked" onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();" /></td>
                  <td width="69" align="right" valign="middle" bgcolor="#DDDDDD" class="mycon"><?php echo constant("CD_CENTRE_SCHEDULE_NOTSATRTED");?></td>
                  <td width="20" align="left" valign="middle" bgcolor="#DDDDDD"><input type="radio" name="status" id="status" value="Not Started" <?php if($_REQUEST[status]=="Not Started") {?> checked="checked" <?php } ?> onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();"/></td>
                  <td width="71" align="right" valign="middle" bgcolor="#DDDDDD" class="mycon"><?php echo constant("CD_CENTRE_SCHEDULE_CONTINUE");?></td>
                  <td width="20" align="left" valign="middle" bgcolor="#DDDDDD" class="mycon">
                    <input type="radio" name="status" id="status" value="Continue" <?php if($_REQUEST[status]=="Continue") {?> checked="checked" <?php } ?> onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();"/>
                  </td>
                  <td width="80" align="right" valign="middle" bgcolor="#DDDDDD" class="mycon"><?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?></td>
                  <td width="20" align="left" valign="middle" bgcolor="#DDDDDD" class="mycon">
                    <input type="radio" name="status" id="status" value="Completed" <?php if($_REQUEST[status]=="Completed") {?> checked="checked" <?php } ?> onchange="javascript:document.frm.action='centre_schedule.php',document.frm.submit();"/>
                  </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="left" valign="top" bgcolor="#EFEFEF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#EFEFEF" class="mycon">
                  <td align="left" valign="middle" style="padding-left:15px;"><div id="ganttChart"></div>
                    <!--<link rel="stylesheet" type="text/css" href="js_gchart/jquery-ui-1.8.4.css" />-->
                    <!--<link rel="stylesheet" type="text/css" href="js_gchart/reset.css" />-->
                    <link rel="stylesheet" type="text/css" href="js_gchart/jquery.ganttView.css" />
                    <script type="text/javascript" src="js_gchart/jquery-1.4.2.js"></script>
                    <script type="text/javascript" src="js_gchart/date.js"></script>
                    <script type="text/javascript" src="js_gchart/jquery-ui-1.8.4.js"></script>

                    <script type="text/javascript" src="js_gchart/jquery.ganttView.js"></script>
                    <script type="text/javascript">
                    $(function () {
                        $("#ganttChart").ganttView({ 
                            data: ganttData,
                            slideWidth: 1000,
                            behavior: {
                                onClick: function (data) { 
                                    var msg = "You clicked on an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                                    $("#eventMessage").text(msg);
                                },
                                onResize: function (data) { 
                                    var msg = "You resized an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                                    $("#eventMessage").text(msg);
                                },
                                onDrag: function (data) { 
                                    var msg = "You dragged an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                                    $("#eventMessage").text(msg);
                                }
                            }
                        });
                        
                        // $("#ganttChart").ganttView("setSlideWidth", 600);
                    });
                </script>
                    <?php				
				if($_REQUEST['status']=='' || $_REQUEST['status']=='All'){
					$cond = '';
				}else{
					$cond = "status='$_REQUEST[status]'";
				}
				if($_REQUEST[centre_id]!=''){
					if($cond == ''){
						$cond = "centre_id='$_REQUEST[centre_id]'";
					}else{
						$cond = $cond." And centre_id='$_REQUEST[centre_id]'";
					}
				}else{
					$cond = "centre_id='$_SESSION[centre_id]'";
				}
				
				$i = 1;
				$a="";
				foreach($dbf->fetchOrder('student_group',$cond,"") as $val){
					
					//Get Unit
					$val_unit = $dbf->strRecordID("common","*","id='$val[units]'");
										
					//Get course according to group
					$res_course = $dbf->strRecordID("course","*","id='$val[course_id]'");
					
					//Count the Number of students withing a group
					$count_student = $dbf->countRows('student_group_dtls',"parent_id='$val[id]'");
					
					//Get Teacher Name according to group
					$res_teacher = $dbf->strRecordID("teacher","*","id='$val[teacher_id]'");
					
					//Starting date of the group
					$sy = date('Y',strtotime($val[start_date]));
					$sm = date('m',strtotime($val[start_date]))-1;
					$sd = date('d',strtotime($val[start_date]));
					
					//Ending date of the group
					$ey = date('Y',strtotime($val[end_date]));
					$em = date('m',strtotime($val[end_date]))-1;
					$ed = date('d',strtotime($val[end_date]));
					
					////Starting date of the group from Units Table (Min date)
					$num=$dbf->countRows('ped_units',"group_id='$val[id]'");
					if($num==0){
						//Starting date of the group
						$psy = $sy;
						$psm = $sm;
						$psd = $sd;
						
						//Ending date of the group
						$pey = $sy;
						$pem = $sm;
						$ped = $sd;
					}else{
						$res_min = $dbf->strRecordID("ped_units","MIN(dated)","group_id='$val[id]'");
						
						
						//Starting date of the group
						$psy = date('Y',strtotime($res_min["MIN(dated)"]));
						$psm = date('m',strtotime($res_min["MIN(dated)"]))-1;
						$psd = date('d',strtotime($res_min["MIN(dated)"]));
						
						$res_min = $dbf->strRecordID("ped_units","MAX(dated)","group_id='$val[id]'");						
						
						//Ending date of the group
						$pey = date('Y',strtotime($res_min["MAX(dated)"]));
						$pem = date('m',strtotime($res_min["MAX(dated)"]))-1;
						$ped = date('d',strtotime($res_min["MAX(dated)"]));
					}
					
					$smonth = $sm + 1;
					
					if($count_student > 1){
						$count_student = $count_student. ' students';
					}else{
						$count_student = $count_student. ' student';
					}
					$a =$a.','. '
					{id: 1, name: "'.$val[group_name].' ('.$res_course[name].')<br>['.$count_student.']<br>Teacher : '.$res_teacher[name].'", series: [{ name: "Start : '.date('d/M/Y',strtotime($val[start_date])).'<br>'.$val[group_time].'", start: new Date('.$sy.','.$sm.','.$sd.'), end: new Date('.$ey.','.$em.','.$ed.') },
																   { name: "End : '.date('d/M/Y',strtotime($val[end_date])).'<br>'.$dbf->GetGroupTime($val[id]).'", start: new Date('.$psy.','.$psm.','.$psd.'), end: new Date('.$pey.','.$pem.','.$ped.'), color: "#FFF000" }]
					}
					';
				}
				$a='['.substr($a,1).']';
				?>
                    <script language="JavaScript" type="text/javascript">
                var ganttData = <?php echo $a;?>;
                </script></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="300" align="left" valign="top" bgcolor="#EFEFEF">&nbsp;</td>
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
<?php }?>
</body>
</html>
