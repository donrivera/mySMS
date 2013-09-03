<?
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert')
{

	//Check duplicate
	$num=$dbf->countRows('common',"type='teacher preference' AND name='$_POST[name]'");
	if($num==0)
	{
		$cr_date = date('Y-m-d H:i:s A');
		
		$string="type='teacher preference',name='$_POST[name]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		$dbf->insertSet("common",$string);
		
		header("Location:teacher_manage.php");
	}	
	else
	{
		header("Location:teacher_add.php?msg=exist");		
	}
}


if($_REQUEST['action']=='edit')
{
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="name='$_POST[name]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	$dbf->updateTable("common",$string,"id='$_REQUEST[id]'");
	
	header("Location:teacher_manage.php");
}

if($_REQUEST['action']=='delete')
{
	$dbf->deleteFromTable("common","id='$_REQUEST[id]'");
	header("Location:teacher_manage.php");
}
?>
