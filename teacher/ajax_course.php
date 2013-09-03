<?php
ob_start();
session_start();
if(($_COOKIE['cook_username'])=='')
{
	if($_SESSION['id']=="" || $_SESSION['user_type']!="Teacher")
	{
		header("Location:../index.php");
		exit;
	}
}

include_once '../includes/class.Main.php';

$pageTitle='Welcome to Berlitz-KSA';

include '../application_top.php';

//Object initialization
$dbf = new User();
$teacher_id = $_SESSION[uid];


?>				
					
					
					<select name="course_id" id="course_id" style="width:120px; border:solid 1px; border-color:#FFCC00;" onChange="changeCourse();">
                          <option value=""> Select Course</option>
                          <?php
						  foreach($dbf->fetchOrder('student_group',"teacher_id='$teacher_id' and group_id='$_REQUEST[group_id]'","","") as $res_course1) {
							//Group Name
                      		$res_course = $dbf->strRecordID("course","*","id='$res_course1[course_id]'");
							?>
                          <option value="<?php echo $res_course['id'];?>" <?php if($_REQUEST[course_id]==$res_course['id']) { ?> selected="selected" <?php } ?>><?php echo $res_course['name'];?></option>
                          <?php
						  }
						 ?>
                   </select>
