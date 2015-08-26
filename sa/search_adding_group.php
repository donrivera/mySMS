<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

include_once '../includes/language.php';

$student_id = $_REQUEST['student_id'];
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript">
function check(){
	if(document.frm.group.value==""){
		//document.getElementById('lbl_error').innerHTML="Select a group.";
		document.frm.group.focus();
		return false;
	}
}
function validate_corp_acct(){
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
			document.getElementById('lblgroup').innerHTML="Validating...";
		}
			if(ajaxRequest.readyState == 4){
			var c = ajaxRequest.responseText;
			
			document.getElementById('lblgroup').innerHTML=c;
		}
	}

	var account = document.getElementById('account').value;

	ajaxRequest.open("GET", "corporate_show_ajax.php" + "?account=" + account, true);
	ajaxRequest.send(null); 
}

</script>
<script src="js/jquery.min.js" type="text/javascript"></script>

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
<style>
.btn1{
background:url(../images/btn1.png) no-repeat;
width:143px;
height:25px;
font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
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
.btn2{
background:url(../images/btn2.png) no-repeat;
width:143px;
height:25px;
font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
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
<body>

<?php if($_SESSION['lang']=='EN'){?>
<form id="frm" name="frm" method="post" action="search_adding_group_process.php" onSubmit="return check()">
  <table width="470" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="23%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><span class="leftmenu"><img src="../logo/logo.png" alt="logo" width="100" height="30" /></span></td>
          <td width="59%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><?php echo constant("STUDENT_ADVISOR_SEARCH_TEXT");?></td>
          <td width="11%">&nbsp;</td>
          <td width="7%" align="center" valign="middle"><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/></td>
        </tr>
        <tr>
          <td height="5" colspan="4" align="right" valign="middle"><input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top"><table width="380" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td width="53">&nbsp;</td>
          <td width="306" height="30" id="lbl_error" style="font-family:Arial, Helvetica, sans-serif; color:#FF0000; font-weight:normal; font-size:12px;">&nbsp;</td>
        </tr>
        <tr>
          <td width="21" align="left" valign="top">&nbsp;</td>
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="40" colspan="3" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
              <?php
			  $student_name = $dbf->getDataFromTable("student","first_name","id='$student_id'");
			  $couse_name = '';
			  $no_course = 0;
			  foreach($dbf->fetchOrder('student_fees',"student_id='$student_id'","") as $resa){
				  if($couse_name == ''){
					  $no_course = 1;
					  $couse_name = $dbf->getDataFromTable("course","name","id='$resa[course_id]'");
				  }else{
					  $no_course = $no_course + 1;
					  $couse_name = $couse_name.','.$dbf->getDataFromTable("course","name","id='$resa[course_id]'");
				  }
			  }			 
			  if($couse_name == ''){
				  $course_id = $dbf->getDataFromTable("student_enroll","course_id","student_id='$student_id'");
				  $couse_name = $dbf->getDataFromTable("course","name","id='$course_id'");
			  }
			  if($couse_name != ''){
			  	//echo ADMIN_S6_INTRESTINCOURSE." (".$couse_name.") by ".$student_name;
			  }
			  ?>
			    <?php $year_now=date('Y');
					
					$query=$dbf->genericQuery("
												SELECT DISTINCT sg.group_name,c.name,sg.id
												FROM student_group  sg
												INNER JOIN student_course sc ON sg.course_id=sc.course_id
												INNER JOIN course c ON c.id=sc.course_id
												INNER JOIN student_moving smv ON smv.student_id=sc.student_id
												INNER JOIN student_fees sf ON sf.student_id=sc.student_id AND sf.course_id=sg.course_id 
												WHERE sc.student_id='$student_id' 
												AND smv.status_id >'1' AND sg.centre_id='$_SESSION[centre_id]'
												AND sg.status!='Completed' AND YEAR(sg.start_date) = '$year_now'
												AND sf.type IN('advance','on hold')
												ORDER BY substring('sg.group_name',1,2) ASC
					");
				  ?>
              </td>
              </tr>
            <tr>
              <td width="31%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
			  <?php echo constant("STUDENT_ADVISOR_SEARCH_GROUPNM");?> :</td>
              <td width="3%">&nbsp;</td>
              <td width="66%" align="left" valign="middle">
              <select name="group" class="combo" id="group" style="width:180px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                <option value=""> Select Group</option>
                <?php
				/*
				foreach($dbf->fetchOrder('student_course',"student_id='$student_id' And course_id > 0","") as $rescourse) {
					$res_g = $dbf->strRecordID("student_group","*","course_id='$rescourse[course_id]' And centre_id='$_SESSION[centre_id]' And status!='Completed'");
					$course = $dbf->strRecordID("course","name","id='$rescourse[course_id]'");
					//$already_taught = $dbf->countRows("student_group_dtls","student_id='$student_id' And course_id='$res_g[course_id]'");
					//if($already_taught == 0){
					if($res_g['group_name'] != ""){
				*/
				?>
                <!--<option value="<?php //echo $res_g['id']?>"><?php //echo $res_g['group_name'].' ['.$course["name"].']';?></option>-->
                <?php //}} ?>
				<?php foreach($query as $q):?>
					<option value="<?php echo $q[id];?>"><?php echo $q['group_name'].' ['.$q["name"].']';?></option>
				<?php endforeach;?>
              </select></td>
            </tr>
			<?php
				$sql=$dbf->genericQuery("SELECT code,name FROM corporate WHERE centre_id='".$_SESSION[centre_id]."'");
			?>
			
			<tr>
				<td width="31%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
				Corporate Account:</td>
				<td width="3%">&nbsp;</td>
				<td width="66%" align="left" valign="middle">
					
					<select name="corp_acct" 
							class="combo" 
							id="corp_acct" 
							style="width:180px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;"
							<?php echo (empty($query)?'disabled':'');?>>
						<option value=""> Select Account</option>
						<?php foreach($sql as $s):?>
						<option value="<?php echo $s['code'];?>"><?php echo $s['name'];?></option>
						<?php endforeach;?>
					</select>
					
				</td>
			</tr>
			<tr>
				<td width="31%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
				Account Id:</td>
				<td width="3%">&nbsp;</td>
				<td width="66%" align="left" valign="middle">
					<div id="validate_corporate_account">
					<div id="corp_acct_tab"></div>
					</div>
				</td>
			</tr>
			<tr>
				<td width="31%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
				&nbsp;</td>
				<td width="3%">&nbsp;</td>
				<td width="66%" align="left" valign="middle" id="lblgroup">
					<div id="validate_corporate_account">
					
					</div>
				</td>
			</tr>
			<script language="javascript" type="text/javascript">
				$(document).ready(function() 
				{	
					$('#corp_acct').change(function() 
					{
		
						$.post( "corp_acct_tab.php", function( data ) 
						{
			
							$( "#corp_acct_tab" ).html( data );
						});
		
					});
					/*
					$('#account').keyup(function()
					{
						var key=$("#account").val();
						$.post("corporate_show_ajax.php",
						{account:key,},
						function (data)
						{$("#validate_corporate_account").html(data);});
					});
					*/
				});
			</script>
			<!--
			<tr>
				<td>Corporate Account:</td>
				<td>
					<select>
						<option value=""> Select Account</option>
						<?php foreach($sql as $s):?>
						<option value="<?php echo $s[code];?>"><?php echo $q['name'];?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			-->
            <tr>
              <td height="5" colspan="3" align="right" valign="middle"></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="1" colspan="3" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td height="30" colspan="3"><table width="97%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="6%" align="center" valign="middle"><script language="JavaScript" type="text/javascript">
				function showsms(val){
					if(val == "3"){
						document.getElementById('smsid').style.display = "block";
					}else{
						document.getElementById('smsid').style.display = "none";
					}
				}
				</script>
                <input name="sms" type="radio" id="radio" value="1" checked="checked" onchange="showsms(this.value)" /></td>
              <td width="94%" align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
            </tr>
            <tr>
              <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onchange="showsms(this.value)" /></td>
              <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
            </tr>
            <tr>
                <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
                <td align="left" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
              </tr>
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <?php
				$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='16'");
				?>
              <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                <tr>
                  <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:300px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td height="40" align="right" valign="bottom" style="padding-right:8px;">
          <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn1"/></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php }else{?>
<form id="frm" name="frm" method="post" action="search_adding_group_process.php" onSubmit="return check()">
  <table width="470" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:solid 2px; border-color:#FF9900;">
    <tr>
      <td height="36" align="left" valign="middle" bgcolor="#FFA022" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="5%" align="left" valign="middle" ><img src="../images/close-btn.png" width="25" height="25" onclick="javascript:self.parent.tb_remove();" style="cursor:pointer;"/></td>
          <td width="9%">&nbsp;</td>
          <td width="62%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><?php echo constant("STUDENT_ADVISOR_SEARCH_TEXT");?></td>
          <td width="24%" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold; font-size:12px;"><img src="../logo/logo-ar.png" width="100" height="30" /></td>
        </tr>
        <tr>
          <td height="5" colspan="4" align="right" valign="middle"><input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td height="103" align="center" valign="top"><table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="194" height="30" id="lbl_error" style="font-family:Arial, Helvetica, sans-serif; color:#FF0000; font-weight:normal; font-size:12px;">&nbsp;</td>
          <td width="151">&nbsp;</td>
          <td>&nbsp;</td>          
        </tr>
        <tr>          
          <td colspan="2" align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="40" colspan="3" align="right" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">
              <?php
              $student_name = $dbf->getDataFromTable("student","first_name","id='$student_id'");
			  $couse_name = '';
			  $no_course = 0;
			  foreach($dbf->fetchOrder('student_fees',"student_id='$student_id'","") as $resa){
				  if($couse_name == ''){
					  $no_course = 1;
					  $couse_name = $dbf->getDataFromTable("course","name","id='$resa[course_id]'");
				  }else{
					  $no_course = $no_course + 1;
					  $couse_name = $couse_name.','.$dbf->getDataFromTable("course","name","id='$resa[course_id]'");
				  }
			  }			 
			  if($couse_name == ''){
				  $course_id = $dbf->getDataFromTable("student_enroll","course_id","student_id='$student_id'");
				  $couse_name = $dbf->getDataFromTable("course","name","id='$course_id'");
			  }
			  if($couse_name != ''){
			  	//echo ADMIN_S6_INTRESTINCOURSE.' ('.$couse_name.") by ".$student_name;
			  }
			  ?>
              </td>
              </tr>
            <tr>
              <td width="66%" align="right" valign="middle">
              <select name="group" class="combo" id="group" style="width:180px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;">
                <option value=""> <?php echo constant("SELECT_GROUP");?> </option>
                <?php
				foreach($dbf->fetchOrder('student_course',"student_id='$student_id' And course_id > 0","") as $rescourse) {
					$res_g = $dbf->strRecordID("student_group","*","course_id='$rescourse[course_id]' And centre_id='$_SESSION[centre_id]' And status<>'Completed'");
					$course = $dbf->strRecordID("course","name","id='$rescourse[course_id]'");
					if($res_g['group_name'] != ""){
				  ?>
                <option value="<?php echo $res_g['id']?>"><?php echo $res_g['group_name'].' ['.$course["name"].']';?></option>
                <?php }} ?>
              </select></td>
              <td width="3%">&nbsp;</td>
              <td width="31%" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; color:#003333; font-weight:normal; font-size:12px;">: <?php echo constant("STUDENT_ADVISOR_SEARCH_GROUPNM");?></td>
              
              </tr>
            <tr>
              <td height="5" colspan="3" align="right" valign="middle"></td>
              </tr>
            </table></td>
            <td width="35" align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td height="1" colspan="3" bgcolor="#dddddd"></td>
        </tr>
        <tr>
          <td height="30" colspan="3"><table width="97%" border="0" cellspacing="0" cellpadding="0">
            <tr>              
              <td width="94%" align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_STANDARD_SMS");?></td>
              <td width="6%" align="center" valign="middle"><script language="JavaScript" type="text/javascript">
				function showsms(val){
					if(val == "3"){
						document.getElementById('smsid').style.display = "block";
					}else{
						document.getElementById('smsid').style.display = "none";
					}
				}
				</script>
                <input name="sms" type="radio" id="radio" value="1" checked="checked" onchange="showsms(this.value)" /></td>
            </tr>
            <tr>              
              <td align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CANCEL_SMS");?></td>
              <td align="center" valign="middle"><input name="sms" type="radio" id="radio2" value="2" onchange="showsms(this.value)" /></td>
            </tr>
            <tr>                                        
            <td align="right" valign="middle" class="mytext"><?php echo constant("CD_STUDENT_STATUS_CHANGE_SMS");?></td>
            <td align="center" valign="middle"><input name="sms" type="radio" id="radio3" value="3" onChange="showsms(this.value)"></td>
          </tr>
            <tr>
              <td align="center" valign="middle">&nbsp;</td>
              <?php
				$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='16'");
				?>
              <td align="left" valign="middle" class="mytext"><table width="97%" border="0" cellspacing="0" cellpadding="0" id="smsid" style="display:none;">
                <tr>
                  <td align="left" valign="middle"><textarea name="contents" id="contents" style="width:400px; height:30px; border:solid 1px; border-color:#999999;background-color:#ECF1FF;" autocomplete="off"><?php echo $sms_cont;?></textarea></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
         <td height="40" align="left" valign="bottom" style="padding-right:8px;">
          <input type="submit" name="submit" id="submit" value="<?php echo constant("btn_save_btn");?>" class="btn2" /></td>
          <td>&nbsp;</td>          
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?php }?>
</body>
</html>
