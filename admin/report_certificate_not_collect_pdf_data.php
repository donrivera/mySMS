<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';

?>	
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
<thead>
    <tr class="logintext">
    <th width="3%" height="25" align="center" valign="middle" bgcolor="#CCCCCC" >&nbsp;</th>
    <th width="5%" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("STUDENT_ADVISOR_SEARCH_MANAGE_SL");?></th>
    <th width="18%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_NAME");?></th>
    <th width="18%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILE");?></th>
    <th width="28%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
    <th width="7%" align="center" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("CD_AUTO_SEARCH_AGE");?></th>
    </tr>
  </thead>
  <?php
    $k=1;
    $i = 1;
    $color = "#ECECFF";
    
    if($_REQUEST[start_date]!='' && $_REQUEST[end_date]!=''){
        $cond="certificate_collect='0' And (enroll_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
    }else{
        $cond="certificate_collect='0'";
    }

    //Get number of rows
    $num=$dbf->countRows('student_enroll', $cond);
    
    //Get currency
    $res_currency = $dbf->strRecordID("currency_setup","*","use_currency='1'");
    
    //Loop start
    foreach($dbf->fetchOrder('student_enroll', $cond ,"","") as $val1){
        $val = $dbf->strRecordID("student","*","id='$val1[student_id]'");
    ?>
  <tr bgcolor="<?php echo $color;?>">
    <td width="3%" height="25" align="center" valign="middle" class="contenttext"></td>
    <td width="5%" height="25" align="center" valign="middle" class="mycon"><?php echo $k; ?></td>
    <td width="18%" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[first_name];?></td>
    <td width="18%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[student_mobile];?></td>
    <td width="28%" align="left" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[email];?></td>
    <td width="7%" align="center" valign="middle" class="mycon" style="padding-left:5px;"><?php echo $val[age];?></td>
  </tr>
  <?php
  $k++;
    }
    ?>
</table>