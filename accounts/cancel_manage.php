<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Accountant")
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
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Berlitz</title>
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

<!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->

<!--table sorter ***************************************************** -->

<!--*******************************************************************-->

</head>
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
  <script type="text/javascript">
	$(function() {
		$("#sort_table")
			.tablesorter({ 
        // pass the headers argument and assing a object 
        headers: { 
            // assign the secound column (we start counting zero) 
         6: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },
            7: { 
                // disable it by setting the property sorter to false 
                sorter: false 
            },
        } 
    })
			
			.tablesorterPager({container: $("#pager"), size: 15});
	});
	</script>
  <tr>
    <td align="left" valign="top">
    
    
    <form name="frm" id="frm" >
    <table width="98%" border="0" cellpadding="0" cellspacing="0">
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
            <td bgcolor="#b4b4b4" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="headingtext"><h1><?php echo constant("CANCELLATION_REQUEST");?></h1></td>
                <td width="22%">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="450" align="left" valign="top" style="border:solid 1px; border-color:#CCC; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td align="left" valign="top" bgcolor="#FFFFFF">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="25" colspan="9" align="left" valign="middle" class="leftmenu"><u><?php echo constant("ACCOUNTANT_SEARCH_CONDITION");?></u></td>
                    </tr>
                  <tr>
                    <td width="7%" height="25" align="right" valign="middle" class="mymenutext"><?php echo constant("ADMIN_VIEW_GROUP_SIZE_CENTRE");?> :&nbsp;</td>
                    <td width="20%" align="left" valign="middle">
                    <select name="centre_id" id="centre_id" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:192px;">
                      <option value="">-- All Centre --</option>
                      <?php
                        foreach($dbf->fetchOrder('centre',"","name") as $valc) {	
                      ?>
                      <option value="<?php echo $valc[id];?>" <?php if($valc["id"]==$_REQUEST["centre_id"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
                      <?php
                       }
                       ?>
                    </select></td>
                    <td width="7%" align="center" valign="middle" class="hometest_name"><input type="image" src="../images/searchButton.png" width="50" height="22" /></td>
                    <td width="3%" align="left" valign="middle">&nbsp;</td>
                    <td width="5%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                    <td width="9%" align="left" valign="middle">&nbsp;</td>
                    <td width="10%" align="right" valign="middle" class="hometest_name">&nbsp;</td>
                    <td width="12%" align="left" valign="middle">&nbsp;</td>
                    <td width="27%" align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="5" colspan="9" align="left" valign="middle">&nbsp;</td>
                    </tr>
                </table>
                <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;" bordercolor="#000000" class="tablesorter" id="sort_table">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                      <th width="11%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("SA_REQUEST_DATE");?></th>
                      <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("RECEPTION_ARF_MANAGE_STUDENTNAME");?></th>
                      <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></th>
                      <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("SA_REASON_FOR_CANCEL");?></th>
                      <th width="19%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("SA_CD_CANCEL_STATUS");?></th>
                      <th width="18%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("SA_ADMIN_CANCEL_STATUS");?></th>
                      <th width="5%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext">&nbsp;</th>
                      </tr>
                  </thead>
                  <?php					
					$i = 1;
					$color="#ECECFF";					
					$num=$dbf->countRows('student_cancel',"centre_id='$_REQUEST[centre_id]'");
					foreach($dbf->fetchOrder('student_cancel',"centre_id='$_REQUEST[centre_id]'","dated desc") as $valcancel) {						
					$res_student = $dbf->strRecordID("student","*","id='$valcancel[student_id]'");
					?>                    
                  <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    <td align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                    <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $valcancel[dated];?></td>
                    <td align="left" valign="middle" class="mycon" >&nbsp;<a href="single-home.php?student_id=<?php echo $res_student[id];?>"><?php echo $res_student[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($res_student["id"]));?></a></td>
                    <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $res_student[student_mobile];?></td>
                    <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $valcancel[comment];?></td>
                    <?php
					if($valcancel["cd_comment"]!=''){
						$comment = $valcancel["cd_status"].'<br>'.$valcancel["cd_comment"].'<br>'.$valcancel["cd_dated"];
					}else{
						$comment = $valcancel["cd_status"];
					}
					?>
                    <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $comment;?></td>
                    <?php
					if($valcancel["admin_comment"]!=''){
						$comment = $valcancel["admin_status"].'<br>'.$valcancel["admin_comment"].'<br>'.$valcancel["admin_dated"];
					}else{
						$comment = $valcancel["admin_status"];
					}
					?>
                    <td align="left" valign="middle" class="mycon" >&nbsp;<?php echo $comment;?></td>
                    <td align="center" valign="middle" class="mycon" >
                    <?php if($valcancel["admin_status"] == 'Pending'){?>
                    <a href="cancel_status.php?action=delete&centre_id=<?php echo $_REQUEST[centre_id];?>&cancel_id=<?php echo $valcancel["id"];?>"><img src="../images/edit_icon.png" width="16" height="16" border="0" title="Click here to change the Status" /></a>
                    <?php } ?>
                    </td>
                    <?php
					  	  $i = $i + 1;
						  if($color=="#ECECFF"){
							  $color = "#FBFAFA";
						  }else{
							  $color="#ECECFF";
						  }
					  }
					  ?>
                  </tr>

                </table></td>
              </tr>
              <?php
				if($num> 0){
				?>
              <tr>
                <td ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
            }
			if($num==0){
			?>
		  <tr>
			<td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
		  </tr>
		  <?php
			}
			?>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php include '../footer.php';?>
</table>
</table>
</body>
</html>