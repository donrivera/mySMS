<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="dropdowntabs.js"></script>
<link rel="stylesheet" type="text/css" href="glowtabs.css" />
</head>

<script language="JavaScript">
setInterval( "SANAjax();", 30000 );  ///////// 10 seconds

$(function() {
SANAjax = function(){

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
			document.getElementById('dataDisplay').innerHTML="<img src='../images/vista.gif' alt='logo' width='105' height='30' />";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('dataDisplay').innerHTML=c;
		}
	}

	//var type = document.getElementById('type').value;

	ajaxRequest.open("GET", "comments_ajax.php", true);
	ajaxRequest.send(null); 

//$('#dataDisplay').prepend("Hi This is auto refresh example for you - w3cgallery.com <br><br>").fadeIn("slow");

}
 });
</script>

<script language="JavaScript">
setInterval( "SANAjax_Info();", 30000 );  ///////// 10 seconds

$(function() {
SANAjax_Info = function(){

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
			document.getElementById('DisplayInfo').innerHTML="";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('DisplayInfo').innerHTML=c;
		}
	}

	ajaxRequest.open("GET", "news_alert.php", true);
	ajaxRequest.send(null);
}
 });
</script>


<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->
<script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        headers: { 
         8: { 
                sorter: false 
            },           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 15});
	});
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
<body onload="countdown_init(<?php echo $count;?>);">
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
            <td height="36" class="headingtext" style="background:url(../images/footer_repeat.png) repeat-x;padding-left:10px;"><?php echo constant("CD_AUTO_SEARCH_HEADING");?></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
              <thead>
                <tr class="logintext">
                  <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                  <th width="21%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" > <?php echo constant("ADMIN_STUDENT_MANAGE_NAMEOFSTUDENT");?></th>
                  <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
                  <th width="4%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_AGE");?></th>
                  <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_CONTACTNUMBER");?></th>
                  <th width="18%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("RECEPTION_STUDENT_APPOINT_MANAGE_COMMENT");?></th>
                  <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_S2_COUNTRY");?></th>
                  <td align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("CD_AUTO_SEARCH_ACTION");?></td>
                </tr>
              </thead>
              <?php
				$i = 1;
				$color = "#ECECFF";
				$num=$dbf->countRows('student',"first_name like '$_REQUEST[testinput]%' OR student_first_name like '$_REQUEST[testinput]%'");
				foreach($dbf->fetchOrder('student',"first_name like '$_REQUEST[testinput]%' OR student_first_name like '$_REQUEST[testinput]%'","first_name") as $val) {
				?>
              <tr bgcolor="<?php echo $color;?>"  onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" >
                <td height="25" align="center" valign="middle" class="contenttext" ><?php echo $i;?></td>
                <td align="left" valign="middle" class="contenttext"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                <td align="left" valign="middle" class="contenttext"><?php echo $val[email];?></td>
                <td align="center" valign="middle" class="contenttext"><?php 
					if($val[age] != '0')
					{
						echo $val[age];
					}
				?>                </td>
                <td align="left" valign="middle" class="contenttext" ><?php echo $val[student_mobile];?></td>
                <td align="left" valign="middle" class="contenttext" ><?php echo $val[student_comment];?></td>
                <td align="left" valign="middle" class="contenttext"><span class="contenttext" style="padding-left:5px;background-color:<?php echo $color;?>">
                  <?php
				foreach($dbf->fetchOrder('countries',"id='$val[country_id]'","") as $val1) {
				 echo $val1[value];
				}
				 ?>
                </span></td>
                <td width="4%" height="25" align="center" valign="middle" class="contenttext" style="padding-left:5px;background-color:<?php echo $color;?>"><a href="auto_search_view.php?id=<?php echo $val[id]; ?>"><img src="../images/view_icon.png"  title="View"/></a></td>
                <?php 
				  $i = $i + 1;
				  if($color=="#ECECFF")
					  {
						  $color = "#FBFAFA";
					  }
					  else
					  {
						  $color="#ECECFF";
					  }
				  }
				  ?>
              </tr>

            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#999999;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="15">15</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>
            </table></td>
          </tr>
              <?php
					if($num==0)
					{
					?>
              <tr>
                <td height="25" colspan="8" align="center" valign="middle" bgcolor="#F8F9FB" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?> </td>
              </tr>
              <?php
					}
					?>
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
