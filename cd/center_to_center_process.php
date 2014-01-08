<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';
include("../includes/saudismsNET-API.php");

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='update')
{
	$comm = mysql_real_escape_string($_REQUEST["comment"]);
	$reg_dt = date('Y-m-d');
	
	$tran_id = $_REQUEST["tran_id"];
	$dtls = $dbf->strRecordID("transfer_centre_to_centre","*","id='$tran_id'");
	
	$f_center=$dtls[centre_from];
	$f_grp_id=$dtls[from_id];
	$t_center=$dtls[centre_to];
	$t_grp_id=$dtls[to_id];
	$f_stat=$dtls[from_status_id];
	$t_stat=$dtls[to_status_id];
	$f_cou_id=$dtls[from_course_id];
	$t_cou_id=$dtls[to_course_id];
	$f_sdt=$dtls[student_id];
	//$t_sdt=$dtls[to_student_id];
	$center_id=$dtls[centre_id];
		
	$string="status='$_REQUEST[status]',cd_comment='$comm'";
	$dbf->updateTable("transfer_centre_to_centre",$string,"id='$tran_id'");
	
	//==========================================================
	//Insert in Student Comments Table (student_comment)
	$dt = date('Y-m-d h:i:s');
	
	if($comm != '')
	{
		
		$ids = $dbf->strRecordID("transfer_centre_to_centre", "*", "id='$tran_id'");
		
		$string_move="student_id='$ids[student_id]',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		$dbf->insertSet("student_comment",$string_move);

		$string_move="student_id='$ids[to_student_id]',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
		$dbf->insertSet("student_comment",$string_move);		
	}
	//==========================================================
	
	$sms_gateway = $dbf->strRecordID("sms_gateway","*","");
	
	if($_REQUEST["status"] == 'Approved')
	{
		switch($f_stat)
		{
			case '1':
			case '2':	{
							$dbf->updateTable("student","centre_id='$t_center'","id='$f_sdt'");
							$dbf->updateTable("student_appointment","centre_id='$t_center'","id='$f_sdt'");
						}break;
			case '3':
			case '6':
			case '7':	{	
							$dbf->updateTable("student","centre_id='$t_center'","id='$f_sdt'");
							$dbf->updateTable("student_appointment","centre_id='$t_center'","id='$f_sdt'");
							$dbf->studentTransferFeeByCenter($f_sdt,$f_cou_id,$f_center,$t_center,$comm,$_SESSION["id"],$_SESSION["centre_id"]);
											
						}break;
			case '4':
			case '5':	{
							$dbf->updateTable("student","centre_id='$t_center'","id='$f_sdt'");
							$dbf->updateTable("student_appointment","centre_id='$t_center'","id='$f_sdt'");
							$dbf->studentTransferClass($f_sdt,$f_cou_id);
							$dbf->studentTransferFeeByCenter($f_sdt,$f_cou_id,$f_center,$t_center,$comm,$_SESSION["id"],$_SESSION["centre_id"]);
							
						}break;
				
			default:	{
							echo '
									<script type="text/javascript">
										alert("Select Status for Student!");
										self.parent.location.href="center_to_center_manage.php";
										self.parent.tb_remove();
									</script>
								';
						}break;	
		}
	}
	
	//Start SMS
	if($dbf->countRows("sms_gateway","status='Enable'") > 0)
	{
		$userto = $dbf->strRecordID("user","*","id='$dtls[created_by]'");
		$mobile_no = $userto["mobile"];
		
		if($mobile_no != '')
		{
			$sms = $_REQUEST['sms'];
			if($sms == "1")
			{
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
				
				// Your Message in English or arabic or both.
				// Each 70 Arabic Characters will be charged 1 Credit, Each 160 English Characters will be charged 1 Credit.
				//$sms_cont = $dbf->getDataFromTable("sms_templete","contents","id='37'");
				//$msg = str_replace('%teacher%',$teacher,$sms_cont);
				
				$msg = "Centre Director has been ".$_REQUEST["status"]." your request for transfer";
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
?>

<script type="text/javascript">
	self.parent.location.href='center_to_center_manage.php';
	self.parent.tb_remove();
</script>
