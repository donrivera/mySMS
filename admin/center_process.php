<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	
	//Creating selfservice.php Automatically
	//======================================
	$file_name = 'selfservice'.$_REQUEST['no'].'.php';
	$file_path = '../'.$file_name;
	if(!file_exists($file_path)){		
		//Source file path
		$source = '../service/selfservice.php';
		$destin = $file_path;
				
		if (!copy($source, $destin)) {
		echo "failed to copy $file...\n";
		}
	}
	//======================================
	
	$ctime = $_POST[start_time].":".$_POST[start_time2];
	$etime = $_POST[end_time].":".$_POST[end_time2];
	$sstime = $_POST[s_starttime].":".$_POST[s_starttime2];
	$setime = $_POST[s_endtime].":".$_POST[s_endtime2];
	
	$_SESSION['c_name'] = $_POST[name];
	$_SESSION['c_no'] = $_POST[no];
	$_SESSION['c_tel_no'] = $_POST[tel_no];
	$_SESSION['c_email_add'] = $_POST[email_add];
	$_SESSION['c_dir_name'] = $_POST[dir_name];
	$_SESSION['c_street'] = $_POST[street];
	$_SESSION['c_area'] = $_POST[area];
	$_SESSION['c_province'] = $_POST[province];
	$_SESSION['c_country'] = $_POST[country];
	$_SESSION['c_unit'] = $_POST[unit];
	$_SESSION['c_ctime'] = $ctime;
	$_SESSION['c_etime'] = $etime;
	$_SESSION['c_sstime'] = $sstime;
	$_SESSION['c_setime'] = $setime;
	$_SESSION['c_class'] = $_POST["class"];
	$_SESSION['c_invoice_from'] = $_POST[invoice_from];
	
	//Check duplicate
	$num=$dbf->countRows('centre',"name='$_REQUEST[name]'");
	$num_no=$dbf->countRows('centre',"cen_no='$_REQUEST[no]'");
	if($num > 0 || $num_no > 0){
		header("Location:center_add.php?msg=exist");
		exit;
	}
	
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="name='$_POST[name]',cen_no='$_POST[no]',cen_tel_no='$_POST[tel_no]',cen_email='$_POST[email_add]',cen_dir_name='$_POST[dir_name]',street_name='$_POST[street]',area='$_POST[area]',province='$_POST[province]',country='$_POST[country]',unit_day='$_POST[unit]',start_time='$ctime',end_time='$etime',class_start_time='$sstime',class_end_time='$setime',cen_no_clas='$_POST[class]',invoice_from='$_POST[invoice_from]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
	
	$ids = $dbf->insertSet("centre",$string);

	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "c".$i;
		$c = $_REQUEST[$c];
		
		$r = "r".$i;
		$r = $_REQUEST[$r];
		
		if($c != ''){
			$string="centre_id='$ids',name='$c',no='$r'";
			$dbf->insertSet("centre_room",$string);
		}
	}
	
	//Start Insert in Group Size of the Particular Centre
	//Loop from group which is set By admin
	foreach($dbf->fetchOrder('group_size',"","id") as $valgroup){
		$string="group_id ='$valgroup[group_id]',size_from='$valgroup[size_from]',size_to='$valgroup[size_to]',total_size='$valgroup[total_size]',week_id1='$valgroup[week_id1]',units='$valgroup[units]',centre_id='$ids'";
		
		$dbf->insertSet("centre_group_size",$string);
	}		
	//End
			
	//Clear Session
	unset($_SESSION['c_name']);
	session_unregister('c_name');
	
	unset($_SESSION['c_no']);
	session_unregister('c_no');
	
	unset($_SESSION['c_tel_no']);
	session_unregister('c_tel_no');
	
	unset($_SESSION['c_email_add']);
	session_unregister('c_email_add');
	
	unset($_SESSION['c_dir_name']);
	session_unregister('c_dir_name');
	
	unset($_SESSION['c_street']);
	session_unregister('c_street');
	
	unset($_SESSION['c_area']);
	session_unregister('c_area');
	
	unset($_SESSION['c_province']);
	session_unregister('c_province');
	
	unset($_SESSION['c_country']);
	session_unregister('c_country');
	
	unset($_SESSION['c_unit']);
	session_unregister('c_unit');
	
	unset($_SESSION['c_ctime']);
	session_unregister('c_ctime');
	
	unset($_SESSION['c_etime']);
	session_unregister('c_etime');
	
	unset($_SESSION['c_sstime']);
	session_unregister('c_sstime');
	
	unset($_SESSION['c_setime']);
	session_unregister('c_setime');
	
	unset($_SESSION['c_class']);
	session_unregister('c_class');
	
	unset($_SESSION['c_invoice_from']);
	session_unregister('c_invoice_from');

	header("Location:center_manage.php");
	
}


if($_REQUEST['action']=='edit'){
	
	//Creating selfservice.php Automatically
	//======================================
	$file_name = 'selfservice'.$_REQUEST['no'].'.php';
	$file_path = '../'.$file_name;
	if(!file_exists($file_path)){		
		//Source file path
		$source = '../service/selfservice.php';
		$destin = $file_path;
				
		if (!copy($source, $destin)) {
		echo "failed to copy $file...\n";
		}
	}
	//======================================
		
	$ctime = $_POST[start_time].":".$_POST[start_time2];
	$etime = $_POST[end_time].":".$_POST[end_time2];
	$sstime = $_POST[s_starttime].":".$_POST[s_starttime2];
	$setime = $_POST[s_endtime].":".$_POST[s_endtime2];
	
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="name='$_POST[name]',cen_no='$_POST[no]',cen_tel_no='$_POST[tel_no]',cen_email='$_POST[email_add]',cen_dir_name='$_POST[dir_name]',street_name='$_POST[street]',area='$_POST[area]',province='$_POST[province]',country='$_POST[country]',unit_day='$_POST[unit]',start_time='$ctime',end_time='$etime',class_start_time='$sstime',class_end_time='$setime',cen_no_clas='$_POST[class]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	$dbf->updateTable("centre",$string,"id='$_REQUEST[id]'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		$c = "c".$i;
		$c = $_REQUEST[$c];
		$r = "r".$i;
		$r = $_REQUEST[$r];
		
		if($c != ''){
			$num=$dbf->countRows('centre_room',"centre_id='$_REQUEST[id]' AND name='$c'");
			if($num==0){
				$string="centre_id='$_REQUEST[id]',name='$c',no='$r'";
				$dbf->insertSet("centre_room",$string);
			}else{
				$string="no='$r'";
				$dbf->updateTable("centre_room",$string,"centre_id='$_REQUEST[id]' AND name='$c'");
			}			
		}
	}
	
	//Start Insert in Group Size of the Particular Centre

	//Check the particular centre id exist in centre_group_size
	$num_centre=$dbf->countRows('centre_group_size',"centre_id='$_REQUEST[id]'");
	if($num_centre==0){
		//Loop from group which is set By admin
		foreach($dbf->fetchOrder('group_size',"","id") as $valgroup){
			$string="group_id ='$valgroup[group_id]',size_from='$valgroup[size_from]',size_to='$valgroup[size_to]',total_size='$valgroup[total_size]',week_id1='$valgroup[week_id1]',units='$valgroup[units]',centre_id='$_REQUEST[id]'";
			
			$dbf->insertSet("centre_group_size",$string);
		}
		
	}	
	//End
			
	header("Location:center_manage.php");
}

if($_REQUEST['action']=='delete'){
	$dbf->deleteFromTable("centre","id='$_REQUEST[id]'");
	$dbf->deleteFromTable("centre_room","centre_id='$_REQUEST[id]'");
	
	header("Location:center_manage.php");
}
?>
