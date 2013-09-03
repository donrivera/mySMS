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
include("../includes/saudismsNET-API.php");

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
//$studentid = $_REQUEST['student_id'];
$centre_id = $_SESSION['centre_id'];
$student_id = $_REQUEST['student_id'];
$course_id =  $_REQUEST['course_id'];

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
<script type="text/javascript" src="../modal/thickbox.js"></script>

<script type="text/javascript">
function setsubmit(){
	var student_id = <?php echo $student_id; ?>;	
	var course_id = document.getElementById('course_id').value;
	document.location.href='single-cycle.php?student_id='+student_id+'&course_id='+course_id;
}
function blinkId(id) {	
	var i = document.getElementById(id);
	if(i.style.visibility=='hidden') {
		i.style.visibility='visible';
	} else {
		i.style.visibility='hidden';
	}
    setTimeout("blinkId('"+id+"')",500);
	return true;
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
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
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
        <td width="19%" align="left" valign="top">
        <?php include 'single-menu.php';?>
        </td>
        <td width="2%"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td width="79%" align="left" valign="top">
		
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left" class="logintext"> <?php echo constant("STUDENT_INFORMATON");?></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right"><a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn1" border="0" align="left" /></a></td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="middle" bgcolor="#FFFFFF">
            <form id="frm" name="frm" method="post">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="21%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td colspan="2" align="left" valign="top">
                  <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                  </tr>
                  <tr>
                    <td width="35%" height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?> : &nbsp;</td>
                    <td width="65%" align="left" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php if($student["student_id"] > 0) { echo $student["student_id"]; }?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?> : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");;?></td>
                  </tr>
                  <tr>
                    <td height="22" align="right" valign="middle" class="pedtext">Add Date : &nbsp;</td>
                    <td align="left" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                  </tr>
                </table>
                </td>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                  <tr>
                    <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="middle">
                <select id="course_id" name="course_id" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onChange="setsubmit();">
                    <option value="">--Select Course--</option>
                    <?php
						foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","","") as $valc) {
							$course = $dbf->strRecordID("course", "*", "id='$valc[course_id]'");
						?>
                    <option value="<?php echo $course["id"]; ?>"<?php if($course_id==$course["id"]){?> selected="selected" <?php } ?>><?php echo $course[name]; ?></option>
                    <?php
					  }
					  ?>
                  </select>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
              <?php
				$status = $dbf->getDataFromTable("student_moving","status_id","student_id='$student_id' And course_id='$course_id'");
				
				//Get Balance of a particular student
				$enroll = $dbf->strRecordID("student_enroll","*","student_id='$student_id' And course_id='$course_id'");
				$course = $dbf->strRecordID("course","*","id='$course_id'");
				$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$enroll[fee_id]'");
				
				$course_fee = $course_fees + $enroll["other_amt"];
				$paid_amt = $enroll["discount"];
				$paid_stucture = $dbf->getDataFromTable("student_fees","SUM(paid_amt)","student_id='$student_id' And course_id='$course_id'");
				$paid_amt = $paid_amt + $paid_stucture;
				if($paid_amt < $course_fee){
					$pay_status = constant("STUDENT_ADVISOR_AUDITING_PAYPENDING");
				}else{
					$pay_status = constant("STUDENT_ADVISOR_AUDITING_FULLPAY");
				}
			  ?>
              <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top">
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#ccc;">
                  <tr>
                    <td width="142">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="142">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="142">&nbsp;</td>
                    <td width="516"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="167" align="center" valign="middle"><br /></td>
                        <td width="170" align="center" valign="middle">
                        <table width="70%" border="1" bordercolor="#666699" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#9BC4FF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_AUDITING_ENQUIRY");?></td>
                          </tr>
                        </table></td>
                        <td width="179" align="center" valign="middle">&nbsp;</td>
                        </tr>
                      </table></td>
                    <td width="142">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="142" align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="144" align="right" valign="middle">
                        <table width="90%" border="1" bordercolor="#0099CC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#0033CC" class="logintext"><?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?></td>
                          </tr>
                        </table>
                          <br /><?php if($status == 8){ ?>
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" bgcolor="#0033CC" class="logintext"><?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table><?php } ?></td>
                      </tr>
                      <tr>
                        <td height="143" align="center" valign="middle"><table width="90%" border="1" bordercolor="#f00" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" class="nametext1" bgcolor="#FF0000" style="text-shadow: 1px 0px #960; color:#FFF;"><?php echo constant("CRITICAL_STATUS");?></td>
                          </tr>
                        </table>
                        <br /><?php if($status == 9){ ?>
                        <table width="90%" border="1" bordercolor="#f00" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" class="nametext1" bgcolor="#FF0000" style="text-shadow: 1px 0px #960; color:#FFF;"><?php echo constant("CRITICAL_STATUS");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table><?php } ?></td>
                      </tr>
                      <tr>
                        <td height="225" align="center" valign="middle">
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#E3E3DF" class="leftmenu"><?php echo constant("CANCEL_STATUS");?></td>
                          </tr>
                        </table>
                        <br /><?php if($status == 7){ ?>
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" bgcolor="#E3E3DF" class="leftmenu"><?php echo constant("CANCEL_STATUS");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table><?php } ?>
                        </td>
                      </tr>
                    </table></td>
                    <td width="516"><table width="516" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="167" align="left" valign="top" id="8">
                            <?php
                            if($status == 8){
								$img = "../images/toplefth11.jpg";
								?>
                                <script type="text/javascript">blinkId('8');</script>
                                <?php
							}else{
								$img = "../images/topleft11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="167" height="144" />
                            </td>
                            <td width="170" align="left" valign="top" id="1">
                            <?php
                            $enroll_eq = $dbf->getDataFromTable("student_moving","status_id","student_id='$student_id'");
							$is_advance = $dbf->getDataFromTable("student_moving","course_id","student_id='$student_id' And course_id > '0'");
							$enroll_dtls = $dbf->countRows("student_group_dtls","student_id='$student_id' And course_id='$course_id'");
							
                            if($enroll_eq == 1 && $enroll_dtls <= 0){
								$img = "../images/top_midh11.jpg";
								?>
                                <script type="text/javascript">blinkId('1');</script>
                                <?php
							}else{
								$img = "../images/top_mid11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="170" height="144" /></td>
                            <td width="179" align="left" valign="top" id="2"><?php
                            if($enroll_eq == 2 && $enroll_dtls <= 0 && $is_advance <= 0){
								$img = "../images/top_righth11.jpg";
								?>
                                <script type="text/javascript">blinkId('2');</script>
                                <?php
							}else{
								$img = "../images/top_right11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="179" height="144" /></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="167" align="left" valign="top" id="9">
                            <?php
                            if($status == 9){
								$img = "../images/mid_lefth11.jpg";
								?>
                                <script type="text/javascript">blinkId('9');</script>
                                <?php
							}else{
								$img = "../images/mid_left11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="167" height="143" /></td>
                            <td align="center" valign="bottom"><img src="../images/life_cycle.jpg" width="167" height="73"></td>
                            <td width="179" align="right" valign="top" id="3">
                            <?php
							$is_wait = $dbf->getDataFromTable("student_moving","status_id","student_id='$student_id' And group_id='0'"); //And course_id='0'
							if($is_wait > 2){								
								if($enroll_eq == 3 && $enroll_dtls <= 0){                            
									$img = "../images/mid_righth11.jpg";
									?>
									<script type="text/javascript">blinkId('3');</script>
									<?php
								}else if($is_wait == 3 && $enroll_dtls <= 0){
									$img = "../images/mid_righth11.jpg";
									?>
									<script type="text/javascript">blinkId('3');</script>
									<?php
								}else if($enroll_eq == 2 && $enroll_dtls <= 0 && $is_advance > 0){
									$img = "../images/mid_righth11.jpg";
									?>
									<script type="text/javascript">blinkId('3');</script>
									<?php
								}else{
									$img = "../images/mid_right11.jpg";
								}
							}else{
								$img = "../images/mid_right11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="179" height="143" /></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="107" align="left" valign="top" id="7">
                            <?php
                            if($status == 7){
								$img = "../images/bot_lefth11.jpg";
								?>
                                <script type="text/javascript">blinkId('7');</script>
                                <?php
							}else{
								$img = "../images/bot_left11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="107" height="225" /></td>
                            <td width="152" align="left" valign="top" id="6">
                            <?php
                            if($status == 6){
								$img = "../images/bot_mid1h11.jpg";
								?>
                                <script type="text/javascript">blinkId('6');</script>
                                <?php
							}else{
								$img = "../images/bot_mid111.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="152" height="225" /></td>
                            <td width="154" align="left" valign="top" id="5">
                            <?php
                            if($status == 5){
								$img = "../images/bot_mid2h11.jpg";
								?>
                                <script type="text/javascript">blinkId('5');</script>
                                <?php
							}else{
								$img = "../images/bot_mid211.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="154" height="225" /></td>
                            <td align="left" valign="top" id="4">
                            <?php
                            if($status == 4){
								$img = "../images/bot_righth11.jpg";
								?>
                                <script type="text/javascript">blinkId('4');</script>
                                <?php
							}else{
								$img = "../images/bot_right11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="103" height="225" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                    <td width="142" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="144">
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_AUDITING_POTENTI");?></td>
                          </tr>
                        </table>
                        <br /></td>
                      </tr>
                      <tr>
                        <td height="143"><table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#9999CC" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_AUDITING_WAITING");?></td>
                          </tr>
                        </table>
                        <br />
                        <?php if($status == 3){ ?>
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" bgcolor="#9999CC" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_AUDITING_WAITING");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table>
                          <?php } ?>
                          </td>
                      </tr>
                      <tr>
                        <td height="225"><table width="90%" border="1" bordercolor="#FF6600" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#FF9966" class="leftmenu"><?php echo constant("ENROLLED");?></td>
                          </tr>
                        </table>
                        <br /><?php if($status == 4){ ?>
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" bgcolor="#FF9966" class="leftmenu"><?php echo constant("ENROLLED");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table><?php } ?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="142">&nbsp;</td>
                    <td width="516"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="35%" align="center" valign="middle">
                          <table width="70%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td height="20" align="center" valign="middle" bgcolor="#FFFF00" class="pedtext"><?php echo constant("STUDENT_ADVISOR_AUDITING_ONHOLD");?></td>
                              </tr>
                            </table>
                          <br /><?php if($status == 6){ ?>
                          <table width="70%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td width="83%" height="20" align="center" valign="middle" bgcolor="#FFFF00" class="pedtext"><?php echo constant("STUDENT_ADVISOR_AUDITING_ONHOLD");?> <?php echo $pay_status;?></td>
                              </tr>
                            </table><?php } ?>
                          </td>
                        <td width="65%" align="right" valign="middle"><table width="150" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td height="20" align="center" valign="middle" bgcolor="#6633CC" class="logintext"><?php echo constant("STUDENT_ADVISOR_AUDITING_ACTIVE");?></td>
                              </tr>
                            </table>
                          <br /><?php if($status == 5){ ?>
                          <table width="150" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td height="20" align="center" valign="middle" bgcolor="#6633CC" class="logintext"><?php echo constant("STUDENT_ADVISOR_AUDITING_ACTIVE");?> <?php echo $pay_status;?></td>
                              </tr>
                            </table><?php } ?></td>
                        </tr>
                      </table></td>
                    <td width="142">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="142">&nbsp;</td>
                    <td width="516">&nbsp;</td>
                    <td width="142">&nbsp;</td>
                  </tr>
                </table>
                </td>
              </tr>
              
            </table>
            </form>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
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
    <td align="left" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="78%" align="right" valign="top">
        	<table width="98%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="79%" align="left" valign="top">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="25%" height="30" align="left"> <a href="single-home.php?student_id=<?php echo $_REQUEST[student_id];?>">
                    <input type="button" value="<?php echo constant("btn_cancel_btn2");?>" class="btn2" border="0" align="left" />
                </a></td>
                <td width="6%" id="lblname">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="41%" align="left">&nbsp;</td>
                <td width="18%" align="right" class="logintext"><?php echo constant("STUDENT_INFORMATON");?>&nbsp;</td>
              </tr>
              <tr>
                <td height="15" colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
              </tr>
            </table></td>
          </tr>		  
          <tr>
            <td align="center" valign="top" bgcolor="#FFFFFF">
            <form id="frm" name="frm" method="post">
            <table width="80%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#999;">
              <tr>
                <td width="4%">&nbsp;</td>
                <td width="19%">&nbsp;</td>
                <td width="24%">&nbsp;</td>
                <td width="13%">&nbsp;</td>
                <td width="40%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top"><?php
				if($student["photo"]!=''){
						$photo = "../sa/photo/".$student["photo"];
				  }else{
						$photo = "../images/noimage.jpg";
				  }
				  ?>
                    <table width="120" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                      <tr>
                        <td align="center"><img src="<?php echo $photo;?>" width="120" height="130"></td>
                      </tr>
                  </table></td>
                <?php $student = $dbf->strRecordID("student","*","id='$student_id'"); ?>
                <td>&nbsp;</td>
                <td colspan="2" align="center" valign="top">
                <table width="95%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" colspan="2" align="center" valign="middle" bgcolor="#DDDDFF" class="pedtext"><?php echo constant("STUDENT_INFORMATON");?></td>
                    </tr>
                    <tr>
                      <td width="64%" height="22" align="right" valign="middle" class="mytext"><?php echo $student["first_name"];?><?php echo $Arabic->en2ar($dbf->StudentName($student["id"]));?></td>
                      <td width="36%" align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></td>
                    </tr>
                    <?php if($student["student_id"] > 0) { ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_id"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT_ID");?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["email"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $student["student_mobile"];?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></td>
                    </tr>
                    <tr>
                      <td height="22" align="right" valign="middle" class="mytext"><?php echo $dbf->getDataFromTable("countries","value","id='$student[country_id]'");?></td>
                      <td align="left" valign="middle" class="pedtext">: <?php echo constant("ADMIN_TEACHER1_MANAGE_NATIONALITY");?></td>
                    </tr>
                    <tr>
                    <td align="right" valign="middle" class="mytext"><?php echo date('D,d M Y , h:i A',strtotime($student["created_datetime"]));?></td>
                    <td height="22" align="left" valign="middle" class="pedtext"><?php echo $Arabic->en2ar(': Add Date');?></td>
                  	</tr>
                </table>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
                <td height="1" bgcolor="#CCCCCC"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="right" valign="middle">
                <select id="course_id" name="course_id" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onChange="setsubmit();">
                    <option value="">--Select Course--</option>
                    <?php
					foreach($dbf->fetchOrder('student_enroll',"student_id='$student_id'","","") as $valc) 																		                    {
					$course = $dbf->strRecordID("course", "*", "id='$valc[course_id]'");
					?>
                    <option value="<?php echo $course["id"]; ?>"<?php if($course_id==$course["id"]){?> selected="selected" <?php } ?>><?php echo $course[name]; ?></option>
                    <?php
					  }
					  ?>
                  </select>
                </td>
              </tr>
              <tr>
              <?php
				$status = $dbf->getDataFromTable("student_moving","status_id","student_id='$student_id' And course_id='$course_id'");
				
				//Get Balance of a particular student
				$enroll = $dbf->strRecordID("student_enroll","*","student_id='$student_id' And course_id='$course_id'");
				$course = $dbf->strRecordID("course","*","id='$course_id'");
				$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$enroll[fee_id]'");
				
				$course_fee = $course_fees + $enroll["other_amt"];
				$paid_amt = $enroll["discount"];
				$paid_stucture = $dbf->getDataFromTable("student_fees","SUM(paid_amt)","student_id='$student_id' And course_id='$course_id'");
				$paid_amt = $paid_amt + $paid_stucture;
				if($paid_amt < $course_fee){
					$pay_status = constant("STUDENT_ADVISOR_AUDITING_PAYPENDING");
				}else{
					$pay_status = constant("STUDENT_ADVISOR_AUDITING_FULLPAY");
				}
			  ?>
              <td>&nbsp;</td>
                <td colspan="6" align="left" valign="top">
                <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px; border-color:#ccc;">
                  <tr>
                    <td width="142">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="142">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="142">&nbsp;</td>
                    <td width="516"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="167" align="center" valign="middle"><br /></td>
                        <td width="170" align="center" valign="middle">
                        <table width="70%" border="1" bordercolor="#666699" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#9BC4FF" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_AUDITING_ENQUIRY");?></td>
                          </tr>
                        </table></td>
                        <td width="179" align="center" valign="middle">&nbsp;</td>
                        </tr>
                      </table></td>
                    <td width="142">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="142" align="right" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="144" align="right" valign="middle">
                        <table width="90%" border="1" bordercolor="#0099CC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#0033CC" class="logintext"><?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?></td>
                          </tr>
                        </table>
                          <br /><?php if($status == 8){ ?>
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" bgcolor="#0033CC" class="logintext"><?php echo constant("STUDENT_ADVISOR_AUDITING_COMPLETED");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table><?php } ?></td>
                      </tr>
                      <tr>
                        <td height="143" align="center" valign="middle"><table width="90%" border="1" bordercolor="#f00" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" class="nametext1" bgcolor="#FF0000" style="text-shadow: 1px 0px #960; color:#FFF;"><?php echo constant("CRITICAL_STATUS");?></td>
                          </tr>
                        </table>
                        <br /><?php if($status == 9){ ?>
                        <table width="90%" border="1" bordercolor="#f00" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" class="nametext1" bgcolor="#FF0000" style="text-shadow: 1px 0px #960; color:#FFF;"><?php echo constant("CRITICAL_STATUS");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table><?php } ?></td>
                      </tr>
                      <tr>
                        <td height="225" align="center" valign="middle">
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#E3E3DF" class="leftmenu"><?php echo constant("CANCEL_STATUS");?></td>
                          </tr>
                        </table>
                        <br /><?php if($status == 7){ ?>
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" bgcolor="#E3E3DF" class="leftmenu"><?php echo constant("CANCEL_STATUS");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table><?php } ?>
                        </td>
                      </tr>
                    </table></td>
                    <td width="516"><table width="516" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="167" align="left" valign="top" id="8">
                            <?php
                            if($status == 8){
								$img = "../images/toplefth11.jpg";
								?>
                                <script type="text/javascript">blinkId('8');</script>
                                <?php
							}else{
								$img = "../images/topleft11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="167" height="144" />
                            </td>
                            <td width="170" align="left" valign="top" id="1">
                            <?php
                            $enroll_eq = $dbf->getDataFromTable("student_moving","status_id","student_id='$student_id'");
							$is_advance = $dbf->getDataFromTable("student_moving","course_id","student_id='$student_id' And course_id > '0'");
							$enroll_dtls = $dbf->countRows("student_group_dtls","student_id='$student_id' And course_id='$course_id'");
							
                            if($enroll_eq == 1 && $enroll_dtls <= 0){
								$img = "../images/top_midh11.jpg";
								?>
                                <script type="text/javascript">blinkId('1');</script>
                                <?php
							}else{
								$img = "../images/top_mid11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="170" height="144" /></td>
                            <td width="179" align="left" valign="top" id="2"><?php
                            if($enroll_eq == 2 && $enroll_dtls <= 0 && $is_advance <= 0){
								$img = "../images/top_righth11.jpg";
								?>
                                <script type="text/javascript">blinkId('2');</script>
                                <?php
							}else{
								$img = "../images/top_right11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="179" height="144" /></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="167" align="left" valign="top" id="9">
                            <?php
                            if($status == 9){
								$img = "../images/mid_lefth11.jpg";
								?>
                                <script type="text/javascript">blinkId('9');</script>
                                <?php
							}else{
								$img = "../images/mid_left11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="167" height="143" /></td>
                            <td align="center" valign="bottom"><img src="../images/life_cycle.jpg" width="167" height="73"></td>
                            <td width="179" align="right" valign="top" id="3">
                            <?php
							$is_wait = $dbf->getDataFromTable("student_moving","status_id","student_id='$student_id' And group_id='0'"); //And course_id='0'
							if($is_wait > 2){								
								if($enroll_eq == 3 && $enroll_dtls <= 0){                            
									$img = "../images/mid_righth11.jpg";
									?>
									<script type="text/javascript">blinkId('3');</script>
									<?php
								}else if($is_wait == 3 && $enroll_dtls <= 0){
									$img = "../images/mid_righth11.jpg";
									?>
									<script type="text/javascript">blinkId('3');</script>
									<?php
								}else if($enroll_eq == 2 && $enroll_dtls <= 0 && $is_advance > 0){
									$img = "../images/mid_righth11.jpg";
									?>
									<script type="text/javascript">blinkId('3');</script>
									<?php
								}else{
									$img = "../images/mid_right11.jpg";
								}
							}else{
								$img = "../images/mid_right11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="179" height="143" /></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="107" align="left" valign="top" id="7">
                            <?php
                            if($status == 7){
								$img = "../images/bot_lefth11.jpg";
								?>
                                <script type="text/javascript">blinkId('7');</script>
                                <?php
							}else{
								$img = "../images/bot_left11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="107" height="225" /></td>
                            <td width="152" align="left" valign="top" id="6">
                            <?php
                            if($status == 6){
								$img = "../images/bot_mid1h11.jpg";
								?>
                                <script type="text/javascript">blinkId('6');</script>
                                <?php
							}else{
								$img = "../images/bot_mid111.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="152" height="225" /></td>
                            <td width="154" align="left" valign="top" id="5">
                            <?php
                            if($status == 5){
								$img = "../images/bot_mid2h11.jpg";
								?>
                                <script type="text/javascript">blinkId('5');</script>
                                <?php
							}else{
								$img = "../images/bot_mid211.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="154" height="225" /></td>
                            <td align="left" valign="top" id="4">
                            <?php
                            if($status == 4){
								$img = "../images/bot_righth11.jpg";
								?>
                                <script type="text/javascript">blinkId('4');</script>
                                <?php
							}else{
								$img = "../images/bot_right11.jpg";
							}
							?>
                            <img src="<?php echo $img;?>" width="103" height="225" /></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                    <td width="142" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="144">
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#CCCCCC" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_AUDITING_POTENTI");?></td>
                          </tr>
                        </table>
                        <br /></td>
                      </tr>
                      <tr>
                        <td height="143"><table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#9999CC" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_AUDITING_WAITING");?></td>
                          </tr>
                        </table>
                        <br />
                        <?php if($status == 3){ ?>
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" bgcolor="#9999CC" class="leftmenu"><?php echo constant("STUDENT_ADVISOR_AUDITING_WAITING");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table>
                          <?php } ?>
                          </td>
                      </tr>
                      <tr>
                        <td height="225"><table width="90%" border="1" bordercolor="#FF6600" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td height="20" align="center" valign="middle" bgcolor="#FF9966" class="leftmenu"><?php echo constant("ENROLLED");?></td>
                          </tr>
                        </table>
                        <br /><?php if($status == 4){ ?>
                        <table width="90%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="83%" height="20" align="center" valign="middle" bgcolor="#FF9966" class="leftmenu"><?php echo constant("ENROLLED");?> <?php echo $pay_status;?></td>
                          </tr>
                          </table><?php } ?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="142">&nbsp;</td>
                    <td width="516"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="35%" align="center" valign="middle">
                          <table width="70%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td height="20" align="center" valign="middle" bgcolor="#FFFF00" class="pedtext"><?php echo constant("STUDENT_ADVISOR_AUDITING_ONHOLD");?></td>
                              </tr>
                            </table>
                          <br /><?php if($status == 6){ ?>
                          <table width="70%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td width="83%" height="20" align="center" valign="middle" bgcolor="#FFFF00" class="pedtext"><?php echo constant("STUDENT_ADVISOR_AUDITING_ONHOLD");?> <?php echo $pay_status;?></td>
                              </tr>
                            </table><?php } ?>
                          </td>
                        <td width="65%" align="right" valign="middle"><table width="150" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td height="20" align="center" valign="middle" bgcolor="#6633CC" class="logintext"><?php echo constant("STUDENT_ADVISOR_AUDITING_ACTIVE");?></td>
                              </tr>
                            </table>
                          <br /><?php if($status == 5){ ?>
                          <table width="150" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                            <tr>
                              <td height="20" align="center" valign="middle" bgcolor="#6633CC" class="logintext"><?php echo constant("STUDENT_ADVISOR_AUDITING_ACTIVE");?> <?php echo $pay_status;?></td>
                              </tr>
                            </table><?php } ?></td>
                        </tr>
                      </table></td>
                    <td width="142">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="142">&nbsp;</td>
                    <td width="516">&nbsp;</td>
                    <td width="142">&nbsp;</td>
                  </tr>
                </table>
                </td>
              </tr>
              
            </table>
            </form>
            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
		</td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'single-menu.php';?></td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
<?php }?>
</body>
</html>
