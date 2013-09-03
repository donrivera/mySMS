<?php
ob_start();
session_start();
include_once 'includes/class.Main.php';

//Object initialization
$dbf = new User();

$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");

// Loop each group (status = Completed, completed_date <> '', completed_date +3 days
// If today date = completed_date +3 days
// Then fired the mail to Centre director from Teacher
$today = date('Y-m-d');
$today = date('Y-m-d',strtotime(date("Y-m-d", strtotime($today)) . "-3 day"));

foreach($dbf->fetchOrder('student_group',"status='Completed' And completed_date<>'0000-00-00'","","","") as $group){
	
	if($today == $group["completed_date"]){
		
		//Get teacher email id
		$from = $dbf->getDataFromTable("teacher","email","id='$group[teacher_id]'");
		$to = $dbf->getDataFromTable("user","email","user_type='Center Director' And center_id='$group[centre_id]'");
		$cd = $dbf->getDataFromTable("user","user_name","user_type='Center Director' And center_id='$group[centre_id]'");
		$teacher = $dbf->getDataFromTable("teacher","name","id='$group[teacher_id]'");
		
		$email_cont = $dbf->strRecordID("email_templetes","*","id='2'");
		$email_msg = $email_cont["content"];
		
		$email_msg = str_replace('%cd%',$cd,$email_msg);
		$email_msg = str_replace('%teacher%',$teacher,$email_msg);
		
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From:".$from."\n";
			
		$body1 = '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
		  <tr>
			<td height="39" align="left" valign="middle" bgcolor="#FF9900" style="padding-left:5px;"><img src="'.$res_logo[name].'" width="105" height="30" /></td>
		  </tr>
		  <tr>
		    <td align="left" valign="middle">&nbsp;</td>
  		  </tr>
		  <tr>
			<td height="50" align="left" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#999999; padding-left:5px;">'.$email_msg.'</td>
		  </tr>		  
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>';
		
		//$subject ="Alerts for Filled up the Certificate grade !!!";
		$subject = $email_cont["title"];
		mail($to,$subject,$body1,$headers);
		
		//Start Save Mail
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		
		$string="dated='$dttm',user_id='1',msg='$subject',send_to='CD',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='CRON',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
		// End Save Mail
	}
}
?>