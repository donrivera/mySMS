<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){

	//Check duplicate
	$num=$dbf->countRows('help',"title='$_POST[title]'");
	if($num==0){		
		$audience='0';
		if($_POST[audience]!=""){			
			$audience='1';		
			$string="title='$_POST[title]',descr='$_POST[content]',cen_dr='1',stu_ad='1',rep='1',student='1',teacher='1',ac='1',lis='1',lism='1'";
		}else{
			$string="title='$_POST[title]',descr='$_POST[content]'";
		}
		
		$dbf->insertSet("help",$string);
		
		header("Location:help_manage.php");
		exit;
	}else{
		header("Location:help_add.php?msg=exist");
		exit;
	}
}

if($_REQUEST['action']=='edit'){
	
	$string="descr='$_POST[content]'";
	$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	
	$audience='0';
	if($_POST[audience]!=""){			
		$audience='1';		
		$string="cen_dr='1',stu_ad='1',rep='1',student='1',teacher='1',ac='1',lis='1',lism='1'";
	}else{
		$string="title='$_POST[title]',descr='$_POST[content]'";
	}
	$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
	
	//Check duplicate
	$num=$dbf->countRows('help',"title='$_POST[title]'");
	if($num==0){		
		$string="title='$_POST[title]'";
		$dbf->updateTable("help",$string,"id='$_REQUEST[id]'");
		
		header("Location:help_manage.php");
		exit;
	}else{
		header("Location:help_edit.php?id=$_REQUEST[id]&msg=added");
		exit;
	}	
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("help","id='$_REQUEST[id]'");
	
	header("Location:help_manage.php");
	exit;
}
?>
