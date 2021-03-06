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
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

$teacher_id = $_SESSION[uid];
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

<!-- Auto select -->
<script src="../js/jquery-1.8.2.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../chosen/chosen.css" />
<script src="../chosen/chosen.jquery.js"></script>
<!-- Auto select -->

<!-- Inner Ajax -->
<script language="javascript" type="text/javascript">
function show_course(){
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
			document.getElementById('lbl_course').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lbl_course').innerHTML=c;
		}
	}

	var student_id = document.getElementById('student').value;
	//alert(student_id)
	ajaxRequest.open("GET", "cancel_course.php" + "?student_id=" + student_id, true);
	ajaxRequest.send(null); 
}
function show_student(){
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
			document.getElementById('lbl_student').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lbl_student').innerHTML=c;
		}
	}

	var student_id = document.getElementById('student').value;
	var course_id = document.getElementById('course_id').value;

	ajaxRequest.open("GET", "cancel_student_dtls.php" + "?course_id=" + course_id + "&student_id=" + student_id, true);
	ajaxRequest.send(null); 
}
</script>	
<!-- Inner Ajax -->

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">
<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="datepicker/demos.css">
<script>
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

<!-- Counter -->
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
<!-- Counter -->
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
            <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="headingtext"><h1 class="amt_head"><?php echo constant("MANAGE_ONHOLD");?></h1></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">
                <a href="hold_manage.php"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;" ><table width="100%" border="0" cellspacing="0" cellpadding="0">              
              <tr>
                <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
              </tr>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
				<br>
				<table width="850" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                    <tr>
                      <td height="10" colspan="3" align="center" valign="top" class="loginheading">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="24" align="left" valign="top" >&nbsp;</td>
                      <td width="793" align="left" valign="top">
					  
					  <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("MANAGE_ONHOLD");?></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                
                                <form action="hold_process.php?action=insert" name="frm" method="post" id="frm">        
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                                      <tr>
                                        <td height="20">&nbsp;</td>
                                        <td height="20" class="leftmenu">&nbsp;</td>
                                        <td height="20" class="leftmenu">&nbsp;</td>
                                        <td height="20">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td width="17"><!--<h2 class="tryit" onclick="tryit('Select Student Name', {'animate':true});">Click Me</h2>--></td>
                                        <td width="118" height="30" align="right" class="nametext">
										<?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?> : <span class="nametext1">*</span> &nbsp;</td>                                      
                                        <td width="283" align="left" valign="middle">
                                        <select name="student" id="student" class="chzn-select" onChange="show_course();">
                                            <option value="">-- Select Student --</option>
                                            <?php
                                            foreach($dbf->fetchOrder('student s,student_moving m',"s.id=m.student_id And (m.status_id='4' OR m.status_id='5') And s.centre_id='$_SESSION[centre_id]'","s.first_name","s.*") as $ress2) {
                                            ?>
                                            <option value="<?php echo $ress2['id']?>"><?php echo $ress2['first_name']."&nbsp;".$ress2['father_name']."&nbsp;".$ress2['family_name']."&nbsp;(".$ress2['first_name1']."&nbsp;".$ress2['father_name1']."&nbsp;".$ress2['grandfather_name1']."&nbsp;".$ress2['family_name1'].")";?></option>
                                            <?php }?>
                                        </select>
                                        
                                        <!-- JavaScript -->
										<script type="text/javascript" src="../tooltip/prettify.js"></script>
                                        <script src="../tooltip/apprise.js" type="text/javascript"></script>
                                        <link href="../tooltip/apprise.css" rel="stylesheet" type="text/css">
                                        <!-- JavaScript -->
                                        
                                        <script>
											function tryit(string, args) {
												apprise(string, args, function(r) {
													if(r) { 
														if(typeof(r)=='string')
															{ $('#returns').text(r); }
														else
															{ $('#returns').text('True'); }
														}
													else 
														{ $('#returns').text('False'); }
												});
											}
											</script>
                                        
										<script type="text/javascript">
										$('.chzn-select').chosen().change( function() {
										//var selectedValue = $(this).find('option:selected').val();
										//alert(selectedValue);
										// $(this).parent().find('option[value="'+ selectedValue +'"]:not(:selected)')
										// .prop("disabled", function( i, val ) {
										//     return !val;
										//   });
										var value = $(".chzn-select").val();
										//alert(value);
										});
										$(".chzn-select").chosen(); 
										$(".chzn-select-deselect").chosen({allow_single_deselect:true});
																				
										$('#frm').on('submit', function(e) {											
											var value = $(".chzn-select").val();											
											if(value == ''){
												tryit('Select Student Name', {'animate':true});
												e.preventDefault();
												return false;
											}
											
											if($('#course_id').val() == ''){
												tryit('Select Course Name', {'animate':true});
												e.preventDefault();
												return false;
											}
											
											if($('#dated').val() == ''){
												tryit('Select Hold Date', {'animate':true});
												e.preventDefault();
												return false;
											}
											
											if($('#comment').val() == ''){
												tryit('Enter Reason', {'animate':true});
												e.preventDefault();
												return false;
											}
										});
                                    </script>
                                          
                                          </td>
                                        <td width="330" rowspan="4" align="center" valign="top" id="lbl_student">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="nametext">
										<?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?> : <span class="nametext1">*</span> &nbsp;</td>
                                        <td align="left" valign="top" id="lbl_course">                                        
                                        <select class="mystyles">
                                        <option value="">-- Select Course --</option>
                                        </select>                                        
                                        </td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="nametext"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : <span class="nametext1">* &nbsp;</span></td>
                                        <td align="left" valign="middle">
                                          <input name="dated" type="text" class="datepickFuture new_textbox100" id="dated" value="<?php echo $res_arf[dated];?>" readonly="">
                                        </td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="top" class="nametext"><?php echo constant("SA_REASON_FOR_CANCEL");?> : <span class="nametext1">*</span> &nbsp;</td>
                                        <td align="left" valign="middle"><textarea name="comment" id="comment" rows="5" cols="35" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea></td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="left" valign="middle" class="nametext">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle">
                                          <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="left" valign="middle" class="leftmenu"></td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                      </tr>
                                    </table>
                                        </form></td>
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
                      <td width="33" align="right" valign="top" >&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="3" align="left" valign="top">&nbsp;</td>
                    </tr>
                </table></td>
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
                  <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      <td width="8%" align="left">
                        <a href="hold_manage.php"><input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" /></a></td>                      
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="54%" height="30" class="headingtext" align="right"><h1><?php echo constant("MANAGE_ONHOLD");?></h1></td>
                      
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">              
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF">
                        <br>
                        <table width="850" border="0" cellpadding="0" cellspacing="0" bordercolor="#ECE9D8" bgcolor="#FFFFFF">
                          <tr>
                            <td height="10" colspan="3" align="center" valign="top" class="loginheading">&nbsp;</td>
                            </tr>
                          <tr>
                            <td width="24" align="left" valign="top" >&nbsp;</td>
                            <td width="793" align="left" valign="top">
                              
                              <table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("MANAGE_ONHOLD");?></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                
                                <form action="hold_process.php?action=insert" name="frm" method="post" id="frm">        
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                                      <tr>
                                        <td height="20">&nbsp;</td>
                                        <td height="20" class="leftmenu">&nbsp;</td>                                        
										<td height="20" class="leftmenu">&nbsp;</td>
										<td height="20">&nbsp;</td>
                                      </tr>
                                      <tr>
									   <td width="330" rowspan="4" align="center" valign="top" id="lbl_student">&nbsp;</td>
                                        <td width="283" align="right" valign="middle">
                                          <select name="student" id="student" class="chzn-select" onChange="show_course();">
                                            <option value="">--<?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_OPTION");?>--</option>
                                            <?php
                                            foreach($dbf->fetchOrder('student s,student_moving m',"s.id=m.student_id And m.status_id='4' And s.centre_id='$_SESSION[centre_id]'","s.first_name","s.*") as $ress2) {
                                            ?>
                                            <option value="<?php echo $ress2['id']?>"><?php echo $ress2[first_name]."&nbsp;".$ress2[father_name]."&nbsp;".$ress2[family_name]."&nbsp;(".$ress2[first_name1]."&nbsp;".$ress2[father_name1]."&nbsp;".$ress2[grandfather_name1]."&nbsp;".$ress2[family_name1].")";?></option>
                                            <?php }?>
                                            </select>
                                            <!-- JavaScript -->
										<script type="text/javascript" src="../tooltip/prettify.js"></script>
                                        <script src="../tooltip/apprise.js" type="text/javascript"></script>
                                        <link href="../tooltip/apprise.css" rel="stylesheet" type="text/css">
                                        <!-- JavaScript -->
                                        
                                        <script>
											function tryit(string, args) {
												apprise(string, args, function(r) {
													if(r) { 
														if(typeof(r)=='string')
															{ $('#returns').text(r); }
														else
															{ $('#returns').text('True'); }
														}
													else 
														{ $('#returns').text('False'); }
												});
											}
											</script>
                                        
										<script type="text/javascript">
										$('.chzn-select').chosen().change( function() {
										//var selectedValue = $(this).find('option:selected').val();
										//alert(selectedValue);
										// $(this).parent().find('option[value="'+ selectedValue +'"]:not(:selected)')
										// .prop("disabled", function( i, val ) {
										//     return !val;
										//   });
										var value = $(".chzn-select").val();
										//alert(value);
										});
										$(".chzn-select").chosen(); 
										$(".chzn-select-deselect").chosen({allow_single_deselect:true});
																				
										$('#frm').on('submit', function(e) {											
											var value = $(".chzn-select").val();											
											if(value == ''){
												tryit('<?php echo constant('RECEPTION_EMAIL_SELECTSTUDENTNM');?>', {'animate':true});
												e.preventDefault();
												return false;
											}
											
											if($('#course_id').val() == ''){
												tryit('<?php echo constant('STUDENT_ADVISOR_GROUP_TXT1');?>', {'animate':true});
												e.preventDefault();
												return false;
											}
											
											if($('#dated').val() == ''){
												tryit('<?php constant('STUDENT_ADVISOR_GROUP_ADD_SELECTDATE');?>', {'animate':true});
												e.preventDefault();
												return false;
											}
											
											if($('#comment').val() == ''){
												tryit('<?php echo constant('SA_REASON_FOR_CANCEL'); ?>', {'animate':true});
												e.preventDefault();
												return false;
											}
										});
                                    </script>
                                           </td>
										   <td width="118" height="30" align="left" class="nametext">
                                           <span class="nametext1">*</span> : <?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?></td>
										   <td width="17">&nbsp;</td>                                       
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle" id="lbl_course">                                        
                                        <select name="course_id" id="course_id" class="mystyles">
                                        <option value="">--<?php echo constant("SELECT_COURSE");?>--</option>
                                        </select>
                                        </td>
										<td height="30" align="left" valign="middle" class="nametext">
										<span class="nametext1">*</span> : <?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
										<td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle">
                                          <input name="dated" type="text" class="datepickFuture validate[required] new_textbox190_ar" id="dated" value="<?php echo $res_arf[dated];?>" readonly="">                                        </td>
										<td height="30" align="left" valign="middle" class="nametext"><span class="nametext1">*</span> : <?php echo constant("TEACHER_ARF_MANAGE_DATE");?></td>
									  <td>&nbsp;</td>
									 </tr>
                                      <tr>
                                        <td align="right" valign="middle"><textarea name="comment" class="validate[required]" id="comment" rows="5" cols="35" style="border:solid 1px; background-color:#ECF1FF; text-align:right; border-color:#999999;"></textarea></td>
										 <td height="30" align="left" valign="middle" class="nametext"><span class="nametext1">*</span> : <?php echo constant("SA_REASON_FOR_CANCEL");?></td>
										 <td>&nbsp;</td>
                                        </tr>
                                      <tr>                                       
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="center" valign="middle" class="leftmenu">&nbsp;</td>                                       
										<td height="30" align="left" valign="middle" class="nametext">&nbsp;</td>
										<td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle">
                                          <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2"/></td>
										 <td height="30" colspan="2" align="left" valign="middle" class="leftmenu">&nbsp;</td>
										<td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle">&nbsp;</td>                                       
										<td height="30" align="left" valign="middle" class="leftmenu"></td>
										<td>&nbsp;</td>
                                      </tr>
                                    </table>
                                  </form></td>
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
                            <td width="33" align="right" valign="top" >&nbsp;</td>
                            </tr>
                          <tr>
                            <td colspan="3" align="left" valign="top">&nbsp;</td>
                            </tr>
                          </table></td>
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
