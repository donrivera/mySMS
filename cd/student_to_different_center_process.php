<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='update'){

	$comm = mysql_real_escape_string($_REQUEST["comment"]);
	$reg_dt = date('Y-m-d');
	
	$tran_id = $_REQUEST["tran_id"];
	$dtls = $dbf->strRecordID("transfer_different_centre","*","id='$tran_id'");
	
	$from_id = $dtls["from_id"];
	$to_id = $dtls["to_id"];
	
	$string="status='$_REQUEST[status]',cd_comment='$comm'";
	$dbf->updateTable("transfer_different_centre",$string,"id='$tran_id'");
	
	//Insert in Student Comments Table (student_comment)
	$dt = date('Y-m-d h:i:s');
	
	if($comm != ''){		
		foreach($dbf->fetchOrder('transfer_different_centre_dtls',"parent_id='$tran_id'","") as $dtls){
			$string_move="student_id='$dtls[student_id]',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
			$dbf->insertSet("student_comment",$string_move);
		}
	}
	//==========================================================
	
	if($_REQUEST["status"] == 'Approved'){
					
		//Start SMS
		if($dbf->countRows("sms_gateway","status='Enable'") > 0){
			
			//SMS to Destination Center Director
			$userto = $dbf->strRecordID("user","*","user_type='Center Director' And center_id='$to_id'");			
			$mobile_no = $userto["mobile"];
			
			if($mobile_no != ''){
				
				$sms = $_REQUEST['sms'];
				if($sms == "1"){
					
					$sms_gateway = $dbf->strRecordID("sms_gateway","*","status='Enable'");
					// Your username
					$UserName=UrlEncoding($sms_gateway[user]);
					
					// Your password
					$UserPassword=UrlEncoding($sms_gateway[password]);
					
					// Destnation Numbers seprated by comma if more than one and no more than 120 numbers Per time.
					//$Numbers=UrlEncoding("966000000000,966111111111");
					$Numbers=UrlEncoding($mobile_no);
					
					// Originator Or Sender name. In English no more than 11 Numbers or Characters or Both
					$Originator=UrlEncoding($sms_gateway[your_name]);
										
					$msg = "Centre Director has been ".$_REQUEST["status"]." for transfer. plz check your profile";
					$Message=$msg;
					
					// Storing Sending result in a Variable.
					SendSms($UserName,$UserPassword,$Numbers,$Originator,$Message);
					
					//================================
					//SAVED SMS
					//================================
					$cr_date = date('Y-m-d H:i:s A');
					
					$string="dated='$cr_date',user_id='0',msg='$msg',send_to='CD',mobile='CRON - SMS',centre_id='$group[centre_id]',msg_from='CD to SA',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
					$dbf->insertSet("sms_history",$string);
					//================================
					//SAVED SMS
					//================================
				}
			}
		}
		//End SMS
	}
}
?>
<script type="text/javascript">
	self.parent.location.href='student_to_different_center_manage.php';
	self.parent.tb_remove();
</script>