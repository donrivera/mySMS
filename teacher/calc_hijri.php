<?php
include_once '../includes/language.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link type="text/css" href="../cssh/ui.core.css" rel="stylesheet" />
	<link type="text/css" href="../cssh/ui.theme.css" rel="stylesheet" />
	<link type="text/css" href="../cssh/ui.datepicker.css" rel="stylesheet" />
	<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="../js_hijri/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="../js_hijri/ui.core.min.js"></script>
	<script type="text/javascript" src="../js_hijri/ui.datepicker-cc.min.js"></script>
	<script type="text/javascript" src="../js_hijri/calendar.min.js"></script>
	<script type="text/javascript" src="../js_hijri/ui.datepicker-cc-ar.js"></script>
	<script type="text/javascript" src="../js_hijri/ui.datepicker-cc-fa.js"></script>

	<script type="text/javascript">
		$(function() {
			// حالت پیشفرض
			$('#datepicker1').datepicker();
			//-----------------------------------
			// پرکردن فیلد اضافی
			$("#datepicker2").datepicker({
				dateFormat: 'dd/mm/yy',
				altField: '#alternate2',
				altFormat: 'DD، d MM yy'
			});
			//-----------------------------------
			// نمایش دکمه ها
			$('#datepicker3').datepicker({
				showButtonPanel: true
			});
			//-----------------------------------
			// تغییر قالب نمایش تاریخ
			$("#datepicker4").datepicker({
				dateFormat: 'dd/mm/yy'
			});
			$("#format4").change(function() {
				$('#datepicker4').datepicker('option', { dateFormat: $(this).val() });
			});
			//-----------------------------------
			// استفاده از dropdown
			$('#datepicker5').datepicker({
				changeMonth: true,
				changeYear: true
			});
			//-----------------------------------
			// انتخاب با کلیک بر روی عکس
			$("#datepicker6").datepicker({
				showOn: 'button',
				buttonImage: 'images/calendar.gif',
				buttonImageOnly: true
			});
			//-----------------------------------
			// نمایش inline
			$('#datepicker7').datepicker();
			//-----------------------------------
			// نمایش چند ماه
			$('#datepicker8').datepicker({
				numberOfMonths: 3,
				showButtonPanel: true
			});
			//-----------------------------------
			// غیرفعال کردن روزها
			$('#datepicker9').datepicker({
				beforeShowDay: function(date) {
					if (date.getDay() == 5)
						return [false, '', 'تعطیلات آخر هفته'];
					return [true];
				}
			});
			//-----------------------------------
			// تاریخ پیشفرض
			$('#datepicker10').datepicker({
				defaultDate: new JalaliDate(1361, 4, 10)
			});
			//-----------------------------------
			// تنظیم حداقل و حداکثر
			$('#datepicker11').datepicker({
				minDate: '-3d',
				maxDate: '+1w +2d'
			});
			//-----------------------------------
			// تنظیم حداقل بصورت پویا
			$('#datepicker12from').datepicker({
				onSelect: function(dateText, inst) {
					$('#datepicker12to').datepicker('option', 'minDate', new JalaliDate(inst['selectedYear'], inst['selectedMonth'], inst['selectedDay']));
				}
			});
			$('#datepicker12to').datepicker();
			//-----------------------------------
			// استفاده همزمان از تقویم میلادی
			$('#datepicker13').datepicker({
				regional: ''
			});
			//-----------------------------------
			// استفاده همزمان از تقویم هجری قمری
			$('#datepicker14').datepicker({
				regional: 'ar'
			});
			//-----------------------------------
			$('p').hover(function() { $(this).css('background', '#eee'); }, function() { $(this).css('background', '#fff'); });
		});
	</script>

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

	var tno = document.getElementById('datepicker14').value;

	ajaxRequest.open("GET", "calc_hijri_date.php" + "?tno=" + tno, true);
	ajaxRequest.send(null); 
}
</script>

<style>
.btn2{
background:url(../images/btn22.png) no-repeat;
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
</head>

<table width="420" border="0" cellspacing="0" cellpadding="0" style="border:solid 1px; border-color:#cccccc;">
  <tr>
    <td height="30" colspan="4" align="left" valign="middle" bgcolor="#CCCCCC" class="headingtext">&nbsp;<?php echo constant("STUDENT_ADVISOR_CALC_CONVERTER_DATA_HIJRITOGREGORIAN");?></td>
  </tr>
  <tr>
    <td width="48">&nbsp;</td>
    <td width="59" height="20" align="left" valign="middle" class="bigerrortext">&nbsp;</td>
    <td width="110">&nbsp;</td>
    <td width="201">&nbsp;</td>
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
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle" class="heading"><?php echo constant("STUDENT_ADVISOR_CALC_CONVERTER_DATA_HIJRI");?> : </td>
    <td align="left" valign="middle"><input name="datepicker14" type="text" class="textfield_amt" id="datepicker14" /></td>
    <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_english");?>" class="btn2" onclick="showdate();"/></td>
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
    <td height="45" align="left" valign="middle" class="bigerrortext"><p>&nbsp;</p></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
</table>
