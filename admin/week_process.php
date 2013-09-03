<?
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='edit')
{
	//Check duplicate
	$num=$dbf->countRows('working_day',"name='$_POST[name]'");
	if($num==0)
	{
		$string="name='$_POST[name]'";
		$dbf->updateTable("working_day",$string,"id='$_REQUEST[id]'");

		header("Location:week_manage.php");
		exit;
	}
	else
	{
		header("Location:week_edit.php?id=$_REQUEST[id]&msg=exist");
		exit;
	}
	
}

if($_REQUEST['action']=='status')
{
	$string="status='$_POST[status]'";
	$dbf->updateTable("working_day",$string,"id='$_REQUEST[id]'");
}
?>
<script type="text/javascript">
	self.parent.location.href='week_manage.php';
	self.parent.tb_remove();
</script>
