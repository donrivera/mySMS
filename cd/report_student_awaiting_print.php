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
//Object initialization
$dbf = new User();
include_once '../includes/language.php';

?>	
<body>
<table width="100%" border="1" cellpadding="0" cellspacing="0"  bordercolor="#AAAAAA" class="tablesorter" id="sort_table" style="border-collapse:collapse;">
   <thead>
    <tr class="logintext">
      <th width="4%" height="25" align="center" valign="middle" bgcolor="#CDCDCD" >&nbsp;</th>
      <th width="22%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_VIEW_COMMENTS_MANAGE_STUDENT");?></th>
      <th width="16%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"  ><?php echo constant("ADMIN_TEACHER1_MANAGE_MOBILENUMBER");?>  </th>
      <th width="20%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;" ><?php echo constant("ADMIN_TEACHER1_MANAGE_EMAIL");?></th>
      <th width="14%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"  ><?php echo constant("ADMIN_REPORT_STUDENT_AWAITING_LEVEL");?></th>
      <th width="24%" align="left" valign="middle" bgcolor="#CDCDCD" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#6a6868;font-weight:bold;"  ><?php echo constant("CD_REPORT_STUDENT_AWAITING_CSV_DATA_DATEWAIT");?> </th>
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
    <tr>
      <td height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext"><?php echo $i;?></td>
      <td height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[first_name];?></td>
      <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[student_mobile];?></td>
      <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $val[email];?></td>
      <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php echo $course;?></td>
      <td align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#000000;padding-left:3px;"><?php if($val[date_time] != '0000-00-00 00:00:00') { echo date('m/d/Y',strtotime($val[date_time])); }?></td>
      <?php    
	  $i = $i + 1;
	  }
	  ?>
    </tr>
</table>
</body>
<script type="text/javascript">
window.print();
</script>
