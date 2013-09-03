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
	$dtls = $dbf->strRecordID("transfer_centre_to_centre","*","id='$tran_id'");
		
	$from_id = $dtls["from_id"];
	$to_id = $dtls["to_id"];
	
	$string="status='$_REQUEST[status]',cd_comment='$comm'";
	$dbf->updateTable("transfer_centre_to_centre",$string,"id='$tran_id'");
	
	if($_REQUEST["status"] == 'Approved'){
		
		// --------------------   START REMOVE FROM SOURSE GROUP   ---------------------------		
		$group = $from_id;
		
		//Get all students from sourse group for removing from source group
		foreach($dbf->fetchOrder('transfer_centre_to_centre_dtls',"parent_id='$tran_id'") as $transfer){
			
			$id1 = $transfer["student_id"];		
			$dbf->deleteFromTable("student_group_dtls","parent_id='$group' And student_id='$id1'");
		}
		
		//Get number of student recently added
		$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
		
		//Get the range from (group_size) Table
		$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");		
		$my_group_id = $sizegroup["group_id"];
		
		if($prev_num_student == 0){	$my_group_id = 0;}
		
		//update the Group ID to Student_group Table means we can get the student according to group_id
		$string_g="group_id='$my_group_id'";
		$dbf->updateTable("student_group",$string_g,"id='$group'");
		
		//update in group details table
		$string_g1="group_id='$my_group_id'";
		$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");				
		// --------------------   END REMOVE FROM SOURSE GROUP   ---------------------------
		
		// ====================   START ADDING TO DESTINATION GROUP  ===========================
		
		$group = $to_id;
		
		//Get the Group details with Centre wise
		$res_group = $dbf->strRecordID("student_group","*","id='$group'");
		
		$room_id = $res_group["room_id"];
		$centre_id = $res_group["centre_id"];
		$course_id = $res_group["course_id"];
		
		//Get the Numbers of students in a particular Group with Centre wise
		$num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
		
		//This is the Previous (Count Number of Students)
		//===============================================
		if($num_student == 0){
			
			//Get all students from transfer dtls for transert one group to another
			foreach($dbf->fetchOrder('transfer_centre_to_centre_dtls',"parent_id='$tran_id'") as $transfer){
				
				$transfermain = $dbf->strRecordID("transfer_centre_to_centre","*","parent_id='$transfer[parent_id]'");
				
				$id1 = $transfer["student_id"];
				
				//Insert query here			
				$str_d="parent_id='$group',student_id='$id1',course_id='$course_id',centre_id='$centre_id',room_id='$room_id'";
				$dbf->insertSet("student_group_dtls",$str_d);
				
				//Update in student Table
				$string="centre_id='$centre_id'";
				$dbf->updateTable("student",$string,"id='$id1'");
								
				//Update in ENROLLED Table
				$string="group_id='$group',centre_id='$centre_id'";
				$dbf->updateTable("student_enroll",$string,"student_id='$id1' And course_id='$course_id'");
			}
			
			//Get number of student recently added
			$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
			
			//Get the range from (group_size) Table
			$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
					
			//update the Group ID to Student_group Table means we can get the student according to group_id
			$string_g="group_id='$sizegroup[group_id]'";
			$dbf->updateTable("student_group",$string_g,"id='$group'");
			
			//update in group details table
			$string_g1="group_id='$sizegroup[group_id]'";
			$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");
			
		}else{
			//Get Previous Group after re-arranged
			//====================================
			
			//Get number of student recently added
			$prev_num = $dbf->countRows('student_group_dtls',"parent_id='$group'");
					
			//Get the range from (group_size) Table
			$prev_group = $dbf->strRecordID("group_size","*","(size_to>='$prev_num' And size_from<='$prev_num')");
			
			//update the Group ID to Student_group Table means we can get the student according to group_id
			$prev_group_id = $prev_group["group_id"];
			
			//Check whether selected group has been start or not
			$no_unit_finined = $dbf->countRows('ped_units',"group_id='$group'");
			
			if($no_unit_finined > 0){
				
				//Example : 70 units in admin panel
				//Get the Original Units which is entry By Administrator
				$original_unit = $prev_group["units"];
				
				//Example : 10 units in (ped_units) Table
				//Finished points in Decimal value
				// $dec_point_finish = 10 / 70 = 0.1429
				$dec_point_finish = round($no_unit_finined / $original_unit,4);
				
				// $dec_point_100 =  0.142857143 * 100 = 14.29
				$dec_point_100 = $dec_point_finish * 100;
				
				//$pending_units = 70 (70 * 0.1429) = 60
				$pending_units = round($original_unit - ($original_unit * $dec_point_finish));
								
				//Insert IN details table
				foreach($dbf->fetchOrder('transfer_centre_to_centre_dtls',"parent_id='$tran_id'") as $transfer){				
					
					$id2 = $transfer["student_id"];
					
					//Insert query here			
					$str_d="parent_id='$group',student_id='$id2',course_id='$res_group[course_id]',centre_id='$centre_id',room_id='$room_id'";
					$dbf->insertSet("student_group_dtls",$str_d);				
					
					//Update in student Table
					$string="centre_id='$centre_id'";
					$dbf->updateTable("student",$string,"id='$id2'");
					
					//Update in ENROLLED Table
					$string="group_id='$group',centre_id='$centre_id'";
					$dbf->updateTable("student_enroll",$string,"student_id='$id2' And course_id='$course_id'");				
					
				}
				//=====================================
				
				//Get number of student recently added
				$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
				
				//Get the range from (group_size) Table
				$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
						
				//update the Group ID to Student_group Table means we can get the student according to group_id
				$string_g="group_id='$sizegroup[group_id]'";
				$dbf->updateTable("student_group",$string_g,"id='$group'");
				
				$string_g1="group_id='$sizegroup[group_id]'";
				$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");
				
				//Calculate And Previous group update here
				//========================================		
				//Original Unit of the Current Group => 80
				$curr_original_unit = $group[units];
						
				//Finished unit of the Current Group => (0.1429 * 80) => 11.43
				$curr_finished_unit = round($dec_point_finish * $curr_original_unit,2);
				
				//Pending unit of the Currect Group => (80 - 11.43) => 68.57
				$curr_pending_unit = $curr_original_unit - $curr_finished_unit;
				
				//Get the value decimal point (68.57) => 68
				$dec_right_value = substr($curr_pending_unit,0,2);
				
				//Check Odd or Even Number
				if ($dec_right_value % 2 == 0){				//echo "number is even";
					$dec_right_value_is = substr($curr_pending_unit,0,2); // 18.66 => 18
				}else{
					//echo "number is odd";
					$dec_right_value_is = ceil($curr_pending_unit); // 63.44 => 64
				}
				
				//Update the previous Group here
				//========================================		
				$string_g="effect_units='$dec_right_value_is'";
				$dbf->updateTable("centre_group_size",$string_g,"centre_id='$centre_id' And group_id='$prev_group_id'");
							
				// Check the Group which is middle o the Start group to End group
				// Example :G1 - G3 means (G2 is middle)
				
				//Get End unit of First group means => G1 group
				$first_unit = $prev_group["size_to"];
		
				//Get Start unit of Last group means => G3 group
				$last_unit = $group["size_from"];
				
				//Get the number group between two group (G1 to G3)
				$num_middle_group = $dbf->countRows('group_size',"(size_to > '$first_unit' And size_from < '$last_unit')");
				
				//If exist then do the work
				if($num_middle_group > 0){
				
					//Start Loop for middle group
					foreach($dbf->fetchOrder('group_size',"(size_to > '$first_unit' And size_from < '$last_unit')","id") as $valmiddle){
						
						//Get the value decimal point (68.57) => 68
						//echo $curr_finished_unit;
						$dec_right_value_middle = substr($curr_finished_unit,0,2);
						
						//Check Odd or Even Number
						if ($dec_right_value_middle % 2 == 0){
							//echo "number is even";
							$dec_right_value_is_middle = substr($dec_right_value_middle,0,2); // 18.66 => 18
						}else{
							//echo "number is odd";
							$dec_right_value_is_middle = ceil($curr_finished_unit); // 63.44 => 64
						}
						
						//Update the previous Group here
						//========================================		
						$string_g="effect_units='$dec_right_value_is_middle'";
						$dbf->updateTable("centre_group_size",$string_g,"centre_id='$centre_id' And group_id='$valmiddle[group_id]'");					
					}//End Loop				
				}
							
				//Get the effected group_size Table
				$sms_group_size = $dbf->strRecordID("group_size","*","group_id='$prev_group_id'");
				
				//Current Group
				$group3 = $dbf->strRecordID("common","*","id='$sizegroup[group_id]'");
				$g3_name = $group3[name];		
				
				//Get the effected group Name
				$sms_group = $dbf->strRecordID("common","*","id='$prev_group_id'");
				
				//Group Name
				$g_name = $sms_group["name"];
				
				if($sms_group_size["size_from"] != '0' && $sms_group_size["size_to"] == '0'){
					$student = $sms_group_size["total_size"]."-student"; //12-student
				}else if($sms_group_size["size_from"] != '0' && $sms_group_size["size_to"] != '0'){
					$student = $sms_group_size["size_to"]."-student"; //9-student
				}else if($sms_group_size["size_from"] == '0' && $sms_group_size["size_to"] == '0'){
					$student = ""; //Flex
				}
				
				//Calculate units (Effected Unit - No of class has been finished)
				// 8 = 68 - 60
				$unit = $dec_right_value_is - $pending_units;
				
				//Centre director details
				$res_cd = $dbf->strRecordID("user","*","id='$_SESSION[id]'");	
				$from = $res_cd["email"];		
								
				//======================
				// Start Mail to Teacher
				//======================
				
				//Teacher Email address
				$to_user = $res_teacher["email"];
				$admin_mail = $dbf->getDataFromTable("user","email","user_type='Administrator");
		
				if($to_user != ''){
			
					$headers .= 'MIME-Version: 1.0' . "\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= "From:".$from."\n";
											
					$email_cont = $dbf->strRecordID("email_templetes","*","id='6'");
					$email_msg = $email_cont["content"];
					
					$email_msg = str_replace('%teacher%',$res_teacher["name"],$email_msg);
					$email_msg = str_replace('%pending_units%',$pending_units,$email_msg);
					$email_msg = str_replace('%groupname%',$g_name,$email_msg);
					$email_msg = str_replace('%dec_right_value_is%',$dec_right_value_is,$email_msg);
					$email_msg = str_replace('%g3_name%',$g3_name,$email_msg);
					$email_msg = str_replace('%unit%',$unit,$email_msg);
					
					$email_msg = str_replace('%no_student_remove%',$no_student_remove,$email_msg);
					$email_msg = str_replace('%student%',$student,$email_msg);
					$email_msg = str_replace('%no_unit_finined%',$no_unit_finined,$email_msg);
					
					$body1='<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:solid 2px; border-color:#FFCC00;">
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
					
					$subject = $email_cont["title"];				
					//$subject ="Group size has been changed Notification !!!";
					
					mail($to_user,$subject,$body1,$headers);
					
					//Start Save Mail
					$dt = date('Y-m-d');
					$dttm = date('Y-m-d h:i:s');
					
					$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Teacher',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='Admin',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
					$dbf->insertSet("email_history",$string);
					//End Save Mail					
				}
				
				//===============
				// End Mail
				//===============
				
				//Start Save Mail
				$dt = date('Y-m-d');
				$dttm = date('Y-m-d h:i:s');
				
				$string="dated='$dttm',user_id='$_SESSION[id]',msg='$subject',send_to='Admin',email='$to',centre_id='$_SESSION[centre_id]',send_date='$dt',msg_from='$subject',automatic='Yes',page_full_path='$_SERVER[REQUEST_URI]'";
				$dbf->insertSet("email_history",$string);
				// End Save Mail
					
			}else{
				
				//Get all students from transfer dtls for transert one group to another
				foreach($dbf->fetchOrder('transfer_centre_to_centre_dtls',"parent_id='$tran_id'") as $transfer){
				
					$id3 = $transfer["student_id"];
											
					//Insert query here			
					$str_d="parent_id='$group',student_id='$id3',course_id='$course_id',centre_id='$centre_id',room_id='$room_id'";
					$dbf->insertSet("student_group_dtls",$str_d);		
					
					//Update in student Table
					$string="centre_id='$centre_id'";
					$dbf->updateTable("student",$string,"id='$id3'");
										
					//Update in ENROLLED Table
					$string="group_id='$group',centre_id='$centre_id'";
					$dbf->updateTable("student_enroll",$string,"student_id='$id3' And course_id='$course_id'");
				}
				//=====================================
				
				//Get number of student recently added
				$prev_num_student = $dbf->countRows('student_group_dtls',"parent_id='$group'");
				
				//Get the range from (group_size) Table
				$sizegroup = $dbf->strRecordID("group_size","*","(size_to>='$prev_num_student' And size_from<='$prev_num_student')");
						
				//update the Group ID to Student_group Table means we can get the student according to group_id
				$string_g="group_id='$sizegroup[group_id]'";
				$dbf->updateTable("student_group",$string_g,"id='$group'");
				
				//update in group details
				$string_g1="group_id='$sizegroup[group_id]'";
				$dbf->updateTable("student_group_dtls",$string_g1,"parent_id='$group'");
			}	
		}
		// ====================   END ADDING TO DESTINATION GROUP  ===========================
		
	}
	
	//Start SMS
	if($dbf->countRows("sms_gateway","status='Enable'") > 0){
		
		$userto = $dbf->strRecordID("user","*","id='$dtls[created_by]'");
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