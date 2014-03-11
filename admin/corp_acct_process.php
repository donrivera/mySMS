<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	$cr_date = date('Y-m-d H:i:s A');
	//Check duplicate
	$num=$dbf->countRows('corporate',"code='$_POST[corporate_code]'");
	if($num==0){
		$cr_date = date('Y-m-d H:i:s A');
		
		$string="	centre_id='$_POST[centre_name]',
					code='$_POST[corporate_code]',
					name='$_POST[corporate_name]',
					address='$_POST[corporate_address]',
					contact='$_POST[corporate_contact]',
					details='$_POST[corporate_details]',
					no_of_students='$_POST[corporate_num_of_students]',
					no_of_class='$_POST[corporate_num_of_class]',
					remarks='$_POST[corporate_remarks]',
					date_added='$cr_date'";
		$dbf->insertSet("corporate",$string);
		
		header("Location:corp_acct_manage.php");
	}else{
		header("Location:corp_acct_add.php?msg=exist");		
	}
	
}

if($_REQUEST['action']=='edit'){
	
	$cr_date = date('Y-m-d H:i:s A');	
	$string="	centre_id='$_POST[centre_name]',
				code='$_POST[corporate_code]',
				name='$_POST[corporate_name]',
				address='$_POST[corporate_address]',
				contact='$_POST[corporate_contact]',
				details='$_POST[corporate_details]',
				no_of_students='$_POST[corporate_num_of_students]',
				no_of_class='$_POST[corporate_num_of_class]',
				remarks='$_POST[corporate_remarks]',
				date_added='$cr_date'";
	#$string="name='$_POST[material_name]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	
	$dbf->updateTable("corporate",$string,"id='$_REQUEST[id]'");	
	header("Location:corp_acct_manage.php");
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("corporate","id='$_REQUEST[id]'");
	header("Location:corp_acct_manage.php");
}
?>
