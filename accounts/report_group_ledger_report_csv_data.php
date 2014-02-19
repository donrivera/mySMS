<?php
ob_start();
session_start();

include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();
include_once '../includes/language.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#999999" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
  <thead>
    <tr class="logintext">
      <th width="3%" height="30" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;</th>
      <th width="14%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_GROUP_MANAGE_GROUPNAME");?></th>
      <th width="20%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_STARTDATE");?> / <?php echo constant("ADMIN_VACATION_CENTRE_MANAGE_ENDDATE");?></th>
      <th width="21%" height="30" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_COUNT_STU");?></th>
      <th width="22%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_TOT_EN_AMOUNT");?></th>
      <th width="20%" align="left" valign="middle" bgcolor="#CCCCCC" class="pedtext"><?php echo constant("ACCOUNTANT_TOT_BAL_AMOUNT");?></th>
    </tr>
  </thead>
    <?php
        $i = 1;
        $color="#ECECFF";
		/*
        if($_REQUEST[group_id] == ''){
            $cond = "id > 0 And ()";
        }else{
            $cond = '';
            if($_REQUEST[student_id] == '' && $_REQUEST[balance] == ''){
                $cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
            }else if($_REQUEST[student_id] != '' && $_REQUEST[balance] == ''){
                $cond = "student_id='$_REQUEST[student_id]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
            }else if($_REQUEST[student_id] == '' && $_REQUEST[balance] != ''){
                $cond = "(paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
            }else if($_REQUEST[student_id] != '' && $_REQUEST[balance] != ''){
                $cond = "student_id='$_REQUEST[student_id]' And (paid_date BETWEEN '$_REQUEST[start_date]' And '$_REQUEST[end_date]')";
            }
            $group = "id = '$_REQUEST[group_id]'";
        }
        $num=$dbf->countRows('student_fees', $group);
        //loop start
        foreach($dbf->fetchOrder('student_group', $group,"group_name") as $valgroup) {
        */
		$start_date = $_REQUEST[start_date];
		$end_date = $_REQUEST[end_date];
		$group_status=$_REQUEST[group_status];
		if($_REQUEST[group_id] != '' && $group_status!=''){$group = "id='$_REQUEST[group_id]' AND status='$group_status'";}
		elseif($_REQUEST[group_id] == '' && $group_status!=''){$group="status='$group_status'";}
		elseif($_REQUEST[group_id] != '' && $group_status==''){$group="id='$_REQUEST[group_id]'";}
		elseif($group_status ==''){$group = "id > 0";}
		elseif($_REQUEST[group_id] == ''){$group = "id > 0";}
		else{$group = "id = '$_REQUEST[group_id]'";}
		$num=$dbf->countRows('student_group', $group."AND start_date BETWEEN '$start_date' AND '$end_date'");
					
		//loop start
		foreach($dbf->fetchOrder('student_group', $group."AND start_date BETWEEN '$start_date' AND '$end_date'","group_name") as $valgroup) {
        //Count the number o students in student_group_dtls table
        $numofstudent=$dbf->countRows('student_group_dtls', "parent_id='$valgroup[id]'");
       
		$course_fee=$dbf->getDataFromTable("course_fee", "fees", "id='$valgroup[course_id]'");
		$en_amt=$course_fee * $numofstudent;
		$payments=$dbf->getDataFromTable("student_enroll se INNER JOIN student_fees sf ON sf.student_id=se.student_id AND sf.course_id=se.course_id", "SUM(sf.paid_amt) as total", "se.group_id='$valgroup[id]'");
        $bal_amt=$en_amt-$payments;
		?>        
    <tr bgcolor="<?php echo $color;?>" onMouseover="this.bgColor='#FDE6D0'" onMouseout="this.bgColor='<?php echo $color;?>'" style="cursor:pointer;">
      <td align="center" valign="middle" class="mycon">&nbsp;</td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo $valgroup["group_name"];?> <?php echo $valgroup["group_time"];?> <?php echo $dbf->printClassTimeFormat($valgroup["group_start_time"],$valgroup["group_end_time"]);?></td>
      <td align="left" valign="middle" class="mycon">&nbsp;<?php echo date('d-M-Y',strtotime($valgroup["start_date"]));?>&nbsp;/&nbsp;<?php echo date('d-M-Y',strtotime($valgroup["end_date"]));?></td>
      <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $numofstudent;?></td>
      <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $en_amt;?></td>
      <td align="center" valign="middle" class="mycon">&nbsp;<?php echo $bal_amt;?></td>
    </tr>  
    <?php
            $i = $i + 1;
            if($color=="#ECECFF"){
                $color = "#FBFAFA";
            }else{
                $color="#ECECFF";
            }
        }
        ?>            
</table>