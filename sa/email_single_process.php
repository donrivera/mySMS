<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
$from = $dbf->getDataFromTable("user", "email", "id='$_SESSION[id]'");
$to = $_REQUEST['mobile'];

$headers .= 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= "From:".$from."\n";

$body = '<table border="0" cellpadding="5" cellspacing="0" style="border: 1px solid rgb(109, 146, 201);" width="662">
			<tbody>
				<tr>
					<td bgcolor="#FF9900" colspan="2" height="80">
						<img alt="" src="'.$res_logo[name].'" style="width: 105px; height: 30px;" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">'.$_POST["msg"].'</span></span></td>
				</tr>
				<tr>
					<td>
						</td>
					<td>
						<span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">Thank you,<br />
						B</span></span><span style="font-family: comic sans ms,cursive;"><span style="font-size: 12px;">erliz AlAhsa, a Dar Al-Khibra Human Resourses Development Company</span></span></td>
				</tr>
				<tr>
					<td>&nbsp;
						</td>
					<td>&nbsp;
						</td>
				</tr>
			</tbody>
		</table>';
		
$subject = $_POST[subject];

mail($to,$subject,$body,$headers);
//=================
// End Email
//=================

//Start Save Mail	
$dt = date('Y-m-d');
$dttm = date('Y-m-d h:i:s');

$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='student',email='$to',send_date='$dt',msg_from='Admin',page_full_path='$_SERVER[REQUEST_URI]'";
$dbf->insertSet("email_history",$string);
// End Save Mail

header("Location:email_single.php?student_id=$_REQUEST[student_id]&msg=sent");
exit;
?>