<?php
ob_start();
session_start();
if(!isset($_COOKIE['cook_username']))
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

//Used currency
$res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");

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



<!--table sorter ***************************************************** -->

     
<!--*******************************************************************-->
<script type="text/javascript">
function errorconfirm(){
	alert("Record can't be deleted as it has been used in the other part of Application.")
}
</script>
<script type="text/javascript">
function show_details(a){
	var arrow="plusArrow"+a;
	var content="content"+a;
	if(document.getElementById(a).style.display==''){
		document.getElementById(a).style.display='none';
		document.getElementById(arrow).innerHTML='<img src="../images/plus.gif" alt="Loading" />';
	}else{
		document.getElementById(a).style.display='';
		document.getElementById(arrow).innerHTML='<img src="../images/minus.gif" alt="Loading" />';
	}
}
</script>
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
</script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#centre").change(function(){
		$("#statusresult")
		.html("Wait...")
		.load("corporate_accounts_group.php", {status: $(this).val()}); // Page Name and Condition
	});
});
</script>
<?php
//Get from the table
$res_logout = $dbf->strRecordID("conditions","*","type='Logout Time'");
$count = $res_logout["name"]; // Set timeout period in seconds
?>
<body onLoad="countdown_init(<?php echo $count;?>);">
<table <?php if($_SESSION["lang"] == "AR"){?> style="margin-top:-15px;" <?php } ?> width="100%" border="0" align="center" cellpadding="0" cellspacing="0" onClick="countdown_init(<?=$count;?>);">
  <tr>
    <td height="39" align="left" valign="middle" style="padding-left:5px;"><?php include '../top.php';?></td>
  </tr>
  <tr>
    <td height="104" align="left" valign="top"><?php include 'header.php';?></td>
  </tr>
  <!--TABLE SORTER-->
<link rel="stylesheet" href="../table_sorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../table_sorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../table_sorter/addons/pager/jquery.tablesorter.pager.js"></script>
<!--TABLE SORTER-->
	<tr>
        <td align="left" height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
              <td width="36" align="center" valign="middle"><a href="corporate_accounts_word.php?code=<?php echo $_REQUEST[code];?>&account=<?php echo $_REQUEST[account];?>"><img src="../images/word2007.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_WORD ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="corporate_accounts_csv.php?code=<?php echo $_REQUEST[code];?>&account=<?php echo $_REQUEST[account];?>"><img src="../images/excel2007.PNG" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_XLS ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="corporate_accounts_pdf.php?code=<?php echo $_REQUEST[code];?>&account=<?php echo $_REQUEST[account];?>"><img src="../images/pdf.png" width="20" height="20" border="0" title="<?php echo ICON_EXPORT_PDF ?>"></a></td>
              <td width="36" align="center" valign="middle"><a href="corporate_accounts_print.php?code=<?php echo $_REQUEST[code];?>&account=<?php echo $_REQUEST[account];?>" target="_blank"><img src="../images/print.png" width="16" height="16" border="0" title="<?php echo STUDENT_ADVISOR_SEARCH_MANAGE_PRINT ?>"></a></td>
            </tr>
          </table></td>
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
        
        <form name="frm" id="frm" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle" bgcolor="#b4b4b4" class="title headingtext" style="background:url(../images/footer_repeat.png) repeat-x;">
            <table width="100%" border="0" cellspacing="0">
              <tr>
                <td width="54%" height="30" class="logintext"><?php echo "Corporate Accounts";?></td>
                <td width="22%" height="30">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
                <td width="8%" height="30" align="left">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" bgcolor="#FFFFFF">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
			
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="1%" align="left" valign="middle">&nbsp;</td>
					<td width="6%" height="30" align="right" valign="middle" class="pedtext"><?php echo "Center";?> : &nbsp;</td>
                    <td width="10%" align="left" valign="middle">
                    <select name="centre" id="centre" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:100px;">
                      <option value="">--Select--</option>
                      <?php
						foreach($dbf->fetchOrder('centre',"","name") as $ctr) {	
					  ?>
                      <option value="<?php echo $ctr[id];?>" <?php if($ctr["id"]==$_REQUEST["centre"]){?> selected="" <?php } ?>><?php echo $ctr[name];?></option>
                      <?php
					   }
					   ?>
                    </select></td>
                    <td width="6%" height="30" align="right" valign="middle" class="pedtext"><?php echo "Name";?> : &nbsp;</td>
                    <td width="6%" align="left" valign="middle" id="statusresult">
                    <select name="code" id="code" style="border:solid 1px; border-color:#999999;background-color:#ECF1FF; height:25px; width:150px;">
                      <option value="">--Select--</option>
                      <?php
						foreach($dbf->fetchOrder('corporate',"","name") as $valc) {	
					  ?>
                      <option value="<?php echo $valc[code];?>" <?php if($valc["code"]==$_REQUEST["code"]){?> selected="" <?php } ?>><?php echo $valc[name];?></option>
                      <?php
					   }
					   ?>
                    </select></td>
					<td width="6%" align="right" valign="middle" class="pedtext"><?php echo "Account";?> :&nbsp;</td>
                    <td width="12%" align="left" valign="middle"><input name="account" type="text" class="new_textbox100" id="account" value="<?php echo $_REQUEST[account];?>"></td>
                    <td width="15%" align="right" valign="middle"><input type="submit" name="submit" id="submit" value="<?php echo constant("btn_search");?>" class="btn1"/></td>
				  </tr>
                </table></td>
                </tr>
              <tr>
                <td align="center" valign="middle">
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
                  <thead>
                    <tr class="logintext">
                      <th width="4%" align="center" valign="middle" bgcolor="#99CC99" >&nbsp;</th>
                      <th width="5%" align="center" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
                      <th width="25%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo "Account";?></th>
                      <th width="26%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo "Address";?></th>
                      <th width="33%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo "Contact";?></th>
                      <!--<th width="7%" align="left" valign="middle" bgcolor="#99CC99" class="pedtext" ><?php echo "Details";?></th>-->
                      </tr>
                  </thead>
                  <?php
			     	$k=1;
					$i = 1;
					$color = "#ECECFF";
					/*
					$condition = '';
					//Concate the Condition
					//1.
					if($_REQUEST[fname]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "email LIKE '$_REQUEST[email]%'";
					}
					//End 1.
					
					//2.
					else if($_REQUEST[fname]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%'";
					}else if($_REQUEST[fname]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}
					//End 2.
					
					//3.
					else if($_REQUEST[fname]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "(first_name LIKE '$_REQUEST[fname]%' OR student_first_name LIKE '$_REQUEST[fname]%') AND student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}else if($_REQUEST[fname]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
						$condition = "student_mobile LIKE '$_REQUEST[mobile]%' AND email LIKE '$_REQUEST[email]%'";
					}
					//End 3.
					
					//4.
					else if($_REQUEST[fname]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
						$condition = "id>'0'";
					}
					//End 4.
					*/
					$cond=(!empty($_REQUEST[account])?" AND cs.account=".$_REQUEST[account]:"");
					$sql=$dbf->genericQuery(" 	SELECT DISTINCT(cs.account),c.*
												FROM corporate_students cs
												INNER JOIN corporate c ON c.code=cs.code
												WHERE cs.code='".$_REQUEST[code]."'".$cond);
					//Get number of rows
					$num=count($sql);
					//Loop start
					foreach($sql as $corp){		
										
					#$is_enroll = $dbf->countRows("student_group_dtls", "student_id='$valstudent[id]'");
					if($num > 0 ){
					?>
                  <tr bgcolor="<?php echo $color;?>" onMouseOver="this.bgColor='#FDE6D0'" onMouseOut="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
                    <td width="4%" align="center" valign="middle" class="contenttext">
                    <a href="javascript:void(0);" onClick="show_details('<?php echo $corp[account];?>');"> <span id="plusArrow<?php echo $corp[account];?>">
                    <img src="../images/plus.gif" border="0" /></span></a></td>
                    <td width="5%" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
                    <td width="25%" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $corp[account];?></td>
                    <td width="26%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $corp[address];?></td>
                    <td width="33%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $corp[contact];?></td>
                    <!--<td width="7%" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $corp[details];?></td>-->
                    <?php
					  $i = $i + 1;
					  if($color=="#ECECFF"){
						  $color = "#FBFAFA";
					  }else{
						  $color="#ECECFF";
					  }
				  ?>
                  </tr>
                   
                  <tr style="display:none;" id="<?php echo $corp[account];?>">
                    <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
                    <td height="25" colspan="4" align="left"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;">
                    
                    <table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                    <?php
                    //Loop start
					$chk = 'first';
					$sql1=$dbf->genericQuery("SELECT cs.id,cs.sub_account,cs.student_id,s.address,s.student_id,s.student_mobile,c.name,sg.group_name,sg.start_date,sg.end_date 
												FROM corporate_students cs 
												INNER JOIN student s ON s.id=cs.student_id
												INNER JOIN student_group_dtls sgd ON sgd.course_id=cs.course_id	AND sgd.student_id=cs.student_id		
												INNER JOIN student_group sg ON sg.id=sgd.parent_id
												INNER JOIN course c ON c.id=cs.course_id
												WHERE cs.account='".$corp[account]."'");
					foreach($sql1 as $student){
												
						#$res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]'");
						#$course = $dbf->strRecordID("course","*","id='$res_enroll[course_id]'");
						#$paid = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]' And status='1'");
						
						#$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
						#$course_fee = ($course_fees - $res_enroll["discount"]) + $res_enroll["other_amt"];
						#$paid_amt = $paid["SUM(paid_amt)"];
						#$bal_amt = $course_fee - $paid_amt;
							
						if($chk == 'first'){
                    ?>
                      <tr>
                        <td height="20" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">Sub Account</td>
                        <td align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext">Student Name</td>
                        <td align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">Class</td>
                        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext">ID</td>
                        <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext">Mobile</td>
                        </tr>
                      <?php } $chk = ''; ?>
                      <tr>
                        <td width="6%" align="center" valign="middle">
						<!--
                        <a href="javascript:void(0);" onClick="show_details('<?php echo 'c'.$val_s_course[id];?>');"> <span id="plusArrow<?php echo 'c'.$val_s_course[id];?>"><img src="../images/plus.gif" border="0" /></span></a>
                        -->
						<?php echo $student[sub_account];?>
						</td>
                        <td width="30%" align="left" valign="middle" class="mycon"><?php echo $dbf->printStudentName($student[id]);?></td>
                        <td width="19%" align="center" valign="middle" class="mycon">
							<?php echo $student[group_name]."&nbsp;<BR/>".$student[start_date]."&nbsp;to&nbsp;".$student[end_date];?>
						</td>
                        <td width="11%" align="right" valign="middle" class="mycon"><?php echo $student[student_id];?></td>
                        <td width="12%" align="right" valign="middle" class="mycon"><?php echo $student[student_mobile];?></td>
						<!--
                        <td width="22%" align="right" valign="middle" class="mycon">
                          <?php if($bal_amt==0 && $paid_amt>0) { echo "Full Payment"; } ?>&nbsp;</td>-->
                      </tr>
                      <tr style="display:none;" id="<?php echo 'c'.$val_s_course[id];?>">
                        <td align="center" valign="middle">&nbsp;</td>
                        <td colspan="5" align="left" valign="middle">
                        <table width="98%" border="2" bordercolor="#AAAAAA" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                          <tr>
                            <td width="7%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
                            <td width="15%" align="left" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
                            <td width="16%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("ACCOUNTANT_RE_NO");?></td>
                            <td width="16%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SCHEDFE");?></td>
                            <td width="16%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMODE");?></td>
                            <td width="16%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAIDONDT");?></td>
                            <td width="14%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAID");?></td>
                            <td width="8%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_STATUS");?></td>
                            <td align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("COMMON_ACTION");?></td>
                          </tr>
                          <?php
							/*
						  $j = 1;
						foreach($dbf->fetchOrder('student_fees',"course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]' And status='1'","") as $vali) {
						
						$dt="";
						$ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");				
						?>
                          <tr bgcolor="<?php echo $color;?>" onMouseOver="this.bgColor='#FDE6D0'" onMouseOut="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;"  onClick="javascript:window.location.href='payment_history_edit.php?ids=<?php echo $val_s_course[student_id];?>&fee_id=<?php echo $vali["id"];?>&course_id=<?php echo $vali[course_id];?>&centre_id=<?php echo $_REQUEST[centre_id];?>'">
                            <td align="center" valign="middle" class="text_structure"><?php echo $j.".";?></td>
                            <td align="left" valign="middle" class="text_structure">&nbsp;&nbsp;<?php echo $vali["fee_date"];?></td>
                            <td align="center" valign="middle" class="text_structure"><?php echo $vali["invoice_no"];?></td>
                            <td align="right" valign="middle" class="text_structure"><?php echo $vali["fee_amt"];?>&nbsp;&nbsp;<?php echo $res_currency[symbol];?>&nbsp;&nbsp;</td>
                            <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
                            <?php if($vali["paid_date"]!="0000-00-00") { $dt = $vali["paid_date"]; } ?>
                            <td align="center" class="text_structure"><?php echo $dt;?>&nbsp;&nbsp;</td>
                            <td align="right" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"].'&nbsp;&nbsp;'.$res_currency[symbol]; }?>
                              &nbsp;&nbsp;</td>
                            <td align="center" ><?php if($vali["paid_amt"]<=0) { ?>
                              <img src="../images/block.png" width="16" height="16" title="Not Paid"/>
                              <?php } else {?>
                              <img src="../images/tick.png" width="16" height="16" title="Paid" />
                              <?php }?></td>
                            <td align="center" ><?php
							  if($vali["paid_amt"]!="0") {								  
								  //if course not completed
								if($num_complete == 0) {
							  ?>
                              <a href="payment_history_edit.php?ids=<?php echo $val_s_course[student_id];?>&amp;fee_id=<?php echo $vali["id"];?>&amp;course_id=<?php echo $vali[course_id];?>&amp;centre_id=<?php echo $_REQUEST[centre_id];?>"> <img src="../images/edit.gif" width="16" height="16" border="0" title="Edit" /></a>
                              <?php }} ?></td>
                          </tr>
                          <?php $j++; }
						  */
						  ?>
                        </table>
                        </td>
                        </tr>
                      
                      <?php } ?>
                      
                    </table>
                                        
                    </td>
                  </tr>                             
                  
                  <?php
			  		$k++;
					}
					}
					?>
                </table></td>
                </tr>
                
              </table></td>
          </tr>               
          <tr>
            <td align="right">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                  <td width="76%" align="center">&nbsp;</td>
                  <td width="24%" align="left" ><!--<div id="pager" class="pager" style="text-align:left; padding-top:10px;"> <img src="../table_sorter/icons/first.png" alt="first" width="16" height="16" class="first"/> <img src="../table_sorter/icons/prev.png" alt="prev" width="16" height="16" class="prev"/>
                    <input name="text" type="text" class="pagedisplay trans" size="5" readonly="readonly" style="border:solid 1px; border-color:#FFCC00;"/>
                    <img src="../table_sorter/icons/next.png" width="16" height="16" class="next"/> <img src="../table_sorter/icons/last.png" width="16" height="16" class="last"/>
                    <select name="select" class="pagesize">
                      <option value="25" selected="selected">25</option>
                      <option  value="50">50</option>
                      </select>
                    </div>--></td>
                  </tr>
                <?php
					if($num==0)
					{
					?>
                <tr>
                  <td height="25" colspan="9" align="center" valign="middle" class="nametext1"><?php echo constant("ADMIN_GROUP_MANAGE_NOREC");?> </td>
                  </tr>
                <?php
					}
					?>
                
                </table>
              </td>
          </tr>
          </table>
        </form>
        
        </td>
      </tr>
    </table></td>
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
