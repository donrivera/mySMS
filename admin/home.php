<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator"){
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
        <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
          <tr>
            <td height="30" bgcolor="#FFA938" class="logintext" style="background:url(../images/footer_repeat.png) repeat-x;"><?php echo constant("ADMIN_DASHBOARD_DASHBOARD");?></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top"  style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="1%">&nbsp;</td>
                <td width="33%" id="countdown_text">&nbsp;</td>
                <td width="33%">
                </td>
                <td width="0%">&nbsp;</td>
                <td width="32%">&nbsp;</td>
                <td width="1%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="middle">
                <table width="99%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_DASHBOARD_RECENTLY");?></td>
                  </tr>
                </table></td>
                <td align="left" valign="middle">
                <table width="95%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("ADMIN_DASHBOARD_NO_OF_STUDENTS");?></td>
                  </tr>
                </table></td>
                <td>&nbsp;</td>
                <td><table width="99%" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px #B6B6B6; background:url(../images/bg.png) repeat-x; ">
                  <tr>
                    <td height="25" align="left" valign="middle" class="pedtext"><?php echo constant("RECENT_ADDED_STUDENTS");?></td>
                  </tr>
                </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td></td>
                <td height="2" align="left" valign="middle"></td>
                <td height="2" align="center" valign="middle"></td>
                <td height="2"></td>
                <td height="2"></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top">
                <table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;" >
                  <tr>
                    <td width="10%" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                    <td width="40%" align="left" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_DASHBOARD_STUDENT");?></td>
                    <td width="25%" align="center" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_DASHBOARD_DATED");?></td>
                    <td width="25%" height="25" align="right" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_DASHBOARD_AMOUNT");?>&nbsp;</td>
                  </tr>
                  <?php
				  $res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
                  foreach($dbf->fetchOrder('student_fees',"paid_date<>'0000-00-00'","paid_date DESC LIMIT 0,7") as $val_pay) {
					  
					  //Get student information
					  $res_stu = $dbf->strRecordID("student","*","id='$val_pay[student_id]'");
					  if($res_stu["photo"]!='')
					    {
							$photo = "../sa/photo/".$res_stu["photo"];
					    }
					    else
					    {
							$photo = "../images/noimage.jpg";
					    }
					?>
                  <tr>
                    <td height="25" align="center" valign="middle"><img src="<?php echo $photo;?>" oncontextmenu="return false;" width="20" height="20" /></td>
                    <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $res_stu[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_stu["id"]));?></td>
                    <td align="center" valign="middle" class="mycon"><?php echo date('d-M-Y',strtotime($val_pay[paid_date]));?></td>
                    <td align="right" valign="middle" class="mycon"><?php echo $val_pay[paid_amt];?>&nbsp;<?php echo $res_currency[symbol];?>&nbsp;</td>
                  </tr>
                  <?php } ?>
                </table></td>
                <td align="left" valign="top"><?php
				echo $strXML1="<chart palette='4' decimals='0' bgColor='99CC99,FFFFFF' bgAlpha='40,100' bgRatio='0,100' bgAngle='300' >";
				
				
				foreach($dbf->fetchOrder('centre',"","") as $val_cen) {
				
				//Get Number of Students in a particular Centre
				$res_no=$dbf->strRecordID('student','COUNT(id)',"centre_id='$val_cen[id]'");
				
				$no = $res_no["COUNT(id)"];

				$centre = $val_cen[name];
				
				if($no==0)
				{
					// isSliced='1'
					$strXML1.="<set label='$centre' value='$no'/>";
				}
				else
				{
					$strXML1.="<set label='$centre' value='$no'/>";
				}
				
				}
				
				$strXML1.="</chart>";
				echo renderChartHTML("../FusionCharts/Charts/Pie3D.swf", "", $strXML1, "myNext", 325, 205);
				?></td>
                <td>&nbsp;</td>
                <td align="center" valign="top"><table width="99%" border="1" cellspacing="0" bordercolor="#999999" cellpadding="0" style="border-collapse:collapse;" >
                  <tr>
                    <td width="12%" height="25" align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
                    <td width="38%" align="left" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_DASHBOARD_STUDENT");?></td>
                    <td width="50%" align="center" valign="middle" bgcolor="#CCCCCC" class="logintext"><?php echo constant("ADMIN_DASHBOARD_DATED_TIME");?></td>
                  </tr>
                  <?php
					foreach($dbf->fetchOrder('student',"","id DESC LIMIT 0,7") as $val_en) {
						if($val_en["photo"]!=''){
							$photo = "../sa/photo/".$val_en["photo"];
						}else{
							$photo = "../images/noimage.jpg";
						}
						if($val_en[created_datetime] != '0000-00-00 00:00:00'){
							$dt = date('d-M-Y, h:i:s A',strtotime($val_en[created_datetime]));
						}else{
							$dt = '';
						}
					?>
                  <tr>
                    <td height="25" align="center" valign="middle"><img src="<?php echo $photo;?>" oncontextmenu="return false;" width="20" height="20" /></td>
                    <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $val_en[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val_en["id"]));?></td>
                    <td align="center" valign="middle" class="mycon" ><?php echo $dt;?></td>
                  </tr>
                  <?php } ?>
                </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="4" align="left" valign="middle">
                <table width="100%" border="1" cellspacing="0" bordercolor="#666666" cellpadding="0" style="border-collapse:collapse;" >
                  <tr>
                    <td width="14%" height="25" align="center" valign="middle" bgcolor="#F1EDF1" class="nametext1"><?php echo constant("ADMIN_DASHBOARD_MONTHLY_NUMBER_STUDENTS");?></td>
                    </tr>
                    <?php
						//For January
						 $start_date = date("Y-m-d", strtotime(date("01").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("01").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$jan = $res["COUNT(id)"];
						
						//February
						$start_date = date("Y-m-d", strtotime(date("02").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("02").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$feb = $res["COUNT(id)"];
												
						//March
						$start_date = date("Y-m-d", strtotime(date("03").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("03").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$mar = $res["COUNT(id)"];
						
						//April
						$start_date = date("Y-m-d", strtotime(date("04").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("04").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$apr = $res["COUNT(id)"];
						
						//May
						$start_date = date("Y-m-d", strtotime(date("05").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("05").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$may = $res["COUNT(id)"];
						
						//June
						$start_date = date("Y-m-d", strtotime(date("06").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("06").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$jun = $res["COUNT(id)"];
						
						//July
						$start_date = date("Y-m-d", strtotime(date("07").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("07").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$jul = $res["COUNT(id)"];
						
						//Auguest
						 $start_date = date("Y-m-d", strtotime(date("08").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("08").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$aug = $res["COUNT(id)"];
						
						//September
						$start_date = date("Y-m-d", strtotime(date("09").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("09").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$sep = $res["COUNT(id)"];
						
						//October
						$start_date = date("Y-m-d", strtotime(date("10").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("10").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$oct = $res["COUNT(id)"];
						
						//November
						$start_date = date("Y-m-d", strtotime(date("11").'/01/'.date('Y').' 00:00:00'));
						$end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("11").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$nov = $res["COUNT(id)"];
						
						//December
						 $start_date = date("Y-m-d", strtotime(date("12").'/01/'.date('Y').' 00:00:00'));
						 $end_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date("12").'/01/'.date('Y').' 00:00:00'))));
						
						$res=$dbf->strRecordID('student', 'COUNT(id)',"DATE_FORMAT(created_datetime,'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");
						
						$dec = $res["COUNT(id)"];
						
						?>
                  <tr>
                    <td height="25" align="center" valign="middle" bgcolor="#F1EDF1">					
                    <?php						
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
				echo renderChartHTML("../FusionCharts/Charts/Column3D.swf", "", $strXML1, "myNext", 1020, 250);
				?>
                    </td>
                    </tr>
                  
                </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF" ></td>
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
