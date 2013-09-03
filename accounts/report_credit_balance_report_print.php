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

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>	
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
  <thead>
    <tr class="logintext">
      <th width="4%" height="25" align="center" valign="middle" bgcolor="#CCCCCC" >&nbsp;</th>
      <th width="5%" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
      <th width="19%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
      <th width="32%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
      <th width="33%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_MOBILENO");?></th>
      <th width="7%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext" ><?php echo constant("ADMIN_SMS_GATEWAY_MANAGE_STATUS");?></th>
      </tr>
  </thead>
  <?php
    $k=1;
    $i = 1;
    $color = "#ECECFF";
                            
    //Loop start
    foreach($dbf->fetchOrder('student', "centre_id='$_REQUEST[centre_id]'","","") as $valstudent){
    
    $total_course_fees = 0;
    foreach($dbf->fetchOrder('student_group_dtls', "student_id='$valstudent[id]'","","") as $dtls){						
        $total_course_fees = $total_course_fees + $dbf->BalanceAmount($dtls["student_id"],$dtls["course_id"]);						
    }
    
    if($total_course_fees < 0){									
    ?>
  <tr bgcolor="<?php echo $color;?>" onMouseOver="this.bgColor='#FDE6D0'" onMouseOut="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
    <td width="4%" height="25" align="center" valign="middle" class="contenttext">
    <a href="javascript:void(0);" onClick="show_details('<?php echo $valstudent[id];?>');"> <span id="plusArrow<?php echo $valstudent[id];?>">
    <img src="../images/plus.gif" border="0" /></span></a></td>
    <td width="5%" height="25" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
    <td width="19%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valstudent[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($valstudent["id"]));?></td>
    <td width="32%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valstudent[email];?></td>
    <td width="33%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $valstudent[student_mobile];?></td>
    <td width="7%" align="center" valign="middle"><?php echo $dbf->VVIP_Icon($valstudent["id"]);?></td>
    <?php
      $i = $i + 1;
      if($color=="#ECECFF"){
          $color = "#FBFAFA";
      }else{
          $color="#ECECFF";
      }
  ?>
  </tr>
   
  <tr style="display:none;" id="<?php echo $valstudent[id];?>">
    <td align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
    <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext">&nbsp;</td>
    <td height="25" colspan="4" align="left"  bgcolor="#F8F9FB" valign="middle" style="padding-left:5px;">
    
    <table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
    <?php
    //Loop start
    $chk = 'first';
    foreach($dbf->fetchOrder('student_group_dtls',"centre_id='$_REQUEST[centre_id]' And student_id='$valstudent[id]'","","") as $val_s_course){
        
        $course = $dbf->strRecordID("course","*","id='$val_s_course[course_id]'");
        $res_enroll = $dbf->strRecordID("student_enroll","*","course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]'");
        
        $paid = $dbf->strRecordID("student_fees","SUM(paid_amt)","course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]' And status='1'");
        
		$course_fees = $dbf->getDataFromTable("course_fee","fees","id='$res_enroll[fee_id]'");
        $course_fee = ($course_fees - $res_enroll["discount"]) + $res_enroll["other_amt"];
        $paid_amt = $paid["SUM(paid_amt)"];
        $bal_amt = $course_fee - $paid_amt;
        if($bal_amt < 0){
        if($chk == 'first'){
    ?>
      <tr>
        <td height="20" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
        <td align="left" valign="middle" bgcolor="#CCCCCC" class="cer4">&nbsp;</td>
        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext">Course Fee</td>
        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext">Paid Amount</td>
        <td align="right" valign="middle" bgcolor="#CCCCCC" class="pedtext">Balance amount</td>
      </tr>
      <?php } $chk = ''; ?>
      <tr>
        <td width="5%" height="20" align="center" valign="middle">
            <a href="javascript:void(0);" onClick="show_details('<?php echo 'c'.$val_s_course[id];?>');"> <span id="plusArrow<?php echo 'c'.$val_s_course[id];?>">
                <img src="../images/plus.gif" border="0" /></span>
            </a>
        </td>
        <td width="60%" align="left" valign="middle" class="cer4"><?php echo $course["name"];?></td>
        <td width="11%" align="right" valign="middle" class="shop1"><?php echo $course_fee;?>&nbsp;</td>
        <td width="12%" align="right" valign="middle" class="shop1"><?php echo $paid_amt;?>&nbsp;</td>
        <td width="12%" align="right" valign="middle" class="shop1"><?php echo $bal_amt;?>&nbsp;</td>
      </tr>
      <tr style="display:none;" id="<?php echo 'c'.$val_s_course[id];?>">
        <td align="center" valign="middle">&nbsp;</td>
        <td colspan="4" align="left" valign="middle"><table width="80%" border="2" bordercolor="#AAAAAA" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
          <tr>
            <td width="6%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></td>
            <td width="18%" align="left" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYDT");?></td>
            <td width="18%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SCHEDFE");?></td>
            <td width="19%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAYMODE");?></td>
            <td width="23%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAIDONDT");?></td>
            <td width="16%" align="center" valign="middle" bgcolor="#CDCDCD" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_PAID");?></td>
            </tr>
          <?php
            $j = 1;
			foreach($dbf->fetchOrder('student_fees',"course_id='$val_s_course[course_id]' And student_id='$val_s_course[student_id]'","") as $vali) {
			
			$dt="";
			$ptype = $dbf->strRecordID("common","*","id='$vali[payment_type]'");				
			?>
          <tr bgcolor="<?php echo $color;?>" onMouseOver="this.bgColor='#FDE6D0'" onMouseOut="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;" >
            <td height="25" align="center" valign="middle" class="text_structure"><?php echo $j.".";?></td>
            <td align="left" valign="middle" class="text_structure">&nbsp;&nbsp;<?php echo $vali["fee_date"];?></td>
            <td align="right" valign="middle" class="text_structure"><?php echo $vali["fee_amt"];?>&nbsp;&nbsp;<?php echo $res_currency[symbol];?>&nbsp;&nbsp;</td>
            <td class="text_structure" align="center"><?php echo $ptype[name]; ?></td>
            <?php if($vali["paid_date"]!="0000-00-00") { $dt = $vali["paid_date"]; } ?>
            <td align="center" class="text_structure"><?php echo $dt;?>&nbsp;&nbsp;</td>
            <td align="right" class="text_structure"><?php if($vali["paid_amt"]!="0") { echo $vali["paid_amt"].'&nbsp;&nbsp;'.$res_currency[symbol]; }?>
              &nbsp;&nbsp;</td>
            </tr>
          <?php $j++; } ?>
        </table></td>
        </tr>
      
      <?php
    }
      }
      ?>
      
    </table>
    
    </td>
  </tr>                 
  
  <?php
    $k++;
    }
    $total_course_fees = 0;
}
?>
</table>
<script type="text/javascript">
window.print();
</script>
