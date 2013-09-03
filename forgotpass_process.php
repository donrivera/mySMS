<?php 
ob_start();

include_once 'includes/class.Main.php';

//Object initialization
$dbf = new User();

$res_admin = $dbf->strRecordID("user","*","id='1'");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<?php
$email=$_REQUEST['emailid'];
$from=$res_admin[email];

$num=$dbf->countRows('user',"email='$email'");
if($num==0)
{
	header("location:forgot_password.php?msg=invalid");
}
else
{
	$ro = $dbf->strRecordID("user","*","email='$email'");
	$u=$ro['user_id'];
	$p=base64_decode(base64_decode($ro['password']));
	
	$res_logo = $dbf->strRecordID("conditions","*","type='Logo path'");
	
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From:".$from."\n";
	$body='<table border="0" cellpadding="5" cellspacing="0" style="border: 1px solid rgb(109, 146, 201);" width="662">
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
					<td><table width="56%" height="97"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
						<tr>
						  <th height="28" colspan="2" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#FFFFFF" scope="col"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="9%" height="30" align="center" valign="middle" >&nbsp;</td>
							  <td width="91%" height="30" align="left" valign="middle"  style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#000000">Your Login Information</td>
							</tr>
						  </table></th>
		  </tr>
						  <tr>
							<td >&nbsp;</td>
							<td height="20" align="left"  style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000066; font-weight:bold"><span class="style6">Username: <span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;"> '.$u.' </span></span></td>
						  </tr>
						  <tr>
							<td width="9%" >&nbsp;</td>
							<td width="91%" height="20" align="left"  style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000066; font-weight:bold"><span class="style6">Password: '.$p.'</span></td>
						  </tr>
						  </table></td>
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
	
	$subject = "Password Recovery Information";
	if(mail($email,$subject,$body,$headers))
	{
		header("location:recovery_confirmation.php");
		exit;
	}

}
?>
<body>
</body>
</html>
