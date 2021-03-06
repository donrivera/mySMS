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
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>

<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]==''){
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
$(function() {
	$( ".datepickFuture" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		minDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
});
</script>
<!--UI JQUERY DATE PICKER-->

<script type="text/javascript">
function checkall(type)
{
	var count = document.getElementById('count').value;
	for(i = 1; i<=count; i++)
	{
		var id = "id"+i;
		document.getElementById(id).checked = type;
	}
}

function show_course()
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
			document.getElementById('showcourse').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('showcourse').innerHTML=c;
		}
	}

	var group = document.getElementById('group').value;
	
	ajaxRequest.open("GET", "ep_no_of_students_ajax.php" + "?group=" + group, true);
	ajaxRequest.send(null); 
}

function show_student()
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
			document.getElementById('showstudent').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('showstudent').innerHTML=c;
		}
	}

	var group = document.getElementById('group').value;
	
	ajaxRequest.open("GET", "ep_scheduling_student_ajax.php" + "?group=" + group, true);
	ajaxRequest.send(null); 
}

function show_save()
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
			document.getElementById('lblsave').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblsave').innerHTML=c;
		}
	}

	var group = document.getElementById('group').value;
	
	ajaxRequest.open("GET", "ep_scheduling_save_ajax.php" + "?group=" + group, true);
	ajaxRequest.send(null); 
}

function display_save1(type){
	if(type==true){
		document.getElementById('idsave').style.display = 'block';
	}else{
		document.getElementById('idsave').style.display = 'none';
	}
}
function display_save2()
{
	document.getElementById('idsave').style.display = 'none';
	var count = document.getElementById('count').value;
	for(i = 1; i<=count; i++)
	{
		var id = "id"+i;
		if(document.getElementById(id).checked == true)
		{
			document.getElementById('idsave').style.display = 'block';
			break;
		}
	}
}

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

$(document).ready(function(){
	$("#mystatus").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("ep_scheduling_add_group_ajax.php", {status: $(this).val()}); // Page Name and Condition
	});
});
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
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo constant("CD_EP_SCHEDULING_ADD_SCHEDULINGMAKEUP");?></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="ep_scheduling_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
          </tr>
          <?php if($_REQUEST[msg]=="added") { ?>
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                <tr>
                  <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                  <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                  <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="lable1"><?php echo constant("COMMON_RECORDADDMSG");?> </td>
                </tr>
            </table></td>
          </tr>
          <?php } ?>
          <tr>
            <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
            
     		<table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td height="30" colspan="3" align="left" valign="middle" style="padding-left:340px;" id="lblerror"></td>
                </tr>
                <tr>
                  <td height="2" colspan="3" align="left" valign="middle" style="padding-left:340px;" id="lblerror2"></td>
                </tr>
                <tr>
                  <td width="30" align="left" valign="top">&nbsp;</td>
                  <td width="554" align="left" valign="top">
                  
                  <form action="ep_scheduling_process.php?action=insert" name="frm" method="post" id="frm">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#FF6600;">
                      <tr>
                        <td height="25" colspan="2" align="right" valign="middle" bgcolor="#F2F2F2" class="lable1" style="padding-left:5px;padding-bottom:5px;padding-top:5px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="38%" height="25" align="right" valign="middle" class="pedtext"><?php echo constant('ADMIN_WEEK_MANAGE_STATUS');?> :&nbsp;</td>
                            <td width="62%" align="left" valign="middle">
                            <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                                <option value="">All</option>
                                <option value="Not Started">Not Started</option>
                                <option value="Continue">Active - In Progress</option>
                                <option value="Completed">Completed</option>                               
                              </select></td>
                          </tr>
                          <tr>
                            <td height="25" align="right" valign="middle" class="pedtext"><?php echo constant("RECEPTION_GROUP_MANAGE_GROUPNAME");?> : <span class="nametext1">*</span>&nbsp;</td>
                            <td align="left" valign="middle" id="statusresult"><select name="group" class="validate[required]" id="group" style="width:150px; border:solid 1px; border-color:#999999;" onChange="show_course(),show_student(),show_save();">
                            <option value="">--Select Group--</option>
                            <?php
							foreach($dbf->fetchOrder('student_group',"status<>'Completed' And centre_id='$_SESSION[centre_id]'","","*") as $ress) {
							?>
                            <option value="<?php echo $ress[id];?>"><?php echo $ress['group_name'] ?>, <?php echo date('d/m/Y',strtotime($ress['start_date']));?> - <?php echo $ress['end_date'] ?>, <?php echo $ress["group_time"];?>-<?php echo $dbf->GetGroupTime($ress["id"]);?></option>
                            <?php }?>
                          </select></td>
                          </tr>
                        </table></td>
                        <td width="61%" align="center" valign="middle" bgcolor="#F2F2F2" id="showcourse" style="padding-bottom:5px;padding-top:5px;">
                          <table width="90%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                            <tr>
                              <td width="21%" align="center" valign="middle" bgcolor="#FEF1FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?></td>
                              <td width="21%" align="center" valign="middle" bgcolor="#FEF1FE" class="pedtext"><?php echo constant("ADMIN_MENU_COURSE");?></td>
                              <td width="39%" align="center" valign="middle" bgcolor="#FEF1FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_SCHEDULESTUDENTS");?>:</td>
                              <td width="19%" height="25" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
                              </tr>
                            <tr>
                              <td align="center" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
                              <td align="center" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
                              <td align="center" valign="middle" bgcolor="#FEF1FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_ENROLLEDSTUDENTS");?>:</td>
                              <td height="25" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
                              </tr>
                          </table></td>
                        <td width="6%" align="left" valign="middle" bgcolor="#F2F2F2">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="2" colspan="4" bgcolor="#FF6600"></td>
                      </tr>
                      <tr>
                        <td height="5" colspan="4"></td>
                      </tr>
                      <tr>
                        <td height="5" colspan="4" align="left" valign="middle" style="padding-left:5px;">
                        <table width="600" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
                          <tr>
                            <td width="41" align="left" valign="middle" bgcolor="#FDEAFF" class="nametext1">&nbsp;&nbsp;<?php echo constant("ADMIN_GROUP_SIZE_MANAGE_NOTE");?></td>
                            <td width="5" bgcolor="#FDEAFF">&nbsp;</td>
                            <td width="449" align="left" valign="middle" bgcolor="#FDEAFF" class="pedtext_normal"><?php echo constant("CD_EP_CHANGE_CLASSROOM_STUDENTCURSENOTCOMPLETE");?>.</td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="5" colspan="4"></td>
                        </tr>
                      <tr>
                        <td colspan="4" align="left" valign="middle" id="showstudent">
                        
                        <table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#AAAAAA" class="tablesorter" style="border-collapse:collapse;">
                        	<thead>
                                <tr class="pedtext">
                                  <th width="6%" align="center" valign="middle" bgcolor="#99CC99">
                                  <input type="checkbox" name="chk" id="chk" onChange="checkall(this.checked);"></th>
                                  <th width="24%" align="left" valign="middle" bgcolor="#99CC99" style="padding-left:5px;"><span class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></span></th>
                                  <th width="15%" align="left" valign="middle" bgcolor="#99CC99"  style="padding-left:5px;"><span class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></span></th>
                                  <th width="23%" align="left" valign="middle" bgcolor="#99CC99"  style="padding-left:5px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?> </span></th>
                                  <th width="26%" align="left" valign="middle" bgcolor="#99CC99" style="padding-left:5px;"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_S4_EMAILADDRESS");?></span></th>
                                  </tr>
                                  </thead>

                                <?php
                                    $i = 1;
									
									//studentstatus_id='6' Means "Enrolled"
									
                                    $num=$dbf->countRows('student',"studentstatus_id='6' AND certificate_collect='0'");
									
                                    foreach($dbf->fetchOrder('student',"studentstatus_id='6' AND certificate_collect='0'","first_name  LIMIT 0,5") as $val)
                                    {
										
									//Get course Name
                                    $valc = $dbf->strRecordID("common","*","id='$val[studentstatus_id]'");
                                    
                                    ?>
                                <tr>
                                  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"><input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>"></td>
                                  <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[student_id];?></td>
                                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                                  <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[email];?></td>
                                  <?php
                                      $i = $i + 1;
                                      }
                                      ?>
                                      <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
                                </tr>
                               
                            </table>
                        
                        </td>
                        </tr>
                      <tr>
                        <td width="13%">&nbsp;</td>
                        <td width="20%">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td colspan="4" align="center" valign="middle"><table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
                          <tr>
                            <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="border-top:solid 1px;">&nbsp;</td>
                            <td height="30" align="right" valign="middle" bgcolor="#F8F9FB" class="pedtext" style="padding-left:5px;"><?php echo constant("CD_EP_SCHEDULING_MANAGE_SCHEDULEDATE");?> : <span class="nametext1">*</span></td>
                            <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">
                              <input name="schedule_date" type="text" class="datepickFuture new_textbox100 validate[required]" id="schedule_date" />
                            </td>
                          </tr>
                          <tr>
                            <td width="7%" height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="border-top:solid 1px;">&nbsp;</td>
                            <td width="18%" height="30" align="right" valign="middle" bgcolor="#F8F9FB" class="pedtext" style="padding-left:5px;"><?php echo constant("CD_EP_SCHEDULING_ADD_MARKUPDATE");?> : <span class="nametext1">*</span></td>
                            <td width="75%" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">
                            <input name="dated" type="text" class="datepickFuture new_textbox100 validate[required]" id="dated" /></td>
                          </tr>
                          </table></td>
                        </tr>
                      <tr>
                        <td colspan="4" align="center" valign="middle" id="lblsave">&nbsp;</td>
                        </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                    </table>
                  </form></td>
                  <td width="30" align="right" valign="top" >&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
            </table>
			</td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
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
                  <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                       <td width="8%" align="left"><a href="ep_scheduling_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                     
                      <td width="54%" height="30" class="logintext" align="right"><?php echo constant("CD_EP_SCHEDULING_ADD_SCHEDULINGMAKEUP");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                  </tr>
                <?php if($_REQUEST[msg]=="added") { ?>
                <tr>
                  <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                    <tr>
                      <td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/success-icon.png" width="28" height="28" /></td>
                      <td width="10" bgcolor="#EAFDEB">&nbsp;</td>
                      <td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="lable1"><?php echo constant("COMMON_RECORDADDMSG");?> </td>
                      </tr>
                    </table></td>
                  </tr>
                <?php } ?>
                <tr>
                  <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
                    
                    <table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                <tr>
                  <td height="30" colspan="3" align="left" valign="middle" style="padding-left:340px;" id="lblerror"></td>
                </tr>
                <tr>
                  <td height="2" colspan="3" align="left" valign="middle" style="padding-left:340px;" id="lblerror2"></td>
                </tr>
                <tr>
                  <td width="30" align="left" valign="top">&nbsp;</td>
                  <td width="554" align="left" valign="top">
                  
                  <form action="ep_scheduling_process.php?action=insert" name="frm" method="post" id="frm">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 2px; border-color:#FF6600;">
                      <tr>
                        <td width="13%" height="25" align="left" valign="middle" bgcolor="#F2F2F2" style="padding-left:5px;padding-bottom:5px;padding-top:5px;">&nbsp;</td>

                        <td width="46%" align="center" valign="middle" bgcolor="#F2F2F2" id="showcourse" style="padding-bottom:5px;padding-top:5px;">
                        <table width="90%" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" style="border-collapse:collapse;">
                          <tr>
                            <td width="19%" height="25" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
                            <td width="39%" align="center" valign="middle" bgcolor="#FEF1FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_SCHEDULESTUDENTS");?>:</td>
                            <td width="21%" align="center" valign="middle" bgcolor="#FEF1FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_GROUPADD");?></td>
                            <td width="21%" align="center" valign="middle" bgcolor="#FEF1FE" class="pedtext"><?php echo constant("ADMIN_MENU_COURSE");?></td>
                          </tr>
                          <tr>
                            <td height="25" align="left" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
                            <td align="center" valign="middle" bgcolor="#FEF1FE" class="pedtext"><?php echo constant("CD_EP_ADDING_STUDENT_ENROLLEDSTUDENTS");?>:</td>
                            <td align="center" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
                            <td align="center" valign="middle" bgcolor="#FFFFFF" class="pedtext">&nbsp;</td>
                          </tr>
                        </table></td>
                        <td width="21%" align="left" valign="middle" bgcolor="#F2F2F2">
                        <table width="95%" border="0" cellspacing="0" cellpadding="0">
                          <tr>                            
                            <td width="58%" align="left" valign="middle">
                            <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;">
                                <option value="">All</option>
                                <option value="Not Started">Not Started</option>
                                <option value="Continue">Active - In Progress</option>   
                                <option value="Completed">Completed</option>                             
                              </select></td>
                              <td width="42%" height="25" align="left" valign="middle" class="pedtext">:<?php echo constant('ADMIN_WEEK_MANAGE_STATUS');?>&nbsp;</td>
                          </tr>
                          <tr>
                            
                            <td align="left" valign="middle" id="statusresult"><select name="group" class="validate[required]" id="group" style="width:150px; border:solid 1px; border-color:#999999;" onChange="show_course(),show_student(),show_save();">
                            <option value="">--Select Group--</option>
                            <?php
							foreach($dbf->fetchOrder('student_group',"status<>'Completed' And centre_id='$_SESSION[centre_id]'","","*") as $ress) {
							?>
                            <option value="<?php echo $ress[id];?>"><?php echo $ress['group_name'] ?>, <?php echo date('d/m/Y',strtotime($ress['start_date']));?> - <?php echo $ress['end_date'] ?>, <?php echo $ress["group_time"];?>-<?php echo $dbf->GetGroupTime($ress["id"]);?></option>
                            <?php }?>
                          </select></td>
                          <td height="25" align="left" valign="middle" class="pedtext"><span class="nametext1">*</span> : <?php echo constant("RECEPTION_GROUP_MANAGE_GROUPNAME");?></td>
                          </tr>
                        </table>
                        </td>
                      </tr>
                      <tr>
                        <td height="2" colspan="3" bgcolor="#FF6600"></td>
                      </tr>
                      <tr>
                        <td height="5" colspan="3"></td>
                      </tr>
                      <tr>
                        <td height="5" colspan="3" align="right" valign="middle" style="padding-left:5px;">
                        <table width="600" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#CCCCCC;">
                          <tr>
						  	<td width="449" align="right" valign="middle" bgcolor="#FDEAFF" class="pedtext_normal"><?php echo constant("CD_EP_CHANGE_CLASSROOM_STUDENTCURSENOTCOMPLETE");?></td>
						    <td width="5" bgcolor="#FDEAFF">&nbsp;</td>
                            <td width="41" align="left" valign="middle" bgcolor="#FDEAFF" class="nametext1">&nbsp;&nbsp;: <?php echo constant("ADMIN_TIMEOUT_MANAGE_NOTE");?></td>
                         </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="5" colspan="3"></td>
                        </tr>
                      <tr>
                        <td colspan="3" align="left" valign="middle" id="showstudent">
                        
                        <table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="#AAAAAA" class="tablesorter" style="border-collapse:collapse;">
                        	<thead>
                                <tr class="pedtext">
                                  <th width="24%" align="right" valign="middle" bgcolor="#99CC99" style="padding-left:5px;"><span class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></span></th>
                                  <th width="15%" align="right" valign="middle" bgcolor="#99CC99"  style="padding-left:5px;"><span class="pedtext"><?php echo constant("ADMIN_S_MANAGE_STUDENTID");?></span></th>
                                  <th width="23%" align="right" valign="middle" bgcolor="#99CC99"  style="padding-left:5px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?> </span></th>
                                  <th width="26%" align="right" valign="middle" bgcolor="#99CC99" style="padding-left:5px;"><span class="pedtext"><?php echo constant("STUDENT_ADVISOR_S4_EMAILADDRESS");?></span></th>
								  <th width="6%" align="center" valign="middle" bgcolor="#99CC99">
                                  <input type="checkbox" name="chk" id="chk" onChange="checkall(this.checked);"></th>
                                  </tr>
                                  </thead>

                                <?php
                                    $i = 1;
									
									//studentstatus_id='6' Means "Enrolled"
									
                                    $num=$dbf->countRows('student',"studentstatus_id='6' AND certificate_collect='0'");
									
                                    foreach($dbf->fetchOrder('student',"studentstatus_id='6' AND certificate_collect='0'","first_name  LIMIT 0,5") as $val)
                                    {
										
									//Get course Name
                                    $valc = $dbf->strRecordID("common","*","id='$val[studentstatus_id]'");
                                    
                                    ?>
                                <tr>                                 
                                  <td height="25" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                                  <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[student_id];?></td>
                                  <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                                  <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $val[email];?></td>
								  <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"><input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>"></td>
                                  <?php
                                      $i = $i + 1;
                                      }
                                      ?>
                                      <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
                                </tr>
                            </table>
                        </td>
                        </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
                        <td colspan="3" align="center" valign="middle"><table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;">
                          <tr>
                            <td align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">
                              <input name="schedule_date" type="text" class="validate[required] datepickFuture new_textbox140_ar" id="schedule_date" /></td>
                            <td height="30" align="left" valign="middle" bgcolor="#F8F9FB" class="pedtext" style="padding-left:5px;"><span class="nametext1">*</span> : <?php echo constant("CD_EP_SCHEDULING_MANAGE_SCHEDULEDATE");?></td>
							<td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="border-top:solid 1px;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="75%" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;">
                            <input name="dated" type="text" class="validate[required] datepickFuture new_textbox140_ar" id="dated" /></td>							 
                            <td width="18%" height="30" align="left" valign="middle" bgcolor="#F8F9FB" class="pedtext" style="padding-left:5px;"><span class="nametext1">*</span> : <?php echo constant("CD_EP_SCHEDULING_ADD_MARKUPDATE");?></td>
							<td width="7%" height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="border-top:solid 1px;">&nbsp;</td>
                          </tr>
                          </table></td>
                        </tr>
                      <tr>
                        <td colspan="3" align="center" valign="middle" id="lblsave">&nbsp;</td>
                        </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        </tr>
                    </table>
                  </form></td>
                  <td width="30" align="right" valign="top" >&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
            </table>
                    </td>
                  </tr>
                <tr>
                  <td bgcolor="#FFFFFF">&nbsp;</td>
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
