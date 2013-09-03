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
include '../includes/FusionCharts.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

if($_SESSION['ALERT_DISPLAY'] == ''){
$alert_count = $dbf->countRows("alerts", "cen_dr='1' AND status='0' And imp='1' And id not in (select alert_id from alerts_read where user_id='$_SESSION[id]')");
}
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

<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="../modal/thickbox.js"></script>
<link rel="stylesheet" href="../modal/thickbox.css" type="text/css" media="screen" />

<!-- POP UP modal box -->
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.2.js"></script>
<link rel="stylesheet" href="../fancybox/jquery.fancybox-1.3.2.css" type="text/css" media="screen" />
<!-- POP UP modal box -->

<script language="Javascript" type="text/javascript">
var countdown;
var countdown_number;

function countdown_init(count) {
    countdown_number = count;
    countdown_trigger();
}

function countdown_trigger() {
    if(countdown_number > 0) {
        countdown_number--;
        //document.getElementById('countdown_text').innerHTML = countdown_number;
        if(countdown_number > 0) {
            countdown = setTimeout('countdown_trigger()', 1000);
        }
    }
	if(countdown_number == 0)
	{
		var msg = "Your session has been expired.";
		alert(msg)
		window.location.href='../logout.php';
	}
}
function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}
function colorMe(tdid){
	alert(tdid)
	var d = new Date();
	var m = d.getMonth();
	var y = d.getFullYear();
	var tot = daysInMonth(m,y);
	var kk;
	for(k = 1; k <= tot; k++){
		kk = 'kk'+k;
		document.getElementById(kk).style.backgroundColor = '#FFFFFF';
	}
	//document.getElementById(kk).style.backgroundColor = '#FF0000';
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

var x = <?php echo $alert_count; ?>;
$(function(){
	if(x > 0){
	$.fancybox.showActivity();
	//var res="<div style='width:300px;height:200px;border:2px solid red;'class='post_review_main'> bye bye</div>";
	$.post("alert_page.php",{"choice":"alert_respose"},function(res){
		$.fancybox(res,{centerOnScroll:true,hideOnOverlayClick:false});
	});
	}
});
</script>
<?php
//Get from the table
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds

// Alert set 1 time by session
$_SESSION['ALERT_DISPLAY'] = 'TRUE';
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<?php if($_SESSION[lang]=="EN"){?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="50" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
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
        <td width="79%" align="left" valign="top">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
          <tr>
            <td height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;">
			<?php echo constant("CENTER_DIRECTOR_HOME_DASHBOARD");?></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="0%">&nbsp;</td>
                <td width="30%" id="countdown_text">&nbsp;</td>
                <td width="24%">
                </td>
                <td width="46%"></td>
                <td width="0%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="middle">
                <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                  <tr>
                    <td height="25" align="center" valign="middle" class="pedtext"><?php echo constant("ACCOUNTANT_SUMMERY");?></td>
                  </tr>
                </table></td>
                <td align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("CD_HOME_SALE_OFDAY");?></td>
                  </tr>
                </table></td>
                <td align="left" valign="top">
                <table width="99%" border="0" align="right" cellpadding="0" cellspacing="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php //echo constant("RECENT_ADDED_STUDENTS");?></td>
                  </tr>
                </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td></td>
                <td height="2" align="left" valign="middle"></td>
                <td height="2" align="center" valign="middle"></td>
                <td align="center" valign="middle"></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top">
                <?php
				$centre_id = $_SESSION['centre_id'];
				$is_transfer = $dbf->countRows("transfer_centre_to_centre", "status='Approved' And centre_to='$centre_id'");
				if($is_transfer > 0){
					
					// Get All student pay Amount
					$trans_amount = 0;
					foreach($dbf->fetchOrder('transfer_centre_to_centre m,transfer_centre_to_centre_dtls d',"m.id=d.parent_id And m.centre_to='$centre_id' And status='Approved'","","d.*") as $tran) {
						$trans_amount = $trans_amount + $dbf->GetStudentPaidAmount($tran["student_id"]);
					}
				?>
                  	<table width="98%" border="0" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="14%" height="25" align="center" valign="middle"><img src="../images/new.png" width="38" height="15" id="trans"/></td>
                        <td width="54%" align="left" valign="middle" class="red_smalltext">&nbsp;<?php echo constant("TRANSFERD_CENTER_AMOUNT");?>&nbsp; :&nbsp;</td>
                        <td width="32%" align="left" valign="middle" class="nametext"><?php echo $trans_amount;?></td>
                      </tr>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="2"></td>
                      </tr>
                    </table>
					<script type="text/javascript">blinkId('trans');</script>
                    <?php } ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50%" align="center" valign="top">
                        <table width="95%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
                          <tr>
                            <td height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo constant("CD_HOME_PREV_SALE");?></td>
                          </tr>
                          <?php
                          $y = date('Y') - 1;
                          
                          $start_date = date("Y-m-d", strtotime(date("01").'/01/'.$y.' 00:00:00'));
                          $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+12 month',strtotime(date("01").'/01/'.$y.' 00:00:00'))));
                            
                          $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$start_date' AND '$end_date')");
                          $amt = $res["SUM(paid_amt)"];
						  						  
                          if($amt == '') { $amt = 0; }
                          ?>
                          <tr>
                            <td height="25" align="center" valign="middle" class="leftmenu"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                          </tr>
                          <tr>
                            <td height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo constant("CD_HOME_CURR_SALE");?></td>
                          </tr>
                          <?php
                          $start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
                          $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+12 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
                            
                          $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$start_date' AND '$end_date')");
                          $amt = $res["SUM(paid_amt)"];
						  						  
						  # If any discount for this Month
						  $res=$dbf->strRecordID('student_enroll', 'SUM(discount)',"centre_id='$centre_id' And (payment_date BETWEEN '$start_date' AND '$end_date')");
                          $amt = $amt - $res["SUM(discount)"];
						  
                          if($amt == '') { $amt = 0; }
                          ?>
                          <tr>
                            <td height="25" align="center" valign="middle" class="mymenutext"><?php echo $amt." ".$res_currency[symbol];?></td>
                          </tr>
                        </table></td>
                        <td width="50%" align="center" valign="top"><table width="95%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
                          <tr>
                            <td height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">Current Month Sales</td>
                          </tr>
                          <?php
                          $y = date('Y');
                          $m = date('m');
                          $start_date = date("Y-m-d", strtotime(date($m).'/01/'.$y.' 00:00:00'));
                          $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date($m).'/01/'.$y.' 00:00:00'))));
                          
						  # Get Paid amount for the Month 
                          $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$start_date' AND '$end_date')");
                          $amt = $res["SUM(paid_amt)"];
						  						  
						  # If any discount for this Month
						  $res=$dbf->strRecordID('student_enroll', 'SUM(discount)',"centre_id='$centre_id' And (payment_date BETWEEN '$start_date' AND '$end_date')");
                          $amt = $amt - $res["SUM(discount)"];
						  
                          if($amt == '') { $amt = 0; }
                          ?>
                          <tr>
                            <td height="75" align="center" valign="middle" class="leftmenu"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                          </tr>
                          <?php
                          $start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
                          $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+12 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
                            
                          $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$start_date' AND '$end_date')");
                          $amt = $res["SUM(paid_amt)"];
                          if($amt == '') { $amt = 0; }
                          ?>
                        </table></td>
                      </tr>
			</table>
			<br />
            <table width="98%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
              <tr>
                <td width="55%" height="25" align="left" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">Total  of the number of sales </td>
                <td width="22%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">Cash</td>
                <td width="23%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">POS</td>
              </tr>
              <tr>
                <td height="25" align="center" valign="middle" class="red_smalltext">Today : </td>
                <?php
                //Cash for the Day
                // 60 = Cash
                  $start_date = date("Y-m-d");
                  $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And paid_date='$start_date' And payment_type='60'");
                  $amt = $res["SUM(paid_amt)"];
				  				  				  				  
                  if($amt == '') { $amt = 0; }
                  ?>
                <td align="center" valign="middle" class="red_smalltext"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                <?php
                //Cash for the Day
                // 60 = POS
                  $start_date = date("Y-m-d");
                  $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And paid_date='$start_date' And payment_type='61'");
                  $amt = $res["SUM(paid_amt)"];
				  				  
                  if($amt == '') { $amt = 0; }
                  ?>
                <td align="center" valign="middle" class="red_smalltext"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
              </tr>
              <tr>
                <td height="25" align="center" valign="middle" bgcolor="#F7F7F7" class="red_smalltext">This Week : </td>
                <?php
                //Cash for the Week
                // 60 = Cash
                $first_day_of_week = date('Y-m-d', strtotime('Last Sunday', time()));
                $last_day_of_week = date('Y-m-d', strtotime('Next Saturday', time()));
                
                $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And payment_type='60'");
                $amt = $res["SUM(paid_amt)"];
				
				$res=$dbf->strRecordID('student_enroll', 'SUM(discount)',"centre_id='$centre_id' And (payment_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And payment_type='60'");
                $amt = $amt - $res["SUM(discount)"];
								
                if($amt == '') { $amt = 0; }
                ?>
                <td align="center" valign="middle" bgcolor="#F7F7F7" class="red_smalltext"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                <?php
                //Cash for the Week
                // 61 = POS	
                $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And payment_type='61'");
                $amt = $res["SUM(paid_amt)"];
								
                if($amt == '') { $amt = 0; }
                ?>
                <td align="center" valign="middle" bgcolor="#F7F7F7" class="red_smalltext"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
              </tr>
              </table>
		</td>
            <td align="center" valign="top" style="border-left:solid 1px; border-color:#CCC; border-bottom:solid 1px; border-color:#ccc;">
              <?php
			  
                function GenerateCalendar($Month, $Year){
                    
					$centre_id = $_SESSION['centre_id'];
					
                    //Object initialization
                    $dbf = new User();
                    $res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
                    
                    $FirstDay = mktime(0,0,0,$Month,1,$Year);
                    $LastDay = mktime(0,0,0,$Month,date('t',$FirstDay),$Year);
                    $Today = mktime(0,0,0,date('m'),date('d'),date('Y'));
                    $FirstDayWeekNo = date('w',$FirstDay);
                    $LastDayNo = date('d',$LastDay);
                
                    //Creates Header for Calendar of the Month
                    echo('<table cellspacing="2" width="100%" cellpadding="0" border="1" bordercolor="#999999" style="border-collapse:collapse; color:#be883b; ">');
                    echo('<tr><th colspan="7" align="center"  height="30" class="pedtext">'.date('F',$FirstDay)." - ".date('Y',$FirstDay)."</th></tr>");
                    echo('<tr class="days">');
                    echo('<td width="40px" align="center" height="30" style="background-color:#ccc;color:#000; font-weight:bold;">Sun</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Mon</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Tue</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Wed</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Thu</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Fri</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Sat</td>');
                    echo('</tr>');
                    //End Create Header for Calendar of the Month
                
                    //Being Populating Calendar
                    $CurrentDateCount = 1;
                    $CurrentDayCount = 0;
                
                    //Make sure the frist day of the month is ploted correctly					
                    echo('<tr>');
                
                    for ($DayCounter = 0; $DayCounter < $FirstDayWeekNo; $DayCounter += 1){
                        echo('<td> </td>');
                        $CurrentDayCount = $DayCounter + 1;
                    }
                    $m = 1;
                    for($DayCounter = $CurrentDateCount; $DayCounter <= $LastDayNo; $DayCounter +=1){
                        //Being new Row for Each Sunday
                        if ($DayCounter > 1 ){
                            if ($CurrentDayCount == 0){
                                echo('<tr">');
                            }
                        }
                        
                        //Check Date
                        //echo $Year;
                        //echo $Month;
                        
                        //Looping Date
                        $dt=date("Y-m-d",mktime(0,0,0,$Month,$DayCounter,$Year));
                        //echo $dt;                
                        $res = $dbf->strRecordID("student_fees","SUM(paid_amt)","centre_id='$centre_id' And paid_date='$dt'");
                        $amt = $res["SUM(paid_amt)"];
                        						
						# If any discount for this Date
						$res = $dbf->strRecordID('student_enroll', 'SUM(discount)',"centre_id='$centre_id' And payment_date='$dt'");
                        $amt = $amt - $res["SUM(discount)"];
												
                        $descr = constant("CD_HOME_SALE_OFDAY")." ".$amt." ".$res_currency[symbol];
                                                                       
                        //Matching with My date
                        if($amt>0){
                            echo('<td align="center" bgcolor="#FFCC00" style="color:#ffffff;">');
                            echo('<a class="tooltip" href="#">');
                            echo($DayCounter);
                            echo('<span class="classic">');
                            echo($descr);
                            echo('</span>');
                            echo('</a></td>');
                        }else{
							$kk = 'kk'.$m;
                            echo('<td align="center" height="25" style="color:#000;" id="'.$kk.'" onmouseover="colorMe(kk)" class="mycon">');
                            echo($DayCounter);
                            echo('</td>');
							$m++;
                        }
                        
                        $CurrentDayCount += 1;
                
                        //End Row for Each Sat
                        if ($CurrentDayCount > 6){
                            echo('</tr>');
                            $CurrentDayCount = 0;
                        }
                    }
                    //End Populating Calendar
                    echo('</table>');
                }
                
                //
                date_default_timezone_set('UTC');
                
                //Get Current Month
                $mth=date("m");
                
                echo('<table cellpadding="10" cellspacing = "10">');
                for ($CurrentMonth = $mth; $CurrentMonth <= $mth; $CurrentMonth +=1){
                    if ($CurrentMonth - 1 % 5 == 0){
                        echo('<tr>');
                        echo('<td valign="top">');
                    }else{
                        echo('<td valign="top">');
                    }
                    
                    //Get Current Year
                    
                    $yr=date("Y");
                    
                    GenerateCalendar($CurrentMonth,$yr);
                    if ($CurrentMonth % 4 == 0){
                        echo('</td>');
                        echo('</tr>');
                    }else{
                        echo('</td>');
                    }
                }
                echo('</table>');
                ?>  
              </td>
                <td align="right" valign="top"  style="border-left:solid 1px; border-color:#CCC;">
                  <table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#666666">
                    <tr class="pedtext">
                      <td width="20%" height="20" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></td>
                      <td width="18%" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("ADMIN_DASHBOARD_DATED");?></td>
                      <td width="23%" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?></td>
                      <td width="17%" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
                      <td width="9%" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("STUDENT_ADVISOR_PED_NO");?>.</td>
                      </tr>
                    <?php
                  foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id'","id DESC LIMIT 0,7") as $valgroup) {
                      
                      $teacher = $dbf->strRecordID("teacher","*","id='$valgroup[teacher_id]'"); 
                      $course = $dbf->strRecordID("course","*","id='$valgroup[course_id]'"); 
                      $no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$valgroup[id]'");					  
                      ?>
                    <tr class="mycon">
                      <td height="20" align="center" valign="middle" bgcolor="#FFFFFF"><a href="group_manage.php?group_id=<?php echo $valgroup["id"];?>" style="text-decoration:none;"><?php echo $valgroup["group_name"];?> <?php echo $valgroup["group_time"];?>-<?php echo $dbf->GetGroupTime($valgroup["id"]);?></a></td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $valgroup["start_date"].'<br>'.$valgroup["end_date"];?></td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $teacher["name"];?></td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $course["name"];?></td>
                      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $no["COUNT(id)"];?></td>
                      </tr>
                    <?php } ?>
                    </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="center" valign="top">&nbsp;</td>
                <td align="center" valign="top" class="cer7_bold">&nbsp;</td>
                <td align="right" valign="top" >&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td></td>
                <td height="1" colspan="3" align="left" valign="middle" bgcolor="#CCCCCC"></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td height="1" colspan="3" align="left" valign="middle" style="padding-top:5px;">
                
                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="54%" align="left" valign="top">
                    <table width="96%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
                      <tr>
                        <td width="58%" height="25" align="left" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">&nbsp;</td>
                        <td width="8%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">Today</td>
                        <td width="17%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">Last 3 Days</td>
                        <td width="17%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">This Week</td>
                      </tr>
                      <tr>
                        <td height="25" align="left" valign="middle" class="red_smalltext">Total  number of new enquiries</td>
                        <td align="center" valign="middle" class="red_smalltext">
                        <?php
						//No of students are enquries in this centre today
						$today = date('Y-m-d');
						$res=$dbf->strRecordID('student', 'COUNT(id)',"centre_id='$centre_id' And register_date='$today' And id not in (select student_id from student_enroll)");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;
						?>
                        </td>
                        <td align="center" valign="middle" class="red_smalltext">
                        <?php
                        $d = date('d');
						$end_date = date("Y-m-d", strtotime(date($m).'/'.$d.'/'.$y.' 00:00:00'));
	  					$start_date = date("Y-m-d", strtotime('-1 second',strtotime('-2 day',strtotime($end_date))));
	  
						//No of students are enquries in this centre before 3 days
						$res=$dbf->strRecordID('student', 'COUNT(id)',"centre_id='$centre_id' And (register_date BETWEEN '$start_date' And '$end_date') And id not in (select student_id from student_enroll)");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;
						?>
                        </td>
                        <td align="center" valign="middle" class="red_smalltext">
                        <?php $res=$dbf->strRecordID('student', 'COUNT(id)',"centre_id='$centre_id' And (register_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And id not in (select student_id from student_enroll)");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;
						?>
                        </td>
                      </tr>
                      <tr>
                        <td height="25" align="left" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">Total  number of new enrollments </td>
                        <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">
                        <?php
                        //No of students are enquries in this centre today
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date='$today'");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?>
                        </td>
                        <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">
                        <?php
                        //No of students are enquries in this centre before 3 days
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And (enroll_date BETWEEN '$start_date' And '$end_date')");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?>
                        </td>
                        <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">
						<?php
                        $res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And (enroll_date BETWEEN '$first_day_of_week' AND '$last_day_of_week')");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?>
                        </td>
                      </tr>
                      <tr>
                        <td height="25" align="left" valign="middle" class="red_smalltext">Total  number of new re-enrollments </td>
                        <td align="center" valign="middle" class="red_smalltext">
                        <?php
						//loop start
						$enroll = 0;
						foreach($dbf->fetchOrder('student_enroll', "enroll_date='$today' And centre_id='$centre_id'") as $valenroll) {					
													
							//Check whether it is for New-Enrollment or Re-enrollment
							$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And enroll_date='$today'");
							if($num_re > 1){
								$enroll = $enroll + 1;
							}
						}
						echo $enroll;
						?>
                        </td>
                        <td align="center" valign="middle" class="red_smalltext">
                        <?php
						//loop start
						$enroll = 0;
						foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
													
							//Check whether it is for New-Enrollment or Re-enrollment
							$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$start_date' And '$end_date')");
							if($num_re > 1){
								$enroll = $enroll + 1;
							}
						}
						echo $enroll;
						?>
                        </td>
                        <td align="center" valign="middle" class="red_smalltext">
						<?php
						//loop start
						$enroll = 0;
						foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And centre_id='$centre_id'") as $valenroll) {					
													
						//Check whether it is for New-Enrollment or Re-enrollment
						$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$first_day_of_week' And '$last_day_of_week')");
							if($num_re > 1){
								$enroll = $enroll + 1;
							}
						}
						echo $enroll;
						?>
                        </td>
                      </tr>                      
                      <tr>
                        <td height="25" align="left" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">Total  number of absent students </td>
                        <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">
                        <?php
						$no_of_attand = 0;
						foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And attend_date='$today'") as $cer) {
							$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]' And centre_id='$centre_id'");
							$c_id = $centre_grp["centre_id"];
							if($c_id == $centre_id){
								$no_of_attand = $no_of_attand + 1;
							}
						}
						echo $no_of_attand;
						?>
                        </td>
                        <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">
                        <?php
						$no_of_attand = 0;
						foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And (attend_date BETWEEN '$start_date' And '$end_date')") as $cer) {
							$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]' And centre_id='$centre_id'");
							$c_id = $centre_grp["centre_id"];
							if($c_id == $centre_id){
								$no_of_attand = $no_of_attand + 1;
							}
						}
						echo $no_of_attand;
						?>
                        </td>
                        <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">
                        <?php
						$no_of_attand = 0;
						foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And (attend_date BETWEEN '$first_day_of_week' And '$last_day_of_week')") as $cer) {
							$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]' And centre_id='$centre_id'");
							$c_id = $centre_grp["centre_id"];
							if($c_id == $centre_id){
								$no_of_attand = $no_of_attand + 1;
							}
						}
						echo $no_of_attand;
						?>
                        </td>
                      </tr>
                      <tr>
                        <td height="25" align="left" valign="middle" class="red_smalltext">Total  number of units taught</td>
                        <td align="center" valign="middle" class="red_smalltext">
                        <?php
                        $res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And a.attend_date='$today'");
						$no_student = $res["COUNT(a.id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?>
                        </td>
                        <td align="center" valign="middle" class="red_smalltext">
                        <?php
                        $res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$start_date' AND '$end_date')");
						$no_student = $res["COUNT(a.id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?>
                        </td>
                        <td align="center" valign="middle">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr class="mytext">
                            <td width="50%" align="center" valign="middle">Week</td>
                            <td align="center" valign="middle">Month</td>
                          </tr>
                          <tr class="mytext">
                            <td align="center" valign="middle">
                            <?php
							$res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$first_day_of_week' AND '$last_day_of_week')");
							$no_student = $res["COUNT(a.id)"];
							if($no_student == '') { $no_student = 0; }
							echo $no_student;?>
                            </td>
                            <td align="center" valign="middle">
                            <?php
							$y = date('Y');
							  $m = date('m');
							  $start_date = date("Y-m-d", strtotime(date($m).'/01/'.$y.' 00:00:00'));
							  $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date($m).'/01/'.$y.' 00:00:00'))));
						  
							$res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$start_date' AND '$end_date')");
							$no_student = $res["COUNT(a.id)"];
							if($no_student == '') { $no_student = 0; }
							echo $no_student;?>
                            </td>
                          </tr>
                        </table>                        
                        </td>
                      </tr>
                    </table>
                    
                    <table width="50%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                      <tr>
                        <td height="30" colspan="3" align="center" valign="middle" class="leftmenu">Click below to view the Alerts</td>
                        </tr>
                      <tr>
                        <td width="30%">&nbsp;</td>
                        <td width="47%" align="center" valign="middle">
                        <a href="alert_page.php?page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../home_icon/alert-icon.png" width="60" height="60" border="0" /></a>
                        </td>
                        <td width="23%">&nbsp;</td>
                      </tr>
                    </table>
                    
                    </td>
                    <td width="46%" align="right" valign="top">
                    <table width="100%" border="1" cellspacing="0" bordercolor="#666666" cellpadding="0" style="border-collapse:collapse;" >
                      <tr>
                        <td width="14%" height="25" align="center" valign="middle" bgcolor="#F1EDF1" class="nametext1">
						<?php echo constant("ADMIN_DASHBOARD_MONTHLY_NUMBER_STUDENTS");?></td>
                      </tr>
                      <?php
						//For January
						 $start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$jan = $res["COUNT(id)"];
						
						//February
						$start_date = date("Y-m-d", strtotime(date("02").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("02").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$feb = $res["COUNT(id)"];
						
						
						//March
						 $start_date = date("Y-m-d", strtotime(date("03").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("03").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$mar = $res["COUNT(id)"];
						
						//April
						$start_date = date("Y-m-d", strtotime(date("04").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("04").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$apr = $res["COUNT(id)"];
						
						//May
						$start_date = date("Y-m-d", strtotime(date("05").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("05").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$may = $res["COUNT(id)"];
						
						//June
						$start_date = date("Y-m-d", strtotime(date("06").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("06").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$jun = $res["COUNT(id)"];
						
						//July
						$start_date = date("Y-m-d", strtotime(date("07").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("07").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$jul = $res["COUNT(id)"];
						
						//Auguest
						 $start_date = date("Y-m-d", strtotime(date("08").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("08").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$aug = $res["COUNT(id)"];
						
						//September
						$start_date = date("Y-m-d", strtotime(date("09").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("09").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$sep = $res["COUNT(id)"];
						
						//October
						$start_date = date("Y-m-d", strtotime(date("10").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("10").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$oct = $res["COUNT(id)"];
						
						//November
						$start_date = date("Y-m-d", strtotime(date("11").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("11").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$nov = $res["COUNT(id)"];
						
						//December
						 $start_date = date("Y-m-d", strtotime(date("12").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("12").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$dec = $res["COUNT(id)"];
						
						?>
                      <tr>
                        <td height="25" align="center" valign="middle" bgcolor="#F1EDF1"><?php
						
						//$start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
						//$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
						
				echo $strXML1="<chart showValues='0' decimals='0' formatNumberScale='0'>
				<set label='Jan' value='$jan'/>
						<set label='Feb' value='$feb'/>
						<set label='Mar' value='$mar'/>
						<set label='Apr' value='$apr'/>
						<set label='May' value='$may'/>
						<set label='Jun' value='$jun'/>
						<set label='Jul' value='$jul'/>
						<set label='Aug' value='$aug'/>
						<set label='Sep' value='$sep'/>
						<set label='Oct' value='$oct'/>
						<set label='Nov' value='$nov'/>
						<set label='Dec' value='$dec'/></chart>";
				echo renderChartHTML("../FusionCharts/Charts/Column3D.swf", "", $strXML1, "myNext", 470, 120);
				?></td>
                      </tr>
                    </table></td>
                    </tr>
                </table>
                
                
                
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td height="30" colspan="2" align="left" style="padding-top:2px;"><table width="100%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                  <tr>
                    <td height="25" colspan="3" align="center" valign="middle" bgcolor="#F5F5F5" class="leftmenu">View All Alerts</td>
                    </tr>
                  <tr>
                    <td width="31%" align="center" valign="middle" class="leftmenu">&nbsp;<a href="alert_page.php?choice=alert_respose&page=alert_page.php&page_from=dashboard&amp;TB_iframe=true&amp;height=150&amp;width=550&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox ">&nbsp; Others Alerts / News</a></td>
                    <td width="32%" align="center" valign="middle" class="leftmenu"><a href="alert_sickleave.php?page=alert_sickleave.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "> All Sick Leave Alerts</a></td>
                    <td width="37%" height="25" align="center" valign="middle" class="leftmenu"><a href="alert_cancel.php?page=alert_cancel.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox ">&nbsp;All Cancellation Alerts</a></td>
                  </tr>
                  </table></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>                
                <td align="left" style="padding-top:2px;">&nbsp;</td>
                <td height="30" align="center" valign="bottom" class="cer7_bold">All Groups Status within a Center</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3" align="left" valign="top">
				<?php
                 echo $strXML1="<chart palette='1' showValues='0' yAxisValuesPadding='10'>			
                        <categories>";
						
						foreach($dbf->fetchOrder('student_group', "centre_id='$centre_id'") as $cer) {
							
							$grp_name = $cer["group_name"];							
                            $strXML1.=" <category label='$grp_name'/>";
							
						}
							
						$strXML1.="</categories>						
						<dataset seriesName='Total Unit(s)'>";
						
						foreach($dbf->fetchOrder('student_group', "centre_id='$centre_id'") as $cer) {
							
							//Get no of unit of a group
							$res_unit = $dbf->strRecordID("group_size","*","group_id='$cer[group_id]'");
							$group_unit = $res_unit["units"];							
							$strXML1.="<set value='$group_unit'/>";
							
						}
						
						$strXML1.="</dataset>
						<dataset seriesname='Completed Unit(s)'>";
						
						foreach($dbf->fetchOrder('student_group', "centre_id='$centre_id'") as $cer) {
							
							$left_units = $dbf->countRows('ped_units',"group_id='$cer[id]'");
							$strXML1.="<set value='$left_units'/>";
							
						}
						
						$strXML1.=" </dataset>
												
						</chart>";
				echo renderChartHTML("../FusionCharts/Charts/MSColumnLine3D.swf", "", $strXML1, "myNext", 1000, 300);
				?>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
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
<?php } else { ?>
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="50" align="left" valign="middle" style="padding-left:5px;"><?php include '../top_right.php';?></td>
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
          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#000000;">
            <tr>
              <td height="30" align="right" valign="middle" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;">
                <?php echo constant("CENTER_DIRECTOR_HOME_DASHBOARD");?>&nbsp;</td>
              </tr>
            <tr>
              <td height="450" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="0%">&nbsp;</td>
                  <td width="30%" id="countdown_text">&nbsp;</td>
                  <td width="24%">
                    </td>
                  <td width="46%"></td>
                  <td width="0%">&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="left" valign="middle">
                    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                      <tr>
                        <td height="25" align="center" valign="middle" class="pedtext"><?php echo constant("ACCOUNTANT_SUMMERY");?></td>
                        </tr>
                      </table></td>
                  <td align="left" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                      <tr>
                        <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("CD_HOME_SALE_OFDAY");?></td>
                        </tr>
                      </table></td>
                  <td align="left" valign="top">
                    <table width="99%" border="0" align="right" cellpadding="0" cellspacing="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                      <tr>
                        <td height="25" align="left" valign="middle" class="pedtext"><?php //echo constant("RECENT_ADDED_STUDENTS");?></td>
                        </tr>
                      </table></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td></td>
                  <td height="2" align="left" valign="middle"></td>
                  <td height="2" align="center" valign="middle"></td>
                  <td align="center" valign="middle"></td>
                  <td></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="center" valign="top">
                    <?php
				$centre_id = $_SESSION['centre_id'];
				$is_transfer = $dbf->countRows("transfer_centre_to_centre", "status='Approved' And centre_to='$centre_id'");
				if($is_transfer > 0){
					
					// Get All student pay Amount
					$trans_amount = 0;
					foreach($dbf->fetchOrder('transfer_centre_to_centre m,transfer_centre_to_centre_dtls d',"m.id=d.parent_id And m.centre_to='$centre_id' And status='Approved'","","d.*") as $tran) {
						$trans_amount = $trans_amount + $dbf->GetStudentPaidAmount($tran["student_id"]);
					}
				?>
                    <table width="98%" border="0" bordercolor="#CCCCCC" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                      <tr>
                        <td width="14%" height="25" align="center" valign="middle"><img src="../images/new.png" width="38" height="15" id="trans"/></td>
                        <td width="54%" align="left" valign="middle" class="red_smalltext">&nbsp;<?php echo constant("TRANSFERD_CENTER_AMOUNT");?>&nbsp; :&nbsp;</td>
                        <td width="32%" align="left" valign="middle" class="nametext"><?php echo $trans_amount;?></td>
                        </tr>
                      </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="2"></td>
                        </tr>
                      </table>
                    <script type="text/javascript">blinkId('trans');</script>
                    <?php } ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="50%" align="center" valign="top">
                          <table width="95%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
                            <tr>
                              <td height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo constant("CD_HOME_PREV_SALE");?></td>
                              </tr>
                            <?php
                          $y = date('Y') - 1;
                          
                          $start_date = date("Y-m-d", strtotime(date("01").'/01/'.$y.' 00:00:00'));
                          $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+12 month',strtotime(date("01").'/01/'.$y.' 00:00:00'))));
                          
						  $amt = $dbf->GetFinalAmount($centre_id, $start_date, $end_date);
                          if($amt == '') { $amt = 0; }
                          ?>
                            <tr>
                              <td height="25" align="center" valign="middle" class="leftmenu"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                              </tr>
                            <tr>
                              <td height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo constant("CD_HOME_CURR_SALE");?></td>
                              </tr>
                            <?php
                          $start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
                          $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+12 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
                          
						  $amt = $dbf->GetFinalAmount($centre_id, $start_date, $end_date);
                          if($amt == '') { $amt = 0; }
                          ?>
                            <tr>
                              <td height="25" align="center" valign="middle" class="mymenutext"><?php echo $amt." ".$res_currency[symbol];?></td>
                              </tr>
                            </table></td>
                        <td width="50%" align="center" valign="top"><table width="95%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
                          <tr>
                            <td height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo $Arabic->en2ar('Current Month Sales');?></td>
                            </tr>
                          <?php
                          $y = date('Y');
                          $m = date('m');
                          $start_date = date("Y-m-d", strtotime(date($m).'/01/'.$y.' 00:00:00'));
                          $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date($m).'/01/'.$y.' 00:00:00'))));
                           
                          $amt = $dbf->GetFinalAmount($centre_id, $start_date, $end_date);						  
                          if($amt == '') { $amt = 0; }
                          ?>
                          <tr>
                            <td height="75" align="center" valign="middle" class="leftmenu"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                            </tr>
                          <?php
                          $start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
                          $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+12 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
                            
                          $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$start_date' AND '$end_date')");
                          $amt = $res["SUM(paid_amt)"];
                          if($amt == '') { $amt = 0; }
                          ?>
                          </table></td>
                        </tr>
                      </table>
                    <br />
                    <table width="98%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
                      <tr>
                        <td width="55%" height="25" align="left" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo $Arabic->en2ar('Total  of the number of sales');?> </td>
                        <td width="22%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo $Arabic->en2ar('Cash');?></td>
                        <td width="23%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo $Arabic->en2ar('POS');?></td>
                        </tr>
                      <tr>
                        <td height="25" align="center" valign="middle" class="red_smalltext"><?php echo $Arabic->en2ar('Today');?> : </td>
                        <?php
                //Cash for the Day
                // 60 = Cash
                  $start_date = date("Y-m-d");
                  $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And paid_date='$start_date' And payment_type='60'");
                  $amt = $res["SUM(paid_amt)"];
				  				  				  				  
                  if($amt == '') { $amt = 0; }
                  ?>
                        <td align="center" valign="middle" class="red_smalltext"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                        <?php
                //Cash for the Day
                // 60 = POS
                  $start_date = date("Y-m-d");
                  $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And paid_date='$start_date' And payment_type='61'");
                  $amt = $res["SUM(paid_amt)"];
				  				  
                  if($amt == '') { $amt = 0; }
                  ?>
                        <td align="center" valign="middle" class="red_smalltext"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                        </tr>
                      <tr>
                        <td height="25" align="center" valign="middle" bgcolor="#F7F7F7" class="red_smalltext"><?php echo $Arabic->en2ar('This Week');?> : </td>
                        <?php
                //Cash for the Week
                // 60 = Cash
                $first_day_of_week = date('Y-m-d', strtotime('Last Sunday', time()));
                $last_day_of_week = date('Y-m-d', strtotime('Next Saturday', time()));
                
                $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And payment_type='60'");
                $amt = $res["SUM(paid_amt)"];
				
                if($amt == '') { $amt = 0; }
                ?>
                <td align="center" valign="middle" bgcolor="#F7F7F7" class="red_smalltext"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                <?php
                //Cash for the Week
                // 61 = POS	
                $res=$dbf->strRecordID('student_fees', 'SUM(paid_amt)',"centre_id='$centre_id' And (paid_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And payment_type='61'");
                $amt = $res["SUM(paid_amt)"];
								
                if($amt == '') { $amt = 0; }
                ?>
                        <td align="center" valign="middle" bgcolor="#F7F7F7" class="red_smalltext"><?php echo $amt;?> <?php echo $res_currency[symbol];?></td>
                        </tr>
                      </table>
                    </td>
                  <td align="center" valign="top" style="border-left:solid 1px; border-color:#CCC; border-bottom:solid 1px; border-color:#ccc;">
                    <?php
			  
                function GenerateCalendar($Month, $Year){
                    
					$centre_id = $_SESSION['centre_id'];
					
                    //Object initialization
                    $dbf = new User();
                    $res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
                    
                    $FirstDay = mktime(0,0,0,$Month,1,$Year);
                    $LastDay = mktime(0,0,0,$Month,date('t',$FirstDay),$Year);
                    $Today = mktime(0,0,0,date('m'),date('d'),date('Y'));
                    $FirstDayWeekNo = date('w',$FirstDay);
                    $LastDayNo = date('d',$LastDay);
                
                    //Creates Header for Calendar of the Month
                    echo('<table cellspacing="2" width="100%" cellpadding="0" border="1" bordercolor="#999999" style="border-collapse:collapse; color:#be883b; ">');
                    echo('<tr><th colspan="7" align="center"  height="30" class="pedtext">'.date('F',$FirstDay)." - ".date('Y',$FirstDay)."</th></tr>");
                    echo('<tr class="days">');
                    echo('<td width="40px" align="center" height="30" style="background-color:#ccc;color:#000; font-weight:bold;">Sun</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Mon</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Tue</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Wed</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Thu</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Fri</td>');
                    echo('<td width="40px" align="center" style="background-color:#ccc;color:#000; font-weight:bold;">Sat</td>');
                    echo('</tr>');
                    //End Create Header for Calendar of the Month
                
                    //Being Populating Calendar
                    $CurrentDateCount = 1;
                    $CurrentDayCount = 0;
                
                    //Make sure the frist day of the month is ploted correctly					
                    echo('<tr>');
                
                    for ($DayCounter = 0; $DayCounter < $FirstDayWeekNo; $DayCounter += 1){
                        echo('<td> </td>');
                        $CurrentDayCount = $DayCounter + 1;
                    }
                    $m = 1;
                    for($DayCounter = $CurrentDateCount; $DayCounter <= $LastDayNo; $DayCounter +=1){
                        //Being new Row for Each Sunday
                        if ($DayCounter > 1 ){
                            if ($CurrentDayCount == 0){
                                echo('<tr">');
                            }
                        }
                        
                        //Check Date
                        //echo $Year;
                        //echo $Month;
                        
                        //Looping Date
                        $dt=date("Y-m-d",mktime(0,0,0,$Month,$DayCounter,$Year));
                        //echo $dt;                
                        $res = $dbf->strRecordID("student_fees","SUM(paid_amt)","centre_id='$centre_id' And paid_date='$dt'");
                        $amt = $res["SUM(paid_amt)"];
                        
						# If any discount for this Date
						$res = $dbf->strRecordID('student_enroll', 'SUM(discount)',"centre_id='$centre_id' And payment_date='$dt'");
                        $amt = $amt - $res["SUM(discount)"];
												
                        $descr = constant("CD_HOME_SALE_OFDAY")." ".$amt." ".$res_currency[symbol];
                                                                       
                        //Matching with My date
                        if($amt>0){
                            echo('<td align="center" bgcolor="#FFCC00" style="color:#ffffff;">');
                            echo('<a class="tooltip" href="#">');
                            echo($DayCounter);
                            echo('<span class="classic">');
                            echo($descr);
                            echo('</span>');
                            echo('</a></td>');
                        }else{
							$kk = 'kk'.$m;
                            echo('<td align="center" height="25" style="color:#000;" id="'.$kk.'" onmouseover="colorMe(kk)" class="mycon">');
                            echo($DayCounter);
                            echo('</td>');
							$m++;
                        }
                        
                        $CurrentDayCount += 1;
                
                        //End Row for Each Sat
                        if ($CurrentDayCount > 6){
                            echo('</tr>');
                            $CurrentDayCount = 0;
                        }
                    }
                    //End Populating Calendar
                    echo('</table>');
                }
                
                //
                date_default_timezone_set('UTC');
                
                //Get Current Month
                $mth=date("m");
                
                echo('<table cellpadding="10" cellspacing = "10">');
                for ($CurrentMonth = $mth; $CurrentMonth <= $mth; $CurrentMonth +=1){
                    if ($CurrentMonth - 1 % 5 == 0){
                        echo('<tr>');
                        echo('<td valign="top">');
                    }else{
                        echo('<td valign="top">');
                    }
                    
                    //Get Current Year
                    
                    $yr=date("Y");
                    
                    GenerateCalendar($CurrentMonth,$yr);
                    if ($CurrentMonth % 4 == 0){
                        echo('</td>');
                        echo('</tr>');
                    }else{
                        echo('</td>');
                    }
                }
                echo('</table>');
                ?>  
                    </td>
                  <td align="right" valign="top"  style="border-left:solid 1px; border-color:#CCC;">
                    <table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;" bordercolor="#666666">
                      <tr class="pedtext">
                        <td width="20%" height="20" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></td>
                        <td width="18%" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("ADMIN_DASHBOARD_DATED");?></td>
                        <td width="23%" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("ADMIN_NEWS_MANAGE_TEACHER");?></td>
                        <td width="17%" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("ADMIN_GROUP_MANAGE_COURSE");?></td>
                        <td width="9%" align="center" valign="middle" bgcolor="#DBDBDB"><?php echo constant("STUDENT_ADVISOR_PED_NO");?>.</td>
                        </tr>
                      <?php
                      foreach($dbf->fetchOrder('student_group',"centre_id='$centre_id'","id DESC LIMIT 0,7") as $valgroup) {
                      
                      $teacher = $dbf->strRecordID("teacher","*","id='$valgroup[teacher_id]'"); 
                      $course = $dbf->strRecordID("course","*","id='$valgroup[course_id]'"); 
                      $no = $dbf->strRecordID("student_group_dtls","COUNT(id)","parent_id='$valgroup[id]'");					  
                      ?>
                      <tr class="mycon">
                        <td height="20" align="center" valign="middle" bgcolor="#FFFFFF"><a href="group_manage.php?group_id=<?php echo $valgroup["id"];?>" style="text-decoration:none;"><?php echo $valgroup[group_name];?> <?php echo $valgroup["group_time"];?>-<?php echo $dbf->GetGroupTime($valgroup["id"]);?></a></td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $valgroup["start_date"].'<br>'.$valgroup["end_date"];?></td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $teacher[name];?></td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $course[name];?></td>
                        <td align="center" valign="middle" bgcolor="#FFFFFF"><?php echo $no["COUNT(id)"];?></td>
                        </tr>
                      <?php } ?>
                      </table></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="center" valign="top">&nbsp;</td>
                  <td align="center" valign="top" class="cer7_bold">&nbsp;</td>
                  <td align="right" valign="top" >&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td></td>
                  <td height="1" colspan="3" align="left" valign="middle" bgcolor="#CCCCCC"></td>
                  <td></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td height="1" colspan="3" align="left" valign="middle" style="padding-top:5px;">
                    
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="54%" align="left" valign="top">
                        <table width="96%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" bordercolor="#CCCCCC">
                            <tr>
                              <td width="18%" height="25" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo $Arabic->en2ar('This Week');?></td>
                              <td width="15%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo $Arabic->en2ar('Last 3 Days');?></td>
                              <td width="16%" align="center" valign="middle" bgcolor="#EAEAEA" class="red_smalltext"><?php echo $Arabic->en2ar('Today');?></td>
                              <td width="51%" align="left" valign="middle" bgcolor="#EAEAEA" class="red_smalltext">&nbsp;</td>
                              </tr>
                            <tr>
                              <td height="25" align="center" valign="middle" class="red_smalltext">
							  <?php $res=$dbf->strRecordID('student', 'COUNT(id)',"centre_id='$centre_id' And (register_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And id not in (select student_id from student_enroll)");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;
						?></td>
                              <td align="center" valign="middle" class="red_smalltext"><?php
                        $d = date('d');
						$end_date = date("Y-m-d", strtotime(date($m).'/'.$d.'/'.$y.' 00:00:00'));
	  					$start_date = date("Y-m-d", strtotime('-1 second',strtotime('-2 day',strtotime($end_date))));
	  
						//No of students are enquries in this centre before 3 days
						$res=$dbf->strRecordID('student', 'COUNT(id)',"centre_id='$centre_id' And (register_date BETWEEN '$start_date' And '$end_date') And id not in (select student_id from student_enroll)");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;
						?></td>
                              <td align="center" valign="middle" class="red_smalltext"><?php
								//No of students are enquries in this centre today
								$res=$dbf->strRecordID('student', 'COUNT(id)',"centre_id='$centre_id' And register_date='$today' And id not in (select student_id from student_enroll)");
								$no_student = $res["COUNT(id)"];
								if($no_student == '') { $no_student = 0; }
								echo $no_student;
								?></td>
                              <td align="left" valign="middle" class="red_smalltext"><?php echo $Arabic->en2ar('Total  number of new enquiries');?></td>
                              </tr>
                            <tr>
                              <td height="25" align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext"><?php
                        $res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And (enroll_date BETWEEN '$first_day_of_week' AND '$last_day_of_week')");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?></td>
                              <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext"><?php
                        //No of students are enquries in this centre before 3 days
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And (enroll_date BETWEEN '$start_date' And '$end_date')");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?></td>
                              <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext">
							  <?php
                        //No of students are enquries in this centre today
						$today = date("Y-m-d");
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date='$today'");
						$no_student = $res["COUNT(id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?></td>
                              <td align="left" valign="middle" bgcolor="#F5F5F5" class="red_smalltext"><?php echo $Arabic->en2ar('Total  number of new enrollments');?> </td>
                              </tr>
                            <tr>
                              <td height="25" align="center" valign="middle" class="red_smalltext"><?php
						//loop start
						$enroll = 0;
						foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$first_day_of_week' AND '$last_day_of_week') And centre_id='$centre_id'") as $valenroll) {					
													
						//Check whether it is for New-Enrollment or Re-enrollment
						$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$first_day_of_week' And '$last_day_of_week')");
							if($num_re > 1){
								$enroll = $enroll + 1;
							}
						}
						echo $enroll;
						?></td>
                              <td align="center" valign="middle" class="red_smalltext"><?php
						//loop start
						$enroll = 0;
						foreach($dbf->fetchOrder('student_enroll', "(enroll_date BETWEEN '$start_date' And '$end_date') And centre_id='$centre_id'") as $valenroll) {					
													
							//Check whether it is for New-Enrollment or Re-enrollment
							$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And (enroll_date BETWEEN '$start_date' And '$end_date')");
							if($num_re > 1){
								$enroll = $enroll + 1;
							}
						}
						echo $enroll;
						?></td>
                              <td align="center" valign="middle" class="red_smalltext"><?php
						//loop start
						$enroll = 0;
						foreach($dbf->fetchOrder('student_enroll', "enroll_date='$today' And centre_id='$centre_id'") as $valenroll) {					
													
							//Check whether it is for New-Enrollment or Re-enrollment
							$num_re = $dbf->countRows('student_enroll',"student_id='$valenroll[student_id]' And enroll_date='$today'");
							if($num_re > 1){
								$enroll = $enroll + 1;
							}
						}
						echo $enroll;
						?></td>
                              <td align="left" valign="middle" class="red_smalltext"><?php echo $Arabic->en2ar('Total  number of new re-enrollments');?></td>
                              </tr>                      
                            <tr>
                              <td height="25" align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext"><?php
						$no_of_attand = 0;
						foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And (attend_date BETWEEN '$first_day_of_week' And '$last_day_of_week')") as $cer) {
							$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]' And centre_id='$centre_id'");
							$c_id = $centre_grp["centre_id"];
							if($c_id == $centre_id){
								$no_of_attand = $no_of_attand + 1;
							}
						}
						echo $no_of_attand;
						?></td>
                              <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext"><?php
						$no_of_attand = 0;
						foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And (attend_date BETWEEN '$start_date' And '$end_date')") as $cer) {
							$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]' And centre_id='$centre_id'");
							$c_id = $centre_grp["centre_id"];
							if($c_id == $centre_id){
								$no_of_attand = $no_of_attand + 1;
							}
						}
						echo $no_of_attand;
						?></td>
                              <td align="center" valign="middle" bgcolor="#F5F5F5" class="red_smalltext"><?php
						$no_of_attand = 0;
						foreach($dbf->fetchOrder('ped_attendance', "(shift1='A' OR shift2='A' OR shift3='A' OR shift4='A' OR shift5='A' OR shift6='A' OR shift7='A' OR shift8='A' OR shift9='A') And attend_date='$today'") as $cer) {
							$centre_grp = $dbf->strRecordID("student_group","centre_id","id='$cer[group_id]' And centre_id='$centre_id'");
							$c_id = $centre_grp["centre_id"];
							if($c_id == $centre_id){
								$no_of_attand = $no_of_attand + 1;
							}
						}
						echo $no_of_attand;
						?></td>
                              <td align="left" valign="middle" bgcolor="#F5F5F5" class="red_smalltext"><?php echo $Arabic->en2ar('Total  number of absent students');?> </td>
                              </tr>
                            <tr>
                              <td height="25" align="left" valign="middle" class="red_smalltext"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr class="mytext">
                                  <td width="50%" align="center" valign="middle"><?php echo $Arabic->en2ar('Week');?></td>
                                  <td align="center" valign="middle"><?php echo $Arabic->en2ar('Month');?></td>
                                </tr>
                                <tr class="mytext">
                                  <td align="center" valign="middle"><?php
							$res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$first_day_of_week' AND '$last_day_of_week')");
							$no_student = $res["COUNT(a.id)"];
							if($no_student == '') { $no_student = 0; }
							echo $no_student;?></td>
                                  <td align="center" valign="middle"><?php
							$y = date('Y');
							  $m = date('m');
							  $start_date = date("Y-m-d", strtotime(date($m).'/01/'.$y.' 00:00:00'));
							  $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date($m).'/01/'.$y.' 00:00:00'))));
						  
							$res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$start_date' AND '$end_date')");
							$no_student = $res["COUNT(a.id)"];
							if($no_student == '') { $no_student = 0; }
							echo $no_student;?></td>
                                </tr>
                              </table></td>
                              <td align="center" valign="middle" class="red_smalltext"><?php
                        $res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And (a.attend_date BETWEEN '$start_date' AND '$end_date')");
						$no_student = $res["COUNT(a.id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?></td>
                              <td align="center" valign="middle" class="red_smalltext"><?php
                        $res=$dbf->strRecordID('student_group g,ped_attendance a', 'COUNT(a.id)',"g.id=a.group_id And g.centre_id='$centre_id' And a.attend_date='$today'");
						$no_student = $res["COUNT(a.id)"];
						if($no_student == '') { $no_student = 0; }
						echo $no_student;?></td>
                              <td align="left" valign="middle" class="red_smalltext"><?php echo $Arabic->en2ar('Total  number of units taught');?></td>
                              </tr>
                            </table>                          
                          
                          
                          <table width="50%" border="0" cellspacing="0" cellpadding="0" style="display:none;">
                            <tr>
                              <td height="30" colspan="3" align="center" valign="middle" class="leftmenu"><?php echo $Arabic->en2ar('Click below to view the Alerts');?></td>
                              </tr>
                            <tr>
                              <td width="30%">&nbsp;</td>
                              <td width="47%" align="center" valign="middle">
                                <a href="alert_page.php?page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "><img src="../home_icon/alert-icon.png" width="60" height="60" border="0" /></a>
                                </td>
                              <td width="23%">&nbsp;</td>
                              </tr>
                            </table>
                          
                          </td>
                        <td width="46%" align="right" valign="top">
                          <table width="100%" border="1" cellspacing="0" bordercolor="#666666" cellpadding="0" style="border-collapse:collapse;" >
                            <tr>
                              <td width="14%" height="25" align="center" valign="middle" bgcolor="#F1EDF1" class="nametext1">
                                <?php echo constant("ADMIN_DASHBOARD_MONTHLY_NUMBER_STUDENTS");?></td>
                              </tr>
                            <?php
						//For January
						 $start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$jan = $res["COUNT(id)"];
						
						//February
						$start_date = date("Y-m-d", strtotime(date("02").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("02").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$feb = $res["COUNT(id)"];
						
						
						//March
						 $start_date = date("Y-m-d", strtotime(date("03").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("03").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$mar = $res["COUNT(id)"];
						
						//April
						$start_date = date("Y-m-d", strtotime(date("04").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("04").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$apr = $res["COUNT(id)"];
						
						//May
						$start_date = date("Y-m-d", strtotime(date("05").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("05").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$may = $res["COUNT(id)"];
						
						//June
						$start_date = date("Y-m-d", strtotime(date("06").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("06").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$jun = $res["COUNT(id)"];
						
						//July
						$start_date = date("Y-m-d", strtotime(date("07").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("07").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$jul = $res["COUNT(id)"];
						
						//Auguest
						 $start_date = date("Y-m-d", strtotime(date("08").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("08").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$aug = $res["COUNT(id)"];
						
						//September
						$start_date = date("Y-m-d", strtotime(date("09").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("09").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$sep = $res["COUNT(id)"];
						
						//October
						$start_date = date("Y-m-d", strtotime(date("10").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("10").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$oct = $res["COUNT(id)"];
						
						//November
						$start_date = date("Y-m-d", strtotime(date("11").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("11").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$nov = $res["COUNT(id)"];
						
						//December
						 $start_date = date("Y-m-d", strtotime(date("12").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("12").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student_enroll', 'COUNT(id)',"centre_id='$centre_id' And enroll_date BETWEEN '$start_date' AND '$end_date'");
						
						$dec = $res["COUNT(id)"];
						
						?>
                            <tr>
                              <td height="25" align="center" valign="middle" bgcolor="#F1EDF1"><?php
						
						//$start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
						//$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
						
				echo $strXML1="<chart showValues='0' decimals='0' formatNumberScale='0'>
				<set label='Jan' value='$jan'/>
						<set label='Feb' value='$feb'/>
						<set label='Mar' value='$mar'/>
						<set label='Apr' value='$apr'/>
						<set label='May' value='$may'/>
						<set label='Jun' value='$jun'/>
						<set label='Jul' value='$jul'/>
						<set label='Aug' value='$aug'/>
						<set label='Sep' value='$sep'/>
						<set label='Oct' value='$oct'/>
						<set label='Nov' value='$nov'/>
						<set label='Dec' value='$dec'/></chart>";
				echo renderChartHTML("../FusionCharts/Charts/Column3D.swf", "", $strXML1, "myNext", 470, 120);
				?></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table>
                    
                    
                    
                    </td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td height="30" colspan="2" align="left" style="padding-top:2px;"><table width="100%" border="1" cellspacing="0" bordercolor="#CCCCCC" cellpadding="0" style="border-collapse:collapse;">
                    <tr>
                      <td height="25" colspan="3" align="center" valign="middle" bgcolor="#F5F5F5" class="leftmenu"><?php echo $Arabic->en2ar('View All Alerts');?></td>
                      </tr>
                    <tr>
                      <td width="31%" align="center" valign="middle" class="leftmenu">&nbsp;<a href="alert_page.php?choice=alert_respose&page=alert_page.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox ">&nbsp; <?php echo $Arabic->en2ar('Others Alerts / News');?></a></td>
                      <td width="32%" align="center" valign="middle" class="leftmenu"><a href="alert_sickleave.php?page=alert_sickleave.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox "> <?php echo $Arabic->en2ar('All Sick Leave Alerts');?></a></td>
                      <td width="37%" height="25" align="center" valign="middle" class="leftmenu"><a href="alert_cancel.php?page=alert_cancel.php&amp;TB_iframe=true&amp;height=240&amp;width=465&amp;inlineId=hiddenModalContent&amp;modal=true" class="top_menu_link thickbox ">&nbsp;<?php echo $Arabic->en2ar('All Cancellation Alerts');?></a></td>
                      </tr>
                    </table></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>                
                  <td align="left" style="padding-top:2px;">&nbsp;</td>
                  <td height="30" align="center" valign="bottom" class="cer7_bold"><?php echo $Arabic->en2ar('All Groups Status within a Center');?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="left" valign="top">
                    <?php
                 echo $strXML1="<chart palette='1' showValues='0' yAxisValuesPadding='10'>			
                        <categories>";
						
						foreach($dbf->fetchOrder('student_group', "centre_id='$centre_id'") as $cer) {
							
							$grp_name = $cer["group_name"];							
                            $strXML1.=" <category label='$grp_name'/>";
							
						}
							
						$strXML1.="</categories>						
						<dataset seriesName='Total Unit(s)'>";
						
						foreach($dbf->fetchOrder('student_group', "centre_id='$centre_id'") as $cer) {
							
							//Get no of unit of a group
							$res_unit = $dbf->strRecordID("group_size","*","group_id='$cer[group_id]'");
							$group_unit = $res_unit["units"];							
							$strXML1.="<set value='$group_unit'/>";
							
						}
						
						$strXML1.="</dataset>
						<dataset seriesname='Completed Unit(s)'>";
						
						foreach($dbf->fetchOrder('student_group', "centre_id='$centre_id'") as $cer) {
							
							$left_units = $dbf->countRows('ped_units',"group_id='$cer[id]'");
							$strXML1.="<set value='$left_units'/>";
							
						}
						
						$strXML1.=" </dataset>
												
						</chart>";
				echo renderChartHTML("../FusionCharts/Charts/MSColumnLine3D.swf", "", $strXML1, "myNext", 1000, 300);
				?>
                    </td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            <tr>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
          </table></td>
      </tr>
    </table>
        </td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php } ?>
</body>
</html>
