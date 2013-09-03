<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
require '../I18N/Arabic.php';

//Object initialization
$dbf = new User();
$Arabic = new I18N_Arabic('Transliteration');

include_once '../includes/language.php';

?>
<?php if($_SESSION[lang]=="EN"){?>
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;" class="tablesorter" bordercolor="#AAAAAA">
		<?php
		$condition = '';
		//Concate the Condition
		//1.
		if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%')";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = " And s.student_id LIKE '$_REQUEST[stid]%'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = " And s.student_mobile LIKE '$_REQUEST[mobile]%'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = " And s.email LIKE '$_REQUEST[email]%'";
		}
		//End 1.
		
		//2.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'";
		}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
		}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = " And s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = " And s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = " And s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%'";
		}
		//End 2.
		
		//3.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]==''){
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
		}else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!=''){
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%'";
		}else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = " And s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
		}
		//End 3.
		
		//4.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!=''){
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
		}else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]==''){
			$condition = "";
		}
		//End 4.
		
		$i = 1;
				
		// Which students are Not Enrolled for Particular Course					
		//Get group details
		$res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");
		
		$num = $dbf->countRows('student s,student_course c',"s.id=c.student_id And c.course_id='$res_g[course_id]' And s.id not in (select student_id from student_group_dtls where course_id='$res_g[course_id]') ".$condition);
		
		foreach($dbf->fetchOrder('student s,student_course c',"s.id=c.student_id And c.course_id='$res_g[course_id]' And s.id not in (select student_id from student_group_dtls where course_id='$res_g[course_id]')".$condition,"s.first_name","s.*") as $vals){
				
		?>
        <tr>
          <td width="7%" height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" >
          <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>" onchange="display_save2();"/></td>
          <td width="32%" height="25" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
          <td width="19%" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
          <td width="20%" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
          <td width="22%" align="left" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
          <?php
              $i = $i + 1;
              }
              ?>
              <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
        </tr>
       
    </table>
 <?php } else{?>
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="1" style="border-collapse:collapse;" class="tablesorter" bordercolor="#AAAAAA">
		<?php
		$condition = '';
		//Concate the Condition
		//1.
		if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]=='')
		{
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%')";
		}
		else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]=='')
		{
			$condition = " And s.student_id LIKE '$_REQUEST[stid]%'";
		}
		else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]=='')
		{
			$condition = " And s.student_mobile LIKE '$_REQUEST[mobile]%'";
		}
		else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!='')
		{
			$condition = " And s.email LIKE '$_REQUEST[email]%'";
		}
		//End 1.
		
		//2.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]=='')
		{
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%'";
		}
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]=='')
		{
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
		}
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!='')
		{
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.email LIKE '$_REQUEST[email]%'";
		}
		else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]=='')
		{
			$condition = " And s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.student_id LIKE '$_REQUEST[stid]%'";
		}
		else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!='')
		{
			$condition = " And s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
		}
		else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!='')
		{
			$condition = " And s.student_id LIKE  '$_REQUEST[stid]%' AND s.email LIKE '%$_REQUEST[email]%'";
		}
		//End 2.
		
		//3.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]=='')
		{
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%'";
		}
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]=='' && $_REQUEST[email]!='')
		{
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE '$_REQUEST[stid]%' AND s.email LIKE '$_REQUEST[email]%'";
		}
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!='')
		{
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
		}					
		else if($_REQUEST[fname]=='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!='')
		{
			$condition = " And s.student_id LIKE '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
		}
		//End 3.
		
		//4.
		else if($_REQUEST[fname]!='' && $_REQUEST[stid]!='' && $_REQUEST[mobile]!='' && $_REQUEST[email]!='')
		{
			$condition = " And (s.family_name LIKE '$_REQUEST[fname]%' OR s.family_name1 LIKE '$_REQUEST[fname]%' OR s.first_name LIKE '$_REQUEST[fname]%' OR s.student_first_name LIKE '$_REQUEST[fname]%') AND s.student_id LIKE  '$_REQUEST[stid]%' AND s.student_mobile LIKE '$_REQUEST[mobile]%' AND s.email LIKE '$_REQUEST[email]%'";
		}
		else if($_REQUEST[fname]=='' && $_REQUEST[stid]=='' && $_REQUEST[mobile]=='' && $_REQUEST[email]=='')
		{
			$condition = "";
		}
		//End 4.
		
		$i = 1;
		
		//studentstatus_id='6' Means "Enrolled"
		//SELECT s.* FROM student s,student_course c WHERE s.id=c.student_id and studentstatus_id='6' and c.course_id='1' And s.id not in (select student_id from student_group_dtls where course_id='1')
		
		//Get group details
		$res_g = $dbf->strRecordID("student_group","*","id='$_REQUEST[group]'");
		
		$num=$dbf->countRows('student s',"s.id not in (select student_id from student_group_dtls where course_id='$res_g[course_id]') ".$condition);
		
		foreach($dbf->fetchOrder('student s',"s.id not in (select student_id from student_group_dtls where course_id='$res_g[course_id]')".$condition,"s.first_name","s.*") as $vals)
		{
		
		?>
        <tr>
          <td width="22%" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[email];?></td>
          <td width="20%" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_mobile];?></td>
          <td width="19%" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[student_id];?></td>
          <td width="32%" height="25" align="right" valign="middle" bgcolor="#F8F9FB" class="contenttext" style="padding-left:5px;"><?php echo $vals[first_name];?><?php echo $Arabic->en2ar($dbf->StudentName($vals["id"]));?></td>
          <td width="7%" height="25" align="center" valign="middle" bgcolor="#F8F9FB" class="contenttext" >
          <input type="checkbox" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php echo $vals[id];?>" onchange="display_save2();"/></td>
          <?php
              $i = $i + 1;
              }
              ?>
              <input type="hidden" name="count" id="count" value="<?php echo $i-1;?>">
   </tr>
       
</table>
 <?php }?>   