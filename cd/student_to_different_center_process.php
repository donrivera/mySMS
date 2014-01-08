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
	$dtls = $dbf->strRecordID("transfer_different_centre","*","id='$tran_id'");
	
	$f_center=$dtls[centre_from];
	$f_grp_id=$dtls[from_id];
	$t_center=$dtls[centre_to];
	$t_grp_id=$dtls[to_id];
	$f_stat=$dtls[from_status];
	$t_stat=$dtls[to_status];
	$f_cou_id=$dtls[from_course_id];
	$t_cou_id=$dtls[to_course_id];
	$f_sdt=$dtls[from_student];
	$t_sdt=$dtls[to_student];
	$center_id=$dtls[centre_id];
	
	
	$from_id = $dtls["from_id"];
	$to_id = $dtls["to_id"];
	
	$string="status='$_REQUEST[status]',cd_comment='$comm'";
	$dbf->updateTable("transfer_different_centre",$string,"id='$tran_id'");
	
	//Insert in Student Comments Table (student_comment)
	$dt = date('Y-m-d h:i:s');
	
	if($comm != '')
	{		
		foreach($dbf->fetchOrder('transfer_different_centre_dtls',"parent_id='$tran_id'","") as $dtls)
		{
			$string_move="student_id='$dtls[student_id]',user_id='$_SESSION[id]',comments='$comm',date_time='$dt',status_id='1'";
			$dbf->insertSet("student_comment",$string_move);
		}
	}
	//==========================================================
	
	if($_REQUEST["status"] == 'Approved')
	{
		
		switch($f_stat)
		{
			case '3':	{
							switch($t_stat)
							{
								case '3':
								case '4':	{	
												$dbf->updateTable("student_fees","centre_id='$t_center'","student_id='$f_sdt' AND course_id='$f_cou_id'");	
												$dbf->studentTransferFee($f_sdt,$f_stat,$f_cou_id,$t_cou_id,$t_sdt,$comm,$_SESSION["id"],$_SESSION["centre_id"]);
											}break;
							}
						}break;
			case '4':	{
							switch($t_stat)
							{
								case '3':
								case '4':	{	
												$dbf->updateTable("student_fees","centre_id='$t_center'","student_id='$f_sdt' AND course_id='$f_cou_id'");
												$dbf->studentTransferClass($f_sdt,$f_cou_id);
												$dbf->studentTransferFee($f_sdt,$f_stat,$f_cou_id,$t_cou_id,$t_sdt,$comm,$_SESSION["id"],$_SESSION["centre_id"]);
											}break;
							}
						}break;
			case '5':	{
							switch($t_stat)
							{
								case '3':
								case '4':
								case '5':	{	
												$dbf->updateTable("student_fees","centre_id='$t_center'","student_id='$f_sdt' AND course_id='$f_cou_id'");
												$dbf->studentTransferClass($f_sdt,$f_cou_id);
												$dbf->studentTransferFee($f_sdt,$f_stat,$f_cou_id,$t_cou_id,$t_sdt,$comm,$_SESSION["id"],$_SESSION["centre_id"]);
											}break;
							}
						}
			case '6':
			case '7':	{
							switch($t_stat)
							{
								
								case '4':	{	
												$dbf->updateTable("student_fees","centre_id='$t_center'","student_id='$f_sdt' AND course_id='$f_cou_id'");	
												$dbf->studentTransferFee($f_sdt,$f_stat,$f_cou_id,$t_cou_id,$t_sdt,$comm,$_SESSION["id"],$_SESSION["centre_id"]);
											}break;
							}
						}break;
			default:	{
							echo '
									<script type="text/javascript">
										alert("Select Status for Student 1!");
										self.parent.location.href="student_to_different_center_manage.php";
										self.parent.tb_remove();
									</script>
								';
						}break;
		}
		
		//Start SMS
		if($dbf->countRows("sms_gateway","status='Enable'") > 0)
		{
			//SMS to Destination Center Director
			$userto = $dbf->strRecordID("user","*","user_type='Center Director' And center_id='$to_id'");			
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
