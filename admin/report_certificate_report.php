<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Administrator")
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

function show_group(){

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
			document.getElementById('statusresult').innerHTML="---";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('statusresult').innerHTML=c;
		}
	}

	var status = document.getElementById('mystatus').value;

	ajaxRequest.open("GET", "ped_group.php" + "?status=" + status, true);
	ajaxRequest.send(null); 
}

function setsubmit(){
	var cmbgroup = document.getElementById('cmbgroup').value;
	var mystatus = document.getElementById('mystatus').value;	
	document.location.href='report_certificate_report.php?cmbgroup='+cmbgroup+'&mystatus='+mystatus;
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
    <td height="104" align="left" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include 'header.php';?></td>
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
	.tablesorterPager({container: $("#pager"), size: 10});
});
</script>
      <tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="middle"><a href="report_certificate_report_word.php?cmbgroup=<?php echo $_REQUEST[cmbgroup];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_certificate_report_csv.php?cmbgroup=<?php echo $_REQUEST[cmbgroup];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_certificate_report_pdf.php?cmbgroup=<?php echo $_REQUEST[cmbgroup];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href=" report_certificate_report_print.php?cmbgroup=<?php echo $_REQUEST[cmbgroup];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
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
                <tr class="logintext">
                  <td width="25%" height="30" class="logintext"><img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_TEACHER_BOARD_PROGRESSREPORTS");?> <img src="../images/rightarrow.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_SUMMARY");?></td>
                  <td width="10%" align="right" class="headingtext">Status : &nbsp;</td>
                  <td width="13%" align="left">
                  <select name="mystatus" id="mystatus" style="width:150px; border:solid 1px; border-color:#999999;" onChange="show_group();">
                    <option value="">All</option>
                    <option value="Not Started" <?php if($_REQUEST['mystatus']=='Not Started'){ ?> selected="" <?php } ?>>Not Started</option>
                    <option value="Continue" <?php if($_REQUEST['mystatus']=='Continue'){ ?> selected="" <?php } ?>>Active - In Progress</option>
                    <option value="Completed" <?php if($_REQUEST['mystatus']=='Completed'){ ?> selected="" <?php } ?>>Completed</option>
                  </select>
				  </td>
                  <td width="31%" align="left" valign="middle" id="statusresult">
                  <select name="cmbgroup" id="cmbgroup" style="border:solid 1px; border-color:#FFCC33; height:20px; width:150px;"  onChange="setsubmit();">
                    <option value="">--<?php echo constant("SELECT_GROUP");?>--</option>
                    <?php
						if($_REQUEST["mystatus"] == ""){
							$status = "";
						}else{
							$status = "status='$_REQUEST[mystatus]'";
						}
						foreach($dbf->fetchOrder('student_group', $status ,"") as $val) {	
					  ?>
                    <option value="<?php echo $val[id];?>" <?php if($_REQUEST[cmbgroup]==$val[id]){?> selected="selected"<?php }?>><?php echo $val['group_name'] ?>, <?php echo date('d/m/Y',strtotime($val['start_date']));?> - <?php echo date('d/m/Y',strtotime($val['end_date'])) ?>, <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></option>
                    <?php
					   }
					   ?>
                  </select>
                  </td>
                  <td width="21%" align="left" valign="middle">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
			<thead>
                <tr class="logintext">
                  <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                  <th width="22%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></th>
                  <th width="13%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_IDNUMBER");?></th>
                  <th width="20%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><span class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_GROUPNAME");?></th>
                  <th width="15%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_PERCENT");?></th>
                  <th width="27%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_GROUPSAED");?></th>
                  </tr>
				  </thead>
                <?php					
					if($_REQUEST[cmbgroup]!=""){
						$cond="g.id=d.parent_id And s.id=d.student_id And g.id='$_REQUEST[cmbgroup]'"; //certificate_collect='0' And 
					}
										
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					if($cond!=''){
						
						$num=$dbf->countRows('student s,student_group g,student_group_dtls d', $cond);
						
						//Loop Start
						foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls d', $cond,"s.first_name","s.*") as $val){
													
						   //Get the Group Name
							$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[cmbgroup]'");
							
							//Get the Group Name
							$group = $dbf->strRecordID("common","*","id='$_REQUEST[cmbgroup]'");
							
							//Get Percentage from teacher_progress_certificate Table
							$res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$res_group[course_id]' And student_id='$val[id]'");					
							$percentage = $res_per[final_percent];
					?>
                    
                <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                  <td height="25" align="center" valign="middle" class="mycon"><?php echo $i;?></td>
                  <td height="25" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_id];?></td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_group[group_name];?> <?php echo $res_group["group_time"];?>-<?php echo $dbf->GetGroupTime($res_group["id"]);?></td>
                  <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $percentage;?>%</td>
                  <td align="left" valign="middle" class="mycon" style="padding-left:5px;">
				  <?php echo $res_group[start_date] ." And ". $res_group[end_date];?></td>
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
					}
				?>
                </tr>
            </table></td>
          </tr>
          <?php if($num!=0) { ?>
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
                <? }
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                </tr>
                <?
					}
					?>
		  
        </table>
		</form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <?php include '../footer.php';?>
</table>
<?php }  else {?>
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
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="middle"><a href="report_certificate_report_word.php?group=<?php echo $_REQUEST[group];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_certificate_report_csv.php?group=<?php echo $_REQUEST[group];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="report_certificate_report_pdf.php?group=<?php echo $_REQUEST[group];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href=" report_certificate_report_print.php?group=<?php echo $_REQUEST[group];?>" target="_blank"><img src="../images/print.png" alt="" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
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
                        <tr class="logintext">
                          
                          
                          <td width="31%" align="right">
                            <select name="group" id="group" style="border:solid 1px; border-color:#FFCC33; height:20px; width:210px;"  onChange="javascript:document.frm.action='report_certificate_report.php',document.frm.submit();">
                              <option value="">--<?php echo constant("SELECT_GROUP");?>--</option>
                              <?php
								foreach($dbf->fetchOrder('student_group',"","") as $val) {	
							  ?>
                              <option value="<?php echo $val[id];?>" <?php if($_REQUEST[group]==$val[id]){?> selected="selected"<?php }?>><?php echo $val['group_name'] ?>, <?php echo date('d/m/Y',strtotime($val['start_date']));?> - <?php echo date('d/m/Y',strtotime($val['end_date'])) ?>, <?php echo $val["group_time"];?>-<?php echo $dbf->GetGroupTime($val["id"]);?></option>
                              <?php
							   }
							   ?>
                              </select></td>
                              <td width="10%" align="left" class="headingtext">&nbsp;&nbsp;:&nbsp;<?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_GROUPNAME");?></td>
                          <td width="8%" align="left">&nbsp; </td>
                          <td width="8%" align="left">&nbsp;</td>
                          <td width="43%" height="30" class="headingtext" align="right"><img src="../images/arrow_small_right4.png" width="16" height="16"><?php echo constant("ADMIN_MENU_REPORTS_SUMMARY");?> <img src="../images/arrow_small_right2.png" width="16" height="16"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_CERTIFICATE");?></td>
                          </tr>
                        </table></td>
                      </tr>
                    <tr>
                      <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#DFF2DB" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                        <thead>
                          <tr class="logintext">
                            
                            
                            <th width="13%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_IDNUMBER");?></th>
                            <th width="20%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><span class="pedtext"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_GROUPNAME");?></th>
                            <th width="15%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_PERCENT");?></th>
                            <th width="27%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_GROUPSAED");?></th>
                            <th width="22%" align="right" valign="middle" bgcolor="#99CC99" class="pedtext" style="padding-right:25px;"><?php echo constant("ADMIN_REPORT_CERTIFICATE_REPORT_STUDENTNAME");?></th>
                            <th width="3%" height="25" align="center" valign="middle" bgcolor="#99CC99">&nbsp;</th>
                            </tr>
                          </thead>
                        <?php
						if($_REQUEST[group]!=""){
						$cond="g.id=d.parent_id And s.id=d.student_id And g.id='$_REQUEST[group]'"; //certificate_collect='0' And 
					}
										
					$i = 1;
					$color="#ECECFF";
					
					//Get Number of Rows
					if($cond!=''){
						
						$num=$dbf->countRows('student s,student_group g,student_group_dtls d', $cond);
						
						//Loop Start
						foreach($dbf->fetchOrder('student s,student_group g,student_group_dtls d', $cond,"s.first_name","s.*") as $val){
						
							//Get Student Name
							$ress = $dbf->strRecordID("student","*","id='$res[student_id]'");
							
						   //Get the Group Name
							$res_group = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");
							
							//Get the Group Name
							$group = $dbf->strRecordID("common","*","id='$_REQUEST[group]'");
							
							//Get Percentage from teacher_progress_certificate Table
							$res_per = $dbf->strRecordID("teacher_progress_certificate","*","course_id='$res_group[course_id]' And student_id='$val[id]'");					
							$percentage = $res_per[final_percent];
						?>                        
                        <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">                          <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_id];?></td>
                          <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $group[group_name];?> <?php echo $group["group_time"];?>-<?php echo $dbf->GetGroupTime($group["id"]);?></td>
                          <td align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $percentage;?>%</td>
                          <td align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $res_group[start_date] ." And ". $res_group[end_date];?></td>
                          <td height="25" align="right" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[first_name];?> <?php echo $Arabic->en2ar($dbf->StudentName($val["id"]));?></td>
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
					}
				?>
                          </tr>
                        </table></td>
                      </tr>
                    <?php if($num!=0) { ?>
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
                    <? }
					if($num==0)
					{
					?>
                    <tr>
                      <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("COMMON_NORECFOUND");?></td>
                      </tr>
                    <?
					}
					?>
                    
                    </table>
                </form></td>
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
