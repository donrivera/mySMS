<?
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$num=$dbf->countRows('email_templete');

if($num==0)
{
	$string="title='$_POST[title]',content='$_POST[content]'";
	$dbf->insertSet("email_templete",$string);
	
	header("Location:email_manage.php?msg=added");
}
else
{
	$content = mysql_real_escape_string($_POST[content]);
	
	$string="title='$_POST[title]',content='$content'";
	$dbf->updateTable("email_templete",$string,"id>'0'");
	
	header("Location:email_manage.php?msg=edit");
}
?>
