<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

//Object initialization of class validatesaid
include_once '../includes/validateSAID.class.php';
$std = new validateSAID();

if($_REQUEST['action']=='age')
{
	$_SESSION[age] = $_REQUEST[age];
	if($_REQUEST['age']<=16)
	{	
		header("Location:s_parent.php");
	}
	else
	{
		header("Location:s0.php");
	}
}
if($_REQUEST['action']=='parent')
{
	$_SESSION[gname] = $_REQUEST[gname];
	$_SESSION[pcontact] = $_REQUEST[pcontact];
	$_SESSION[information] = $_REQUEST[information];
	
	header("Location:s1.php");
 }
if($_REQUEST['action']=='s0')
{
	$_SESSION[gender] = $_REQUEST[gender];
	
	header("Location:s1.php");
 }
if($_REQUEST['action']=='name')
{
	$num=$dbf->countRows('student',"first_name='$_REQUEST[name]'");
	
	if($num==0)
	{
		$_SESSION[name] = $_REQUEST[name];
		$_SESSION[name1] = $_REQUEST[name1];
		
		header("Location:s2.php");
		exit;
	}
	else
	{
		header("Location:s1.php?msg=exist");
		exit;
	}
}
if($_REQUEST['action']=='country')
{
	//Duplicate checking student id
	$num=$dbf->countRows('student'," student_id='$_REQUEST[studentid]'");
	if($num>0)
	{
		//Error message sent to header
		header("Location:s2.php?msg=idexist");
		exit;
	}
	
	$sid=$_REQUEST[studentid];
	$cid=$_REQUEST[country];
	
	if($cid=='189')
	{
		$stu_id = $std->check($sid);
		
		if($stu_id !='')
		{
			$_SESSION[country] = $_REQUEST[country];
			$_SESSION[student_id] = $_REQUEST[studentid];
			header("Location:s3.php");
		}
		else
		{
			
			header("Location:s2.php?msg=invalid");
		}
	}
	else
	{
			$_SESSION[country] = $_REQUEST[country];
			$_SESSION[student_id] = $_REQUEST[studentid];
			header("Location:s3.php");
	}
	
 }

if($_REQUEST['action']=='contact')
{
	//Duplicate checking on Mobile Number
	$num=$dbf->countRows('student'," student_mobile='$_REQUEST[mobile_no]'");
	if($num>0)
	{
		//Error message sent to header
		header("Location:s3.php?msg=mexist");
		exit;
	}
	//Duplicate checking on Mobile Number
	$num2=$dbf->countRows('student',"alt_contact='$_REQUEST[alt_no]'");
	if($num2>0)
	{
		//Error message sent to header
		header("Location:s3.php?msg=maexist");
		exit;
	}
	else
	{
		$_SESSION[mobile_no] = $_REQUEST[mobile_no];
		$_SESSION[alt_no] = $_REQUEST[alt_no];
		header("Location:s4.php");
		exit;
	}
 }

if($_REQUEST['action']=='email')
{
	//Duplicate checking on Mobile Number
	$num=$dbf->countRows('student',"email='$_REQUEST[email]'");
	if($num>0)
	{
		//Error message sent to header
		header("Location:s4.php?msg=exist");
		exit;
	}
	else
	{
		$_SESSION[email] = $_REQUEST[email];
		header("Location:s5.php");
		exit;
	}
 }
if($_REQUEST['action']=='enroll')
{
	$_SESSION[status] = $_REQUEST[status];
	header("Location:s6.php");
 }
if($_REQUEST['action']=='course')
{
	$courseid='';
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++)
	{
		$c = "course".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{
			if($courseid == '')
			{
				$courseid=$c;
			}
			else
			{
				$courseid=$courseid.','.$c;
			}
		}
	}
	$_SESSION[courseid] = $courseid;
	header("Location:s7.php");
 }
if($_REQUEST['action']=='comment')
{
	$str = mysql_real_escape_string($_POST[student_comment]);
	$_SESSION[student_comment] = $str;
	header("Location:s8.php");
 }
 if($_REQUEST['action']=='aboutus')
{
	$leadid='';
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++)
	{
		$c = "lead".$i;
		$c = $_REQUEST[$c];
		
		if($c != '')
		{
			if($leadid == '')
			{
				$leadid=$c;
			}
			else
			{
				$leadid=$leadid.','.$c;
			}
		}
	}
	$_SESSION[leadid] = $leadid;	
	header("Location:s9.php");
}
 
if($_REQUEST['action']=='insert')
{
	     
			 //insert into student table
			$string="age='$_SESSION[age]',guardian_name='$_SESSION[gname]',guardian_contact='$_SESSION[pcontact]',guardian_comment ='$_SESSION[information]', first_name='$_SESSION[name]', arabic_name='$_SESSION[name1]', gender='$_SESSION[gender]',country_id='$_SESSION[country]',student_id='$_SESSION[student_id]',student_mobile='$_SESSION[mobile_no]',alt_contact='$_SESSION[alt_no]',email='$_SESSION[email]',studentstatus_id='$_SESSION[status]',student_comment='$_SESSION[student_comment]'";
			
			$id = $dbf->insertSet("student",$string);
			
			//Set in Session (New Student ID)
			$_SESSION['studentid'] = $id;
			
			//Delete from student course table
			$dbf->deleteFromTable("student_course","student_id='$_SESSION[studentid]'");
			//insert into student course table
			$courseid=explode(',',$_SESSION[courseid]);
			foreach($courseid as $val)
			{
				$string="student_id='$_SESSION[studentid]',course_id='$val'";
				$dbf->insertSet("student_course",$string);
			}	
			//Delete from student course table
			$dbf->deleteFromTable("student_lead","student_id='$_SESSION[studentid]'");
			//insert into student lead table
			$leadid=explode(',',$_SESSION[leadid]);
			foreach($leadid as $val2)
			{
				$string="student_id='$_SESSION[studentid]',lead_id='$val2'";
				$dbf->insertSet("student_lead",$string);
			}	
			
		header("Location:s_finish.php");
}

if($_REQUEST['action']=='finished')
{
	//Clear all previous session value
	unset($_SESSION['student_id']);
	session_unregister('student_id');
	
	unset($_SESSION['gname']);
	session_unregister('gname');
	
	unset($_SESSION['pcontact']);
	session_unregister('pcontact');
	
	unset($_SESSION['information']);
	session_unregister('information');
	
	unset($_SESSION['age']);
	session_unregister('age');
	
	unset($_SESSION['name']);
	session_unregister('name');
	
	unset($_SESSION['name1']);
	session_unregister('name1');
	
	unset($_SESSION['gender']);
	session_unregister('gender');
	
	unset($_SESSION['country']);
	session_unregister('country');
	
	unset($_SESSION['mobile_no']);
	session_unregister('mobile_no');
	
	unset($_SESSION['alt_no']);
	session_unregister('alt_no');
	
	unset($_SESSION['email']);
	session_unregister('email');
	
	unset($_SESSION['status']);
	session_unregister('status');
	
	unset($_SESSION['student_comment']);
	session_unregister('student_comment');
	
	unset($_SESSION['courseid']);
	session_unregister('courseid');
	
	unset($_SESSION['leadid']);
	session_unregister('leadid');
	
	unset($_SESSION['studentid']);
	session_unregister('studentid');
		
	header("Location:s_manage.php");	
}


if($_REQUEST['action']=='search')
{
	$string="level_complete='$_POST[level]',ob_amt='$_POST[payment]',payment_type='$_POST[ptype]',web='$_POST[web]'";
	$dbf->updateTable("student",$string,"id='$_REQUEST[id]'");
	
	
	//update student_comment table
	$comment=mysql_real_escape_string($_POST[textarea]);
	 $string2="comments='$comment'";
	$dbf->updateTable("student_comment",$string2,"student_id='$_REQUEST[id]'");
	
	
	//Delete from student material table
	$dbf->deleteFromTable("student_material","student_id='$_REQUEST[id]'");
	
	//Insert in student material table
	//---------------------------------------------------
	$totrow_cont = $_REQUEST['mcount'];

	for($i=1; $i<=$totrow_cont;$i++)
	{
		$name = "material".$i;
		$name = $_REQUEST[$name];
		
		if($name != "")
		{
			$string="student_id='$_REQUEST[id]',mate_id='$name'";
			$dbf->insertSet("student_material",$string);
		}
	}
	//----------------------------------------------------
	
	//Insert in student fees table
	$tot = $_REQUEST['count'];

	for($k=1; $k<=$tot;$k++)
	{
		$name = "pdate".$k;
		$name = $_REQUEST[$name];
		
		$amt = "amt".$k;
		$amt = $_REQUEST[$amt];
		
		if($name != "" && $amt != "")
		{
			$string="student_id='$_REQUEST[id]',fee_date='$name',fee_amt='$amt'";
			$dbf->insertSet("student_fees",$string);
		}
	}
	//----------------------------------------------------
	
	header("Location:search_manage.php?id=$_REQUEST[id]");
}



if($_REQUEST['action']=='invoice')
{
	$string="paid_date='$_POST[dated]',	payment_type='$_POST[payment_type]',paid_amt='$_POST[amt]',status='1'";
	$dbf->updateTable("student_fees",$string,"id='$_REQUEST[schid]'");
	
	header("Location:search_manage.php?id=$_REQUEST[id]");
}

?>
