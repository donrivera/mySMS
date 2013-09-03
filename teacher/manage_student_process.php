<?
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{

	//Check duplicate
	$num=$dbf->countRows('common',"type='student status' AND name='$_POST[name]'");
	if($num==0)
	{
		$string="type='student status',name='$_POST[name]'";
		$dbf->insertSet("common",$string);
		
		header("Location:student_manage.php");
	}	
	else
	{
		header("Location:manage_student_add.php?msg=exist");		
	}
}


if($_REQUEST['action']=='edit')
{

	$string="name='$_POST[name]'";
	$dbf->updateTable("common",$string,"id='$_REQUEST[id]'");
	
	header("Location:student_manage.php");
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("common","id='$_REQUEST[id]'");
	header("Location:student_manage.php");
}
?>
