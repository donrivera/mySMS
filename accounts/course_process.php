<?
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{

	//Check duplicate
	$num=$dbf->countRows('course',"name='$_POST[name]'");
	if($num==0)
	{
		$cr_date = date('Y-m-d H:i:s A');
		
		$string="name='$_POST[name]',code='$_POST[code]',slno='$_POST[maxid]',descr='$_POST[descr]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		$dbf->insertSet("course",$string);
		
		header("Location:course_manage.php");
	}	
	else
	{
		header("Location:course_add.php?msg=exist");		
	}
}


if($_REQUEST['action']=='edit')
{
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="name='$_POST[name]',code='$_POST[code]',descr='$_POST[descr]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	$dbf->updateTable("course",$string,"id='$_REQUEST[id]'");
	
	header("Location:course_manage.php");
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("course","id='$_REQUEST[id]'");
	header("Location:course_manage.php");
}
?>
