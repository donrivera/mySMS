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
include_once '../includes/language.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>

<link rel="stylesheet" href="js/validationEngine.jquery.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<?php 
if($_SESSION[lang]=='')
{
	$LANGUAGE = "EN";
}
else
{
	$LANGUAGE = $_SESSION[lang];
}
if($LANGUAGE=='EN')
{
?>
<script src="js/jquery.validationEngine-en.js" type="text/javascript"></script>
<?php
}
if($LANGUAGE=='AR')
{
?>
<script src="js/jquery.validationEngine-ar.js" type="text/javascript"></script>
<?php
}
?>
<script src="js/jquery.validationEngine.js" type="text/javascript"></script>

<script>	
$(document).ready(function() {	
	$("#frm").validationEngine()	
	//$.validationEngine.loadValidation("#date")
	//alert($("#formID").validationEngine({returnIsValid:true}))
	//$.validationEngine.buildPrompt("#date","This is an example","error")	 		 // Exterior prompt build example
	//$.validationEngine.closePrompt(".formError",true) 							// CLOSE ALL OPEN PROMPTS
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
</script>
<!--UI JQUERY DATE PICKER-->

<script language="javascript" type="text/javascript">
function getteacher()
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
			document.getElementById('showsch').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('showsch').innerHTML=c;
		}
	}

	var teacher = document.getElementById('group').value;
		
	ajaxRequest.open("GET", "ep_class_cancel_ajax.php" + "?teacher=" + teacher, true);
	ajaxRequest.send(null);
}
</script>

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

$(document).ready(function(){
	$("#mystatus").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("ep_clas_cancel_add_ajax.php", {status: $(this).val()}); // Page Name and Condition
	});
});
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
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                  <tr>
                    <td width="54%" height="30" class="logintext"><?php echo constant("CD_EP_CLASS_CANCEL_MANAGE");?></td>
                    <td width="22%">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left">&nbsp;</td>
                    <td width="8%" align="left"><a href="ep_class_cancel_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
                    </tr>
                  </table></td>
                </tr>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                </tr>
              <?php if($_REQUEST[msg]=="exist") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                  <tr>
                    <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                    <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                    <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext1"><?php echo constant("CD_EP_CLASS_CANCEL_ADD_RECEXIST");?></td>
                    </tr>
                  </table></td>
                </tr>
              <?php } ?>
              <?php if($_REQUEST[msg]=="added") { ?>
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                  <tr>
                    <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                    <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                    <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("CD_EP_CLASS_CANCEL_ADD_RECADD");?></td>
                    </tr>
                  </table></td>
                </tr>
              <?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                   
                  <table width="737" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                          <td width="100%" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADD_CANCELLATON");?></span></td>
                          <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                        <tr>
                          <td align="center" valign="top" bgcolor="#EBEBEB">
                            
                            <form action="ep_class_cancel_process.php?action=insert" name="frm" method="post" id="frm">
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                <tr>
                                  <td width="3%">&nbsp;</td>
                                  <td width="12%">&nbsp;</td>
                                  <td width="0%">&nbsp;</td>
                                  <td width="26%">&nbsp;</td>
                                  <td width="1%">&nbsp;</td>
                                  <td width="58%">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant('ADMIN_WEEK_MANAGE_STATUS');?> :&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">
                                  <select name="mystatus" id="mystatus" style="width:190px; background-color:#ECF1FF;border:solid 1px; border-color:#999999; height:25px;">
                                    <option value="">All</option>
                                    <option value="Not Started">Not Started</option>
                                    <option value="Continue">Active - In Progress</option>
                                    <option value="Completed">Completed</option>                               
                                  </select>
                                  </td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?> : <span class="nametext1">*</span>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle" id="statusresult">
                                    <select name="group" id="group" class="validate[required]" style="width:190px; background-color:#ECF1FF;border:solid 1px; border-color:#999999; height:25px;" onchange="getteacher();">
                                      <option value=""> Select Group</option>
                                      <?php
								foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]'","") as $res) {
								  ?>
                                      <option value="<?php echo $res['id'];?>"><?php echo $res['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res['start_date']));?> - <?php echo date('d/m/Y',strtotime($res['end_date'])) ?>, <?php echo $res["group_time"];?>-<?php echo $dbf->GetGroupTime($res["id"]);?></option>
                                      <?php }?>
                                      </select></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle" id="showsch"><table width="60%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF3300;">
                                    <tr>
                                      <td width="87%" height="25" align="center" valign="middle" bgcolor="#E0E3FE" class="red_smalltext"><?php echo constant("CD_EP_CLASS_CANCEL_AJAX_GROUPSTARTON");?> ____________ <?php echo constant("CD_EP_CLASS_CANCEL_AJAX_TO");?> ____________</td>
                                    </tr>
                                  </table></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="middle" class="leftmenu"> <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?> : <span class="nametext1">*</span>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle"><input name="startdate" type="text" class="validate[required] datepick new_textbox100" readonly="" id="startdate" size="45" minlength="4"/></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="top" id="lblerror">
                                    </td>
                                </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="28" align="right" valign="middle" class="leftmenu"><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENTS");?> : <span class="nametext1">*</span>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  <td colspan="3" align="left" valign="middle">
                                    <textarea name="comments" cols="45" id="comments" class="validate[required]" style="width:450px; height:70px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;"></textarea></td>
                                </tr>
                                <tr>
                                  <td height="10" colspan="6" align="left" valign="middle"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                                  <td>&nbsp;</td>
                                  <td align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td height="10" colspan="6" align="left" valign="middle"></td>
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
                <td height="140" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
              </table></td>
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
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onclick="countdown_init(<?=$count;?>);">
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
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                        <tr>
                         <td width="8%" align="left"><a href="ep_class_cancel_manage.php"> <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>
                          <td width="22%">&nbsp;</td>
                          <td width="8%" align="left">&nbsp;</td>
                          <td width="8%" align="left">&nbsp;</td>
                          
                           <td width="54%" height="30" class="logintext" align="right"><?php echo constant("CD_EP_CLASS_CANCEL_MANAGE");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <?php if($_REQUEST[msg]=="exist") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext1"><?php echo constant("CD_EP_CLASS_CANCEL_ADD_RECEXIST");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <?php if($_REQUEST[msg]=="added") { ?>
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF"><table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
                        <tr>
                          <td width="37" height="30" align="center" valign="middle" bgcolor="#FFF2FD"><img src="../images/close-btn.png" width="25" height="25" /></td>
                          <td width="10" bgcolor="#FFF2FD">&nbsp;</td>
                          <td width="253" align="left" valign="middle" bgcolor="#FFF2FD" class="nametext"><?php echo constant("CD_EP_CLASS_CANCEL_ADD_RECADD");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="737" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" style="background:url(../images/left_mid_bg.png) repeat-x;"><span class="logintext"><?php echo constant("ADD_CANCELLATON");?></span></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                  
                                  <form action="ep_class_cancel_process.php?action=insert" name="frm" method="post" id="frm">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                      <tr>                                        <td width="58%">&nbsp;</td>
                                        <td width="1%">&nbsp;</td>
                                        <td width="26%">&nbsp;</td>
                                        <td width="0%">&nbsp;</td>
                                        <td width="12%">&nbsp;</td>
                                        <td width="3%">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle" id="showsch3">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="right" valign="middle">
                                        <select name="mystatus" id="mystatus" style="width:190px; background-color:#ECF1FF;border:solid 1px; border-color:#999999; height:25px;">
                                            <option value="">All</option>
                                            <option value="Not Started">Not Started</option>
                                            <option value="Continue">Active - In Progress</option>
                                            <option value="Completed">Completed</option>                               
                                          </select>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">: <?php echo constant('ADMIN_WEEK_MANAGE_STATUS');?></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle" id="showsch"><table width="60%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#FF3300;">
                                          <tr>
                                            <td width="87%" height="25" align="center" valign="middle" bgcolor="#E0E3FE" class="red_smalltext"><?php echo constant("CD_EP_CLASS_CANCEL_AJAX_GROUPSTARTON");?> ____________ <?php echo constant("CD_EP_CLASS_CANCEL_AJAX_TO");?> ____________</td>
                                            </tr>
                                          </table></td>
                                          <td>&nbsp;</td>
                                          <td align="right" valign="middle" id="statusresult">
                                          <select name="group" id="group" class="validate[required]" style="width:190px; background-color:#ECF1FF;border:solid 1px; border-color:#999999; height:25px;" onchange="getteacher();">
                                            <option value=""> <?php echo constant("SELECT_GROUP");?></option>
                                            <?php
											foreach($dbf->fetchOrder('student_group',"status<>'Completed' And centre_id='$_SESSION[centre_id]'","") as $res) {
											  ?>
                                            <option value="<?php echo $res['id'];?>"><?php echo $res['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res['start_date']));?> - <?php echo date('d/m/Y',strtotime($res['end_date'])) ?>, <?php echo $res["group_time"];?>-<?php echo $dbf->GetGroupTime($res["id"]);?></option>
                                            <?php }?>
                                            </select></td>
                                           <td>&nbsp;</td>
                                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> :&nbsp;<?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></td>
                                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="top" id="lblerror">
                                          </td>
                                          <td>&nbsp;</td>
                                          <td align="right" valign="middle"><input name="startdate" type="text" class="validate[required] datepick new_textbox100_ar" readonly="" id="startdate" size="45" minlength="4"/></td>
                                          <td>&nbsp;</td>
                                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> : <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?></td>
                                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td colspan="3" align="right" valign="middle">
                                          <textarea name="comments" cols="45" id="comments" class="validate[required]" style="width:450px; height:70px; border:solid 1px; border-color:#999999;background-color:#ECF1FF; text-align:right;"></textarea></td>
                                          <td align="left" valign="middle">&nbsp;</td>
                                          <td height="28" align="left" valign="middle" class="leftmenu"><span class="nametext1">*</span> :&nbsp;<?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENTS");?></td>
                                          <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="10" colspan="6" align="left" valign="middle"></td>
                                        </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
                                        <td>&nbsp;</td>
                                         <td height="25" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td height="10" colspan="6" align="left" valign="middle"></td>
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
                      <td height="140" bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                    </table></td>
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
