<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{
	//Check duplicate
	if($_SESSION['student_id']=='')
	{
		$num=$dbf->countRows('student',"first_name='$_POST[name]'");
		if($num==0)
		{
			$string="first_name='$_POST[name]',complete_name='$_POST[name1]'";
			$id = $dbf->insertSet("student",$string);
			
			//Set in Session (New Student ID)
			$_SESSION['student_id'] = $id;
			
			header("Location:s2.php");
		}	
		else
		{
			header("Location:s1.php?msg=exist");		
		}
	}
	else
	{
		$string="first_name='$_POST[name]',complete_name='$_POST[name1]'";
		$dbf->updateTable("student",$string,"id='$_SESSION[student_id]'");
		
		header("Location:s2.php");
	}
}


if($_REQUEST['action']=='s2')
{

	$string="country_id='$_POST[country]',student_id='$_POST[name1]'";
	$dbf->updateTable("student",$string,"id='$_SESSION[student_id]'");
	
	header("Location:s3.php");
	
	
	//Check Valid ID Number here
	
	/*//pending code
	$num=$dbf->countRows('student',"student_id='$_POST[name1]'");
	if($num==0)
	{
		$string="student_id='$_POST[name1]'";
		$id = $dbf->insertSet("strudent",$string);
						
		header("Location:s3.php");
	}	
	else
	{
		header("Location:s2.php?msg=invalid");		
	}*/
}


if($_REQUEST['action']=='s3')
{
	$string="student_mobile='$_POST[name]',alt_contact='$_POST[name1]'";
	$dbf->updateTable("student",$string,"id='$_SESSION[student_id]'");
	
	header("Location:s4.php");
}

if($_REQUEST['action']=='s4')
{
	$string="email='$_POST[name]'";
	$dbf->updateTable("student",$string,"id='$_SESSION[student_id]'");
	
	header("Location:s5.php");
}

if($_REQUEST['action']=='s5')
{
	$string="studentstatus_id='$_POST[status]'";
	$dbf->updateTable("student",$string,"id='$_SESSION[student_id]'");
	
	header("Location:s6.php");
}

if($_REQUEST['action']=='s6')
{
	
	//Delete from student course table
	$dbf->deleteFromTable("student_course","student_id='$_SESSION[student_id]'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++)
	{
		$c = "course".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{			
			$string="student_id='$_SESSION[student_id]',course_id='$c'";
			$dbf->insertSet("student_course",$string);
		}
	}	
	header("Location:s7.php");
}

if($_REQUEST['action']=='s7')
{
	$str = mysql_real_escape_string($_POST[student_comment]);
	
	$string="student_comment='$str'";
	$dbf->updateTable("student",$string,"id='$_SESSION[student_id]'");
	
	header("Location:s8.php");
}

if($_REQUEST['action']=='s8')
{
	//Delete from student course table
	$dbf->deleteFromTable("student_lead","student_id='$_SESSION[student_id]'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++)
	{
		$c = "lead".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{
			$string="student_id='$_SESSION[student_id]',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}	
	header("Location:s9.php");
}

if($_REQUEST['action']=='s9')
{
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++)
	{
		$c = "lead".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{
			$string="student_id='$_SESSION[student_id]',lead_id='$c'";
			$dbf->insertSet("student_lead",$string);
		}
	}	
	header("Location:s9.php");
}

if($_REQUEST['action']=='delete')
{
	
	//Delete from student course table
	$dbf->deleteFromTable("student_course","student_id='$_REQUEST[id]'");
	
	//Delete from student lead table
	$dbf->deleteFromTable("student_lead","student_id='$_REQUEST[id]'");
	
	//Delete from student fee table
	$dbf->deleteFromTable("student_fees","student_id='$_REQUEST[id]'");
	
	//Delete from student student_material table
	$dbf->deleteFromTable("student_material","student_id='$_REQUEST[id]'");
	
	//Delete from student table
	$dbf->deleteFromTable("student","id='$_REQUEST[id]'");
	
	header("Location:s_manage.php");
}
?>
