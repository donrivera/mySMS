<?php 
ob_start();
session_start();

include_once '../includes/language.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--UI JQUERY DATE PICKER-->
<link rel="stylesheet" href="datepicker/jquery.ui.all.css">
<script type="text/javascript"  src="../js/jquery-1.3.2.min.js"></script>
<script src="datepicker/jquery.ui.core.js"></script>
<script src="datepicker/jquery.ui.widget.js"></script>
<script src="datepicker/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" href="datepicker/demos.css">
<script>
$(function() {
	$( ".datepick" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd-mm-yy'
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


$(function() {
	$( ".datepickPast" ).datepicker({
		changeMonth: true,
		changeYear: true,
		//numberOfMonths: 2,
		maxDate: new Date(),
		
		//maxDate: new Date(2011, 10, 25, 17, 30),

		dateFormat: 'yy-mm-dd'
	});
});	
</script>
<!--UI JQUERY DATE PICKER-->
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<script language="javascript" type="text/javascript">
function showdate()
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
			document.getElementById('lblname').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblname').innerHTML=c;
		}
	}

	var tno = document.getElementById('dated').value;

	ajaxRequest.open("GET", "calc_eng_date.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
}
</script>

<style>
.btn1{
background:url(../images/btn11.png) no-repeat;
width:165px;
height:25px;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
font-weight:bolder;
color:#FFFFFF;
border:none;
text-align:center;
cursor:pointer;
padding-bottom:5px;
text-decoration:none;
text-transform:uppercase;
}
</style>
<body>
<?php if($_SESSION['lang']=='EN'){?>
<table width="420" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
  <tr>
    <td height="30" colspan="4" bgcolor="#CCCCCC" class="login_header">&nbsp;<?php echo constant("STUDENT_ADVISOR_CALC_CONVERTER_DATA_GREGORIANTOHIJRI");?></td>
  </tr>
  <tr>
    <td width="28">&nbsp;</td>
    <td width="78" align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td width="116">&nbsp;</td>
    <td width="196">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td align="left" valign="middle" class="error_msg"><?php echo constant("STUDENT_ADVISOR_CALC_CONVERTER_DATA_YMD");?></td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" class="heading"><?php echo constant("STUDENT_ADVISOR_CALC_CONVERTER_DATA_ENGLISH");?>: </td>
    <td align="left" valign="middle"><input name="dated" type="text" class="datepick textfield_amt" id="dated" /></td>
    <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_hijri");?>" class="btn1" onclick="showdate();"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td height="45" colspan="2" align="left" valign="middle" class="nametext1" id="lblname">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="50" align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>
<?php } else{?>
<table width="400" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc; margin-top:-15px;">
  <tr>
    <td height="45" colspan="4" align="right" valign="middle" bgcolor="#CCCCCC" class="login_header">&nbsp;<?php echo constant("STUDENT_ADVISOR_CALC_CONVERTER_DATA_GREGORIANTOHIJRI");?></td>
  </tr>
  <tr>
    <td width="28">&nbsp;</td>
    <td width="78" align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td width="116">&nbsp;</td>
    <td width="196">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td align="right" valign="middle" class="error_msg"><?php echo constant("STUDENT_ADVISOR_CALC_CONVERTER_DATA_YMD");?></td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_hijri");?>" class="btn2" onclick="showdate();"/></td>
    <td align="left" valign="middle"><input name="dated" type="text" class="datepick textfield_amt" id="dated" /></td>
    <td align="left" valign="middle" class="heading"> : <?php echo constant("STUDENT_ADVISOR_CALC_CONVERTER_DATA_ENGLISH");?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td height="45" colspan="2" align="left" valign="middle" class="nametext1" id="lblname">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="50" align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>
<?php }?>
</body>