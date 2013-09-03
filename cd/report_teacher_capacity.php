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

$pageTitle='Welcome to Berlitz-KSA';

include 'application_top.php';

//Object initialization
$dbf = new User();

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
          4: { 
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
              <td width="36" align="center" valign="middle"><a href="report_teacher_capacity_word.php"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_capacity_csv.php"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_capacity_pdf.php"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_capacity_print.php" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
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
        <form name="frm" id="frm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
              <tr class="logintext">
                <td width="32%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16">
				<?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PROGRESSREPORTS");?>
                <img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_CAPACITY_TEACHERCAPACITY");?></td>
                <td width="5%" align="right" valign="middle" class="logintext">&nbsp;</td>
                <td width="9%" align="left"></td>
                <td width="4%" align="right" class="logintext">&nbsp;</td>
                <td width="8%" align="left">&nbsp;</td>
                <td width="19%" align="center" style="padding-left:5px;">&nbsp;</td>
                <td width="10%" align="left">&nbsp;</td>
                <td width="13%" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
                <tr class="logintext">
                  <th width="6%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="55%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext">
				  <?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERNAME");?></th>
                  <th width="19%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext">
				  <?php echo constant("ADMIN_REPORT_TEACHER_CAPACITY_TOTALTEACH");?></th>
                  <th width="18%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext">
				  <?php echo constant("ADMIN_REPORT_TEACHER_CAPACITY_TOTALCONTRA");?></th>
                  </tr>
				</thead>
                <?php			
					$i = 1;
					$color="#ECECFF";
					$centre_id = $_SESSION["centre_id"];
					$num=$dbf->countRows('user u,teacher_centre c',"u.uid = c.teacher_id And c.centre_id='$centre_id' And u.user_type='Teacher'");
					foreach($dbf->fetchOrder('user u,teacher_centre c',"u.uid = c.teacher_id And c.centre_id='$centre_id' And u.user_type='Teacher'","","u.*") as $val) {
						
						# Get Teacher details
						$res_teacher = $dbf->strRecordID("teacher", "*", "id='$val[uid]'");
						
						//Get the total units from the E-PED unit table of a particular teacher
						$res_unit = $dbf->strRecordID("ped_attendance","COUNT(unit)","teacher_id='$val[uid]' And (shift1<>'' OR shift2<>'' OR shift3<>'' OR shift4<>'' OR shift5<>'' OR shift6<>'' OR shift7<>'' OR shift8<>'' OR shift9<>'')");
					?>                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                  <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_teacher["name"];?></td>
                  <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_unit["COUNT(unit)"];?></td>
                  <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_teacher["unit"];?></td>
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
                  <td height="25" colspan="9" align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
              <tr>
                <td width="76%" height="25" align="center">&nbsp;</td>
                <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                  <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                  <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                  <select name="select" class="pagesize">
                    <option selected="selected"  value="10">10</option>
                    <option value="25">25</option>
                    <option  value="50">50</option>
                  </select>
                </div></td>
              </tr>			  
            </table></td>
                </tr>
                <?php
                }
				if($num==0)
				{
				?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?php
				}
				?>		  
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
    <td height="104" align="left" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header_right.php';?></td>
      </tr>
      <tr>
        <td align="left" height="25" valign="top">
                
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_capacity_word.php"><img src="../images/word2007.png" width="20" height="20" border="0" title="Export to Word"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_capacity_csv.php"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="Export to Excel"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_capacity_pdf.php"><img src="../images/pdf.png" width="20" height="20" border="0" title="Export to PDF"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_teacher_capacity_print.php" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="Print"></a></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">
    <form name="frm" id="frm">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78%" align="right" valign="top">
          <table width="99%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="79%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="0" align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;"><table width="100%" border="0" cellspacing="0">
                    <tr class="logintext">                      
                      <td width="16%" align="left">&nbsp;</td>
                      <td width="13%" align="left">&nbsp;</td>
                      <td width="15%" align="center" style="padding-left:5px;">&nbsp;</td>
                      <td width="9%" align="right">&nbsp;</td>
                      <td width="5%" align="center">&nbsp;</td>
                      <td width="11%" align="right">&nbsp;</td>
                      <td width="6%" align="center" valign="middle" class="headingtext">&nbsp;</td>
                      <td width="25%" height="30" align="right" class="headingtext"><img src="../images/arrow_small_right4.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PROGRESSREPORTS");?>
                        <img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_CAPACITY_TEACHERCAPACITY");?>
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                <tr>
                  <td align="left" valign="top" bgcolor="#FFFFFF">
                  <table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                    <thead>
                      <tr class="logintext">
                        <th width="19%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_CAPACITY_TOTALTEACH");?></th>
                        <th width="18%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_TEACHER_CAPACITY_TOTALCONTRA");?></th>
                        <th width="55%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_TEACHER_LEAVE_REPORT_TEACHERNAME");?></th>
                        <th width="6%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                        </tr>
                      </thead>
                    <?php					
					$i = 1;
					$color="#ECECFF";
					$centre_id = $_SESSION["centre_id"];
					$num=$dbf->countRows('user u,teacher_centre c',"u.uid = c.teacher_id And c.centre_id='$centre_id' And u.user_type='Teacher'");
					foreach($dbf->fetchOrder('user u,teacher_centre c',"u.uid = c.teacher_id And c.centre_id='$centre_id' And u.user_type='Teacher'","","u.*") as $val) {
						
						# Get Teacher details
						$res_teacher = $dbf->strRecordID("teacher", "*", "id='$val[uid]'");
						
						//Get the total units from the E-PED unit table of a particular teacher
						$res_unit = $dbf->strRecordID("ped_attendance","COUNT(unit)","teacher_id='$val[uid]' And (shift1<>'' OR shift2<>'' OR shift3<>'' OR shift4<>'' OR shift5<>'' OR shift6<>'' OR shift7<>'' OR shift8<>'' OR shift9<>'')");						
					?>                    
                    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">                      <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_unit["COUNT(unit)"];?></td>
                      <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_teacher["unit"];?></td>
                      <td height="25" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_teacher["name"];?></td>
                      <td height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
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
					if($num!=0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" ><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                      <td width="76%" height="25" align="center">&nbsp;</td>
                      <td width="24%" height="25" align="left" ><div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                        <input name="text" type="text" class="pagedisplay trans" size="5" readonly="" style="border:solid 1px; border-color:#FFCC00;"/>
                        <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                        <select name="select" class="pagesize">
                          <option selected="selected"  value="10">10</option>
                          <option value="25">25</option>
                          <option  value="50">50</option>
                          </select>
                        </div></td>
                      </tr>                    
                    </table></td>
                  </tr>
                <?php
                }
				if($num==0)
				{
				?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                  </tr>
                <?php
				}
				?>                
                </table></td>
              </tr>
          </table></td>
        <td width="2%" align="right" valign="top">&nbsp;</td>
        <td width="18%" align="right" valign="top"><?php include 'left_menu_right.php';?></td>
      </tr>
    </table>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }?>
</body>
</html>
