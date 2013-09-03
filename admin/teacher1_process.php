<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){

	$over='0';
	if($_POST[overtime]!=""){
		$over='1';
	}

	//Check duplicate
	$num=$dbf->countRows('teacher',"name='$_POST[name]' AND mobile='$_POST[mobile]'");
	if($num==0){
		
		$cr_date = date('Y-m-d H:i:s A');
		
	 	$string=   "name='$_POST[name]',mobile='$_POST[mobile]',country_id='$_POST[country]',teacher_status='$_POST[teacher_status]',unit='$_POST[workload]',overtime='$over',prefer_time='$_POST[preference]',email='$_POST[email]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		
		$id = $dbf->insertSet("teacher",$string);
		
		//Insert in Teacher Centre Table
		$count = $_POST[count];
		for($i=1; $i<=$count; $i++){
			
			$c = "center".$i;
			$c = $_REQUEST[$c];
			
			if($c != ''){
				
				$string="teacher_id='$id',centre_id='$c'";
				$dbf->insertSet("teacher_centre",$string);
			}
		}
		// -- End
				
		//Insert to user Table		
		$pwd = base64_encode(base64_encode($_POST[password]));
		
		$string="user_type='Teacher',email='$_POST[email]',user_id='$_REQUEST[username]',password='$pwd',user_name='$_REQUEST[name]',mobile='$_POST[mobile]',uid='$id',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		$dbf->insertSet("user",$string);
		
		//End
		
		//Mail to particular user
		$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
		$email=$_POST[email];
		$from=$res_admin[email];
		
		$u=$_POST[username];
		$p=$_POST[password];
		
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
			
		$subject = "Your login details";
		mail($email,$subject,$body,$headers);
		
		//Start Save Mail
		$dt = date('Y-m-d');
		$dttm = date('Y-m-d h:i:s');
		
		$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Teacher',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='$subject',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
		$dbf->insertSet("email_history",$string);
		// End Save Mail
				
		header("Location:teacher1_manage.php");
	}	
	else
	{
		header("Location:teacher1_add.php?msg=exist");		
	}
}


if($_REQUEST['action']=='edit'){
	
	$cr_date = date('Y-m-d H:i:s A');
	
	$over='0';
	if($_POST[overtime]!=""){
		$over='1';
	}
	
	$num=$dbf->countRows('teacher',"email='$_POST[email]'");
	if($num == 0){
		$string = "email='$_POST[email]'";
		$dbf->updateTable("teacher",$string,"id='$_REQUEST[id]'");
	}
	
	 $string=   "name='$_POST[name]',mobile='$_POST[mobile]',country_id='$_POST[country]',teacher_status='$_POST[teacher_status]',unit='$_POST[workload]',overtime='$over',prefer_time='$_POST[preference]',last_updated='$cr_date',updated_by='$_SESSION[id]'";
	
	$dbf->updateTable("teacher",$string,"id='$_REQUEST[id]'");
	
	$dbf->deleteFromTable("teacher_centre","teacher_id='$_REQUEST[id]'");
	
	$count = $_POST[count];
	for($i=1; $i<=$count; $i++){
		
		$c = "center".$i;
		$c = $_REQUEST[$c];
		
		if($c != ''){
			
			$string="teacher_id='$_REQUEST[id]',centre_id='$c'";
			$dbf->insertSet("teacher_centre",$string);
		}
	}
	
	//Insert to user Table
		
	$pwd = base64_encode(base64_encode($_POST[password]));
	
	//Check duplicate
	$num=$dbf->countRows('user',"user_type='Teacher' AND uid='$_REQUEST[id]'");
	if($num == 0){
		
		$string="user_type='Teacher',email='$_POST[email]',user_id='$_REQUEST[username]',password='$pwd',user_name='$_REQUEST[name]',mobile='$_POST[mobile]',uid='$_REQUEST[id]'";
		$dbf->insertSet("user",$string);
	}else{
		$string="email='$_POST[email]',user_id='$_REQUEST[username]',password='$pwd',user_name='$_REQUEST[name]',mobile='$_POST[mobile]'";
		$dbf->updateTable("user",$string,"user_type='Teacher' AND uid='$_REQUEST[id]'");
		
		//Check Password has been changed or not
		$prev = $dbf->strRecordID("user","*","uid='$_REQUEST[id]'");
		if($pwd != $prev["password"] || $_REQUEST["username"] != $prev["user_id"]){
			
			//Mail to particular user
			$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
			$email=$_POST[email];
			$from=$res_admin[email];
			
			$u=$_POST[username];
			$p=$_POST[password];
			
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
				
			$subject = "Your login details has been Changed";
			mail($email,$subject,$body,$headers);
		}
		
	}
	//End
	
	header("Location:teacher1_manage.php");
}

if($_REQUEST['action']=='delete'){
	
	$dbf->deleteFromTable("teacher","id='$_REQUEST[id]'");
	$dbf->deleteFromTable("user","user_type='Teacher' And uid='$_REQUEST[id]'");
	$dbf->deleteFromTable("teacher_centre","teacher_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("ped","teacher_id='$_REQUEST[id]'");	
	$dbf->deleteFromTable("ped_attendance","teacher_id='$_REQUEST[id]'");	
	$dbf->deleteFromTable("ped_daily_status","teacher_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("ped_daily_status_dtls","teacher_id='$_REQUEST[id]'");
	$dbf->deleteFromTable("ped_units","teacher_id='$_REQUEST[id]'");
	
	$dbf->deleteFromTable("teacher_progress","teacher_id='$_REQUEST[id]'");	
	$dbf->deleteFromTable("teacher_progress_certificate","teacher_id='$_REQUEST[id]'");	
	$dbf->deleteFromTable("teacher_progress_course","teacher_id='$_REQUEST[id]'");	
			
	header("Location:teacher1_manage.php");
	exit;
}

if($_REQUEST['action']=='setstatus'){
	
	$status = 0;
	if($_REQUEST[val]=="true"){
		$status = 1;
	}
	if($_REQUEST['type']=='cd'){
		$string="cen_dr='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='sa'){
		$string="stu_ad='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='re'){
		$string="rep='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='st'){
		$string="student='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	if($_REQUEST['type']=='te'){
		$string="teacher='$status'";
		$dbf->updateTable("links",$string,"id='$_REQUEST[id]'");
	}
	exit;
}
?>
