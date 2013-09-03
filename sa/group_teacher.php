<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Student Advisor")
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
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]=='')
{
	$LANGUAGE = "EN";
}else{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN'){
?>
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR'){
?>
<script src="js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>

<script>	
$(document).ready(function() {	
	$("#frm").validationEngine()
});

// JUST AN EXAMPLE OF CUSTOM VALIDATI0N FUNCTIONS : funcCall[validate2fields]
function validate2fields(){
	if($("#firstname").val() =="" ||  $("#lastname").val() == ""){
		return false;
	}else{
		return true;
	}
}
</script>	
<!--JQUERY VALIDATION ENDS-->

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">
<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( ".datepick" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd'
	});
});


function showtime()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			//var c = ajaxRequest.responseText;
			document.getElementById('lbltime').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lbltime').innerHTML=c;
		}
	}

	var teacher_id = document.getElementById('teacher').value;
	
	if(teacher_id == '')
	{
		alert("Select the Teacher Name.");
		exit;
	}
	var dt = document.getElementById('date_value').value;
	
	document.getElementById('lblweek').innerHTML = '';
	
	ajaxRequest.open("GET", "group_teacher_timeslot_ajax.php" + "?teacher_id=" + teacher_id +"&date_value=" + dt, true);
	ajaxRequest.send(null); 
}

function showweek(type, dt, tm)
{
	if(type == 'Available')
	{
		document.getElementById('lblweek').innerHTML = dt +' / '+ tm;
		
		document.getElementById('dt').value = dt;
		document.getElementById('tm').value = tm;
	}
	else
	{
		document.getElementById('lblweek').innerHTML = type;
		
		document.getElementById('dt').value = '';
		document.getElementById('tm').value = '';
	}
}
//Simple Date Add Function
function dateAdd(datepart,number,objDate){
   y = objDate.getFullYear();
   m = objDate.getMonth()+1;
   d = objDate.getDate();
   hr =     objDate.getHours();
   mn =     objDate.getMinutes();
   sc =     objDate.getSeconds();
   newY=y;
   newM=m;
   newD=d;
   if (datepart== 'y'){
		newY = parseInt(y) + parseInt(number);
   } else if (datepart== 'm') {
		newM = parseInt(m) + parseInt(number);
   } else {
		newD = parseInt(d) + parseInt(number);
   }
   objNewDate = new Date(newY,newM,newD,hr,mn,sc);  
   return objNewDate;
}

function date_change()
{
	dateParts = document.getElementById('date_value').value;
	newDays = document.getElementById('prev_unit').value;

   	var myDate=new Date(dateParts);
	var x = myDate.setDate(myDate.getDate()+parseInt(newDays));
	x = new Date(x);

	var d  = x.getDate();
	var day = (d < 10) ? '0' + d : d;
	var m = x.getMonth()+1;
	var month = (m < 10) ? '0' + m : m;	
	var yy = x.getFullYear();
	var year = (yy < 1000) ? yy + 1900 : yy;

   	x = year + "-" + month + "-" + day;
   
    document.getElementById('gr_course_endt').value = x;
}

function check_date(){
	
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			//var c = ajaxRequest.responseText;
			document.getElementById('lblcheckdt').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblcheckdt').innerHTML=c;
		}
	}

	var teacher_id = document.getElementById('teacher').value;
	var sdt = document.getElementById('date_value').value;
	
	ajaxRequest.open("GET", "group_teacher_date_check.php" + "?teacher_id=" + teacher_id +"&sdt=" + sdt, true);
	ajaxRequest.send(null);
}

function colorchanged(id){
	clearcolor();
	var x = 'td'+id;
	document.getElementById(x).style.backgroundColor = '#FFCC00';
}

function clickcolor(id){
	clearcolor();	
	var x = 'td'+id;
	//alert(document.getElementById(x).style.backgroundColor)
	document.getElementById(x).style.backgroundColor = '#333399';
	
}
function clearcolor(){	
	for(i = 1; i < 330; i++){
		var td = 'td'+i;
		document.getElementById(td).style.backgroundColor = '';
	}	
}
</script>
<!--UI JQUERY DATE PICKER-->

<style type="text/css">
<!--
.style14 {color: #0000FF; font-weight: bold; font-size: larger; }
.style15 {font-size: larger}
.style25 {color: #0000FF; font-weight: bold; }
.style28 {font-size: 14px; font-weight: normal; color: #000000; }
.style35 {font-size: 12px; font-weight: bold; color: #000000; }
.pedtext{font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:7px;font-weight:bold;}
.teachertext{font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#999900;padding-left:2px;font-weight:bold; cursor:pointer;}
.teachertext a{font-size:12px;color:#999900;text-decoration:none; cursor:pointer;}
.teachertext1{font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#FF0000;padding-left:2px;font-weight:bold; cursor:pointer;}
-->
</style>
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

function show_teacher_group(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}		
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState != 4){
			document.getElementById('id_show_group').innerHTML="Wait ...";
		}
		if(ajaxRequest.readyState == 4){
		var c = ajaxRequest.responseText;		
		document.getElementById('id_show_group').innerHTML=c;
		}
	}
	var teacher_id = document.getElementById('teacher').value;	
	ajaxRequest.open("GET", "group_quick_teacher_group.php" + "?teacher_id=" + teacher_id, true);
	ajaxRequest.send(null);
}
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION['lang']=='EN'){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top" ><?php include 'header.php';?></td>
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
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_TOPTEXT");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="alert_manage.php"></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <tr>
                <td height="450" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("SELECT_TIME_SLOT");?></span></td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="group_course_process.php?action=teacher" name="frm" method="post" id="frm">
                          <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                              <td width="8%">&nbsp;</td>
                              <td width="27%" class="nametext"></td>
                              <td width="1%">&nbsp;</td>
                              <td width="31%">&nbsp;</td>
                              <td width="33%" rowspan="6" align="left" valign="middle" style="padding-top:3px;"><br/>
                                <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                  <tr>
                                    <td height="25" align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                  <?php
                                $ress = $dbf->strRecordID("course","*","id='$_SESSION[gr_course_id]'");							
                                ?>
                                  <tr>
                                    <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?> :</span> <span class="shop2"><?php echo $ress["name"];?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?> :</span> <span class="shop2"><?php echo $_SESSION[group_name];?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <?php
                                $res_unit = $dbf->strRecordID("common","*","id='$_SESSION[gr_course_units]'");							
                                ?>
                                    <td align="left" valign="top"><span class="shop1"> <?php echo constant("STUDENT_ADVISOR_GROUP_MANAGE_UNITSDAY");?> :</span> <span class="shop2"><?php echo $res_unit["name"];?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><span class="shop1"> Units :</span> <span class="shop2"><?php echo $_SESSION["gr_course_total_units"];?></span></td>
                                  </tr>
                                  <tr>
                                    <td height="5" align="left" valign="top"></td>
                                  </tr>
                                  </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="16%" align="left" valign="middle" class="shop1"><?php echo constant("PROGRESS_BAR");?></td>
                                <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                  <div class="meter-value" style="background-color:#847B7B; width:60%;">
                                    <div style="border:solid 1px; border-color:#847B7B; "></div>
                                  </div>
                                </div></td>
                                <td width="29%" align="left" valign="middle" class="shop2">&nbsp;60%</td>
                              </tr>
                            </table></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" colspan="3" align="left" valign="middle" class="leftmenu">
							  <?php echo constant("STUDENT_ADVISOR_GROUP_TXT5");?>                              
                              <span class="nametext1">*</span></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu">
                              <select name="teacher" id="teacher" class="validate[required]" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onChange="show_teacher_group();">
                                <option value="">--Select Teacher--</option>
                                <?php
								foreach($dbf->fetchOrder('teacher t,teacher_centre c',"t.id=c.teacher_id And c.centre_id='$_SESSION[centre_id]'","","t.*") as $ress2) {
							  ?>
                                <option value="<?php echo $ress2['id']?>"<?php if($ress2["id"]==$_SESSION[gr_course_teacher]) {?> selected="selected"<?php }?> > <?php echo $ress2['name'];?></option>
                                <?php }?>
                              </select></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_GROUP_GRPSTARTDT");?><span class="nametext1">*</span></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>
                            <!--,check_date()-->
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <?php
							if($_SESSION[gr_course_strdt]==''){
								$dt =date('Y-m-d');
							}else{
								$dt = $_SESSION["gr_course_strdt"];
							}
							?>
                              <td height="28" align="left" valign="middle" class="leftmenu"><input type="text" name="date_value" class="validate[required] datepick new_textbox80"  id="date_value" value="<?php echo $dt;?>" onChange="date_change();" /></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                            </tr>                            
                            <?php
							$no_unit = $_SESSION["gr_course_total_units"];
							
							$no_unit = ($no_unit/10) * 7;							
							
							$dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($dt)) . "+$no_unit day"));
							?>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu"><input type="hidden" name="prev_unit" id="prev_unit" value="<?php echo $no_unit;?>"></td>
                              <td height="28" align="left" valign="top" class="lable1" >
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu" height="25"><?php echo constant("STUDENT_ADVISOR_GROUP_TIMESLOT");?></td>
                                </tr>
                                <tr>
                                  <td height="25" align="left" valign="middle"><img src="../images/change_status.png" width="16" height="16" title="Refresh Time slot" onClick="showtime();" style="cursor:pointer;"></td>
                                </tr>
                                <tr>
                                  <td height="25" align="left" valign="middle" class="lable1"><?php echo constant("STUDENT_ADVISOR_GROUP_GRPENDDT");?></td>
                                </tr>
                                <tr>
                                  <td height="25" align="left" valign="middle"><input type="text" name="gr_course_endt" class="new_textbox80"  id="gr_course_endt" value="<?php echo $dt1;?>" readonly="" /></td>
                                </tr>
                                <tr>
                                  <td height="25" align="left" valign="middle">
                                  <input type="text" name="dt" class="validate[required] new_textbox80" id="dt" readonly="" value="<?php echo $_SESSION[dt];?>">
                                &nbsp;
                                <input type="text" name="tm" class="new_textbox70" id="tm" readonly="" value="<?php echo $_SESSION[tm];?>" onBlur="checkTab('tm');"></td>
                                </tr>
                                <tr>
                                  <td height="25" align="left" valign="middle" id="lblweek">&nbsp;</td>
                                </tr>
                              </table>
                              </td>
                              <td>&nbsp;</td>
                              <td colspan="2" align="left" valign="top" id="id_show_group">
                              <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse:collapse;">
                                  <tr class="logintext">
                                    <td width="19%" height="20" align="left" valign="middle" bgcolor="#000066">
                                      <?php echo constant("STUDENT_ADVISOR_SEARCH_GROUPNM");?></td>
                                    <td width="22%" align="left" valign="middle" bgcolor="#000066"><?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                                    <td width="30%" align="left" valign="middle" bgcolor="#000066"><?php echo constant("CD_GROUP_QUICK_START_END_DATE");?></td>
                                    <td width="12%" align="center" valign="middle" bgcolor="#000066"><?php echo constant("CD_GROUP_TEACHER_TIME");?></td>
                                    <td width="17%" align="left" valign="middle" bgcolor="#000066"> % <?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?>
                                      </td>
                                    </tr>
                                  <tr>
                                    <td align="left" valign="middle">&nbsp;</td>
                                    <td align="left" valign="middle">&nbsp;</td>
                                    <td align="left" valign="middle">&nbsp;</td>
                                    <td align="center" valign="middle">&nbsp;</td>
                                    <td align="center" valign="middle">&nbsp;</td>
                                    </tr>
                                  </table>
                              </td>
                              </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu"></td>
                              <td height="28" align="left" valign="middle" ></td>
                              <td>&nbsp;</td>
                              <td colspan="2" align="left" valign="middle" class="mytext" style="padding-bottom:5px;"><?php if($_REQUEST["msg"] == "o0k9b4"){?>Teacher not available for  <?php echo $_SESSION["tm"];?> to <?php echo $_SESSION["end_tm"];?><?php } ?>
                                </td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle" class="leftmenu"></td>
                            </tr>
                            <tr>
                              <td height="28" colspan="5" align="center" valign="middle" id="lbltime" ><?php
                            //date calculation start here
							function week_number($date)
							{	 
								return date("W", strtotime("$date + 1 day"));
							}
							
							function datefromweeknr($aYear, $aWeek, $aDay)
							{
								$Days=array('xx','ma','di','wo','do','vr','za','zo');
								$DayOfWeek=array_search($aDay,$Days); //get day of week (1=Monday)
								$DayOfWeekRef = date("w", mktime (0,0,0,1,4,$aYear)); //get day of week of January 4 (always week 1)
								if ($DayOfWeekRef==0)
									$DayOfWeekRef=7;
									$ResultDate=mktime(0,0,0,1,4,$aYear)+((($aWeek-1)*7+($DayOfWeek-$DayOfWeekRef))*86400);
							
									return $ResultDate;
							};
							
							function week_start_date($wk_num, $yr, $first = 1, $format = 'F d, Y')
							{
								$wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
								$mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
								return date($format, $mon_ts);
							}
									
							//------------------------------------------
							//accepting dynamic date value
							//------------------------------------------
							
							$teacher_id = $_SESSION["gr_course_teacher"];
																					
							if($_SESSION[gr_course_strdt]==""){
								unset($dd);
								unset($chdate);
							}else{
								$dd=strtotime($_SESSION[gr_course_strdt]);
								$chdate=date("Y-m-d",$dd);
							}
							if(isset($chdate)){
								$date=$chdate;
							}else{
								$date=date("Y-m-d");
							}
							
							$yar=date('Y',strtotime($date));
							$d=date('d',strtotime($date));
							$wk_num= week_number($date); 
							
							//echo $sStartDate = week_start_date($wk_num, $yr);
							//$rr=datefromweeknr($yar, $wk_num, $d);;
							//$sStartDate= date('Y-m-d',$rr);
							$sStartDate= date('Y-m-d');
							
							// $sStartDate = week_start_date($wk_num, $yr);
							$startdate= date('Y-m-d', strtotime('+1 days', strtotime($sStartDate))); 
							$enddate   = date('Y-m-d', strtotime('+6 days', strtotime($sStartDate))); 
							
							//exit;
							//$sund=date('Y-m-d', strtotime('+0 days', strtotime($sStartDate))); 
							$sun=date('m/j', strtotime('+1 days', strtotime($sStartDate))); 
							$mon= date('m/j', strtotime('+2 days', strtotime($sStartDate))); 
							$tue= date('m/j', strtotime('+3 days', strtotime($sStartDate)));
							$wed= date('m/j', strtotime('+4 days', strtotime($sStartDate))); 
							$thu= date('m/j', strtotime('+5 days', strtotime($sStartDate))); 
							$fri= date('m/j', strtotime('+6 days', strtotime($sStartDate)));
							$sat= date('m/j', strtotime('0 days', strtotime($sStartDate))); 
							
							$sun1=date('Y-m-d', strtotime('+0 days', strtotime($sStartDate))); 
							$mon1= date('Y-m-d', strtotime('+1 days', strtotime($sStartDate))); 
							$tue1= date('Y-m-d', strtotime('+2 days', strtotime($sStartDate)));
							$wed1= date('Y-m-d', strtotime('+3 days', strtotime($sStartDate))); 
							$thu1= date('Y-m-d', strtotime('+4 days', strtotime($sStartDate))); 
							$fri1= date('Y-m-d', strtotime('+5 days', strtotime($sStartDate)));
							$sat1= date('Y-m-d', strtotime('+6 days', strtotime($sStartDate)));
							
							$sum_month= date('m', strtotime('+0 days', strtotime($sStartDate))); 
							$mon_month= date('m', strtotime('+1 days', strtotime($sStartDate))); 
							$tue_month= date('m', strtotime('+2 days', strtotime($sStartDate)));
							$wed_month= date('m', strtotime('+3 days', strtotime($sStartDate))); 
							$thu_month= date('m', strtotime('+4 days', strtotime($sStartDate))); 
							$fri_month= date('m', strtotime('+5 days', strtotime($sStartDate)));
							$sat_month= date('m', strtotime('+6 days', strtotime($sStartDate))); 
							
							$sum_day= date('D', strtotime('+0 days', strtotime($sStartDate))); 
							$mon_day= date('D', strtotime('+1 days', strtotime($sStartDate))); 
							$tue_day= date('D', strtotime('+2 days', strtotime($sStartDate)));
							$wed_day= date('D', strtotime('+3 days', strtotime($sStartDate))); 
							$thu_day= date('D', strtotime('+4 days', strtotime($sStartDate))); 
							$fri_day= date('D', strtotime('+5 days', strtotime($sStartDate)));
							$sat_day= date('D', strtotime('+6 days', strtotime($sStartDate))); 
							
							$year=date('Y',strtotime($date));
							//date calculation end here
                            ?>
                            <style>
							.scroll-div{
							overflow-x:hidden;
							overflow-y:scroll;
							font-size:11px;
							font-weight:bold;
							color:#245F9A;
							float:left;
							width:99%;
							height:300px;
							margin:5px 0px;
							}
							</style>
                               <?php
                            $centre_id = $_SESSION['centre_id'];
                            $center = $dbf->strRecordID("centre", "*", "id='$centre_id'");
                            $start_time = $center["class_start_time"];
                            $end_time = $center["class_end_time"];
                            
                            $tot = $dbf->TimeDiff($start_time,$end_time);
                            $time = explode(":",$tot);
                            
                            $minutes = intval($time[0])*60 + intval($time[1]);
                            $minutes = $minutes / 15;
                            ?>
                               <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#EBE5CD" style="border-collapse:collapse;">
                              <tr>
                                <td width="85" height="30" align="center" valign="middle" bordercolor="#FF9933" bgcolor="#FFF8E6" class="pedtext"><?php echo constant("CD_GROUP_TEACHER_TIME");?></td>
                                <td align="left" valign="middle" bordercolor="#FF9933" bgcolor="#EBEBEB"><table width="690" border="0" cellspacing="0" cellpadding="0">
                                  <tr class="pedtext">
                                    <td width="86" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $sum_day.'<br>'.$sat?></td>
                                    <td width="96" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $mon_day.'<br>'.$sun?></td>
                                    <td width="96" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $tue_day.'<br>'.$mon?></td>
                                    <td width="89" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $wed_day.'<br>'.$tue?></td>
                                    <td width="95" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $thu_day.'<br>'.$wed?></td>
                                    <td width="90" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $fri_day.'<br>'.$thu?></td>
                                    <td align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $sat_day.'<br>'.$fri?></td>
                                    <td align="center" valign="middle">&nbsp;</td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td height="25" colspan="2" align="center" valign="middle">
                                  
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td align="left" valign="middle">
                                      
                                      
                                      <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#EBE5CD" style="border-collapse:collapse;">
  
                                      <tr>
                                        <td height="25" colspan="2" align="center" valign="middle">
                                          
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td align="left" valign="middle">
                                              
                                              <div class="scroll-div">
                                      
                                      <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#EBE5CD" style="border-collapse:collapse;">
                                      <?php
									  $line = 1;
									  for($k = 1; $k <= $minutes; $k++){
									  if($k == 1){
										  $centre_time = date('h:i A', strtotime($start_time));
									  }
									  //echo $line;				  
									  $starttime = date('H:i:s',strtotime(date("H:i:s", strtotime($centre_time)) . " +1 minutes"));									  
                                      ?>
                                        <tr>
                                          <td width="70" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo $centre_time;?></td>
                                          <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0" >
                                              <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                                <td width="3" align="left" valign="middle"></td>
                                                <?php                                            
                                            $num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$sun1' BETWEEN start_date And end_date)");
                                            if($num==0){
                                                $class = 'teachertext';
                                                $text = 'Available';
                                                $img = "../images/tick.png";
                                            }else{
                                                $class = 'teachertext1';
                                                $text = 'Not Available';
                                                $img = "../images/block.png";
                                            }
											
											$each_day = date('l', strtotime($sStartDate));
											$each_date = date('Y-m-d', strtotime($sStartDate));
                                            $weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
											$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
											
                                            if($weekend == 0){
                                            ?>
                                                <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $sun1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                                <?php } else { ?>
                                                <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1"  id="td<?php echo $line;?>">Non-Teaching Day</td>
                                                <?php } $line++;?>
                                                <td width="3" align="right" valign="middle"></td>
                                                </tr>
                                              </table></td>
                                          <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                                <td width="3" align="left" valign="middle"></td>
                                                <?php
											$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$mon1' BETWEEN start_date And end_date)");
											if($num==0){
												$class = 'teachertext';
												$text = 'Available';
												$img = "../images/tick.png";
											}else{
												$class = 'teachertext1';
												$text = 'Not Available';
												$img = "../images/block.png";
											}                    
											
											$each_day = date('l', strtotime($each_day));
											$each_date = date('Y-m-d', strtotime($each_day));
											$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
											$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
											
											if($weekend == 0){
											?>
                                                <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $mon1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                                <?php } else { ?>
                                                <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                                <?php } $line++; ?>
                                                <td width="3" align="right" valign="middle"></td>
                                                </tr>
                                              </table></td>
                                          <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                                <td width="3" align="left" valign="middle"></td>
                                                <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$tue1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0)
										{
										?>
                                                <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $tue1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                                <?php } else { ?>
                                                <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                                <?php } $line++; ?>
                                                <td width="3" align="right" valign="middle"></td>
                                                </tr>
                                              </table></td>
                                          <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                                <td width="3" align="left" valign="middle"></td>
                                                <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$wed1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0)
										{
										?>
                                                <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $wed1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                                <?php } else { ?>
                                                <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                                <?php } $line++; ?>
                                                <td width="3" align="right" valign="middle"></td>
                                                </tr>
                                              </table></td>
                                          <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                                <td width="3" align="left" valign="middle"></td>
                                                <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$thu1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0){
										?>
                                                <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $thu1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                                <?php } else { ?>
                                                <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                                <?php } $line++; ?>
                                                <td width="3" align="right" valign="middle"></td>
                                                </tr>
                                              </table></td>
                                          <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                                <td width="3" align="left" valign="middle"></td>
                                                <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$fri1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0){
										?>
                                                <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $fri1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);"><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                                <?php } else { ?>
                                                <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                                <?php } $line++; ?>
                                                <td width="3" align="right" valign="middle"></td>
                                                </tr>
                                              </table></td>
                                          <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                                <td width="3" align="left" valign="middle"></td>
                                                <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$sat1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0){
										?>
                                                <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $sat1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);"><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                                <?php } else { ?>
                                                <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                                <?php } $line++; ?>
                                                <td width="3" align="right" valign="middle"></td>
                                                </tr>
                                              </table></td>
                                        </tr>
                                        <?php						
										$centre_time = date('h:i A',strtotime(date("H:i:s", strtotime($centre_time)) . " +15 minutes"));
										$each_day = $sStartDate;
									  }
										?>
                                        
                                        </table>
                            
                                      </div>
                                      
                                              </td>
                                              </tr>
                                            </table>
                                          
                                          </td>
                                      </tr>
                            </table>

                                     
                                      </td>
                                      </tr>
                                    </table>
                                  
                                  </td>
                              </tr>
                            </table>
                               
                               </td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle" class="leftmenu"></td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                            <tr>
                              <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                              <td height="25" align="left" valign="middle" class="leftmenu"><a href="group_unit.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
                              <td>&nbsp;</td>
                              <td align="left" valign="middle">&nbsp;</td>
                              <td align="left"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn1"/></td>
                            </tr>
                            <tr>
                              <td height="10" colspan="5" align="left" valign="middle"></td>
                            </tr>
                          </table>
                        </form>
                        
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="5" align="left" valign="top"><img src="../images/bot_left.png" width="5" height="4" /></td>
                            <td width="100%" style="background:url(../images/bot_mid.png) repeat-x;"></td>
                            <td width="5" align="right" valign="top"><img src="../images/bot_right.png" width="5" height="4" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                
				</td>
              </tr>
              <tr>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
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
    <td height="104" align="left" valign="top" ><?php include 'header_right.php';?></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="98%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left"><a href="alert_manage.php"></a></td>
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_GROUP_TOPTEXT");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <tr>
                      <td height="450" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("SELECT_TIME_SLOT");?></span></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                  
                                  <form action="group_course_process.php?action=teacher" name="frm" method="post" id="frm">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                      <tr>
                                        <td width="28%" rowspan="6" align="center" valign="top" style="padding-top:3px;"><br/>
                                          <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                            <tr>
                                              <td height="25" align="left" valign="middle">&nbsp;</td>
                                              </tr>
                                            <?php
                                $ress = $dbf->strRecordID("course","*","id='$_SESSION[gr_course_id]'");							
                                ?>
                                            <tr>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $ress["name"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[group_name];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_GROUP");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <?php
                                $res_unit = $dbf->strRecordID("common","*","id='$_SESSION[gr_course_units]'");							
                                ?>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $res_unit["name"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_GROUP_MANAGE_UNITSDAY");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="left" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td height="30" align="left" valign="top">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td height="5" align="left" valign="top"></td>
                                            </tr>
                                            </table></td>
                                        <td width="40%">&nbsp;</td>
                                        <td width="1%">&nbsp;</td>
                                        <td width="25%" class="nametext"></td>
                                        <td width="6%">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
											<td width="29%" align="right" valign="middle" class="shop2">60%&nbsp;</td>                                            
                                            <td width="55%" align="left" valign="middle" style="padding-left:2px;">
                                            <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                              <div class="meter-value" style="background-color:#847B7B; width:60%;">
                                                <div style="border:solid 1px; border-color:#847B7B; "></div>
                                                </div>
                                              </div></td>
                                              <td width="16%" align="left" valign="middle" class="shop1">&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                            
                                            </tr>
                                          </table></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="28" colspan="3" align="right" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_GROUP_TXT5");?></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="right" valign="middle" class="leftmenu"><?php //echo $_SESSION[centre_id];?>
                                          <select name="teacher" id="teacher" class="validate[required]" style="width:150px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                                            <option value="">--<?php echo constant("ADMIN_REPORT_TEACHER_SCHEDULE_SELECTTEACHER");?>--</option>
                                            <?php
								foreach($dbf->fetchOrder('teacher t,teacher_centre c',"t.id=c.teacher_id And c.centre_id='$_SESSION[centre_id]'","","t.*") as $ress2) {
							  ?>
                                            <option value="<?php echo $ress2['id']?>"<?php if($ress2["id"]==$_SESSION[gr_course_teacher]) {?> selected="selected"<?php }?> > <?php echo $ress2['name'];?></option>
                                            <?php }?>
                                            </select></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="right" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("STUDENT_ADVISOR_GROUP_GRPSTARTDT");?></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <!--,check_date()-->
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <?php
										if($_SESSION[gr_course_strdt]=='')
										{
											$dt =date('Y-m-d');
										}
										else
										{
											$dt = $_SESSION["gr_course_strdt"];
										}
										?>
                                        <td height="28" align="right" valign="middle" class="leftmenu"><input type="text" name="date_value" class="validate[required] datepick new_textbox80_ar"  id="date_value" value="<?php echo $dt;?>" onChange="date_change();" /></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <?php
										$sdt = $_SESSION[gr_course_strdt];
										$is_exist = '';
										$teacher_id = $_SESSION[gr_course_teacher];					
										foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id'","id") as $val_group)
										{
											
											$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$_REQUEST[sdt]' BETWEEN start_date And end_date)");
											if($num>0)
											{
												$is_exist = 'true';
												break;
											}		
										}
										?>
                                        <td colspan="2" align="right" valign="top" id="id_show_group">
                                        <table width="98%" border="1" cellspacing="0" cellpadding="0" bordercolor="#cccccc" style="border-collapse:collapse;">
                                          <tr class="logintext">
                                            <td width="19%" height="20" align="left" valign="middle" bgcolor="#000066">
                                              <?php echo constant("STUDENT_ADVISOR_SEARCH_GROUPNM");?></td>
                                            <td width="22%" align="left" valign="middle" bgcolor="#000066"><?php echo constant("STUDENT_ADVISOR_GROUP_COURSE");?></td>
                                            <td width="30%" align="left" valign="middle" bgcolor="#000066"><?php echo constant("CD_GROUP_QUICK_START_END_DATE");?></td>
                                            <td width="12%" align="center" valign="middle" bgcolor="#000066"><?php echo constant("CD_GROUP_TEACHER_TIME");?></td>
                                            <td width="17%" align="left" valign="middle" bgcolor="#000066"> % <?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?>
                                              </td>
                                            </tr>
                                          <tr>
                                            <td align="left" valign="middle">&nbsp;</td>
                                            <td align="left" valign="middle">&nbsp;</td>
                                            <td align="left" valign="middle">&nbsp;</td>
                                            <td align="center" valign="middle">&nbsp;</td>
                                            <td align="center" valign="middle">&nbsp;</td>
                                            </tr>
                                          </table>
										</td>                                        
                                        <td>&nbsp;</td>
                                        <?php
										if($_SESSION[gr_course_strdt]==''){
											$dt =date('Y-m-d');
										}else{
											$dt = $_SESSION["gr_course_strdt"];
										}
										
										$no_unit = $_SESSION["gr_course_total_units"];
										
										$no_unit = ($no_unit/10) * 7;							
										
										$dt1 = date('Y-m-d',strtotime(date("Y-m-d", strtotime($dt)) . "+$no_unit day"));										
										?>
                                        <td height="28" align="right" valign="middle" >
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td align="right" valign="middle" class="leftmenu" height="25"><?php echo constant("STUDENT_ADVISOR_GROUP_TIMESLOT");?></td>
                                              </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle"><img src="../images/change_status.png" width="16" height="16" title="Refresh Time slot" onClick="showtime();" style="cursor:pointer;"></td>
                                              </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle" class="lable1"><?php echo constant("STUDENT_ADVISOR_GROUP_GRPENDDT");?></td>
                                              </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle"><input type="text" name="gr_course_endt" class="new_textbox80_ar"  id="gr_course_endt" value="<?php echo $dt1;?>" readonly="" /></td>
                                              </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle"><input type="text" name="dt" class="validate[required] new_textbox80" id="dt" readonly="" value="<?php echo $_SESSION[dt];?>">
                                          &nbsp;
                                          <input type="text" name="tm" class="new_textbox70" id="tm" readonly="" value="<?php echo $_SESSION[tm];?>" onBlur="checkTab('tm');"></td>
                                              </tr>
                                            <tr>
                                              <td height="25" align="right" valign="middle" class="lable1" id="lblweek">&nbsp;</td>
                                              </tr>
                                            </table>
                                          </td>
                                        <td align="left" valign="middle" class="leftmenu"><input type="hidden" name="prev_unit" id="prev_unit" value="<?php echo $no_unit;?>"></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="right" valign="bottom" class="shop2" ><?php if($_REQUEST["msg"] == "o0k9b4"){ echo 'Teacher not available for $_SESSION["tm"] to $_SESSION["end_tm"]'; } ?></td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="right" valign="middle" ></td>
                                        <td align="left" valign="middle" class="leftmenu"></td>
                                      </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle" class="leftmenu"></td>
                                      </tr>
                                      <tr>
                                        <td height="28" colspan="5" align="center" valign="middle" id="lbltime" ><?php
										//date calculation start here
										function week_number($date)
										{	 
											return date("W", strtotime("$date + 1 day"));
										}
										
										function datefromweeknr($aYear, $aWeek, $aDay)
										{
											$Days=array('xx','ma','di','wo','do','vr','za','zo');
											$DayOfWeek=array_search($aDay,$Days); //get day of week (1=Monday)
											$DayOfWeekRef = date("w", mktime (0,0,0,1,4,$aYear)); //get day of week of January 4 (always week 1)
											if ($DayOfWeekRef==0)
												$DayOfWeekRef=7;
												$ResultDate=mktime(0,0,0,1,4,$aYear)+((($aWeek-1)*7+($DayOfWeek-$DayOfWeekRef))*86400);
										
												return $ResultDate;
										};
										
										function week_start_date($wk_num, $yr, $first = 1, $format = 'F d, Y')
										{
											$wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
											$mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
											return date($format, $mon_ts);
										}
												
										//------------------------------------------
										//accepting dynamic date value
										//------------------------------------------
										
										$teacher_id = $_SESSION["gr_course_teacher"];
																								
										if($_SESSION[gr_course_strdt]==""){
											unset($dd);
											unset($chdate);
										}else{
											$dd=strtotime($_SESSION[gr_course_strdt]);
											$chdate=date("Y-m-d",$dd);
										}
										if(isset($chdate)){
											$date=$chdate;
										}else{
											$date=date("Y-m-d");
										}
										
										$yar=date('Y',strtotime($date));
										$d=date('d',strtotime($date));
										$wk_num= week_number($date); 
										
										//echo $sStartDate = week_start_date($wk_num, $yr);
										$rr=datefromweeknr($yar, $wk_num, $d);;
										$sStartDate= date('Y-m-d',$rr);
										
										// $sStartDate = week_start_date($wk_num, $yr);
										$startdate= date('Y-m-d', strtotime('+0 days', strtotime($sStartDate))); 
										$enddate   = date('Y-m-d', strtotime('+6 days', strtotime($sStartDate))); 
										
										//exit;
										//$sund=date('Y-m-d', strtotime('+0 days', strtotime($sStartDate))); 
										$sun=date('m/j', strtotime('+0 days', strtotime($sStartDate))); 
										$mon= date('m/j', strtotime('+1 days', strtotime($sStartDate))); 
										$tue= date('m/j', strtotime('+2 days', strtotime($sStartDate)));
										$wed= date('m/j', strtotime('+3 days', strtotime($sStartDate))); 
										$thu= date('m/j', strtotime('+4 days', strtotime($sStartDate))); 
										$fri= date('m/j', strtotime('+5 days', strtotime($sStartDate)));
										$sat= date('m/j', strtotime('-1 days', strtotime($sStartDate))); 
										
										$sun1=date('Y-m-d', strtotime('+0 days', strtotime($sStartDate))); 
										$mon1= date('Y-m-d', strtotime('+1 days', strtotime($sStartDate))); 
										$tue1= date('Y-m-d', strtotime('+2 days', strtotime($sStartDate)));
										$wed1= date('Y-m-d', strtotime('+3 days', strtotime($sStartDate))); 
										$thu1= date('Y-m-d', strtotime('+4 days', strtotime($sStartDate))); 
										$fri1= date('Y-m-d', strtotime('+5 days', strtotime($sStartDate)));
										$sat1= date('Y-m-d', strtotime('+6 days', strtotime($sStartDate)));
										
										$sum_month= date('m', strtotime('+0 days', strtotime($sStartDate))); 
										$mon_month= date('m', strtotime('+1 days', strtotime($sStartDate))); 
										$tue_month= date('m', strtotime('+2 days', strtotime($sStartDate)));
										$wed_month= date('m', strtotime('+3 days', strtotime($sStartDate))); 
										$thu_month= date('m', strtotime('+4 days', strtotime($sStartDate))); 
										$fri_month= date('m', strtotime('+5 days', strtotime($sStartDate)));
										$sat_month= date('m', strtotime('+6 days', strtotime($sStartDate))); 
										
										$sum_day= date('j', strtotime('+0 days', strtotime($sStartDate))); 
										$mon_day= date('j', strtotime('+1 days', strtotime($sStartDate))); 
										$tue_day= date('j', strtotime('+2 days', strtotime($sStartDate)));
										$wed_day= date('j', strtotime('+3 days', strtotime($sStartDate))); 
										$thu_day= date('j', strtotime('+4 days', strtotime($sStartDate))); 
										$fri_day= date('j', strtotime('+5 days', strtotime($sStartDate)));
										$sat_day= date('j', strtotime('+6 days', strtotime($sStartDate))); 
										
										$year=date('Y',strtotime($date));
										//date calculation end here
										?>
													  <style>
										.scroll-div{
										overflow-x:hidden;
										overflow-y:scroll;
										font-size:11px;
										font-weight:bold;
										color:#245F9A;
										float:left;
										width:99%;
										height:300px;
										margin:5px 0px;
										}
										</style>
                                         <?php
										$centre_id = $_SESSION['centre_id'];
										$center = $dbf->strRecordID("centre", "*", "id='$centre_id'");
										$start_time = $center["class_start_time"];
										$end_time = $center["class_end_time"];
										
										$tot = $dbf->TimeDiff($start_time,$end_time);
										$time = explode(":",$tot);
										
										$minutes = intval($time[0])*60 + intval($time[1]);
										$minutes = $minutes / 15;
										?> 
                                          <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#EBE5CD" style="border-collapse:collapse;">
                                          <tr>
                                            <td width="12%" height="30" align="center" valign="middle" bordercolor="#FF9933" bgcolor="#FFF8E6"><span class="pedtext"><?php echo constant("CD_GROUP_TEACHER_TIME");?></span></td>
                                            <td width="88%" bordercolor="#FF9933" bgcolor="#FFF8E6"><table width="600" border="0" cellspacing="0" cellpadding="0">
                                  <tr class="pedtext">
                                    <td width="82" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $sum_day.'<br>'.$sat?></td>
                                    <td width="82" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $mon_day.'<br>'.$sun?></td>
                                    <td width="86" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $tue_day.'<br>'.$mon?></td>
                                    <td width="77" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $wed_day.'<br>'.$tue?></td>
                                    <td width="83" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $thu_day.'<br>'.$wed?></td>
                                    <td width="77" align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $fri_day.'<br>'.$thu?></td>
                                    <td align="center" valign="middle" bgcolor="#FFF8E6" style="border-right:solid 1px; border-color:#EBE5CD;"><?php echo $sat_day.'<br>'.$fri?></td>
                                    <td align="center" valign="middle">&nbsp;</td>
                                  </tr>
                                </table></td>
                                          </tr>
                              <tr>
                                <td height="25" colspan="2" align="center" valign="middle">
                                  
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td align="left" valign="middle">
                                      
                                      <div class="scroll-div">
                                      
                                      <table width="99%" border="1" cellspacing="0" cellpadding="0" bordercolor="#EBE5CD" style="border-collapse:collapse;">
                                      <?php
									  $line = 1;
									  for($k = 1; $k <= $minutes; $k++){
									  if($k == 1){
										  $centre_time = date('h:i A', strtotime($start_time));
									  }									  
									  $starttime = date('H:i:s',strtotime(date("H:i:s", strtotime($centre_time)) . " +1 minutes"));									  
                                      ?>
                                        <tr>
                                            <td width="12%" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo $centre_time;?></td>
                                            <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0" >
                                            <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                            <td width="3" align="left" valign="middle"></td>
                                            <?php                                            
                                            $num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$sun1' BETWEEN start_date And end_date)");
                                            if($num==0){
                                                $class = 'teachertext';
                                                $text = 'Available';
                                                $img = "../images/tick.png";
                                            }else{
                                                $class = 'teachertext1';
                                                $text = 'Not Available';
                                                $img = "../images/block.png";
                                            }
											
											$each_day = date('l', strtotime($sStartDate));
											$each_date = date('Y-m-d', strtotime($sStartDate));
                                            $weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
											$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
											
                                            if($weekend == 0){
                                            ?>
                                            <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $sun1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                            <?php } else { ?>
                                            <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1"  id="td<?php echo $line;?>">Non-Teaching Day</td>
                                            <?php } $line++;?>
                                            <td width="3" align="right" valign="middle"></td>
                                            </tr>
                                            </table></td>
                                            <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                            <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                            <td width="3" align="left" valign="middle"></td>
                                            <?php
											$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$mon1' BETWEEN start_date And end_date)");
											if($num==0){
												$class = 'teachertext';
												$text = 'Available';
												$img = "../images/tick.png";
											}else{
												$class = 'teachertext1';
												$text = 'Not Available';
												$img = "../images/block.png";
											}                    
											
											$each_day = date('l', strtotime($each_day));
											$each_date = date('Y-m-d', strtotime($each_day));
											$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
											$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
											
											if($weekend == 0){
											?>
                                        <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $mon1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                        <?php } else { ?>
                                        <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                        <?php } $line++; ?>
                                        <td width="3" align="right" valign="middle"></td>
                                        </tr>
                                        </table></td>
                                        <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                        <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                        <td width="3" align="left" valign="middle"></td>
                                        <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$tue1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0)
										{
										?>
                                        <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $tue1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                        <?php } else { ?>
                                        <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                        <?php } $line++; ?>
                                        <td width="3" align="right" valign="middle"></td>
                                        </tr>
                                        </table></td>
                                        <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                        <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                        <td width="3" align="left" valign="middle"></td>
                                        <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$wed1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0)
										{
										?>
                                        <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $wed1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                        <?php } else { ?>
                                        <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                        <?php } $line++; ?>
                                        <td width="3" align="right" valign="middle"></td>
                                        </tr>
                                        </table></td>
                                        <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                        <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                        <td width="3" align="left" valign="middle"></td>
                                        <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$thu1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0){
										?>
                                        <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $thu1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);" ><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                        <?php } else { ?>
                                        <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                        <?php } $line++; ?>
                                        <td width="3" align="right" valign="middle"></td>
                                        </tr>
                                        </table></td>
                                        <td width="12%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                        <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                        <td width="3" align="left" valign="middle"></td>
                                        <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$fri1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0){
										?>
                                        <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $fri1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);"><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                        <?php } else { ?>
                                        <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                        <?php } $line++; ?>
                                        <td width="3" align="right" valign="middle"></td>
                                        </tr>
                                        </table></td>
                                        <td width="13%" align="center" valign="middle" bgcolor="#FFFAF4" class="style35">
                                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                        <tr onMouseOver="this.style.backgroundColor='#EBDDE2'" onMouseOut="this.style.backgroundColor=''">
                                        <td width="3" align="left" valign="middle"></td>
                                        <?php
										$num=$dbf->countRows('student_group',"teacher_id='$teacher_id' And ('$sat1' BETWEEN start_date And end_date)");
										if($num==0){
											$class = 'teachertext';
											$text = 'Available';
											$img = "../images/tick.png";
										}else{
											$class = 'teachertext1';
											$text = 'Not Available';
											$img = "../images/block.png";
										}
										
										$each_day = date('l', strtotime($each_day));
										$each_date = date('Y-m-d', strtotime($each_day));
										$weekend = $dbf->countRows('working_day',"dyname='$each_day' And status='1'");
										$each_day = date('Y-m-d',strtotime(date("Y-m-d", strtotime($each_date)) . " +1 day"));
										
										if($weekend == 0){
										?>
                                        <td height="60" align="center" valign="middle" class="<?php echo $class;?>" id="td<?php echo $line;?>"><a onClick="showweek('<?php echo $text;?>','<?php echo $sat1;?>','<?php echo $centre_time;?>'),clickcolor(<?php echo $line;?>);"><img src="<?php echo $img;?>" height="16" width="16" title="<?php echo $text;?>" ></a></td>
                                        <?php } else { ?>
                                        <td height="60" align="center" valign="middle" bgcolor="#FFCC00" class="teachertext1" id="td<?php echo $line;?>">Non-Teaching Day</td>
                                        <?php } $line++; ?>
                                        <td width="3" align="right" valign="middle"></td>
                                        </tr>
                                        </table></td>
                                        </tr>
                                        <?php						
										$centre_time = date('h:i A',strtotime(date("H:i:s", strtotime($centre_time)) . " +15 minutes"));
										$each_day = $sStartDate;
									  }
										?>
                                        
                                        </table>
                            
                                      </div>
                                      
                                      </td>
                                      </tr>
                                    </table>
                                  
                                  </td>
                              </tr>
                            </table>
                                          
                                          </td>
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle" class="leftmenu"></td>
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle"></td>
                                        </tr>
                                      <tr>
                                        <td align="center" valign="middle" class="leftmenu"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/></td>
                                        <td align="left">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="right" valign="middle"><span class="leftmenu"><a href="group_unit.php">
                                          <input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" />
                                        </a></span></td>
                                        <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle"></td>
                                        </tr>
                                      </table>
                                    </form>
                                  
                                  </td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="5" align="left" valign="top"><img src="../images/bot_left.png" width="5" height="4" /></td>
                                    <td width="100%" style="background:url(../images/bot_mid.png) repeat-x;"></td>
                                    <td width="5" align="right" valign="top"><img src="../images/bot_right.png" width="5" height="4" /></td>
                                    </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table>
                        
                        </td>
                      </tr>
                    <tr>
                      <td bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
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
   <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
