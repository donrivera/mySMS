<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='classic')
{
	//Check duplicate
	$num=$dbf->countRows('student',"first_name='$_POST[nameenglish]'");
	$comment = mysql_real_escape_string($_POST[comment]);
	$dt = date('Y-m-d h:m:s');
	if($num>0)
	{
		header("Location:s_classic.php?msg=exist");
		exit;
	}
	if($_POST[country]==189)
	{
		$num=$dbf->countRows('student',"student_id='$_POST[sid]'");
		if($num>0)
		{
			header("Location:s_classic.php?msg=idexist");
			exit;
		}
	}
	$num=$dbf->countRows('student',"student_mobile ='$_POST[mobile]'");
	if($num>0)
	{
		header("Location:s_classic.php?msg=mexist");
		exit;
	}
	
	$filename1=$_REQUEST[nameenglish]."-".$_FILES['signature']['name'];
	if($_FILES['signature']['name']<>'')
	{
		move_uploaded_file($_FILES[signature][tmp_name],"../sa/photo/".$filename1);
		
		$string="first_name='$_POST[nameenglish]',father_name='$_POST[fatherenglish]',grandfather_name='$_POST[grandenglish]',family_name='$_POST[famlyenglish]',gender='$_POST[gender]',country_id='$_POST[country]',student_id='$_POST[sid]',student_mobile='$_POST[mobile]',	alt_contact='$_POST[altmobile]',email='$_POST[email]',studentstatus_id='$_POST[status]',student_comment='$comment',photo='$filename1',created_datetime='$dt'";
		
		$id = $dbf->insertSet("student",$string);
		
		//$comment = mysql_real_escape_string($_POST[comment]);
		
		//$dt = date('Y-m-d h:m:s');
		
        $string2="student_id='$id',user_id='$_SESSION[id]',comments='$comment',date_time='$dt'";		
		
		$dbf->insertSet("student_comment",$string2);
		
	}
	else
	{
	
	
		$string="first_name='$_POST[nameenglish]',father_name='$_POST[fatherenglish]',grandfather_name='$_POST[grandenglish]',family_name='$_POST[famlyenglish]',gender='$_POST[gender]',country_id='$_POST[country]',student_id='$_POST[sid]',student_mobile='$_POST[mobile]',	alt_contact='$_POST[altmobile]',email='$_POST[email]',studentstatus_id='$_POST[status]',student_comment='$_POST[comment]',created_datetime='$dt'";
		
		$id = $dbf->insertSet("student",$string);
		
		$comment = mysql_real_escape_string($_POST[comment]);
		
		$dt = date('Y-m-d h:m:s');
		
		$string2="student_id='$id',user_id='$_SESSION[id]',comments='$comment',date_time='$dt'";
		$dbf->insertSet("student_comment",$string2);
		
	}
	
	
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++)
	{
		$c = "course".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{			
			$string="student_id='$id',course_id='$c'";
			$dbf->insertSet("student_course",$string);
		}
	}
	
	$count = $_POST[leadcount];
	for($i=1; $i<=$count; $i++)
	{
		$c = "lead".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{
			$string="student_id='$id',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}
	
	header("Location:s_manage.php");
	exit;

}

if($_REQUEST['action']=='edit')
{

	$res = $dbf->strRecordID("student","*","id='$_REQUEST[id]'");
	$comment = mysql_real_escape_string($_POST[comment]);
	$filename1=$res["first_name"]."-".$_FILES['signature']['name'];
	if($_FILES['signature']['name']<>'')
	{
		//Remove the previous Image (Signature)
		$prev_file = $res["photo"];
		if($prev_file != "")
		{
			$prev_file = "../sa/photo/".$prev_file;
			unlink($prev_file);
		}
		
		move_uploaded_file($_FILES[signature][tmp_name],"../sa/photo/".$filename1);
		
		 $string="photo='$filename1'";
		$dbf->updateTable("student",$string,"id='$_REQUEST[id]'");
	}
	

	$string="first_name='$_POST[nameenglish]',father_name='$_POST[fatherenglish]',grandfather_name='$_POST[grandenglish]',family_name='$_POST[famlyenglish]',arabic_name='$_POST[namearabic]',gender='$_POST[gender]',country_id='$_POST[country]',student_id='$_POST[sid]',student_mobile='$_POST[mobile]',	alt_contact='$_POST[altmobile]',email='$_POST[email]',studentstatus_id='$_POST[status]',student_comment='$comment'";
	
	$dbf->updateTable("student",$string,"id='$_REQUEST[id]'");
	//update student_comment table
	$string2="comments='$comment'";
	$dbf->updateTable("student_comment",$string2,"student_id='$_REQUEST[id]'");
	
	//Delete from student course table
	$dbf->deleteFromTable("student_course","student_id='$_REQUEST[id]'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++)
	{
		$c = "course".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{			
			$string="student_id='$_REQUEST[id]',course_id='$c'";
			$dbf->insertSet("student_course",$string);
		}
	}
	
	//Delete from student course table
	$dbf->deleteFromTable("student_lead","student_id='$_REQUEST[id]'");
	
	$count = $_POST[leadcount];
	for($i=1; $i<=$count; $i++)
	{
		$c = "lead".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{
			$string="student_id='$_REQUEST[id]',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}
		
	header("Location:auto_search_edit.php?id=$_REQUEST[id]");
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("student","id='$_REQUEST[id]'");
	header("Location:s_manage.php");
}
?>
