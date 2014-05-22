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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$res = $dbf->strRecordID("student","*","id='$_SESSION[student_id]'");

include_once '../includes/language.php';

?>	
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

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>

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

function gotfocus()
{
  document.getElementById('group').focus();
}
function checkTab(id)
{
	if(id=="group")
	{
		//document.getElementById('submit').focus();
	}
}
</script>	
<!--JQUERY VALIDATION ENDS-->
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
            <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" align="left" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?></td>
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
			  <?php if($_REQUEST[msg]=="corp_acct_exist") { ?>
					<tr>
						<td align="center" valign="top" bgcolor="#FFFFFF">
							<table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
								<tr>
									<td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
									<td width="10" bgcolor="#EAFDEB">&nbsp;</td>
									<td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="lable2"><?php echo "Corporate Account Exists";?></td>
								</tr>
							</table>
						</td>
					</tr>
					<?php } ?>
				<?php if($_REQUEST[msg]=="corp_acct_exceed") { ?>
					<tr>
						<td align="center" valign="top" bgcolor="#FFFFFF">
							<table width="300" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#66CC66;">
								<tr>
									<td width="37" height="30" align="center" valign="middle" bgcolor="#EAFDEB"><img src="../images/errror.png" width="28" height="28" /></td>
									<td width="10" bgcolor="#EAFDEB">&nbsp;</td>
									<td width="253" align="left" valign="middle" bgcolor="#EAFDEB" class="lable2"><?php echo "Corporate Account Exceeds";?></td>
								</tr>
							</table>
						</td>
					</tr>
					<?php } ?>
              <tr>
                <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                        <td width="100%" align="left" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_GROUP_ADDINGSTDTOGRUP");?>&nbsp;</td>
                        <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                      <tr>
                        <td align="center" valign="top" bgcolor="#EBEBEB">
                        
                        <form action="s1_process.php?action=group" name="frm" method="post" id="frm">
					    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="26%">&nbsp;</td>
                            <td width="1%">&nbsp;</td>
                            <td width="18%">&nbsp;</td>
                            <td width="51%" rowspan="8" align="left" valign="top" style="padding-top:3px;">
                              
                              <br>
                              <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                <tr>
                                  <td height="25" align="left" valign="middle">&nbsp;</td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S2_NAME");?> :</span> <span class="shop2"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></span></td>
                                  </tr>
                                <?php
								$rescc = $dbf->strRecordID("countries","*","id='$_SESSION[country]'");
								?>
                                <tr>
                                  <td height="5" align="left" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S3_NATIONALITY");?> :</span> <span class="shop2"><?php echo $rescc["value"];?></span></td>
                                  </tr>
                                  <?php if($_SESSION[student_id] != ''){?>
                                <tr>
                                  <td height="5" align="left" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S3_IDNUMBER");?> :</span> <span class="shop2"><?php echo $_SESSION[student_id];?></span></td>
                                  </tr>
                                  <?php } ?>
                                <tr>
                                  <td height="5" align="left" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S4_MOBILE");?> :</span> <span class="shop2"><?php echo $_SESSION[mobile_no];?></span></td>
                                  </tr>
                                <tr>
                                  <td height="5" align="left" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S4_TELPHONE");?> :</span> <span class="shop2"><?php echo $_SESSION[alt_no];?></span></td>
                                  </tr>
                                <tr>
                                  <td height="5" align="left" valign="top"></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top"><span class="shop1"><?php echo constant("STUDENT_ADVISOR_S5_EMAIL");?> :</span> <span class="shop2"><?php echo $_SESSION[email];?></span></td>
                                  </tr>
                                <tr>
                                  <td align="left" valign="top">&nbsp;</td>
                                  </tr>
                                
                                </table>
                              
                            </td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="18%" align="left" valign="middle"><?php echo constant("PROGRESS_BAR");?></td>
                                <td width="73%" align="left" valign="middle" style="padding-left:2px;">
                                <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                  <div class="meter-value" style="background-color:#847B7B; width:60%;">
                                    <div style="border:solid 1px; border-color:#847B7B; "></div>
                                  </div>
                                </div></td>
                                <td width="9%" align="center" valign="middle" class="shop2">60%</td>
                              </tr>
                            </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_S_GROUP_ADDINGSTDTOGRUP");?> : </td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">
                              
                            </td>
                            </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <?php							
								if($_SESSION["courseid"] == ''){
									$interest_course = 0;
									$select_first_value = constant("NO_INTERESTED");
								}else{
									$interest_course = $_SESSION["courseid"];
									$select_first_value = constant("SELECT_GROUP");
								}
								?>
                            <td height="28" colspan="3" align="left" valign="middle">
                            <select name="group" class="combo" id="group" style="width:300px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" onBlur="checkTab('group');">
                                <option value=""><?php echo $select_first_value;?></option>
                                <?php
								$group_query=$dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And status<>'Completed' And course_id in (".$interest_course.")","");
							foreach($group_query as $res_g) {
							  ?>
                                <option value="<?php echo $res_g['id']?>" <?php if($res_g["id"]==$_SESSION[group]) { echo "Selected"; }?>><?php echo $res_g['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_g['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_g['end_date'])) ?>,  <?php echo $dbf->printClassTimeFormat($res_g["group_time"],$res_g["group_time_end"]);?></option>
                                </option>
                                <?php }?>
                                </select>
                            </td>
                            </tr>
							<!--CORPORATE ACCOUNT OPTION-->
							<script language="javascript" type="text/javascript">
							$(document).ready(function() 
							{	
								$('#corp_acct').change(function() 
								{
									
									$.post( "corp_acct_tab.php", function( data ) 
									{$( "#corp_acct_tab" ).html( data );});
									
									
								});
							});
							function validate_corp_acct()
							{
								var ajaxRequest;  // The variable that makes Ajax possible!
								try
								{
									// Opera 8.0+, Firefox, Safari
									ajaxRequest = new XMLHttpRequest();
								} 
								catch (e)
								{
									// Internet Explorer Browsers
									try
									{ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");} 
									catch (e) {
												try{ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");} 
												catch (e){
															// Something went wrong
															alert("Your browser broke!");
															return false;
														}
											}
								}
								// Create a function that will receive data sent from the server
								ajaxRequest.onreadystatechange = function()
								{
									if(ajaxRequest.readyState != 4){
										//var c = ajaxRequest.responseText;
										document.getElementById('lblgroup').innerHTML="Validating...";
									}
									if(ajaxRequest.readyState == 4){
										var c = ajaxRequest.responseText;
										document.getElementById('lblgroup').innerHTML=c;
									}
								}
								var account = document.getElementById('account').value;
								var sub = document.getElementById('sub_account').value;
								ajaxRequest.open("GET", "corporate_show_ajax.php" + "?account=" + account+"&sub="+sub, true);
								ajaxRequest.send(null); 
							}
							</script>
							<?php
								$sql=$dbf->genericQuery("SELECT code,name FROM corporate WHERE centre_id='".$_SESSION[centre_id]."'");
							?>
							<tr>
								<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								<td height="28" align="left" valign="middle" class="leftmenu">
									Corporate Account:
								</td>
								
								<td>
									<select name="corp_acct" 
											class="combo" 
											id="corp_acct" 
											style="width:180px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;"
											<?php echo (empty($group_query)?'disabled':'');?>>
										<option value=""> Select Account</option>
										<?php foreach($sql as $s):?>
										<option value="<?php echo $s['code'];?>"><?php echo $s['name'];?></option>
										<?php endforeach;?>
									</select>
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								<td height="28" align="left" valign="middle" class="leftmenu">
									Account Id:
								</td>
								
								<td align="left" valign="middle">
									<div id="validate_corporate_account">
										<div id="corp_acct_tab"></div>
									</div>
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								<td height="28" align="left" valign="middle" class="leftmenu">
									&nbsp;
								</td>
								
								<td align="left" valign="middle" id="lblgroup">
									<div id="validate_corporate_account">
					
									</div>
								</td>
							</tr>
							<tr>
								<td align="left" valign="middle" class="leftmenu">&nbsp;</td>
								<td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
								<td width="3%">&nbsp;</td>
								<td align="left" valign="middle">&nbsp;</td>
							</tr>
							<!--CORPORATE ACCOUNT OPTION-->
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td height="10" colspan="5" align="left" valign="middle"></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                            <td height="25" align="center" valign="middle" class="leftmenu"><a href="s6.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn2" border="0" align="left" /></a></td>
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
                  <td height="0" bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr>
                      
                      <td width="22%">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left">&nbsp;</td>
                      <td width="8%" align="left"><a href="alert_manage.php"></a></td>
                      <td width="54%" height="30" align="right" class="logintext"><?php echo constant("STUDENT_ADVISOR_ADD_STD_WELCOMETEXT");?></td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="top" bgcolor="#FFFFFF" height="3"></td>
                      </tr>
                    <tr>
                      <td height="200" align="center" valign="top" bgcolor="#FFFFFF" style="padding-top:10px;">
                        
                        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="15" align="left" valign="top"><img src="../images/left_top_bg.png" width="15" height="31" alt="left_top" /></td>
                                <td width="100%" align="right" valign="middle" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("STUDENT_ADVISOR_S_GROUP_ADDINGSTDTOGRUP");?>&nbsp;</td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                                </tr>
                              </table></td>
                            </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                  
                                  <form action="s1_process.php?action=group" name="frm" method="post" id="frm">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                      <tr>
                                        <td width="55%" rowspan="8" align="center" valign="top" style="padding-top:3px;">
                                          
                                          <br>
                                          <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                                            <tr>
                                              <td height="25" align="left" valign="middle">&nbsp;</td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $dbf->GetCart_StudentName($_SESSION["name"],$_SESSION["father_name"],$_SESSION["grandfather_name"],$_SESSION["family_name"],$_SESSION["name1"],$_SESSION["father_name1"],$_SESSION["grandfather_name1"],$_SESSION["family_name1"]);?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S2_NAME");?></span></td>
                                              </tr>
                                            <?php
								$rescc = $dbf->strRecordID("countries","*","id='$_SESSION[country]'");
								?>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"> <span class="shop2"><?php echo $rescc["value"];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S3_NATIONALITY");?></span></td>
                                              </tr>
                                              <?php if($_SESSION[student_id] != ''){?>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[student_id];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S3_IDNUMBER");?></span></td>
                                              </tr>
                                              <?php } ?>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[mobile_no];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S4_MOBILE");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[alt_no];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S4_TELPHONE");?></span></td>
                                              </tr>
                                            <tr>
                                              <td height="5" align="right" valign="top"></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top"><span class="shop2"><?php echo $_SESSION[email];?></span><span class="shop1"> : <?php echo constant("STUDENT_ADVISOR_S5_EMAIL");?></span></td>
                                              </tr>
                                            <tr>
                                              <td align="right" valign="top">&nbsp;</td>
                                              </tr>
                                            
                                            </table>
                                          
                                          </td>
                                        <td>&nbsp;</td>
                                        <td width="2%">&nbsp;</td>
                                        <td width="33%">&nbsp;</td>
                                        <td width="1%">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        
                                        <td height="28" colspan="3" align="left" valign="middle" class="leftmenu"><table width="95%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="9%" align="center" valign="middle" class="shop2">60%</td>
                                            <td width="73%" align="left" valign="middle" style="padding-left:2px;">
                                            <div class="meter-wrap" style="background-color:#fff; border:solid 1px; border-color:#847B7B;">
                                              <div class="meter-value" style="background-color:#847B7B; width:60%;">
                                                <div style="border:solid 1px; border-color:#847B7B; "></div>
                                                </div>
                                              </div></td>
                                              <td width="18%" align="left" valign="middle">&nbsp;&nbsp;<?php echo constant("PROGRESS_BAR");?></td>
                                            
                                            </tr>
                                          </table></td>
                                       <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td width="9%" height="28" align="right" valign="middle" class="leftmenu"></td>
                                        <td>&nbsp;</td>
                                        <td width="33%" align="right" valign="middle"><span class="leftmenu"> : <?php echo constant("STUDENT_ADVISOR_S_GROUP_ADDINGSTDTOGRUP");?></span></td>
                                        
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <?php							
										if($_SESSION["courseid"] == ''){
											$interest_course = 0;
											$select_first_value = constant("NO_INTERESTED");
										}else{
											$interest_course = $_SESSION["courseid"];
											$select_first_value = constant("SELECT_GROUP");
										}
										?>
                                      <tr>
                                        <td height="28" colspan="3" align="right" valign="middle">
                                        <select name="group" class="combo" id="group" style="width:300px; border:solid 1px; text-align:right; border-color:#999999;background-color:#ECF1FF;" onBlur="checkTab('group');">
                                          <option value=""><?php echo $select_first_value;?></option>
                                          <?php
											foreach($dbf->fetchOrder('student_group',"centre_id='$_SESSION[centre_id]' And status<>'Completed' And course_id in (".$interest_course.")","") as $res_g) {
											  ?>
                                          <option value="<?php echo $res_g['id']?>" <?php if($res_g["id"]==$_SESSION[group]) { echo "Selected"; }?>><?php echo $res_g['group_name'] ?>, <?php echo date('d/m/Y',strtotime($res_g['start_date']));?> - <?php echo date('d/m/Y',strtotime($res_g['end_date'])) ?>, <?php echo $res_g["group_time"];?>-<?php echo $dbf->GetGroupTime($res_g["id"]);?></option>
                                          <?php }?>
                                          </select>
                                        </td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="28" align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="10" colspan="5" align="left" valign="middle"></td>
                                      </tr>
                                      <tr>
                                        <td align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_next_btn");?>" class="btn2"/></td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td height="25" align="center" valign="middle" class="leftmenu"><a href="s6.php"><input type="button" value="<?php echo constant("btn_back");?>" class="btn1" border="0" align="left" /></a></td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
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
