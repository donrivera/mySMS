<?
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	$cr_date = date('Y-m-d H:i:s A');
	
	//Check duplicate
	$num=$dbf->countRows('links',"links='$_POST[from]'");
	if($num==0){
		
		$string="title='$_POST[name]',links='$_POST[from]',created_datetime='$cr_date',created_by='$_SESSION[id]'";		
		$dbf->insertSet("links",$string);
		
		header("Location:link_manage.php");
	}else{
		header("Location:link_add.php?msg=exist");		
	}
}

if($_REQUEST['action']=='edit'){
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="title='$_POST[name]',links='$_POST[from]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	
	header("Location:link_manage.php");
}

if($_REQUEST['action']=='delete'){
	$dbf->deleteFromTable("links","id='$_REQUEST[id]'");
	header("Location:link_manage.php");
}

if($_REQUEST['action']=='setstatus'){
	$status = 0;
	if($_REQUEST[val]=="true"){
		$status = 1;
	}
	if($_REQUEST['type']=='cd'){
		$string="cen_dr='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='sa'){
		$string="stu_ad='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='re'){
		$string="rep='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='st'){
		$string="student='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='te'){
		$string="teacher='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='ac'){
		$string="ac='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='lis'){
		$string="lis='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='lism'){
		$string="lism='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	exit;				
	//header("Location:link_manage.php");
}

if($_REQUEST['action']=='helpsetstatus'){
	
	$status = 0;
	if($_REQUEST[val]=="true"){
		$status = 1;
	}
	if($_REQUEST['type']=='cd'){
		$string="cen_dr='$status'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='sa'){
		$string="stu_ad='$status'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='re'){
		$string="rep='$status'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='st'){
		$string="student='$status'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='te'){
		$string="teacher='$status'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	}
	
	if($_REQUEST['type']=='ac'){
		$string="ac='$status'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='lis'){
		$string="lis='$status'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='lism'){
		$string="lism='$status'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	}
	
	exit;
}
?>
