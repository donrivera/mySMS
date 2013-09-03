<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Receptionist")
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
           
        } 
    })			
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
<!--*******************************************************************-->
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
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_student_awaiting_word.php?status=<?php echo $_REQUEST[status];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_student_awaiting_csv.php?status=<?php echo $_REQUEST[status];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_student_awaiting_pdf.php?status=<?php echo $_REQUEST[status];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_awaiting_print.php?status=<?php echo $_REQUEST[status];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="Print"></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="99%" border="0" cellpadding="0" cellspacing="0">
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
		<form name="frm" id="frm" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="38%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PROGRESSREPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"> <?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_STUDENTAWAITING");?></td>
                <td width="7%" align="right" class="logintext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_COURSE");?> :&nbsp; </td>
                <td width="34%" align="left" class="logintext">
                <select name="status" id="status" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onChange="javascript:document.frm.action='report_student_awaiting.php',document.frm.submit();">
                  <option value="">--Select--</option>
                  <?php
					foreach($dbf->fetchOrder('course',"","name") as $val) {	
				  ?>
                  <option value="<?php echo $val[id];?>" <?php if($_REQUEST[status]==$val[id]){?> selected="selected"<?php } ?>s><?php echo $val[name];?></option>
                  <?php
				   }
				   ?>
                </select></td>
                <td width="7%" align="left" class="logintext">&nbsp;</td>
                <td width="14%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			   <thead>
                <tr class="logintext">
                  <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME");?></th>
                  <th width="16%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?></th>
                  <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_EMAILADDRESS");?></th>
                  <th width="14%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
                  <th width="24%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_TEXTD");?></th>
                  </tr>
				</thead>
                <?php
					if($_REQUEST[status]!=''){
					 	$cond="s.id = c.student_id And c.course_id = '$_REQUEST[status]' And c.student_id > '0' And c.status_id='3' And s.centre_id='$_SESSION[centre_id]'";
					}else{
						$cond = "s.id = c.student_id And c.student_id > '0' And c.status_id = '3' And s.centre_id='$_SESSION[centre_id]'";
					}
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					if($cond != ''){
						$num=$dbf->countRows('student s,student_moving c',$cond);
					}
					
					//Loop start
					foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.first_name","s.*,c.date_time") as $val){
						$course = $dbf->getDataFromTable("course", "name", "id='$_REQUEST[status]'");
					?>                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                  <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $val[id];?>" style="cursor:pointer;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course;?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;">
				  <?php if($val[date_time] != '0000-00-00 00:00:00') { echo date('m/d/Y',strtotime($val[date_time])); }?></td>
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
			 <?php
              if($num!=0)
                {
                ?>
				<tr>
                  <td height="25" colspan="8" align="center" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                      <tr align="right" valign="middle">
                        <td width="76%" height="25">&nbsp;</td>
                        <td width="22%" height="25" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                          <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                          <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                          <select name="select" class="pagesize">
                            <option selected="selected"  value="10">10</option>
                            <option value="25">25</option>
                            <option  value="50">50</option>
                          </select>
                        </div></td>
                      </tr></table></td>
                </tr>
                <?php
				}
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="8" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php } ?>
        </table>
		</form>
		</td>
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
    <td height="104" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>

        <td><?php include 'header_right.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="top"><a href="report_student_awaiting_word.php?status=<?php echo $_REQUEST[status];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="top"><a href="report_student_awaiting_csv.php?status=<?php echo $_REQUEST[status];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="top"><a href="report_student_awaiting_pdf.php?status=<?php echo $_REQUEST[status];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_student_awaiting_print.php?status=<?php echo $_REQUEST[status];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="Print"></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="99%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top">
                <form name="frm" id="frm" method="post">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                        <tr>
                          <td width="14%" align="left">&nbsp;</td>
                          <td width="7%" align="left" class="logintext">&nbsp;</td>
                          <td width="34%" align="right" class="logintext">
                            <select name="status" id="status" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;" onChange="javascript:document.frm.action='report_student_awaiting.php',document.frm.submit();">
                              <option value="">--<?php echo constant("SELECT");?>--</option>
                              <?php
								foreach($dbf->fetchOrder('course',"","name") as $val) {	
							  ?>
                              <option value="<?php echo $val[id];?>" <?php if($_REQUEST[status]==$val[id]){?> selected="selected"<?php } ?>s><?php echo $val[name];?></option>
                              <?php
							   }
							   ?>
                              </select></td>
                          <td width="7%" align="left" class="logintext"> :&nbsp;<?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_COURSE");?></td>
                          <td width="38%" height="30" align="right" class="logintext"><img src="../images/arrow_small_right4.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PROGRESSREPORTS");?> <img src="../images/arrow_small_right2.png" width="16" height="16"> <?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_STUDENTAWAITING");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF">
                        <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                          <thead>
                            <tr class="logintext">
                              <th width="16%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_MOBILENO");?></th>
                              <th width="20%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_EMAILADDRESS");?></th>
                              <th width="14%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
                              <th width="24%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_TEXTD");?></th>
                              <th width="22%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_STUDENTNAME");?></th>
                              <th width="4%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                              </tr>
                            </thead>
                          <?php
							if($_REQUEST[status]!='')
							{
								$cond="s.id = c.student_id And c.course_id = '$_REQUEST[status]' And s.student_id > '0' And c.status_id='3' And s.centre_id='$_SESSION[centre_id]'";
							}else{
								$cond = "s.id = c.student_id And c.student_id > '0' And c.status_id = '3' And s.centre_id='$_SESSION[centre_id]'";
							}
							$i = 1;
							$color="#ECECFF";
							
							//Get Number of Rows
							if($cond != ''){
								$num=$dbf->countRows('student s,student_moving c',$cond);
							}
							
							//Loop start
							foreach($dbf->fetchOrder('student s,student_moving c',$cond,"s.first_name","s.*,c.date_time") as $val){
								$course = $dbf->getDataFromTable("course", "name", "id='$_REQUEST[status]'");
							?>                          
                          <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                            <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
                            <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
                            <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $course;?></td>
                            <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php if($val[date_time] != '0000-00-00') { echo date('m/d/Y',strtotime($val[date_time])); }?></td>
                            <td height="25" align="right" valign="middle" class="mycon" style="padding-left:5px;"><a href="single-home.php?student_id=<?php echo $val[id];?>" style="cursor:pointer;"><?php echo $val[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></a></td>
                            <td height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
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
                    <?php if($num!=0) { ?>
                    <tr>
                      <td height="25" colspan="8" align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr align="right" valign="middle">
                          <td width="76%" height="25">&nbsp;</td>
                          <td width="22%" height="25" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                            <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                            <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                            <select name="select" class="pagesize">
                              <option selected="selected"  value="10">10</option>
                              <option value="25">25</option>
                              <option  value="50">50</option>
                              </select>
                            </div></td>
                        </tr></table></td>
                      </tr>
                    <?php
					}
					if($num==0)
					{
					?>
                    <tr>
                      <td height="25" colspan="8" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                      </tr>
                    <?php
					}
					?>
                    </table>
                  </form>
                </td>
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
