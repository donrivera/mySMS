<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
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
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
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

<!--JQUERY VALIDATION-->
<script type="text/javascript" src="js/filter_textbox.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
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
<!--JQUERY VALIDATION ENDS-->

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

<script type="text/javascript">
function gotfocus()
{
  document.getElementById('student').focus();
}
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
<body onLoad="countdown_init(<?php echo $count;?>),gotfocus();">
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
                <td width="54%" height="30" class="headingtext"><h1><?php echo constant("CANCELLATION_REQUEST");?></h1></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left"><a href="cancel_manage.php?centre_id=<?php echo $_REQUEST[centre_id];?>">
                <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
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
                <?php
				$cancel = $dbf->strRecordID("student_cancel","*","id='$_REQUEST[cancel_id]'");
				$student_id = $cancel["student_id"];
				$course_id = $cancel["course_id"];
				$student = $dbf->strRecordID("student","*","id='$student_id'");	
				$course = $dbf->strRecordID("course","*","id='$course_id'");	
				?>
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
                                <td width="100%" class="logintext" style="background:url(../images/left_mid_bg.png) repeat-x;"><?php echo constant("CANCELLATION_REQUEST");?></td>
                                <td width="15" align="right" valign="top"><img src="../images/top_right_bg.png" width="15" height="31" /></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-left:solid 1px #C2C2C2; border-right:solid 1px #C2C2C2;  ">
                              <tr>
                                <td align="center" valign="top" bgcolor="#EBEBEB">
                                
                                <form action="cancel_process.php?centre_id=<?php echo $_REQUEST["centre_id"];?>&cancel_id=<?php echo $_REQUEST["cancel_id"];?>&action=update" name="frm" method="post" id="frm">        
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-color:#CCCCCC;">
                                      <tr>
                                        <td height="20">&nbsp;</td>
                                        <td height="20" class="leftmenu">&nbsp;</td>
                                        <td height="20" class="leftmenu">&nbsp;</td>
                                        <td height="20">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td width="17">&nbsp;</td>
                                        <td width="118" height="30" align="right" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_STUDENTNAME");?> : </td>
                                        <td width="283" align="left" valign="middle" class="red_smalltext">&nbsp;<?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                                        <td width="330" rowspan="8" align="center" valign="top">
                                        <?php
                                        $enroll = $dbf->strRecordID("student_enroll",'*',"student_id='$student_id' And course_id='$course_id'");
										$course = $dbf->strRecordID("course",'*',"id='$course_id'");
										$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$enroll[fee_id]'");
										$course_fee = $course_fees;
										$discount = $enroll["discount"];
										$other_amt = $enroll["other_amt"];
										
										$en_amt = $course_fee - $discount;
										$course_fee_final = $en_amt + $other_amt;
										
										$fee = $dbf->strRecordID("student_fees",'SUM(paid_amt)',"student_id='$student_id' And course_id='$course_id'");
										$paid_amt = $fee["SUM(paid_amt)"];
										$bal_amt = $course_fee_final - $paid_amt;
                                        ?>
                                        <table width="250" border="1" cellspacing="0" cellpadding="0" bordercolor="#9999FF" style="border-collapse:collapse;">
                                          <tr>
                                            <td width="54%" height="20" align="right" valign="middle" class="mycon">Course : &nbsp;</td>
                                            <td width="46%" align="left" valign="middle" class="shop2">&nbsp;<?php echo $course["name"];?></td>
                                          </tr>
                                          <tr class="mycon">
                                            <td colspan="2" align="center" valign="middle"><u class="mymenutext">Payment Details</u> &nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td width="54%" align="right" valign="middle" class="mycon">Course Fees : &nbsp;</td>
                                            <td width="46%" align="left" valign="middle" bgcolor="#999999" class="shop2">&nbsp;<?php echo $course_fee;?> <?php echo $res_currency[symbol];?></td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="mycon">Discount (-) : &nbsp;</td>
                                            <td align="left" valign="middle" class="shop2">&nbsp;<?php echo $discount;?> <?php echo $res_currency[symbol];?></td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="mycon">Enrollment Amount : &nbsp;</td>
                                            <td align="left" valign="middle" bgcolor="#FFFF99" class="shop2">&nbsp;<?php echo $en_amt;?> <?php echo $res_currency[symbol];?></td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="mycon">Other Amount : &nbsp;</td>
                                            <td align="left" valign="middle" class="shop2">&nbsp;<?php echo $other_amt;?> <?php echo $res_currency[symbol];?></td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="mycon">Course Fees : &nbsp;</td>
                                            <td align="left" valign="middle" bgcolor="#9D9DFF" class="shop2">&nbsp;<?php echo $course_fee_final;?> <?php echo $res_currency[symbol];?></td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="mycon">Paid Amount : &nbsp;</td>
                                            <td align="left" valign="middle" class="shop2" >&nbsp;<?php echo $paid_amt;?> <?php echo $res_currency[symbol];?></td>
                                          </tr>
                                          <tr>
                                            <td align="right" valign="middle" class="mycon">Balance Amount : &nbsp;</td>
                                            <td align="left" valign="middle" bgcolor="#006699" class="logintext" >&nbsp;<?php echo $bal_amt;?> <?php echo $res_currency[symbol];?></td>
                                          </tr>
                                        </table></td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?> : </td>
                                        <td align="left" valign="middle" class="red_smalltext">&nbsp;<?php echo $course["name"];?></td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="pedtext">
										<?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : </td>
                                        <td align="left" valign="middle" class="red_smalltext">&nbsp;<?php echo $cancel["dated"];?></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="pedtext"><?php echo constant("SA_COMMENTS");?> : </td>
                                        <td align="left" valign="middle" class="red_smalltext">&nbsp;<?php echo $cancel["comment"];?></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="pedtext"><?php echo constant("CD_COMMENT");?> : </td>
                                        <td align="left" valign="middle" class="red_smalltext">&nbsp;<?php echo $cancel["cd_comment"];?></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="pedtext"><?php echo constant("TEACHER_ARF_MANAGE_DATE");?> : </td>
                                        <td align="left" valign="middle">
                                          <input name="dated" type="text" class="datepickFuture validate[required] new_textbox190" id="dated" readonly="">
                                        </td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_WEEK_MANAGE_STATUS");?> : </td>
                                        <td align="left" valign="middle">
                                        <select name="status" id="status" class="validate[required]" style="width:192px; height:25px; border:solid 1px; border-color:#999999;">
                                          <option value="Approved">Approved</option>
                                          <option value="Rejected">Rejected</option>
                                        </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="right" valign="middle" class="pedtext"><?php echo constant("SA_REASON_FOR_CANCEL");?> : <span class="nametext1">*</span></td>
                                        <td align="left" valign="middle"><textarea name="comment" class="validate[required]" id="comment" rows="5" cols="35" style="border:solid 1px; background-color:#ECF1FF; border-color:#999999;"></textarea></td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="left" valign="middle" class="nametext">&nbsp;</td>
                                        <td align="center" valign="middle" class="leftmenu">&nbsp;</td>
                                        <td align="left" valign="middle" class="leftmenu">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="30" align="left" valign="middle" class="leftmenu"></td>
                                        <td align="left" valign="middle">&nbsp;</td>
                                        <td align="left" valign="middle">
                                        <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
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
</table></td>
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
</body>
</html>
