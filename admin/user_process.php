<?php
ob_start();
session_start();
include_once '../includes/class.Main.php';

//Object initialization
$dbf = new User();

if($_REQUEST['action']=='insert'){
	
	if($_POST[type]=="Student"){
		$res = $dbf->strRecordID("student","*","id='$_POST[student]'");
		$uname = $res["first_name"];
		$uid = $_POST[student];
		$center_id = $res[centre_id];
	}else if($_POST[type]=="Teacher"){
		$res = $dbf->strRecordID("teacher","*","id='$_POST[teacher]'");
		$uname = $res["name"];
		$uid = $_POST[teacher];
	}else{
		$uname = $_POST[uname];
		$center_id = $_POST[center_id];
	}
	
	//Check duplicate
	$num=$dbf->countRows('user',"user_type='$_POST[type]' AND user_id='$_POST[uid]'");
	if($num==0){
		
		$pwd = base64_encode(base64_encode($_POST[password]));
		
	 	$cr_date = date('Y-m-d H:i:s A');
		
		////////////////////////////////
		if($_FILES['photo']['name']<>''){
		
		$filename1=time()."_".$_FILES['photo']['name'];
		//echo $filename1;exit;
		move_uploaded_file($_FILES[photo][tmp_name],"photo/".$filename1);
		
		$string="user_type='$_POST[type]',email='$_POST[email]',user_id='$_POST[uid]',password='$pwd',user_name='$uname',mobile='$_POST[mobile]',commonid='$_POST[status]',uid='$uid',photo='$filename1',center_id='$center_id',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		}else{
			 $string="user_type='$_POST[type]',email='$_POST[email]',user_id='$_POST[uid]',password='$pwd',user_name='$uname',mobile='$_POST[mobile]',commonid='$_POST[status]',uid='$uid',center_id='$center_id',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		}
				
		$dbf->insertSet("user",$string);
		
		//Mail to particular user
		$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
		$email=$_POST[email];
		$from=$res_admin[email];
		
		$u=$_POST[uid];
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

		header("Location:user_manage.php");		
		
	}else{
		header("Location:user_add.php?msg=exist");
		exit;
	}
}

if($_REQUEST['action']=='edit'){
	
	$pwd = base64_encode(base64_encode($_POST[password]));
	
	$dbf->updateTable("user","password='$pwd'","id='$_REQUEST[id]'");
	
	//Mail to particular user
	$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");
	$from=$res_admin[email];
	
	$to = $dbf->getDataFromTable("user","email","id='$_REQUEST[id]'");
	
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
			<td><table width="61%" height="57"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
			<tr >
				<th height="35" colspan="2"  style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; color:#033" scope="col">&nbsp;</th>
  </tr>
			  <tr>
				<td width="10%" >&nbsp;</td>
				<td width="90%" height="25" align="left"   style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #000066; font-weight:bold"><span class="style6">Your Current Password: '.$_POST[password].'</span></td>
  </tr>
		  </table></td>
		</tr>
		<tr>
		  <td></td>
		  <td>&nbsp;</td>
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
		
	$subject = "Your password has been changed";
	mail($to,$subject,$body,$headers);
	
	//Start Save Mail
	$dt = date('Y-m-d');
	$dttm = date('Y-m-d h:i:s');
	
	$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Teacher',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='$subject',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
	$dbf->insertSet("email_history",$string);
	// End Save Mail
	
	header("Location:user_manage.php");
	exit;
}

if($_REQUEST['action']=='delete'){
	
	if($_REQUEST["t"] == "t"){
		$dbf->deleteFromTable("teacher","id='$_REQUEST[uid]'");
		$dbf->deleteFromTable("teacher_centre","teacher_id='$_REQUEST[uid]'");
	}
	$dbf->deleteFromTable("user","id='$_REQUEST[id]'");
	
	header("Location:user_manage.php");
}

if($_REQUEST['action']=='block'){
	$dbf->updateTable("user","user_status=1","id='$_REQUEST[id]'");
	header("Location:user_manage.php");
}

if($_REQUEST['action']=='unblock'){
	$dbf->updateTable("user","user_status=0","id='$_REQUEST[id]'");
	header("Location:user_manage.php");
}
if($_REQUEST['action']=='edituser'){
	if($_POST[type]=="Student")
	{
		$res = $dbf->strRecordID("student","*","id='$_POST[student]'");
		$uname = $res["first_name"];
		$uid = $_POST[student];
	}
	else if($_POST[type]=="Teacher")
	{
		$res = $dbf->strRecordID("teacher","*","id='$_POST[teacher]'");
		$uname = $res["name"];
		$uid = $_POST[teacher];
	}
	else
	{
		$uname = $_POST[uname];
	}

	$pwd = base64_encode(base64_encode($_POST[password]));
	$cr_date = date('Y-m-d H:i:s A');
	if($_FILES['photo']['name']<>'')
		{	
		$res = $dbf->strRecordID("user","*","id='$_REQUEST[id]'");
		$filename1=time()."_".$_FILES['photo']['name'];
		//echo $filename1;exit;
		move_uploaded_file($_FILES[photo][tmp_name],"photo/".$filename1);
		$prev_image="$res[photo]";
		unlink("photo/".$prev_image);
							
    $string="user_type='$_POST[type]',email='$_POST[email]',user_id='$_POST[uid]',password='$pwd',user_name='$uname',mobile='$_POST[mobile]',commonid='$_POST[status]',uid='$uid',photo='$filename1',center_id='$_POST[center_id]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
	}else{
		$string="user_type='$_POST[type]',email='$_POST[email]',user_id='$_POST[uid]',password='$pwd',user_name='$uname',mobile='$_POST[mobile]',commonid='$_POST[status]',uid='$uid',center_id='$_POST[center_id]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
		}
	$dbf->updateTable("user",$string,"id='$_REQUEST[id]'");
	header("Location:user_manage.php");
}

if($_REQUEST['action']=='usersetpassword')
{
	$res_st = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");
	
	$pwd = base64_encode(base64_encode($_POST[password]));
	
	$cr_date = date('Y-m-d H:i:s A');
	
	$string="user_type='Student',email='$res_st[email]',user_id='$_POST[uid]',password='$pwd',user_name='$res_st[first_name]',mobile='$res_st[student_mobile]',uid='$_REQUEST[student_id]',center_id='$res_st[centre_id]',created_datetime='$cr_date',created_by='$_SESSION[id]'";
			
	$dbf->insertSet("user",$string);
	
	//Mail to particular user
	$res_admin = $dbf->strRecordID("user","*","id='$_SESSION[id]'");

	//To
	$email=$res_st[email];
	
	//From
	$from=$res_admin[email];
	
	$u=$_POST[uid];
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
	
	$user = $dbf->strRecordID("student","*","id='$_REQUEST[student_id]'");
	$fet = $dbf->strRecordID("user","*","uid='$_REQUEST[student_id]'");
	
	// Session	
	$_SESSION[students_user_name]=$user[first_name];
	$_SESSION[students_id]=$fet[id];
	$_SESSION[students_user_type]="Student";
	$_SESSION[lang]="1";
	$_SESSION[students_uid]=$fet[uid];
	
	header("location:../student/home.php");
	exit;
}
?>
