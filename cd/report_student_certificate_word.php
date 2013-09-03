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

//Object initialization
$dbf = new User();

//Important below 2 lines
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=student_certificate.doc");

?>	
<!--Important-->
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">

<style>
.cer1
{
font-family:Arial, Helvetica, sans-serif;
font-size:10px;
color:#333333;
}

.cer2
{
font-family:Arial, Helvetica, sans-serif;
font-size:9px;
font-weight:normal;
color:#333333;
}

.cer3
{
font-family:Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:normal;
color:#333333;
}

.cer4
{
font-family:Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:bold;
color:#000000;
}

.cer5
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:normal;
color:#000000;
}

.cer6{font-family:minion; font-weight:bold; font-size:15px;}

.cer7_bold{font-family:"Century Gothic"; font-weight:bold; font-size:14px;}
.cer7_normal{font-family:"Century Gothic"; font-weight:normal; font-size:14px;}
.cer8_com{font-family:Cambria; font-weight:normal; font-size:14px;}
.cer9_arial{font-family:Arial, Helvetica, sans-serif; font-weight:normal; font-size:14px;}
.cer9_arial_bold{font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:14px;}
</style>
<body>
<?php
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo Big'");
	$res_logo_left = $dbf->strRecordID("conditions","*","type='Logo Big Left'");
	foreach($dbf->fetchOrder('student_group_dtls',"parent_id='$_REQUEST[group_id]'","id") as $res_group) {
		
		//get student details
		$resg = $dbf->strRecordID("student_group","*","id='$res_group[parent_id]'");
		$res = $dbf->strRecordID("student","*","id='$res_group[student_id]'");
		$resc = $dbf->strRecordID("countries","*","id='$res[country_id]'");
		$rescourse = $dbf->strRecordID("course","*","id='$res_group[course_id]'");
	?>
	<table width="1100" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 1px #000000;" bgcolor="#FFFFFF">
		<tr>
		  <td width="115"><img src="<?php echo $res_logo_left["name"];?>" alt="left-img" width="125" height="670" /></td>
		  <td width="827" align="left" valign="top"><table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
			<tr>
			  <td height="28"><?php echo "asdf".$_SERVER['DOCUMENT_ROOT'];?></td>
			  </tr>
			<tr>
			  <td align="left" valign="top"><table width="900" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="227" align="center" valign="middle" ><p align="center" dir="rtl"><strong><span dir="ltr" class="cer7_bold">Kingdom  of Saudi Arabia</span></strong><strong> </strong><br />
					<strong><span dir="ltr" class="cer7_bold">Dar  Al-Khibrah Language Center </span></strong><br />
					<strong><span dir="ltr"  class="cer7_bold">Under  the Patronage of the <br />Ministry of Education - Al Ahsa <br />(Male)</span></strong><br /><strong><span class="cer7_bold">Licence No. :  05023006</span></strong></p>
					</td>
                    
				  <td width="364" align="center" valign="middle"><img src="<?php echo $res_logo["name"];?>" width="278" height="83" /></td>
				  <td width="309" align="right" valign="middle">
				  <table dir="rtl" border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <td width="255" valign="top">
					  <p align="center" dir="rtl" class="cer7_normal">المملكة العربية السعودية<br />
						معهد دار الخبرة لتعليم اللغة الإنجليزية<br />
						تحت اشراف وزارة التربية والتعليم<br />
						الإدارة العامة للتربية والتعليم بمحافظة الاحساء <br />
						(بنين)<br />
						ترخيص رقم: 05023006&nbsp;&nbsp;</p></td>
					  </tr>
					</table></td>
				  </tr>
				</table></td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  </tr>
			<tr>
			  <td height="40" align="center" valign="middle"><p align="center" dir="rtl" class="cer9_arial">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;شهادة  حضور دورة في اللغة الانجليزية</p></td>
			  </tr>
			<tr>
			  <td align="center" valign="middle" class="cer8_com">A &nbsp;&nbsp;&nbsp;C&nbsp;E&nbsp;R&nbsp;T&nbsp;I&nbsp;F&nbsp;I&nbsp;C&nbsp;A&nbsp;T&nbsp;E &nbsp;&nbsp;&nbsp;O&nbsp;F &nbsp;&nbsp;&nbsp;A&nbsp;T&nbsp;T&nbsp;E&nbsp;N&nbsp;D&nbsp;A&nbsp;N&nbsp;C&nbsp;E &nbsp;&nbsp;&nbsp;I&nbsp;N &nbsp;&nbsp;&nbsp;E&nbsp;N&nbsp;G&nbsp;L&nbsp;I&nbsp;S&nbsp;H &nbsp;&nbsp;&nbsp;L&nbsp;A&nbsp;N&nbsp;G&nbsp;U&nbsp;A&nbsp;G&nbsp;E &nbsp;&nbsp;&nbsp;C&nbsp;O&nbsp;U&nbsp;R&nbsp;S&nbsp;E&nbsp;S</td>
			  </tr>
			<tr>
			  <td height="20">&nbsp;</td>
			  </tr>
			<tr>
			  <td align="center" valign="middle" style="background:url(../images/body-bg1.jpg)  no-repeat center; width:10px;">
			  <table width="900" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="400" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <th height="20" align="left" valign="middle" scope="col">&nbsp;</th>
					  </tr>
					
					<tr>
					  <th height="21" align="left" valign="middle" scope="col" class="cer9_arial">This Certify That ... </th>
					  </tr>
					<tr>
					  <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer9_arial">Mr.<?php echo $res[first_name];?></span></th>
					  </tr>
					<tr>
					  <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer9_arial">Nationality :<?php echo $resc[value];?> </span></th>
					  </tr>
					<tr>
					  <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer9_arial">I.D Number:<?php echo $res[student_id];?> </span></th>
					  </tr>
					<tr>
					  <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer9_arial">He passed the following English language course: <?php echo $rescourse["name"];?></span></th>
					  </tr>
					<tr>
					  <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer9_arial">Level: with a total number of hours: <?php echo $total_units;?></span></th>
					  </tr>
					<tr>
					  <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer9_arial">From date:<?php echo date("d/m/Y",strtotime($resg[start_date]));?> &nbsp;&nbsp;&nbsp;&nbsp;to<?php echo date("d/m/Y",strtotime($resg[end_date]));?> </span></th>
					  </tr>
					<tr>
					  <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer9_arial">That correspond to the Hijra date </span></th>
					  </tr>
					<tr>
					  <th height="21" align="left" valign="middle" class="cer1" scope="col"><span class="cer9_arial">From 
						<?php if($resg[start_date]!='0000-00-00') { echo date("d/m/Y",strtotime($resg[start_date]));}?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to
						<?php if($resg[end_date]!='0000-00-00') { echo date("d/m/Y",strtotime($resg[end_date]));}?>
					  </span></th>
					  </tr>
					</table>                  
					<p align="left" class="cer9_arial" dir="rtl">And has received a final grade of:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; and therefore issued this </p>                  </td>
				  <td width="400" align="right" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					  <th height="20" align="right" valign="middle" scope="col">&nbsp;</th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer9_arial" scope="col"><span class="cer9_arial">&#1610;&#1588;&#1607;&#1583; &#1605;&#1593;&#1607;&#1583; &#1583;&#1575;&#1585; &#1575;&#1604;&#1582;&#1576;&#1585;&#1577; &#1604;&#1604;&#1594;&#1577; &#1575;&#1604;&#1573;&#1606;&#1580;&#1604;&#1610;&#1586;&#1610;&#1577; ...</span></th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer9_arial">&#1576;&#1571;&#1606; &#1575;&#1604;&#1605;&#1578;&#1583;&#1585;&#1576;:&nbsp; </span></th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer9_arial">&#1575;&#1604;&#1580;&#1606;&#1587;&#1610;&#1577;: </span></th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer9_arial">&#1585;&#1602;&#1605; &#1575;&#1604;&#1587;&#1580;&#1604; &#1575;&#1604;&#1605;&#1583;&#1606;&#1610; / &#1575;&#1604;&#1573;&#1602;&#1575;&#1605;&#1577; : </span></th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer9_arial">&#1602;&#1583; &#1575;&#1580;&#1578;&#1575;&#1586; &#1583;&#1608;&#1585;&#1577; &#1601;&#1610; &#1575;&#1604;&#1604;&#1594;&#1577; &#1575;&#1604;&#1575;&#1606;&#1580;&#1604;&#1610;&#1586;&#1610;&#1577; &#1604;&#1594;&#1610;&#1585;  &#1575;&#1604;&#1606;&#1575;&#1591;&#1602;&#1610;&#1606; &#1576;&#1607;&#1575; &#1601;&#1610; &#1575;&#1604;&#1605;&#1587;&#1578;&#1608;&#1609; &#1575;&#1604;&#1585;&#1575;&#1576;&#1593;, &#1608;&#1571;&#1603;&#1605;&#1604; &nbsp;&nbsp;&nbsp;&nbsp;&#1587;&#1575;&#1593;&#1577; &#1583;&#1585;&#1575;&#1587;&#1610;&#1577;.</span></th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer9_arial">&#1601;&#1610; &#1575;&#1604;&#1601;&#1578;&#1585;&#1577; &#1605;&#1606; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#1607;&#1600; &nbsp;&nbsp;&nbsp;&#1573;&#1604;&#1609; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#1607;&#1600;</span></th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer9_arial">&#1575;&#1604;&#1605;&#1608;&#1575;&#1601;&#1602; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#1605; &#1573;&#1604;&#1609; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#1605;</span></th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer9_arial" dir="rtl">&#1608;&#1581;&#1589;&#1604; &#1593;&#1604;&#1609; &#1578;&#1602;&#1583;&#1610;&#1585; , &#1608;&#1576;&#1606;&#1575;&#1569; &#1593;&#1604;&#1610;&#1607; &#1605;&#1606;&#1581; &#1607;&#1584;&#1607;  &#1575;&#1604;&#1588;&#1607;&#1575;&#1583;&#1577;.&nbsp;</span> </th>
					  </tr>
					<tr>
					  <th height="21" align="right" valign="middle" class="cer2" scope="col"><span class="cer9_arial">&#1575;&#1604;&#1605;&#1608;&#1575;&#1601;&#1602; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#1605; &#1573;&#1604;&#1609; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#1605;</span></th>
					  </tr>
				  </table>                  <p dir="rtl">&nbsp;</p>                  </td>
				  </tr>
				</table></td>
			  </tr>
			<tr>
			  <td class="cer9_arial">certificate in recognition of the above </td>
			  </tr>
			<tr>
			  <td>&nbsp;</td>
			  </tr>
			</table></td>
		  </tr>
					</table>
	<br>
	<?php
	}
	?>
</body>
