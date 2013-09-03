<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	//Check duplicate
	$num=$dbf->countRows('grade',"name='$_POST[name]'");
	if($num>0){
		header("Location:grade_add.php?msg=exist");	
		exit;
	}
	
	//Check range
	foreach($dbf->fetchOrder('grade',"tto>='$_REQUEST[from]' and frm<='$_REQUEST[from]'","id") as $val){
		if($val["id"] > 0){
			header("Location:grade_add.php?msg=rangeexist");	
			exit;
			break;
		}	
	}
	
	foreach($dbf->fetchOrder('grade',"tto>='$_REQUEST[to]' and tto<='$_REQUEST[to]'","id") as $val1){
		if($val1["id"] > 0){
			
			header("Location:grade_add.php?msg=rangeexist");	
			exit;
			break;
		}
	}
	
	$cr_date = date('Y-m-d H:i:s A');		
	$string="name='$_POST[name]',frm='$_POST[from]',tto='$_POST[to]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
	
	$dbf->insertSet("grade",$string);
	
	header("Location:grade_manage.php");
	exit;
}


if($_REQUEST['action']=='edit'){
	
	$cr_date = date('Y-m-d H:i:s A');
	
	//(tto >=86 && frm<=86) or (tto >=88 && frm<=88)
	echo $count = $dbf->countRows("grade", "(tto >'$_POST[from]' && frm<='$_POST[from]') or (tto >'$_POST[to]' && frm<='$_POST[to]')");exit;
	
	if($count > 0){			
		header("Location:grade_edit.php?id=$_REQUEST[id]&msg=rangeexist");	
		exit;
		break;
	}
	
	$string="name='$_POST[name]',frm='$_POST[from]',tto='$_POST[to]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	$dbf->updateTable("grade",$string,"id='$_REQUEST[id]'");
	
	header("Location:grade_manage.php");
	exit;
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("grade","id='$_REQUEST[id]'");
	
	header("Location:grade_manage.php");
	exit;
}
?>
